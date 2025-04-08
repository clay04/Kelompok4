<?php
class Login_model{
	private $db;

	public function __construct(){
		// create object from database class
		$this->db = new Database;

		// check status
		if($this->db == false){
			echo "<script>console.log('Connection failed.' );</script>";
		}else{
			echo "<script>console.log('Connected successfully.' );</script>";
		}
	}

	public function check_login($data){
		$email = $data['email'];
		$password = $data['password'];
		$role = $_POST['select-role'];

		if ($role == "mahasiswa") {
			// Ambil data mahasiswa berdasarkan email
			$result = $this->db->query("SELECT * FROM tbl_students WHERE email = '$email';");
			
			if ($result->num_rows > 0) {
				$student = mysqli_fetch_assoc($result);

				// Cek apakah password dienkripsi dengan MD5
				if ($student['password'] === $password || $student['password'] === md5($password)) {
					return [$student];
				}
			}
		} else {
			// Untuk operator
			$result = $this->db->query("SELECT * FROM tbl_operator WHERE role = '$role' AND email = '$email' AND BINARY password = '$password';");
			
			if ($result->num_rows > 0) {
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				return $rows;
			}
		}

		return []; // Jika tidak cocok
	}

	public function get_student_info($email){
		try{
			// Sql mysql
			$sql = "SELECT * FROM tbl_students WHERE email = '$email';";

			// run query
			$result = $this->db->query($sql);

			if ($result->num_rows > 0) {
				// convert to associative array
				$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
				return $rows;
			} else {
				return []; // kosong return empty array
			}
		} catch (Exception $e) {
			return [];
		}
	}
}
?>
