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
        public function fetch($orderby = 'ORDER BY id ASC', $category = null){
                $sql = "SELECT * FROM product "; 
                $data = array();
                if (!is_null($category)){
                        $sql .= ' WHERE category LIKE ? ';
                        $data[] = $category;
                }
                $sql .= ' '.$orderby;
                
                $query = $this->db->query($sql, $data);
                $products = $query->result();
                return $products;  
        }
}
