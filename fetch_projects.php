<?php
header('Content-Type: application/json');
include 'conf/db_connect.php';

$sql = "SELECT * FROM projects ORDER BY campus, id";
$result = $conn->query($sql);

$projects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

echo json_encode($projects);

$conn->close();
?>
