<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	/** 
	 * Main page just show all products
	 */
	public function index()
	{
		$this->load->model('Product_model');

		$this->load->view('header');
		$this->load->view('show_products', ['products'=> $this->Product_model->fetch() ]);
		$this->load->view('footer');
	}

	public function category($category){
		$this->load->model('Product_model');
		
		$data = [];
		$data['products'] = $this->Product_model->fetch('ORDER BY name ASC', $category, $product_id = null, $product_name = null); 

		$this->load->view('header');
		$this->load->view('show_products', $data);
		$this->load->view('footer');
	}
}
