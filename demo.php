<?php
 /**
  * 
  */
 class ClassName
 {
 	public $attrArray = [];
 	public $name = 'demo';
 	
 	public function __construct()
 	{
 		echo "start";
 	}

 	public function __get($attr)
 	{
 		return 'getter';
 	}

 	public function __set($attr, $value)
 	{
 		$this->attrArray[$attr] = 25;
 	}

 	public static function __callStatic($methodName, $arg)
 	{
 		$this->$methodName();
 	}

 	public function __call($methodName, $arg)
 	{
 		echo "string";
 		return $this->{$arg[0]};
 	}

 	public function one() {
 		echo "-1-";
 		return $this;
 	}

 	public function two() {
 		echo "-2-";
 		return $this;
 	}

 	public function three() {
 		echo "-3-";
 		return $this;
 	}

 	public function finalPoint() {
 		echo "end";
 	}

 }

$obj = (new ClassName());

echo $obj->display('age');