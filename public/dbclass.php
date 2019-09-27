<?php
	class Database {
		protected static $connection = null;
		protected static $dbconn = null;

      	protected function __construct($servername, $username, $password, $dbname) {
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

		function select($select_fields) {
			if (empty($select_fields)) {
				$select = 'SELECT * FROM ';
			}
			else{
				$select = 'SELECT '.$select_fields . ' FROM ';
			}
			$select = $select." ".$this;

			return $select;
		}

		
	}



	/**
	 * 
	 */
	class Select extends Database
	{
		
		function __construct(argument)
		{
			
		}
	}

	



?>