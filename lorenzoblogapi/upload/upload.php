<?php

header('Content-Type: application/json');

require('../config/conn.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  //get json response
  $json = file_get_contents('php://input');
  //decode response
  $data = json_decode($json);

  //set it as object
  $title = $data->title;
  $category = $data->category;
  $blog_content = $data->blog_content;
  $thumbnail = $data->thumbnail;
  $author = $data->author;


      //validate post request if empyty

      if (empty($title) || empty($category) || empty($blog_content) || empty($thumbnail)) {

        $response['error'] = true;
        $response['message'] = 'please provide the neccesary infomation';
  
      }else{
        // if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE']), 'multipart/form-data') !== false ) {

        //     echo $file = $_FILES['thumbnail'];
        // }
       // $response['file'] = $thumbnail;

        $date_created = date("Y-m-d");

        $sql = "INSERT INTO blog (title, category, blog_content, thumbnail, author, date_created) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
 
        mysqli_stmt_bind_param($stmt, 'ssssss', $title, $category, $blog_content, $thumbnail, $author, $date_created);

        if(mysqli_stmt_execute($stmt)) {

        //success
        $response['error'] = false;
        $response['message'] = 'Blog post was created successfully';

         http_response_code(200);

         mysqli_stmt_close($stmt);
         // mysqli_close($conn) 

        }
 
      }

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