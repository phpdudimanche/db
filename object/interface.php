<?php
namespace phpdudimanche\db;

interface DB
{
	public function special_error($msg);// SPECIFIC to display error
    public function connect();// get var config file
    public function query($query);// for all CRUD queries
	public function last_auto_increment();// if an autoincrement table
	public function query_retrieve_all($query);// you can choose, by default : associative array
	public function query_retrieve_one($query);// you can choose, by default : associative array
	public function query_prepare($query);// prepared statements
	public function bindParameters(&$statement, &$params);// SPECIFIC for prepared statements 
	public function query_bind();// prepared statements
	public function query_run();// prepared statements
	public function connection_param();// SPECIFIC for transaction param : catch error, commir
	public function transaction_begin();
	public function transaction_end();
	public function transaction_stop();
	public function disconnect();
}
?>