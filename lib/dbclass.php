<?php
	class database {
		var $servername;
      	var $username;
      	var $password;
      	var $dbname;


      	function __construct( $par1) {
			$this->dbname = $par1;
			$this->servername = "localhost:3306";
      		$this->username = "root";
      		$this->password = "mindfire";
		}

		function viewall($tablename) {
			$conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			if ($conn->connect_error) {
    			die("Connection failed: " . $conn->connect_error);
			}
			$stmt=$conn->prepare("SELECT * FROM ? ");
			$stmt->bind_param("s", $tablename);
			$stmt->execute();
			$result=$stmt->get_result();
			return $result;
	}


	$bookworm = new database("bookworm");
	echo $bookworm->viewall('book')->fetch_assoc()['id'];


?>