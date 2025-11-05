<?php
include 'conf/db_connect.php';
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Missing email or password']);
    exit;
}

$sql = "SELECT * FROM students WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($password === $user['password']) {
        $_SESSION['student_id'] = $user['id'];
        echo json_encode([
            'status' => 'success',
            'name' => $user['name'],
            'email' => $user['email'],
            'campus' => $user['campus']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Student not found']);
}
?>
