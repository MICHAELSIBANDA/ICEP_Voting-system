<?php
include 'db_connect.php';
session_start();

$student_id = $_SESSION['student_id'];
$category = $_POST['category'];
$nominee_id = $_POST['nominee_id'];

$sql = "INSERT INTO nominations (student_id, category, nominated_by) VALUES ('$nominee_id', '$category', '$student_id')";
if ($conn->query($sql)) {
    echo "Nomination submitted successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>
