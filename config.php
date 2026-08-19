<?php

//connecting to server in mysql using procedural method
$severname = "localhost";
$username = "root";
$password ="";
$dbname = "unyc";

$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn){
    die ('connection error:'.mysqli_connect_error());
}


?>