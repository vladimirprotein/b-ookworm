<?php
	class Database {
		private $servername;
      	private $username;
      	private $password;
      	private $dbname;


      	public function __construct() {
			$this->dbname = 'bookworm';
			$this->servername = "localhost:3306";
      		$this->username = "root";
      		$this->password = "mindfire";
		}

		public function viewall($tablename) {

			$conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			if ($conn->connect_error) {
    			return false;
			}
			$stmt=$conn->prepare("SELECT * FROM $tablename ");
			//$stmt->bind_param("s", $tablename);

			$stmt->execute();
			$result=$stmt->get_result();
			return $result;
		}
	}


	$bookworm = new Database();
	echo $bookworm->viewall('book')->fetch_assoc()['id'];
	echo $bookworm->viewall('book')->fetch_assoc()['id'];



?>