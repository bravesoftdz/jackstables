<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index()
	{
		$this->load->model('Product_model');

		$this->load->view('header');
		$this->load->view('show_products', ['products'=> $this->Product_model->fetch() ]);
		$this->load->view('footer');
	}

	public function contact(){
		$errors = false;

		if ($_SERVER['REQUEST_TYPE'] == 'POST'){
			$errors = '';
			if (empty($_POST['name'])){
				$errors = 'You must enter a name';
			}else if (empty($_POST['email']) || strpos($_POST['email'], '@')){
				$errors ='You must enter a valid email address';
			}else if (empty($_POST['comments']) || strlen($_POST['comments']) < 15){
				$errors = 'You must enter a comment at least 15 characters long';
			}

			if (empty($errors)){
				$this->load->library('email');
				$this->config->load('my_extra_config');



				$this->email->from($_POST['email'], $_POST['name']);
				$this->email->to($this->config->item('contact_us_email_to')); 

				$this->email->subject('Contact Us - Form');
				$this->email->message($_POST['comment']);	

				$this->email->send();
			}
		}

		$this->load->view('header');
		$this->load->view('contact_form', ['errors'=>$errors]);
		$this->load->view('footer');
	}
}
