<?php

header('Content-Type: application/json');

require('../config/conn.php');

$response = array();

$stmt = $conn->prepare("SELECT * FROM blog WHERE blog_category_id = 2");

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();


    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        
        $row['blog category'] = 'Finance';     
        $blog_post[] = $row;
      
    }

    $response['error'] = false;
    $response['blog post'] = $blog_post;
    $response['message'] = 'blog post returned successfully';


    $stmt->close();
} else {
    $response['error'] = true;
    $response['message'] = 'error';
}

echo json_encode($response);
?>