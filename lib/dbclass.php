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
		function run() {
			$conn= self::getInstance("localhost:3306", "root", "mindfire", "bookworm");
			$conn= self::$dbconn;
			$stmt= $conn->prepare($this->query);
			// $stmt->bind_param("s", $select);
			if(!$stmt->execute()) {
				exit();
			}
			echo $this->query;exit();
			return $stmt->get_result();
		}
		function insert($insert_str = '') {
			$query= "INSERT INTO ".$this->tablename."(".$insert_str.") ";
			$this->query .= $query;
			return $this;
		}
		function values($value_str='') {
			$value_arr= explode(",", $value_str);
			$query= " VALUES(";
			$i=0;
			while ($i<count($value_arr)) {
				$query.="'".$value_arr[$i]."',";
				$i++;
			}
			$query = rtrim($query,",");
			$query.=")";
			$this->query .= $query;
			return $this;
		}
		function update($update_str=''){
			$query= "UPDATE ".$this->tablename." SET ".$update_str." ";
			$this->query.=$query;
			return $this;
		}
		function delete(){
			$query= "DELETE FROM ".$this->tablename." ";
			$this->query.= $query;
			return $this;
		}
		function select($select_str = '*') {
			$query = "SELECT ".$select_str." FROM ".$this->tablename." ";
			$this->query .= $query;
			return $this;
		}
		function select_d($select_str = '*') {
			$query = "SELECT DISTINCT ".$select_str." FROM ".$this->tablename." ";
			$this->query .= $query;
			return $this;
		}
		function where($where) {
			$query = " WHERE ".$where;
			$this->query .= $query;
			return $this;
		}
		function limit($limit){ //to be written after ORDERBY
			$query = " LIMIT ".$limit." ";
			$this->query .= $query;
			return $this;
		}
		function orderby($orderby) {
			$query = " ORDER BY ".$orderby;
			$this->query .= $query;
			return $this;
		}
		function ij($ij){
			$query= $this->tablename." INNER JOIN ".$ij." ";
			$this->tablename= $query;
			return $this;
		}
		function lj($lj){
			$query= $this->tablename." LEFT JOIN ".$lj." ";
			$this->tablename= $query;
			return $this;
		}
		function rj($rj){
			$query= $this->tablename." RIGHT JOIN ".$rj." ";
			$this->tablename= $query;
			return $this;
		}
		function oj($oj){
			$query= $this->tablename." FULL OUTER JOIN ".$oj." ";
			$this->tablename= $query;
			return $this;
		}
		function on($on){
			$query= " ON ".$on." ";
			$this->tablename= "(".$this->tablename.$query.")";
			return $this;
		}
		function group($group){
			$query= " GROUP BY ".$group." ";
			$this->query.= $query;
			return $this;
		}
		function having($having){
			$query= " HAVING ".$having." ";
			$this->query.= $query;
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
		var $tablename;
		function __construct() {
			$this->tablename= 'book';
		}
	}
	class Author extends Database {
		var $tablename;
		function __construct() {
			$this->tablename= 'author';
		}
	}

	$book1= new Book();
	//$book1->select('min(id) as id')->run();
	$book1->oj('book_seller')->on('book.id=book_seller.book_id')->rj('user')->on('user.id=book_seller.user_id')->select('user.unique_id, user.name, book.book_isbn, book.title, book_seller.price')->group('ghanta')->run();

	$author1= new Author();
	//$author1->insert("author_reg, name")->values("aaaaaz, aaaaaaaaaqqqqq")->run();
	//$author1->update("id=99")->where("author_reg='aaaaaz'")->run();



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