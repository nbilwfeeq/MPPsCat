<?php 

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "mpp_scat";

$connect = mysqli_connect($dbServername , $dbUsername , $dbPassword , $dbName) or die ('Failed to connect to db...');

?>