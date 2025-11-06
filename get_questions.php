<?php
include 'conf/db_connect.php';

$questions = [];

$result = $conn->query("SELECT category_key, question FROM category_questions");
while ($row = $result->fetch_assoc()) {
    $questions[$row['category_key']] = $row['question'];
}

$conn->close();
echo json_encode($questions);
?>
