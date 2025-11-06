<?php
include 'conf/db_connect.php';

// Read JSON data from frontend
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['nominations'])) {
    echo json_encode(["status" => "error", "message" => "No nominations submitted."]);
    exit;
}

$judge_name = $data['judge_name'] ?? 'Unknown Judge';
$campus = $data['campus'] ?? 'sosha';
$nominations = $data['nominations'];

$stmt = $conn->prepare("INSERT INTO evaluations (judge_name, campus, category, student_id, student_name, student_email, reason) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");

foreach ($nominations as $nomination) {
    $student = $nomination['student'];
    $stmt->bind_param(
        "sssssss",
        $judge_name,
        $campus,
        $nomination['category'],
        $student['id'],
        $student['name'],
        $student['email'],
        $nomination['reason']
    );
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(["status" => "success", "message" => "Nominations saved successfully!"]);
?>
