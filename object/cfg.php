<?php
//namespace phpdudimanche\db;

	$host="localhost";
	$database="test";// tester = error for connect
	$user="root";
	$pass="";

$db='mysqli';// pdo OR mysqli
$db='\phpdudimanche\db\For_'.$db;// class name for object DOI NOT OMITT first \
	
require_once('interface.php');
require_once('For_pdo.php');
require_once('For_mysqli.php');
?>