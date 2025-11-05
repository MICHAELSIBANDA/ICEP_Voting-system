<?php
header('Content-Type: application/json');
include 'conf/db_connect.php';
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['judge_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$judge_id = $_SESSION['judge_id'];
$evaluations = $data['evaluations'] ?? [];

if (empty($evaluations)) {
    echo json_encode(['status' => 'error', 'message' => 'No evaluations submitted']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO evaluations (judge_id, project_id, score, comments) VALUES (?, ?, ?, ?)");

foreach ($evaluations as $eval) {
    $stmt->bind_param("isis", $judge_id, $eval['project_id'], $eval['score'], $eval['comments']);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(['status' => 'success', 'message' => 'Evaluations saved successfully']);
?>
