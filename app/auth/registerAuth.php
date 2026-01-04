<?php

require_once __DIR__ . '/../config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Content-Type: application/json');

    $rawInput = file_get_contents('php://input');
    $body = json_decode($rawInput, true)?? [];
    $name = $body['name'] ?? ($_POST['name'] ?? '');
    $email = $body['email'] ?? ($_POST['email'] ?? '');
    $password = $body['password'] ?? ($_POST['password'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Name, email and password are required']);
        exit;
    }
    $emailCheck="SELECT * FROM users WHERE email=?";
    $stmt=$connection->prepare($emailCheck);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
        http_response_code(409);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
    }
    else{
        ## hash password
        $hashedPassword=password_hash($password, PASSWORD_DEFAULT);

        $query="INSERT INTO users(name,email,password) VALUES(?,?,?)";
        $stmt=$connection->prepare($query);
        $stmt->bind_param('sss', $name, $email, $hashedPassword);
        $stmt->execute();
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'User registered successfully']);
    }
}

$stmt->close();
$connection->close();
exit;
?>