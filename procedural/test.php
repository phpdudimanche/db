<?php // test examples for procedural DB
require_once('cfg.php');

	$database="tester";// wrong
echo "<pre>";
echo "KO - TEST 01 error : connection error <br />";
	$conn = connect();
print_r($conn);
echo "</pre>";

	$database="test";// good
	$conn = connect();
echo "<pre>";
echo "OK - TEST 02 good connection <br />";
print_r($conn);
echo "</pre>";

// TEAR-DOWN
$query="DROP TABLE IF EXISTS cat";
$query=query_write($query);
// SET-UP
$query="CREATE TABLE cat(
	id INT(3) PRIMARY KEY,
	label VARCHAR(50),
	title VARCHAR(150)
)";
$query=query_write($query);
$query="INSERT INTO cat (id,label,title) VALUES (3,'lien','titre'),(1,'lien 1','titre 1')";
$query=query_write($query);

$query="CREATE TABLE cat(
	id INT(3) PRIMARY KEY,
	label VARCHAR(50),
	title VARCHAR(150)
)";
$query=query_write($query);
echo "<pre>";
echo "KO - TEST 03 erreur Create table <br />";
print_r($query);
echo "</pre>";

$query="CREATE TABLE IF NOT EXISTS cat(
	id INT(3) PRIMARY KEY,
	label VARCHAR(50),
	title VARCHAR(150)
)";
$query=query_write($query);
echo "<pre>";
echo "OK - TEST 04 Create table yet existent <br />";
print_r($query);
echo "</pre>";

$query="INSERT INTO cat (id,label,title) VALUES (3,'label 3','title 3')";
$query=query_write($query);
echo "<pre>";
echo "KO - TEST 05 Error : Insert data on duplicate content <br />";
print_r($query);
// TO VERIFY
$query="select * from cat";
$query=query_read($query);
echo "<br />RESULT : id 3 yet exists<br />";
print_r($query);
$query=query_retrieve_all($query);
print_r($query);
echo "</pre>";

$query="INSERT INTO cat (id,label,title) VALUES (3,'label 3','title 3') ON DUPLICATE KEY update  label='title MAJ',title='title MAJ'";
$query=query_write($query);
echo "<pre>";
echo "OK - TEST 06 Insert or update data on duplicate content <br />";
print_r($query);
echo "</pre>";

$query="select * from table cat";
$query=query_read($query);
echo "<pre>";
echo "KO - TEST 07 Error : Wrong select <br />";
print_r($query);
echo "</pre>";

$query="select * from cat";
$query=query_read($query);
echo "<pre>";
echo "OK - TEST 08 Good select (see MAJ for id 3 in next test)<br />";
print_r($query);
echo "</pre>";

$query=query_retrieve_all($query);
echo "<pre>";
echo "OK - TEST 09 Select all result in array (or object) <br />";
print_r($query);
echo "</pre>";

$query="select * from cat";
$query=query_read($query);
$query=query_retrieve_one($query);
echo "<pre>";
echo "OK - TEST 10 Select first or unique result in array (or object) <br />";
print_r($query);
echo "<br />Display example for id $query[id] , label $query[label], title $query[title]";
echo "</pre>";

error_reporting(E_ALL ^ E_WARNING);
$conn = disconnect();// connection closed
echo "<pre>";
echo "KO - TEST 11 deconnection with warning error to disable (for display in mysqli)<br />";
print_r($conn);
echo "</pre>";

// TEAR-DOWN
$conn = connect();
$query="TRUNCATE TABLE cat";
$query=query_write($query);
//print_r($query);// return 1

echo "<pre>";
echo "OK - Test 12 if table with autoincrement (becarefull to bug with twice insert instead of one), ";
$query="CREATE TABLE IF NOT EXISTS auto(
	id INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
	label VARCHAR(50),
	title VARCHAR(150),
	PRIMARY KEY (id)
)";
$query=query_write($query);

$query="INSERT INTO auto (label,title) VALUES ('lien','titre')";// ,('lien 1','titre 1')
$query=query_write($query);// twice in wamp
echo "<br />display the next auto increment ID = ";
$query=last_auto_increment();
print_r($query);

$query="select * from auto";
$query=query_read($query);
echo "<br />The proof :<br />";
print_r($query);

$query=query_retrieve_all($query);
echo "display data<br />";
print_r($query);
echo "</pre>";

$query="TRUNCATE TABLE auto";
$query=query_write($query);
?>