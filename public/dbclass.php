<?php
	class Database {
		private static $connection = null;
		private static $dbconn = null;

      	private function __construct($dbname, $servername, $username, $password) {
      		static::$dbconn = new mysqli($servername, $username, $password, $dbname);
		}

		public static function getInstance($dbname, $servername, $username, $password) {
			if (!self::$connection) {
				self::$connection = new self($dbname, $servername, $username, $password);
			}

			return self::$connection;
		}

		public function viewall($tablename) {

			$conn = static::$dbconn;

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

	$bookworm = Database::getInstance("bookworm", "localhost:3306", "root", "mindfire");
	$ele= $bookworm->viewall('book');
	echo $ele->fetch_assoc()['id']."<br>";
	echo $ele->fetch_assoc()['id'];



?>