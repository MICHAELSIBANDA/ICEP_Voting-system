<?php
include 'conf/db_connect.php';

$campus = $_GET['campus'] ?? 'sosha'; // default if not provided
$students = [];

$sql = "SELECT * FROM nominations WHERE campus = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $campus);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($students);
?>
