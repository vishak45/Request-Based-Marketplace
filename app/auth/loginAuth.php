<?php

require_once __DIR__ . '/../config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Content-Type: application/json');

    $rawInput = file_get_contents('php://input');
    $body = json_decode($rawInput, true)?? [];
    $email = $body['email'] ?? ($_POST['email'] ?? '');
    $password = $body['password'] ?? ($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
        exit;
    }

    $stmt = $connection->prepare('SELECT id, name, email, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            unset($row['password']);
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];

            http_response_code(200);
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid credentials(password)']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }

}


?>