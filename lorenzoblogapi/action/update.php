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

        //get json response
        $json = file_get_contents('php://input');
        //decode response
        $data = json_decode($json);

        //set it as object
        $id = $data->id;
        $title = $data->title;
        $category = $data->category;
        $blog_content = $data->blog_content;
        $search_keyword = $data->search_keyword;
        $thumbnail = $data->thumbnail;
        $author = $data->author;

            //check if the blog post exist
            $sql = "SELECT * FROM blog WHERE id = ?";
            $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_error($stmt);

                }else{
                    mysqli_stmt_bind_param($stmt, "s", $id);
                    mysqli_stmt_execute($stmt);
    
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
    
                    if ($resultCheck > 0) {
                    //the blog post truly exist

                        $stmt = $conn->prepare("UPDATE blog SET title = ?, blog_category_id = ?, blog_content = ?, search_keyword = ?, thumbnail = ?, author = ? WHERE id = ?");
                        $stmt->bind_param("sissssi", $title, $category, $blog_content, $search_keyword, $thumbnail, $author, $id);

                        if ($stmt->execute()) {
                            $response['error'] = false;
                            $response['message'] = 'Blog post updated successfully';
                        } else {
                            $response['error'] = true;
                            $response['message'] = 'An error occurred. This could be a server error.';
                        }

                        $stmt->close();
              
                    }else{
                        $response['error'] = true;
                        $response['message'] = 'A blog post does not exist with this ID';
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