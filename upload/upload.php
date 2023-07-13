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
  $api_key = $_ENV['API_KEY'];

  if ($_GET['api_key'] !== $api_key) {

      //erorr
      $response['error'] = true;
      $response['message'] = 'Invalid api key';

  }else {
    
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        //get the values of the parameters
        $title = $_POST['title'];
        $category = $_POST['category'];
        $blog_content = $_POST['blog_content'];
        $search_keyword = $_POST['search_keyword'];
        $author = $_POST['author'];
        //getting the image file
        $thumbnail = $_FILES['thumbnail']['name'];
      
            //validate post request if empyty
            if (empty($title) || empty($category) || empty($blog_content) || empty($author) || empty($thumbnail)) {
      
              $response['error'] = true;
              $response['message'] = 'please provide the neccesary infomation';
        
            }else{

                    $split = explode('.', $thumbnail);
                    $extension = end($split);

                    $acceptable = ['png', 'jpeg', 'webp'];

                    if (!in_array($extension, $acceptable)) {

                        //erorr
                        $response['error'] = true;
                        $response['message'] = 'Only png, jpeg and webp image is allowed';

                    }else {

                      $random = rand(0, 1000000);
                      $image_name = $random . $thumbnail;

                      //Set the path where we need to upload the image.
                      $image_upload_dir = "../thumbnail/" . $thumbnail; 

                      $move = move_uploaded_file($_FILES['thumbnail']['tmp_name'], $image_upload_dir);

                        if($move) {
                       
                          $date_created = date("F-jS-Y");
                  
                          $sql = "INSERT INTO blog (title, blog_category_id, blog_content, search_keyword, thumbnail, author, date_created) VALUES (?, ?, ?, ?, ?, ?, ?)";
                          $stmt = mysqli_stmt_init($conn);
                          mysqli_stmt_prepare($stmt, $sql);
                  
                          mysqli_stmt_bind_param($stmt, 'sssssss', $title, $category, $blog_content, $search_keyword, $image_name, $author, $date_created);
                  
                          if(mysqli_stmt_execute($stmt)) {
                  
                          //success
                          $response['error'] = false;
                          $response['message'] = 'Blog post was created successfully';
                  
                          http_response_code(200);
                  
                          mysqli_stmt_close($stmt);
                          // mysqli_close($conn) 
                  
                          }
                        }else {
                          //erorr
                          $response['error'] = true;
                          $response['message'] = 'An error occurred, this could be server error';
                        }
                        
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

    }
  
}

  echo json_encode($response);
  
?>