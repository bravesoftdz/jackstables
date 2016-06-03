<?php 

class Product_model extends CI_Model {

        /** 
         * Construct the model
         */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        /** 
         * Fetch a list of Products
         */
        public function fetch($orderby = 'ORDER BY id ASC', $category = null, $product_id = null){
                $sql = "SELECT * FROM product "; 
                $data = array();
                if (!is_null($product_id)){
                        $sql .= ' WHERE id = ? ';
                        $data[] = $product_id;
                }
                else if (!is_null($category)){
                        $sql .= ' WHERE category LIKE ? ';
                        $data[] = $category;
                }
                $sql .= ' '.$orderby;

                $query = $this->db->query($sql, $data);
                $products = $query->result();
                return $products;  
        }

        /** 
         * Get one product by id
         */
        public function get($product_id){
                $products = $this->fetch('', $category = null, $product_id);
                if (empty($products)){
                        return false;
                }else{
                        return $products[0];
                }
        }
}
