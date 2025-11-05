<?php
header('Content-Type: application/json');
include 'conf/db_connect.php';
session_start();

if (!isset($_SESSION['judge_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must log in first.']);
    exit;
}

$judge_id = $_SESSION['judge_id'];
$data = json_decode(file_get_contents("php://input"), true);
$evaluations = $data['evaluations'] ?? [];

if (empty($evaluations)) {
    echo json_encode(['status' => 'error', 'message' => 'No evaluations submitted']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO evaluations (judge_id, project_id, score, comments) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $judge_id, $project_id, $score, $comments);

foreach ($evaluations as $eval) {
    $project_id = $eval['project_id'];
    $score = $eval['score'] ?? 10; // optional score
    $comments = $eval['comments'] ?? '';
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(['status' => 'success', 'message' => 'Evaluations saved successfully']);
?>
