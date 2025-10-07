<?php
$servername = "localhost"; //server name
$username = "root"; //username
$password = ""; //password
$dbname = "malcolmlismoredb"; //database name

//Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check Connection
if ($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}
?>