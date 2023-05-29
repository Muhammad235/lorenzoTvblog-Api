<?php

header('Content-Type: application/json');

require('../config/conn.php');

$response = array();

$stmt = $conn->prepare("SELECT * FROM blog WHERE blog_category_id = 4");

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();

    $users = array();

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $row['blog category'] = 'Movies';
        
        $blog_post[] = $row;
      
    }

    $response['error'] = false;
    $response['blog post'] = $blog_post;
    $response['message'] = 'blog post returned successfully';

    http_response_code(200);

    $stmt->close();
} else {
    $response['error'] = true;
    $response['message'] = 'error';
}

echo json_encode($response);
?>