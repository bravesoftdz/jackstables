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

        /** 
         * Trim and sanitize the variables a bit
         * @return array of all product variables
         */
        private function sanitize_from_post(){
                $data = [];
                $data['name'] = trim($this->input->post('name'));
                $data['description'] = trim($this->input->post('description'));
                $data['category'] = trim($this->input->post('category'));
                return $data;        
        }

        /** 
         * Do some checking for specific issues with $data
         * @return string|boolean error string or false on no errors
         */
        private function check_errors($data){
            if (strlen($data['name']) < 3){
                return 'Name must be at least 3 characters';
            }                

            if (strlen($data['category']) < 3){
                return 'Category must be at least 3 characters';
            }  

            return false;        
        }

        /** 
         * Insert a new product from the post variables
         * @param string $errors return a string of an error message
         */
        public function add_from_post(&$errors){
                $data = $this->sanitize_from_post();
                $errors = $this->check_errors($data);
                if ($errors !== false){
                    return false;
                }
                
                //TODO: handle file uploads
                if (!$this->db->insert('product', $data)){
                        $errors = 'Database error';
                }else{
                        return $this->db->insert_id();
                }
        }

        public function update_from_post($id, &$errors){
                $data = $this->sanitize_from_post();
                $errors = $this->check_errors($data);
                if ($errors !== false){
                    return false;
                }


                $this->db->where('id', $id);
                return $this->db->update('product', $data);    
        }

        public function delete($id){
            $this->db->where('id', $id);
            return $this->db->delete('product');
        }
}
