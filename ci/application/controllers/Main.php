<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** 
 * This is the main default controller 
 * which holds / and /contact-us
 * @see application/config/routes.php 
 */
class Main extends CI_Controller {
	/** 
	 * This is the main page, where we fetch all products 
	 * and shoow them on the homepage
	 */
	public function index()
	{
		$this->load->model('Product_model');

		$this->load->view('header', ['categories'=>$this->Product_model->categories()]);
		$this->load->view('show_products', ['products'=> $this->Product_model->fetch() ]);
		$this->load->view('footer');
	}

	/** 
	 * This is the contact us page 
	 * It accepts a name, email and comments to send them to the webmaster
	 * stored in application/config/my_extra_config.php
	 */
	public function contact(){
		$errors = false;

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$errors = '';
			if (empty($_POST['name'])){
				$errors = 'You must enter a name';
			}else if (empty($_POST['email']) || strpos($_POST['email'], '@') === false){
				$errors ='You must enter a valid email address';
			}else if (empty($_POST['comments']) || strlen($_POST['comments']) < 15){
				$errors = 'You must enter a comment at least 15 characters long';
			}

			if (empty($errors)){
				$this->load->library('email');
				$this->config->load('my_extra_config');

				$this->email->from($_POST['email'], $_POST['name']);

				$email_to = $this->config->item('contact_us_email_to');

				$this->email->to($email_to); 

				$this->email->subject('Contact Us - Form');
				$this->email->message($_POST['comments']);	

				/** old fashioned way **
				$subject = "Contact Us - Jack's Emporium";
			
				$headers = "From: ".$_POST['email'];
				$email_sent = mail($email_to,$subject,$_POST['comments'],$headers);
				**/

				$email_sent = $this->email->send();

				//echo $this->email->print_debugger();
			}
		}
		$this->load->model('Product_model');
		$this->load->view('header', ['categories'=>$this->Product_model->categories()]);
		if (isset($email_sent)){
			$this->load->view('contact_form_thankyou', ['email_sent'=>$email_sent]);
		}else{
			$this->load->view('contact_form', ['error'=>$errors]);
		}
		$this->load->view('footer');
	}
}
