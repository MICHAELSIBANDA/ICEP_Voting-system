<?php
header('Content-Type: application/json');
include 'conf/db_connect.php';
session_start();

// Get POST data
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Email and password required']);
    exit;
}

// Query for the admin
$stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc(); // ✅ Use consistent variable name

if ($admin) {
    // ✅ Compare plain-text password (or hash if you add one later)
    if ($password === $admin['password']) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_email'] = $admin['email'];

        echo json_encode([
            'status' => 'success',
            'name' => $admin['name'],
            'email' => $admin['email']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Admin not found']);
}

$conn->close();
?>
