<?php
//namespace Phpdudimanche\Db;

	$host="localhost";
	$database="test";// tester = error for connect
	$user="root";
	$pass="";

$db='mysqli';// pdo OR mysqli
$db='\Phpdudimanche\Db\For_'.$db;// class name for object DOI NOT OMITT first \

// include('vendor/autoload.php');// with PSR-4, replace the others require
	
require_once('Db.php');
require_once('For_pdo.php');
require_once('For_mysqli.php');
?>