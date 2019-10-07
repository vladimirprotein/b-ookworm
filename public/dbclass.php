<?php
	class Database {
		protected static $connection = null;
		protected static $dbconn = null;
		protected $query= null;

      	protected function __construct($servername, $username, $password, $dbname) {
      		static::$dbconn = new mysqli($servername, $username, $password, $dbname);
		}

		protected static function getInstance($servername, $username, $password, $dbname) {
			if (!self::$connection) {
				self::$connection = new self($servername, $username, $password, $dbname);
			}

			return self::$connection;
		}

		function get() {
			$conn= self::getInstance("localhost:3306", "root", "mindfire", "bookworm");
			$conn= self::$dbconn;
			$stmt= $conn->prepare($this->query);
			//$stmt->bind_param("s", $select);
			if(!$stmt->execute()) {
				exit;
			}
			$result=$stmt->get_result();
			while ($row= $result->fetch_assoc()){
				echo $row['id'];
				echo "<br>";
			}
		}


		function select($select_str = '*') {
			$query = "SELECT ".$select_str." FROM ".$this->tablename." ";
			$this->query .= $query;
			return $this;
		}

		function where($where) {
			$query = " WHERE ".$where;
			$this->query .= $query;
			return $this;
		}

		function orderby($orderby) {
			$query = " ORDER BY ".$orderby;
			$this->query .= $query;
			return $this;
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
	$book1->select('')->where('id = 63')->orderby('id asc')->get();



	/**
	 * 
	 */
	


	// class Person {
	// 	var $name;
	// 	var $gender;
	// 	var $age;

	// 	function __construct($name, $gender, $age) {
	// 		$this->name= $name;
	// 		$this->gender= $gender;
	// 		$this->age= $age;
	// 	}

	// 	function person_details() {
	// 		echo $this->name.", ".$this->gender.", is ".$this->age."<br>";
	// 	}
	// }


	// class Employee extends Person {
	// 	var $dept;
	// 	function __construct($name, $gender, $age, $dept) {
	// 		parent::__construct($name, $gender, $age);
	// 		$this->dept = $dept;
	// 	}

	// 	function employee_details() {
	// 		echo $this->name.", ".$this->gender.", is ".$this->age." and works in ".$this->dept."<br>";
	// 	}
	// }

	// $person1= new Person("Animesh", "Male", "22");
	// $employee1= new Employee("XYZ", "Female", "21", "IT");
	// $employee2= new Employee("ABCD", "Male", "25", "HR");

	// $person1->person_details();
	// $employee2->person_details();
	// $employee1->employee_details();

	



?>