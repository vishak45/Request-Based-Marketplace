<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    header('Content-Type: application/json');
    try{
    $stmt = $connection->prepare('SELECT * FROM product_list WHERE userId=?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $row['posted_by'] = $_SESSION['user_name'];
        if($row['email']===""){
            $row['email']=$_SESSION['user_email'];
        }
        $requests[] = $row;
    }
    http_response_code(200);
    echo json_encode(['success' => true, 'requests' => $requests]);
    exit;
}
catch(Exception $e){
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
}

?>