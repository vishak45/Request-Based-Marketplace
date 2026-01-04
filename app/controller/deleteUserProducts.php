<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Content-Type: application/json');

    $rawInput = file_get_contents('php://input');
    $body = json_decode($rawInput, true)?? [];
    $id = $body['id'] ?? ($_POST['id'] ?? '');
    try{
        
    
    $query="DELETE FROM product_list WHERE id=? and userId=?";
    $stmt=$connection->prepare($query);
    $stmt->bind_param('ii', $id,$_SESSION['user_id']);
    $stmt->execute();
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Deleted successfully']);
    exit;
    }
    catch(Exception $e){
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}


?>