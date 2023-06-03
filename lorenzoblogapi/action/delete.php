<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

require('../config/conn.php');

$response = array();

// http://localhost:8000/action/delete.php?delete_id=1

//delete
//search
//update


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $delete_id = $_GET['delete_id'];

    $response['id'] = $delete_id;

    $stmt = $conn->prepare("DELETE FROM blog WHERE id = ?");

    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        $response['error'] = false;
        $response['message'] = 'Blog post deleted successfully';
    } else {
        $response['error'] = true;
        $response['message'] = 'An error occurred. This could be a server error.';
    }
    
    $stmt->close();   
    
}else{

    //Request method
    $request_method = $_SERVER['REQUEST_METHOD'];
    if ($request_method !== 'POST') {

    $response['error'] = true;
    $response['message'] = $request_method . ' Request method is not allowed';   

    }
}


echo json_encode($response);
?>