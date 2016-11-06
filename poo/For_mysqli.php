<?php
namespace Phpdudimanche\Db;// for namespace add \ to mysqli

class For_mysqli implements Db{
	
	protected $conn=null;
	protected $prepare=null;	
	
	public function special_error($msg){		
		return "controller displays : ".$msg;// return die("controller displays : ".$msg); OR msg and exit();
	}
	public function connect(){
		global $host,$user,$pass,$database;
		$this->conn= @new \mysqli($host, $user, $pass, $database);// for namespace
		if ($this->conn->connect_errno!=''){
		return $this->special_error($this->conn->connect_errno.':'.$this->conn->connect_error);
		}else{
		return $this->conn;
		}

	}
	public function query($query){
		if(!$this->conn->query($query)){
			return $this->special_error($this->conn->errno.':'.$this->conn->error);
		}else{
			return $this->conn->query($query);// display ''	
		}
	}
	public function last_auto_increment(){
		return $this->conn->insert_id;// http://php.net/manual/en/mysqli.insert-id.php : last id for insert|update with autoincrement (becarefull to double insert with config browser)
}
	public function query_retrieve_all($query){
		return $query->fetch_all(MYSQLI_ASSOC);// http://php.net/manual/en/mysqli-result.fetch-all.php	
		// MYSQLI_ASSOC (associative with field name), MYSQLI_NUM (query num order)
	}
	public function query_retrieve_one($query){
		return $query->fetch_array(MYSQLI_ASSOC);// http://php.net/manual/en/mysqli-result.fetch-array.php
		// MYSQLI_ASSOC (associative with field name), MYSQLI_NUM (query num order)
		//return $query->fetch_assoc();//http://php.net/manual/en/mysqli-result.fetch-assoc.php 
		// associative array
		//return $query->fetch_object();// http://php.net/manual/en/mysqli-result.fetch-object.php
		// object targeted or not : $query->label, title $query->title
		//return $query->fetch_row();// http://php.net/manual/en/mysqli-result.fetch-row.php
		// indexed array
	}
	public function query_prepare($query){
		$prepare=$this->conn->prepare($query);
		$this->prepare=$prepare;		
	}
	public function query_run(){	
		$this->prepare->execute();// possible direct array in pdo
	}	
	function bindParameters(&$statement, &$params) {
	  $args   = array(); 
	  $args[] = implode(',', array_values($params));  
	  foreach ($params as $key => $value) { 
		$args[] = &$params[$key]; 
	  }  
	  $deleteFirst = array_shift($args);// Array ( [0] => iss,2,label 2,title 2 ) http://php.net/manual/en/function.array-shift.php
	  call_user_func_array(array(&$statement, 'bind_param'), $args); 
	} 	
	public function query_bind(){
		//$mySize=func_num_args();
		$myArg=func_get_args();
			$this->bindParameters($this->prepare,$myArg);
	}
	public function connection_param($status='on'){
		$driver = new \mysqli_driver();// for namespace
		if ($status=='on'){
			$driver->report_mode =MYSQLI_REPORT_ALL;// http://www.php.net/manual/en/mysqli-driver.report-mode.php 
		}
		else{
			$driver->report_mode =MYSQLI_REPORT_ERROR;// because MYSQLI_REPORT_ALL is TOO HIGH
		}
	}		
	public function transaction_begin(){
		return $this->conn->begin_transaction();
	}
	public function transaction_end(){
		return $this->conn->commit();
	}
	public function transaction_stop(){
		return $this->conn->rollback();
	}
	public function disconnect(){
		$this->conn->close();// http://php.net/manual/en/mysqli.close.php
	}
}
?>