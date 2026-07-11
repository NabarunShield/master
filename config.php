<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "php_crud_demo";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
