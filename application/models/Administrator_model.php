<?php 

/** 
 * This deals with the administrator table and lets you check to see if a user can login
 */
class Administrator_model extends CI_Model {

        /** 
         * Construct the model
         */
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        /** 
         * Check to see if the username exists and matches the right password
         * This function should use password hashing, but for sake of brevity it was left out
         * @param string $username the admin username trying to login
         * @param string $password the attempted password
         * @param string|boolean $error the error message if it fails, false otherwise
         * @return boolean true on success, false on failure
         */
        public function check_login($username, $password, &$error){
                $error = false;

                $sql = "SELECT * FROM administrator WHERE username = ? "; 
                $query = $this->db->query($sql, array($username) );
                $users = $query->result();
                if (empty($users)){
                        $error = 'INVALID USERNAME';
                        return false;
                }else{
                        $user = $users[0];
                        //TODO: Check password_hash instead (that is why first select by username)
                        if ($user->password == $password){
                                return true;
                        }else{
                                $error = 'INVALID PASSWORD';
                                return false;
                        }
                }  
        }
}
