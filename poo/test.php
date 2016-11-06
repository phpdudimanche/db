<?php // test examples for poo DB
// namespace Phpdudimanche\Db;
require_once('cfg.php');
$myDB= new $db;

	$database="tester";// wrong
echo "<pre>";
echo "KO - TEST 01 error : connection error <br />";
	$myDB=new $db;//$conn = connect();	 \phpdudimanche\db\For_pdo
	$conn=$myDB->connect();
print_r($conn);
echo "</pre>";

	$database="test";// good
	$myDB=new $db;// $conn = connect();
	$conn=$myDB->connect();
echo "<pre>";
echo "OK - TEST 02 good connection <br />";
print_r($conn);
echo "</pre>";

// TEAR-DOWN
$query="DROP TABLE IF EXISTS cat";
//$query=query_write($query);
$query=$myDB->query($query);
// SET-UP
$query="CREATE TABLE cat(
	id INT(3) PRIMARY KEY,
	label VARCHAR(50),
	title VARCHAR(150)
)";
//$query=query_write($query);
$query=$myDB->query($query);
$query="INSERT INTO cat (id,label,title) VALUES (3,'lien','titre'),(1,'lien 1','titre 1')";
//$query=query_write($query);
$query=$myDB->query($query);

$query="CREATE TABLE cat(
	id INT(3) PRIMARY KEY,
	label VARCHAR(50),
	title VARCHAR(150)
)";
//$query=query_write($query);
$query=$myDB->query($query);
echo "<pre>";
echo "KO - TEST 03 erreur Create table <br />";
print_r($query);
echo "</pre>";

$query="CREATE TABLE IF NOT EXISTS cat(
	id INT(3) PRIMARY KEY,
	label VARCHAR(50),
	title VARCHAR(150)
)";
//$query=query_write($query);
$query=$myDB->query($query);
echo "<pre>";
echo "OK - TEST 04 Create table yet existent <br />";
print_r($query);
echo "</pre>";

$query="INSERT INTO cat (id,label,title) VALUES (3,'label 3','title 3')";
//$query=query_write($query);
$query=$myDB->query($query);
echo "<pre>";
echo "KO - TEST 05 Error : Insert data on duplicate content <br />";
print_r($query);
// TO VERIFY
$query="select * from cat";
//$query=query_read($query);
$query=$myDB->query($query);
echo "<br />RESULT : id 3 yet exists<br />";
print_r($query);
//$query=query_retrieve_all($query);
$query=$myDB->query_retrieve_all($query);
print_r($query);
echo "</pre>";

$query="INSERT INTO cat (id,label,title) VALUES (3,'label 3','title 3') ON DUPLICATE KEY update  label='title MAJ',title='title MAJ'";
//$query=query_write($query);
$query=$myDB->query($query);
echo "<pre>";
echo "OK - TEST 06 Insert or update data on duplicate content <br />";
print_r($query);
echo "</pre>";

$query="select * from table cat";
//$query=query_read($query);
$query=$myDB->query($query);
echo "<pre>";
echo "KO - TEST 07 Error : Wrong select <br />";
print_r($query);
echo "</pre>";

$query="select * from cat";
//$query=query_read($query);
$query=$myDB->query($query);
echo "<pre>";
echo "OK - TEST 08 Good select (see MAJ for id 3 in next test)<br />";
print_r($query);
echo "</pre>";

//$query=query_retrieve_all($query);
$query=$myDB->query_retrieve_all($query);
echo "<pre>";
echo "OK - TEST 09 Select all result in array (or object) <br />";
print_r($query);
echo "</pre>";

$query="select * from cat";
//$query=query_read($query);
$query=$myDB->query($query);
//$query=query_retrieve_one($query);
$query=$myDB->query_retrieve_one($query);
echo "<pre>";
echo "OK - TEST 10 Select first or unique result in array (or object) <br />";
print_r($query);
echo "<br />Display example for id $query[id] , label $query[label], title $query[title]";
echo "</pre>";

error_reporting(E_ALL ^ E_WARNING);
//$conn = disconnect();
$myDB->disconnect();
echo "<pre>";
echo "KO - TEST 11 deconnection with warning error to disable (for display in mysqli)<br />";
print_r($conn);
echo "</pre>";

//$conn = connect();
$conn=$myDB->connect();

echo "<pre>";
echo "OK - Test 12 if table with autoincrement (becarefull to bug with twice insert instead of one), ";
$query="CREATE TABLE IF NOT EXISTS auto(
	id INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
	label VARCHAR(50),
	title VARCHAR(150),
	PRIMARY KEY (id)
)";
//$query=query_write($query);
$query=$myDB->query($query);

$query="INSERT INTO auto (label,title) VALUES ('lien','titre')";// ,('lien 1','titre 1')
//$query=query_write($query);// twice in wamp
$query=$myDB->query($query);
echo "<br />display the last auto increment ID = ";
//$query=last_auto_increment();
$query=$myDB->last_auto_increment();
print_r($query);

$query="select * from auto";
//$query=query_read($query);
$query=$myDB->query($query);
echo "<br />The proof :<br />";
print_r($query);

//$query=query_retrieve_all($query);
$query=$myDB->query_retrieve_all($query);
echo "display data<br />";
print_r($query);
echo "</pre>";

echo "<pre>OK - Test 13 prepared statements";
$query="INSERT INTO cat (id,label,title) VALUES (?,?,?)";
$prepare=$myDB->query_prepare($query);
$id=65;$label='label 65';$title='title 65';
$myDB->query_bind('iss',$id,$label,$title);
$myDB->query_run();
$id=68;$label='label 68';$title='title 68';
$myDB->query_bind('iss',$id,$label,$title);
$myDB->query_run();
$query="SELECT * FROM cat";
$query=$myDB->query($query);
$query=$myDB->query_retrieve_all($query);
echo "<br />You can see id 65 and 68</br>";
print_r($query);
echo "</pre>";

echo "<pre>OK - Test 14 transaction";
try{
		$myDB->connection_param();
		$myDB->transaction_begin();
			//print ' is working='.$myDB->conn->inTransaction();// TRUE / FALSE 0 : http://php.net/manual/en/pdo.intransaction.php
	$query="UPDATE cat SET label='txt 6-5', title='t-6-t5' WHERE id=65";
	$query=	$myDB->query($query);//$myDB->conn->exec($query);
	$query="DELETE FROM cat WHERE id=68";
	$query= $myDB->query($query);
	$query="SELECT * FROM t cat";// fatal error before exception (if retrieve all) BUG mysqli "No index used in query/prepared statement"
	$query=$myDB->query($query);
	//throw new \Exception("test"); // for namespace add \ to Exception	
		$final=$myDB->transaction_end();
		//echo ' commit='.$final;// 0 if FALSE
}	
catch(\Exception $e)// for namespace add \ to Exception
	{// INTERCEPTION with param function !
		$myDB->transaction_stop();// THE TRANSACTION'S ADVANTAGE (rollback)
		echo "<br /><b>ROLLBACK ! (becarefull to bug with autocommit) </b><br />";
		echo $e->getMessage();
	}	
$myDB->connection_param('off');
	
echo "<br />(if no rollback)You can see the text from id 65 has changed and id 68 has been deleted<br />";	
$query="SELECT * FROM cat";
$query=$myDB->query($query);
$query=$myDB->query_retrieve_all($query);
print_r($query);
echo "</pre>";

// TEAR-DOWN
$query="TRUNCATE TABLE cat";
//$query=query_write($query);
$query=$myDB->query($query);
//print_r($query);// return 1
$query="TRUNCATE TABLE auto";
//$query=query_write($query);
$query=$myDB->query($query);
?>