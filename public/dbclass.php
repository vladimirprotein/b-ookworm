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

		function select($select_str) {
			$select= "*";
			if (!empty($select_str)) {
				$select= $select_str;
			$conn= self::getInstance("localhost:3306", "root", "mindfire", "bookworm");
			$conn= self::$dbconn;
			$stmt= $conn->prepare("SELECT ".$select_str." from ".$this->tablename);
			$stmt->bind_param("ss", $select_str, $this->tablename);
			$stmt->execute();
			$result=$stmt->get_result();
			echo $result->fetch_assoc();
			}
		}


		/** 
   		* Method to get all the records from a table
   		* param table name.
   		* @returns result object.
 		*/

		/*public function viewall($tablename) {

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
		}*/		
	}

	class Book extends Database {
		var $tablename= 'book';


		function __construct() {
			;
		}
	}

	$book1= new Book();
	$book1->select("id, title");



	/**
	 * 
	 */
	


	class Person {
		var $name;
		var $gender;
		var $age;

		function __construct($name, $gender, $age) {
			$this->name= $name;
			$this->gender= $gender;
			$this->age= $age;
		}

		function person_details() {
			echo $this->name.", ".$this->gender.", is ".$this->age."<br>";
		}
	}


	class Employee extends Person {
		var $dept;
		function __construct($name, $gender, $age, $dept) {
			parent::__construct($name, $gender, $age);
			$this->dept = $dept;
		}

		function employee_details() {
			echo $this->name.", ".$this->gender.", is ".$this->age." and works in ".$this->dept."<br>";
		}
	}

	$person1= new Person("Animesh", "Male", "22");
	$employee1= new Employee("XYZ", "Female", "21", "IT");
	$employee2= new Employee("ABCD", "Male", "25", "HR");

	$person1->person_details();
	$employee2->person_details();
	$employee1->employee_details();

	



?>