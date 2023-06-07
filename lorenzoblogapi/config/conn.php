<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();


define('SERVERNAME', $_ENV['SERVERNAME']);
define('USERNAME', $_ENV['USERNAME']);
define('PASSWORD', '');
define('DBNAME', $_ENV['DBNAME']);

$conn = mysqli_connect(SERVERNAME,USERNAME,PASSWORD,DBNAME);

if(!$conn){
     mysqli_connect_error();
}

?>

