<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "icep_awards";

$conn = new mysqli("localhost", "root", "", "icep_awards");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
