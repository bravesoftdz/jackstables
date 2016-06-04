<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	/** 
	 * Main page just show all products
	 */
	public function index()
	{
		$this->load->model('Product_model');

		$this->load->view('header', ['categories'=>$this->Product_model->categories()]);
		$this->load->view('show_products', ['products'=> $this->Product_model->fetch() ]);
		$this->load->view('footer');
	}

	/** 
	 * List all products by a specific category
	 * @param string $category the category to show
	 */
	public function category($category){
		$this->load->model('Product_model');

		$data = [];
		$data['products'] = $this->Product_model->fetch('ORDER BY name ASC', $category, $product_id = null, $product_name = null); 

		$this->load->view('header', ['categories'=>$this->Product_model->categories()]);
		$this->load->view('show_products', $data);
		$this->load->view('footer');
	}

	/** 
	 * View more details/bigger picture of a specific product
	 * Good for viewing one product at a time
	 * @param int $product_id the product id we want to view
	 */
	public function view($product_id){
		$this->load->model('Product_model');

		$data = [];
		$data['product'] = $this->Product_model->get($product_id);


		$this->load->view('header', ['categories'=>$this->Product_model->categories()]);
		
		if ($data['product']){
			$this->load->view('show_product', $data);
		}else{
			$this->load->view('product_not_found', ['product_id'=>$product_id]);
		}
		$this->load->view('footer');	
	}
}
