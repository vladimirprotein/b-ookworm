<?php
	class Database {
		private static $connection = null;
		private static $dbconn = null;

      	private function __construct($servername, $username, $password, $dbname) {
      		static::$dbconn = new mysqli($servername, $username, $password, $dbname);
		}

		public static function getInstance($servername, $username, $password, $dbname) {
			if (!self::$connection) {
				self::$connection = new self($servername, $username, $password, $dbname);
			}

			return self::$connection;
		}


		/** 
   		* Method to get all the records from a table
   		* param table name.
   		* @returns result object.
 		*/

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

		/** 
   		* Method to get all the records from a table
   		* param table name.
   		* @returns result object.
 		*/

		
	}

	$bookworm = Database::getInstance("localhost:3306", "root", "mindfire", "bookworm");

	$conn = Database::getConn();

			if ($conn->connect_error) {
    			return false;
			}

			$stmt=$conn->prepare("SELECT * FROM book ");
			//$stmt->bind_param("s", $tablename);

			$stmt->execute();
			$result=$stmt->get_result();
	$ele= $result;
	echo $ele->fetch_assoc()['id']."<br>";
	echo $ele->fetch_assoc()['id'];



?>