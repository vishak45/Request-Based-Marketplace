<?php
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Content-Type: application/json');
    if(!isset($_SESSION['user_id']))
    {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    $rawInput = file_get_contents('php://input');
    $body = json_decode($rawInput, true)?? [];
    $request_type = $body['request_type'] ?? ($_POST['request_type'] ?? '');
    $title = $body['title'] ?? ($_POST['title'] ?? '');
    $description = $body['description'] ?? ($_POST['description'] ?? '');
    $category = $body['category'] ?? ($_POST['category'] ?? '');
    $location = $body['location'] ?? ($_POST['location'] ?? '');
    $contact_no = $body['contact_no'] ?? ($_POST['contact_no'] ?? '');
    $email = $body['email'] ?? ($_POST['email'] ?? '');
    try{
    $query="INSERT INTO product_list(userId,req_type,title,description,category,location,contact_no,email) VALUES(?,?,?,?,?,?,?,?)";
    $stmt=$connection->prepare($query);
    $stmt->bind_param('isssssss',$_SESSION['user_id'], $request_type,$title,$description,$category,$location,$contact_no,$email);
   $stmt->execute();
    

    
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Product added successfully']);
   
}
catch(Exception $e){
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Internal server error', 'error' => $e->getMessage()]);
}
}
?>