<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/admin
	 *	- or -
	 * 		http://example.com/index.php/admin/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->welcome_or_login();
	}

	/** 
	 * Show welcome page if logged in,
	 * otherwise, show login page
	 */
	private function welcome_or_login(){
		if (!empty($_SESSION['logged_in_user'])){
			$this->load->view('admin_header', ['title'=> 'Administration - Jack\'s Table Emporium']);
			$this->load->view('admin_welcome');
			$this->load->view('admin_footer');
		}else{
			$this->load->view('full/admin_login');
		}		
	}

	private function assert_logged_in(){
		if (empty($_SESSION['logged_in_user'])){
			$this->load->view('full/admin_login', ['error'=>'You must be logged in to view this page', 'goto'=>uri_string()]);
			exit;
		}else{
			return true;
		}
	}

	/** 
	 * Allow logins from POST or show the login page unless already logged in
	 */
	public function login(){
		//Is someone attempting to login?
		if (!empty($_POST['username'])){
			$this->load->model('Administrator_model', '', $connect_to_db = true);
			$login_check = $this->Administrator_model->check_login($this->input->post('username'), $this->input->post('password'), $error);

			if($login_check){
				
				$_SESSION['logged_in_user'] = $this->input->post('username');
				$_SESSION['logged_in_time'] = time();
				
				//redirect header('Location: /admin/') or instead do the below
				$this->load->view('admin_header', ['title'=> 'Administration']);
				$this->load->view('admin_welcome');
				$this->load->view('admin_footer');
				return;
			}else{
				//Do not tell the user whether it was their username or password which was incorrect
				$this->load->view('full/admin_login', ['error'=> 'Invalid username or password combination']);
				//TODO: Log failed attempt $error
				//TODO: Throttle failed login attempts
				return;
			}
		}else{
			//no one is attempting to login, do the same thign as ->index()
			$this->welcome_or_login();
		}
	}

	public function products($action = 'view', $product_id = null){
		$this->assert_logged_in();
		$data = ['edit'=> false];

		$this->load->model('Product_model');
		
		switch($action){
			case 'view':
				$products = $this->Product_model->fetch('ORDER BY name ASC');

				$this->load->view('admin_header', ['title'=> 'Products']);
				$this->load->view('admin_products', ['products'=>$products]);
				$this->load->view('admin_footer');
			break;

			case 'edit':
				$product = $this->Product_model->get($product_id);
				if (empty($product)){
					$this->load->view('admin_header', ['title'=> 'Edit Invalid Product']);
					$this->load->view('admin_product_addedit_invalid', $data);
					$this->load->view('admin_footer');	
				    return;
				}

				$data = array('edit'=>true, 'product'=>$product);
				

				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					$updated = $this->Product_model->update_from_post($product_id, $errors);
					if ($updated === false){
						$data['errors'] = $errors;
					}else{
						redirect(base_url().'admin/products');
						exit;
					}
				}


			case 'add':
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					$p_id = $this->Product_model->add_from_post($errors);
					if ($p_id === false){
						$data['errors'] = $errors;
					}else{
						$this->load->view('admin_header', ['title'=> 'Product Added']);
						$this->load->view('admin_product_added', [
							'product_id'=>$p_id, 
							'product'=> $this->Product_model->get($p_id)
							]);
						$this->load->view('admin_footer');
						return;
					}
				}

				$this->load->view('admin_header', ['title'=> $data['edit'] ? 'Edit a Product' : 'Add a Product']);
				$this->load->view('admin_product_addedit', $data);
				$this->load->view('admin_footer');	
			break;	

			case 'remove':
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					if (!empty($_POST['remove'])){
						if ($this->Product_model->delete($product_id)){
							redirect(base_url().'admin/products');
							exit;
						}else{
							//Error deleting
							redirect(base_url().'admin/products');
							exit;
						}
					}
				}else{
					$this->product_confirm_remove($product_id);		
				}
			break;
		}

	}

	public function product_confirm_remove($product_id){
			$this->load->view('admin_header', ['title'=> 'Remove a Product']);
			$this->load->view('admin_product_remove', ['product'=> $this->Product_model->get($product_id)]);
			$this->load->view('admin_footer');	
	}

	/** 
	 * Log out of the session and show the login page
	 */
	public function logout(){
		session_start();
		unset($_SESSION['logged_in_user']);
		session_destroy();
		unset($_SESSION);
		$this->load->view('full/admin_login');
	}
}
