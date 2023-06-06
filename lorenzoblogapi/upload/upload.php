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

                    // $image_name = round(microtime(true) * 1000). ".jpg"; //Giving new name to image.

                    $split = explode('.', $thumbnail);
                    $extension = end($split);

                    $acceptable = ['png', 'jpeg'];

                    if (!in_array($extension, $acceptable)) {

                        //erorr
                        $response['error'] = true;
                        $response['message'] = 'Only png and jpeg image is allowed';
                    }else {

                      $random = rand(0, 1000000);
                      $image_name = $random . $thumbnail;

                      //Set the path where we need to upload the image.
                      $image_upload_dir = "thumbnail/".$image_name; 

                      //Here is the main code to convert Base64 image into the real image/Normal image..
                      $move = file_put_contents($image_upload_dir, base64_decode($thumnail));

                        if ($move) {
                       
                          $date_created = date("F-jS-Y");
                  
                          $sql = "INSERT INTO blog (title, blog_category_id, blog_content, thumbnail, author, date_created) VALUES (?, ?, ?, ?, ?, ?)";
                          $stmt = mysqli_stmt_init($conn);
                          mysqli_stmt_prepare($stmt, $sql);
                  
                          mysqli_stmt_bind_param($stmt, 'ssssss', $title, $category, $blog_content, $image_name, $author, $date_created);
                  
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