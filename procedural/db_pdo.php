<?php // db_pdo.php pdo is used as an object in a procedural code // for manual all languages with : fr|en
function special_error($msg){
	 return "controller displays : ".$msg;
}
function connect(){
	global $host,$user,$pass,$database;
	try {
	$pdo= @new PDO("mysql:host={$host};dbname={$database}", $user, $pass);//http://php.net/manual/en/pdo.connections.php
	return $pdo;
	}catch(PDOException $e){
	return special_error($e->getMessage());	
	}
}
function query_write($query){
	global $conn;
	if(!$conn->exec($query)){ // number of lines affected
		$info=$conn->errorInfo()[0].':'.$conn->errorInfo()[2];
		return special_error($info);
	}else{
	   return $conn->exec($query);// http://php.net/manual/en/pdo.exec.php
	}
}
function last_auto_increment(){
	global $conn;
	return $conn->lastInsertId();// http://php.net/manual/fr/pdo.lastinsertid.php : last id for insert|update with autoincrement (becarefull to double insert with config browser)l
}
function query_read($query){
	global $conn;
	if(!$conn->query($query)){ 
		$info=$conn->errorInfo()[0].':'.$conn->errorInfo()[2];
		return special_error($info);
	}else{
	   return $conn->query($query);// http://php.net/manual/en/pdo.query.php
	}
}
function query_retrieve_all($query){
	return $query->fetchAll(PDO::FETCH_ASSOC);
	// http://php.net/manual/en/pdostatement.fetchall.php
	// PDO::FETCH_CLASS (object with class param) PDO::FETCH_COLUMN (indexed array with column order) PDO::FETCH_ASSOC (associative array with column name) PDO::FETCH_FUNC (call a function)
}
function query_retrieve_one($query){
	return $query->fetch(PDO::FETCH_ASSOC);
	// http://php.net/manual/en/pdostatement.fetch.php
	// PDO::FETCH_CLASS (object with class param) PDO::FETCH_COLUMN (indexed array with column order) PDO::FETCH_ASSOC (associative array with column name) PDO::FETCH_FUNC (call a function) + PDO::FETCH_OBJ (anonymous object)
	//return $query->fetchObject();// http://php.net/manual/en/pdostatement.fetchobject.php
	// object targeted or not : $query->label, title $query->title
}
function disconnect(){
	global $conn;
	return $conn=null;//http://php.net/manual/en/pdo.connections.php
}
?>