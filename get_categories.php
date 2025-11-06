<?php
include 'conf/db_connect.php';

$campus = $_GET['campus'] ?? 'sosha';
$categories = [];

$sql = "SELECT category_key, category_name FROM campus_categories WHERE campus = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $campus);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $categories[$row['category_key']] = $row['category_name'];
}

$stmt->close();
$conn->close();

echo json_encode($categories);
?>
