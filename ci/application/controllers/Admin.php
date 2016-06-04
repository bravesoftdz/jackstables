<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Show main login page or main admin page depending
	 * on whether or not you are logged in
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
			$data = [];
			if ($this->input->post('goto')){
				$data['goto'] = $this->input->post('goto');
			}
			$this->load->view('full/admin_login', $data);
		}		
	}

	/** 
	 * Assert that the user is logged in, or take him to the login page where he can continue on after logging in
	 * @return boolean true on successe logged in already, exit and show full login page on failure
	 */
	private function assert_logged_in(){
		if (empty($_SESSION['logged_in_user'])){
			die( $this->load->view('full/admin_login', ['error'=>'You must be logged in to view this page', 'goto'=>uri_string()], true) );

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
				
				if ($this->input->post('goto')){
					redirect(base_url().$this->input->post('goto'));
					return;
				}

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

	/** 
	 * Show a list of categories produced by each product's "category" value
	 */
	public function categories(){
		$this->assert_logged_in();

		$this->load->model('Product_model');

		$this->load->view('admin_header', ['title'=> 'Products']);
		$this->load->view('admin_categories', ['categories'=>$this->Product_model->categories()]);
		$this->load->view('admin_footer');	
	}


	/** 
	 * admin/products[/view|/edit/id|/add|/remove/id]
	 * View products, add, edit, or remove products
	 * @param $action add, edit, view, remove
	 * @param $product_id for editing or removing a specific product
	 */
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
						var_dump($p_id);
						
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

	/** 
	 * Helper function to automatically load the remove product page
	 * @param int $product_id the id of the product to remove
	 */
	private function product_confirm_remove($product_id){
			$this->load->view('admin_header', ['title'=> 'Remove a Product']);
			$this->load->view('admin_product_remove', ['product'=> $this->Product_model->get($product_id)]);
			$this->load->view('admin_footer');	
	}

	/** 
	 * Log out of the session and show the login page
	 */
	public function logout(){
		unset($_SESSION['logged_in_user']);
		session_destroy();
		unset($_SESSION);
		$this->load->view('full/admin_login');
	}
}
