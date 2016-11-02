# DataBaseConnection Wrapper #

A simple PHP DataBase Connection Library Wrapper. 
The goal is to be simple and to be close the native libraries : mysqli, pdo.

## Principle ##
 
 The goal is to have the less to maintain. If you have known different versions of php, of Pear db and mdb2... you know it is unpleasant to update large code sections.

## Use ##

There are two versions :
 
  - procedural DB : 

> $conn = connect(); 

  - object DB with prepared statements : 
> $myDB= new $db;  
> $connection=$myDB->connect();
 
## Param ##

The config file contains your connection params :
> $host="";  
> $database="";  
> $user="";  
> $pass="";  

These variable names are used in connect() function. So, if names are differents, change it in these two places.

In the procedural example, a global name is used to use connection : $conn = connect(). If you change this param name, in procedural you have to change this name in all function.

In order to switch beetween PDO and mysqli :
> $db= 'pdo';// OR 'mysqli'
 
You or i have  just the lib to maintain. And to ensure this is correctly maintenaid beetween mysqli and pdo, in POO there is an interface.
 
## Installation ##
 
 You have just to include this lib, as dir (or as a composer package - https://packagist.org/).
 In your composer.json file in your root, add :
>      "require": {
>        "phpdudimanche/db": ""
>     }

 In your composer console write :   
>     composer update
 
## Test ##
 
 With each version, you have a test file, just to run and to see. No testing tool needed. Tests can be used as examples.   
 
WARNING : there are three potential bugs :

- autoincrement (depends on your config : browser, VPN)
- rollback (depends on your config : autocommit, server)
- transaction (mysqli REPORT_ALL used in transaction test finds a fatal error in query "select * from tablename").