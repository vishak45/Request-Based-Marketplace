<?php
$server="localhost";
$username="root";
$password="vishak@123";
$database="products_db";

$connection=new mysqli($server,$username,$password,$database);
if($connection->connect_error){

    die("Connection failed: " . $connection->connect_error);
}   

?>