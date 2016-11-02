<?php
namespace phpdudimanche\db;// for namespace add \ to PDO

class For_pdo implements DB{
	
	protected $conn=null;
	protected $prepare=null;
	
	public function special_error($msg){
		return "controller displays : ".$msg;// other choice : return die($mlsg) OR exit()
	}	
	public function connect(){
		global $host,$user,$pass,$database;
		try {
        $this->conn=new \PDO("mysql:host={$host};dbname={$database};",$user, $pass);// for namespace		
		return $this->conn;// display "PDO Object ( )"
		} catch(\PDOException $exception){// for namespace
        return $this->special_error( "Erreur de connexion: " . $exception->getMessage());
		}		
	}
	public function query($query){
		if(!$this->conn->query($query)){
		$info=$this->conn->errorInfo()[0].':'.$this->conn->errorInfo()[2];
		return $this->special_error($info);	//	
		}else{
		return $this->conn->query($query);	
		}
	}
	public function last_auto_increment(){
		return $this->conn->lastInsertId();// http://php.net/manual/fr/pdo.lastinsertid.php : last id for insert|update with autoincrement (becarefull to double insert with config browser)l
	}
	public function query_retrieve_all($query){
		return $query->fetchAll(\PDO::FETCH_ASSOC);// for namespace
	// http://php.net/manual/en/pdostatement.fetchall.php
	// PDO::FETCH_CLASS (object with class param) PDO::FETCH_COLUMN (indexed array with column order) PDO::FETCH_ASSOC (associative array with column name) PDO::FETCH_FUNC (call a function)
	}
	public function query_retrieve_one($query){
		return $query->fetch(\PDO::FETCH_ASSOC);// for namespace
		// http://php.net/manual/en/pdostatement.fetch.php
		// PDO::FETCH_CLASS (object with class param) PDO::FETCH_COLUMN (indexed array with column order) PDO::FETCH_ASSOC (associative array with column name) PDO::FETCH_FUNC (call a function) + PDO::FETCH_OBJ (anonymous object)
		//return $query->fetchObject();// http://php.net/manual/en/pdostatement.fetchobject.php
		// object targeted or not : $query->label, title $query->title		
	}
	public function query_prepare($query){
		$prepare=$this->conn->prepare($query);
		$this->prepare=$prepare;
	}
	public function query_run(){// $param better visibility = ':var' ADD type
		/* POSSIBLE direct in array, without bind
		for '?' -> array($id,$label,$title)
		for ':var' -> array(':id'=>$id,':label'=>$label,':title'=>$title)
		POSSIBLE for each var
		list[mysqli] PDO::PARAM_INT[i],(PDO::PARAM_STR,12)[s],PDO::PARAM_LOB[b]// php.net/manual/fr/pdo.constants.php
		bindParam(1,$id)// '?' next = 2,3
		bindParam(':id',$id)// ':' 
		bindParam(':id',$id,PDO::PARAM_INT)// ':'
		bindParam(':label',$label,PDO::PARAM_STR,50)
		*/
		$this->prepare->execute();// no more but was easy without bind $param, alla in execute(array)	
	}	
	function bindParameters(&$statement, &$params) { 
		$args   = array(); 
		$args[] = implode('', array_values($params)); 
		foreach ($params as $key => $value) { 
			$args[] = &$params[$key]; 
		} 
		$args=array_slice($args,2);// delete 2 first  http://php.net/manual/en/function.array-splice.php
		$i=1;	
		foreach ($args as $key => $value) { 
			$statement->bindParam($i,$args[$key]);// for each param : loop like : bindParam(1, $var)
			// TODO iss -> PDO::INT...
		$i++;
		}
	} 	
	public function query_bind(){
		 $mySize=func_num_args();
		 $myArg=func_get_args();
			$this->bindParameters($this->prepare,$myArg);
	}
	public function connection_param($status='on'){
		$this->conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);// http://php.net/manual/en/pdo.setattribute.php // for namespace
		$this->conn->setAttribute(\PDO::ATTR_AUTOCOMMIT,FALSE);// for namespace
	}
	public function transaction_begin(){
		return $this->conn->beginTransaction();
	}
	public function transaction_end(){
		return $this->conn->commit();
	}
	public function transaction_stop(){
		return $this->conn->rollBack();
	}
	public function disconnect(){		
		return $this->conn=null;
	}
}
?>