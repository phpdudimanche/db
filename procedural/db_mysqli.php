<?php // db_mysqli.php mysqli is used as an object in a procedural code // for manual all languages with : fr|en
function special_error($msg){
	 return "controller displays : ".$msg;
}
function connect(){
	global $host,$user,$pass,$database;
	$mysqli= @new mysqli($host, $user, $pass, $database);// http://php.net/manual/fr/mysqli.quickstart.connections.php
	if ($mysqli->connect_errno!=''){
		return special_error($mysqli->connect_errno.':'.$mysqli->connect_error);
	}else{
		return $mysqli;
	}	
}
function query_write($query){
	global $conn;
	if(!$conn->query($query)){ 
		return special_error($conn->errno.':'.$conn->error);
	}else{
	   return $conn->query($query);//http://php.net/manual/fr/mysqli.query.php
	}	
}
function last_auto_increment(){
	global $conn;
	return $conn->insert_id;// http://php.net/manual/fr/mysqli.insert-id.php : last id for insert|update with autoincrement (becarefull to double insert with config browser)
}
function query_read($query){
	global $conn;
	if(!$conn->query($query)){
		return special_error($conn->errno.':'.$conn->error);
	}else{
	   return $conn->query($query);// http://php.net/manual/fr/mysqli.query.php
	} // usefull [num_rows] (line) and [field_count] (column)
}
function query_retrieve_all($query){
		return $query->fetch_all(MYSQLI_ASSOC);// http://php.net/manual/fr/mysqli-result.fetch-all.php	
		// MYSQLI_ASSOC (associative with field name), MYSQLI_NUM (query num order)
}
function query_retrieve_one($query){
		return $query->fetch_array(MYSQLI_ASSOC);// http://php.net/manual/fr/mysqli-result.fetch-array.php
		// MYSQLI_ASSOC (associative with field name), MYSQLI_NUM (query num order)
		//return $query->fetch_assoc();//http://php.net/manual/fr/mysqli-result.fetch-assoc.php 
		// associative array
		//return $query->fetch_object();// http://php.net/manual/fr/mysqli-result.fetch-object.php
		// object targeted or not : $query->label, title $query->title
		//return $query->fetch_row();// http://php.net/manual/fr/mysqli-result.fetch-row.php
		// indexed array
}
function disconnect(){
	global $conn;
	$conn->close();// http://php.net/manual/fr/mysqli.close.php
}
?>