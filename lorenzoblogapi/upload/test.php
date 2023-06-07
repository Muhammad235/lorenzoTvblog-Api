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
    
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        //get json response
        // $json = file_get_contents('php://input');
        // $data = json_decode($json);
      
        //set it as object
        // $title = $data->title;
        // $category = $data->category;
        // $blog_content = $data->blog_content;
        // $search_keyword = $data->search_keyword;
        // $author = $data->author;

        $title = $_POST['title'];
        $category = $_POST['category'];
        $blog_content = $_POST['blog_content'];
        $search_keyword = $_POST['search_keyword'];
        $author = $_POST['author'];

        $thumbnail = $_FILES['thumbnail']['name'];

        $result = ["$title",$category, $blog_content, $thumbnail, $author];
            //validate post request if empyty
            if (empty($title) || empty($category) || empty($blog_content) || empty($search_keyword) || empty($author) || empty($thumbnail)) {
      
              $response['error'] = true;
              $response['message'] = 'please provide the neccesary infomation';
        
            }else{

                //success
                $response['error'] = false;
                $response['message'] = 'Blog post was created successfully';
                $response['result'] = $result;
                $response['thumbnail'] = $thumbnail;

            }
        


      }else{
      
          //Request method
          $request_method = $_SERVER['REQUEST_METHOD'];
          if ($request_method !== 'POST') {
      
          $response['error'] = true;
          $response['message'] = $request_method . ' Request method is not allowed';   
      
          }
      }

    }
  
}

  echo json_encode($response);
  
?>