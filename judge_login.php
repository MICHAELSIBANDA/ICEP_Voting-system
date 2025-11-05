<?php
header('Content-Type: application/json');
include 'db_connect.php';
session_start();

// Get POST data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Email and password required']);
    exit;
}

// Query for the judge
$stmt = $conn->prepare("SELECT * FROM judges WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$judge = $result->fetch_assoc();

if ($judge) {
    // ✅ Compare plain-text password (no hash)
    if ($password === $judge['password']) {
        $_SESSION['judge_id'] = $judge['id'];
        echo json_encode([
            'status' => 'success',
            'name' => $judge['name'],
            'email' => $judge['email']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Judge not found']);
}

$conn->close();
?>
