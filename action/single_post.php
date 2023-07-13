<?php

require '../header.php';

$response = array();


if(!isset($_GET['api_key']) || !isset($_GET['id'])) 
{
    //erorr
    $response['error'] = true;
    $response['message'] = 'provide an api key and a blog post id';

}else 

{
    $api_key = $_ENV['API_KEY'];

  if ($_GET['api_key'] !== $api_key) {

      //erorr
      $response['error'] = true;
      $response['message'] = 'Invalid api key';

  }else {

    $post_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM blog WHERE id = ?");
    $stmt->bind_param("i", $post_id); 
    
    if ($stmt) {
        
        $stmt->execute();
        $result = $stmt->get_result();
    
        $all_blog_post = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            
                $all_blog_post[] = $row;
                $response['error'] = false;
                $response['blog post'] = $all_blog_post;
                $response['message'] = 'Blog posts returned successfully';
            }
        }else {
            $response['error'] = true;
            $response['message'] = 'No blog post with id - ' . $post_id;
        }
    
        $stmt->close();

    } else {
        $response['error'] = true;
        $response['message'] = 'error';
    }  
 }

 }

echo json_encode($response);

?>