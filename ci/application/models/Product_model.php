<?php 

/** 
 * This class deals with products as stored in the product table
 * It lets you fetch, get, add, update, and delete products
 */
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
        public function fetch($orderby = 'ORDER BY id ASC', $category = null, $product_id = null, $product_name = null){
                $sql = "SELECT * FROM product "; 
                $data = array();
                if (!is_null($product_id)){
                        $sql .= ' WHERE id = ? ';
                        $data[] = $product_id;
                }                
                else if (!is_null($product_name)){
                        $sql .= ' WHERE name = ? ';
                        $data[] = $product_name;
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
         * @return boolean|object false on failure to find anything, product object on success
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
         * Fetch all the distinct categories from the given products
         * @return array categories of all the products
         */
        public function categories($orderby = 'ORDER BY category DESC'){
            $sql = 'SELECT DISTINCT category FROM product '.$orderby;
            $query = $this->db->query($sql);
            $catobjs = $query->result();
            $categories = [];
            foreach($catobjs as $co){
                $categories[] = $co->category;
            }
            return $categories;
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
                $data['inventory_count'] = $this->input->post('inventory_count');
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

            if (!is_numeric($data['inventory_count'])){
                return 'Inventory count must be a number';
            }

            if ($data['inventory_count'] < 0){
                return 'Inventory count must be at least 0';
            }

            return false;        
        }

        /** 
         * This will attempt to check the file being uploaded
         * to see if it is a valid image file
         * @param string $errors return the error if there is any in the file
         * @return null|false|string new file name on success, false on failure (@see $errors), null on no image given
         */
        public function check_file_upload(&$errors){
            $errors = false;

            $field_name = 'image';

            if(!empty($_FILES[$field_name])) {

                    $file_name = $_FILES[$field_name]['name'];
                    if (empty($file_name)){
                        return null;
                    }

                    $file_type = $_FILES[$field_name]['type'];

                    $allowed_types = array('image/jpeg', 'image/png');
                    if (!in_array($file_type, $allowed_types)){
                        $errors = 'Invalid file type, must be jpg or png';
                        return false;
                    }

                    $allowed_ext = array('jpg', 'jpeg', 'png');
                    $info = new SplFileInfo($file_name);
                    $ext = strtolower($info->getExtension());

                    if (!in_array($ext, $allowed_ext)){
                        $errors = 'Invalid file extension must be .jpg, .jpeg, or .png';
                        return false;
                    }


                    $tmp_file  = $_FILES[$field_name]['tmp_name'];
                    $error       = $_FILES[$field_name]['error'];
                    $file_size = $_FILES[$field_name]['size'];

                    if($error > 0) {
                        // Display errors caught by PHP
                        $errors = file_upload_error($error);
                        return false;
                    
                    } else {
                        $this->load->helper('string');

                        $upload_path =  __DIR__.'/../../../public_html/images/products';

                        
                        do{
                            $nw_file_name = random_string('alnum', 15).'.'.$ext;
                        }while(file_exists($upload_path.'/'.$nw_file_name));

                        if (move_uploaded_file($tmp_file, $upload_path.'/'.$nw_file_name)){
                            return $nw_file_name;
                        }else{
                            return false;
                        }
                    }
            }else{
                return null; //file not even in upload
            }

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

                $products = $this->fetch('', $category = null, $product_id = null, $product_name = $data['name']);        
                if (!empty($products)){
                    return $data['name'].' is already a product. Choose another name';
                }

                
                $nw_file_name = $this->check_file_upload($errors);
                if ($nw_file_name === false){
                    return false;
                }

                if ($nw_file_name !== null){
                    $data['image'] = $nw_file_name;
                }

                if (!$this->db->insert('product', $data)){
                        $errors = 'Database error';
                }else{
                        return $this->db->insert_id();
                }
        }

        /** 
         * Use the post variables to update the given product
         * @param int $id id of the product to change
         * @param string $errors errors if any
         * @return boolean true if update succeeded, false on failure
         */
        public function update_from_post($id, &$errors){
                $data = $this->sanitize_from_post();
                $errors = $this->check_errors($data);
                if ($errors !== false){
                    return false;
                }

                $nw_file_name = $this->check_file_upload($errors);
                if ($nw_file_name === false){
                    return false;
                }

                if ($nw_file_name !== null){
                    $data['image'] = $nw_file_name;

                    $cur_product = $this->get($id);

                    if (!empty($cur_product->image)){
                        $old_file = __DIR__.'/../../../public_html/images/products/'.$cur_product->image;
                        if (file_exists($old_file)){
                            unlink($old_file);
                        }
                    }
                }else{
                    //image has not changed, but check if we are removing the image

                    if ($this->input->post('remove_image') == '1'){
                        //but we want to remove the image
                        $data['image'] = '';

                        $cur_product = $this->get($id);

                        if (!empty($cur_product->image)){
                            $old_file = __DIR__.'/../../../public_html/images/products/'.$cur_product->image;
                            if (file_exists($old_file)){
                                unlink($old_file);
                            }
                        }  
                    }
                }

                $this->db->where('id', $id);
                return $this->db->update('product', $data);    
        }

        /** 
         * Delete/Remove a product
         */
        public function delete($id){
            $cur_product = $this->get($id);

            //be sure to delete the picture if it exists
            if (!empty($cur_product->image)){
                $old_file = __DIR__.'/../../../public_html/images/products/'.$cur_product->image;
                if (file_exists($old_file)){
                    unlink($old_file);
                }
            }  

            $this->db->where('id', $id);
            return $this->db->delete('product');
        }
}
