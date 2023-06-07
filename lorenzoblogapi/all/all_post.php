<?php

require_once ('../header.php');

$response = array();


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

    $stmt = $conn->prepare("SELECT  * FROM blog");

    if ($stmt) {

        $stmt->execute();
        $result = $stmt->get_result();

        $users = array();

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $all_blog_post[] = $row;
        }

        $response['error'] = false;
        $response['blog post'] = $all_blog_post;
        $response['message'] = 'all blog post returned successfully';
        $stmt->close();
    } else {
        $response['error'] = true;
        $response['message'] = 'error';
    }

 }

 }


echo json_encode($response);

?>