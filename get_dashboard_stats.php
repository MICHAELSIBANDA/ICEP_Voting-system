<?php
include 'conf/db_connect.php';
header('Content-Type: application/json');

$response = [
    'total_nominations' => 0,
    'student_nominations' => 0,
    'supervisor_nominations' => 0,
    'registered_students' => 0,
    'top_projects' => [],
    'top_students' => [],
    'nominations' => [
        'students' => [],
        'projects' => []
    ]
];

// 🧑‍🎓 Registered students
$studentCountQuery = $conn->query("SELECT COUNT(*) AS total FROM students");
if ($studentCountQuery && $row = $studentCountQuery->fetch_assoc()) {
    $response['registered_students'] = (int)$row['total'];
}

// 🎓 Student nominations (you may later refine this logic)
$studentNomQuery = $conn->query("SELECT COUNT(*) AS total FROM students");
if ($studentNomQuery && $row = $studentNomQuery->fetch_assoc()) {
    $response['student_nominations'] = (int)$row['total'];
}

// 🧑‍🏫 Project nominations (based on evaluations)
$projectNomQuery = $conn->query("SELECT COUNT(*) AS total FROM evaluations");
if ($projectNomQuery && $row = $projectNomQuery->fetch_assoc()) {
    $response['supervisor_nominations'] = (int)$row['total'];
}

// 🧮 Total nominations
$response['total_nominations'] = $response['student_nominations'] + $response['supervisor_nominations'];

// 📊 Top nominated projects
$topProjectsQuery = $conn->query("
    SELECT project_id, COUNT(*) AS nominations 
    FROM evaluations 
    GROUP BY project_id 
    ORDER BY nominations DESC 
    LIMIT 5
");

if ($topProjectsQuery && $topProjectsQuery->num_rows > 0) {
    while ($row = $topProjectsQuery->fetch_assoc()) {
        $response['top_projects'][] = [
            'project' => $row['project_id'],
            'nominations' => (int)$row['nominations']
        ];
    }
}

// 🏆 Top nominated students
$topStudentsQuery = $conn->query("
    SELECT name, COUNT(*) AS nominations 
    FROM students 
    GROUP BY name 
    ORDER BY nominations DESC 
    LIMIT 5
");
if ($topStudentsQuery && $topStudentsQuery->num_rows > 0) {
    while ($row = $topStudentsQuery->fetch_assoc()) {
        $response['top_students'][] = [
            'student' => $row['name'],
            'nominations' => (int)$row['nominations']
        ];
    }
}

// 🗂️ All Nominations (from nominations table)
$allStudentQuery = $conn->query("
    SELECT id, student_id, email, name, programme, role, specialization, project, campus, categories
    FROM nominations
   
");
if ($allStudentQuery && $allStudentQuery->num_rows > 0) {
    while ($row = $allStudentQuery->fetch_assoc()) {
        $response['nominations']['students'][] = $row;
    }
}

// 💼 All Project Nominations (from project table)
$allProjectQuery = $conn->query("
    SELECT id, name, team, description, category, year, campus
    FROM projects
");
if ($allProjectQuery && $allProjectQuery->num_rows > 0) {
    while ($row = $allProjectQuery->fetch_assoc()) {
        $response['nominations']['projects'][] = $row;
    }
}

echo json_encode(['status' => 'success', 'data' => $response]);
?>
