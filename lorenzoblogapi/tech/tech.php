<?php

require('../header.php');

$response = array();

//blog_category_id  = tech

if(!isset($_GET['api_key'])) 
{
    //erorr
    $response['error'] = true;
    $response['message'] = 'provide an api key';
}else 

{
    $api_key = $_ENV['API_KEY'];

  if ($_GET['api_key'] !== $api_key) {

      //erorr
      $response['error'] = true;
      $response['message'] = 'Invalid api key';

  }else {

    $stmt = $conn->prepare("SELECT * FROM blog WHERE blog_category_id = 1");

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $row['blog category'] = 'Tech';
            
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
  }
}

echo json_encode($response);
?>