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


    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $search_word = mysqli_real_escape_string($conn, $_GET['search_word']);

            //search blog post table for the keyword
            $sql = "SELECT * FROM blog WHERE title LIKE '%$search_word%' OR blog_content LIKE '%$search_word%' OR search_keyword LIKE '%$search_word%'";

            $result = mysqli_query($conn, $sql);

            $num_of_row = mysqli_num_rows($result);

            if ($num_of_row >0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $search_result[] = $row;
                }

                $response['error'] = true;
                $response['blog post'] = $search_result;
                $response['message'] = 'Matching results returned successfuly!';
                
            }else {
                $response['error'] = true;
                $response['message'] = 'There are no results matching your search!';
            }
              
        
    }else{

        //Request method
        $request_method = $_SERVER['REQUEST_METHOD'];
        if ($request_method !== 'GET') {

        $response['error'] = true;
        $response['message'] = $request_method . ' Request method is not allowed';   

        }
   }
 }

}


echo json_encode($response);
?>