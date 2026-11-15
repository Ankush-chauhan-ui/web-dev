<?php


require __DIR__ . '/includes/db.php';

function go_back(string $status): void
{
    header('Location: index.html?status=' . $status . '#contact');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#contact');
    exit;
}


$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$phone   = trim($_POST['phone']   ?? '');
$course  = trim($_POST['course']  ?? '');
$message = trim($_POST['message'] ?? '');


$allowed_courses = [
    'B.Tech Computer Science',
    'B.Tech Information Tech',
    'B.Tech ECE',
    'B.Tech Mechanical',
    'B.Tech Civil',
    'MBA',
];

$valid =
    mb_strlen($name) >= 2 && mb_strlen($name) <= 100 &&                
    filter_var($email, FILTER_VALIDATE_EMAIL) !== false &&             
    mb_strlen($email) <= 150 &&
    preg_match('/^[0-9]{10}$/', $phone) === 1 &&                       
    in_array($course, $allowed_courses, true) &&                       
    mb_strlen($message) <= 1000;                                       

if (!$valid) {
    go_back('invalid');
}


try {
    $stmt = $pdo->prepare(
        'INSERT INTO enquiries (name, email, phone, course, message)
         VALUES (:name, :email, :phone, :course, :message)'
    );

    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':phone'   => $phone,
        ':course'  => $course,
        ':message' => $message,
    ]);
} catch (PDOException $e) {
    error_log('Enquiry insert failed: ' . $e->getMessage());
    go_back('error');
}

go_back('success');
