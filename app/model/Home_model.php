<?php
// Enable error display
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Home_model {
    private $db;
    public function __construct() {
        // Create object from Database class
        $this->db = new Database();
        // Check status
        if ($this->db == false) {
            echo "<script>console.log('Connection failed.');</script>";
        } else {
            echo "<script>console.log('Connected successfully.');</script>";
        }
    }
    public function input_data($data) {
        try {
            // Check if all required fields are present
            if(!isset($data['reg_number']) || !isset($data['nim_number']) || 
               !isset($data['email']) || !isset($data['fullname']) || !isset($data['password'])) {
                return "FAILED"; // Missing required fields
            }
            
            // Validate user input
            $reg_number = $data['reg_number'];
            $nim_number = $data['nim_number'];
            $email = $data['email'];
            $fullname = $data['fullname'];
            
            // Use a fixed-length hash that will fit in the database field
            // Since password varchar is only 50 chars, use MD5 (not secure but will fit)
            $password = md5($data['password']); // MD5 produces a 32-character hash
            
            // Set timezone
            date_default_timezone_set('Asia/Makassar');
            $datanow = date("Y-m-d H:i:s");
            
            // Insert SQL query
            $sql = "INSERT INTO `tbl_students` (`reg_number`, `nim_number`, `email`, `fullname`, `password`, `created_at`, `updated_at`) 
                    VALUES ('$reg_number', '$nim_number', '$email', '$fullname', '$password', '$datanow', '$datanow')";
            
            // Execute query
            $result = $this->db->query($sql);
            
            if ($result === TRUE) {
                return "SUCCESS";
            } else {
                return "FAILED";
            }
        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage());
            return "ERROR";
        }
    }
}
?>