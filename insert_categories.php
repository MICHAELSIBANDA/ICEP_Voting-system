<?php
include 'conf/db_connect.php';

$campusCategories = [
    'sosha' => [
        'overall' => 'Best Overall Intern',
        'supportive' => 'Best Supportive / Most Dedicated Intern',
        'full_stack' => 'Top Full Stack Intern',
        'punctual' => 'Most Punctual Intern',
        'scrum_master' => 'Top Scrum Master Intern',
        'developer' => 'Top Developer Intern',
        'business_analyst' => 'Top Business Analyst Intern',
        'tester' => 'Top Software Tester Intern'
    ],
    'polokwane' => [
        'overall' => 'Best Overall Intern',
        'supportive' => 'Best Supportive / Most Dedicated Intern',
        'full_stack' => 'Top Full Stack Intern',
        'punctual' => 'Most Punctual Intern',
        'scrum_master' => 'Top Scrum Master Intern',
        'developer' => 'Top Developer Intern'
    ],
    'emalahleni' => [
        'overall' => 'Best Overall Intern',
        'supportive' => 'Best Supportive / Most Dedicated Intern',
        'full_stack' => 'Top Full Stack Intern',
        'punctual' => 'Most Punctual Intern',
        'scrum_master' => 'Top Scrum Master Intern',
        'developer' => 'Top Developer Intern'
    ]
];

$categoryQuestions = [
    'overall' => 'How has this intern demonstrated exceptional overall performance, leadership, and contribution to the team?',
    'supportive' => 'How has this intern shown exceptional dedication, supportiveness, and commitment to helping others succeed?',
    'full_stack' => 'What examples demonstrate this intern\'s excellence in both front-end and back-end development?',
    'punctual' => 'How has this intern consistently demonstrated punctuality, reliability, and meeting deadlines?',
    'scrum_master' => 'How has this Scrum Master demonstrated exceptional leadership, facilitation, and team coordination skills?',
    'developer' => 'What makes this developer stand out in terms of technical skills, problem-solving, and code quality?',
    'business_analyst' => 'How has this Business Analyst shown excellence in requirements gathering, analysis, and stakeholder communication?',
    'tester' => 'How has this Tester shown excellence in quality assurance, bug detection, and ensuring product reliability?'
];


// Insert campus-specific categories
$stmt = $conn->prepare("INSERT INTO campus_categories (campus, category_key, category_name) VALUES (?, ?, ?)");
foreach ($campusCategories as $campus => $categories) {
    foreach ($categories as $key => $name) {
        $stmt->bind_param("sss", $campus, $key, $name);
        $stmt->execute();
    }
}
$stmt->close();


// Insert category questions
$stmt2 = $conn->prepare("INSERT INTO category_questions (category_key, question) VALUES (?, ?)");
foreach ($categoryQuestions as $key => $question) {
    $stmt2->bind_param("ss", $key, $question);
    $stmt2->execute();
}
$stmt2->close();

$conn->close();

echo "✅ Campus categories and category questions successfully inserted!";
?>
