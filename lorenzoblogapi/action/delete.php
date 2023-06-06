<?php

require '../header.php';

$response = array();


if(!isset($_GET['api_key'])) 
{
    //erorr
    $response['error'] = true;
    $response['message'] = 'provide an api key';
}else 

{
  if ($_GET['api_key'] !== '12345') {

      //erorr
      $response['error'] = true;
      $response['message'] = 'Invalid api key';

  }else {

    if (isset($_GET['delete_id'])) {

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

        $response['error'] = true;
        $response['message'] = 'provide the delete id';   

    }

  }

}


echo json_encode($response);

?>