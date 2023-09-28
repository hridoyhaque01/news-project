<?php
include "./config.php";
session_start();
if (isset($_POST['submit'])) {
    $post_id = $_POST['post_id'];
    $post_title = mysqli_real_escape_string($connection, $_POST['post_title']);
    $description = mysqli_real_escape_string($connection, $_POST['postdesc']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $author = $_SESSION['user_id'];
    $prev_cat_id = $_POST['category_id'];


    if(empty($_FILES['new-image']['name'])){
        $name = $_POST['old-image'];
    }else{
     // image upload
     $fileToUpload = $_FILES['new-image'];
     $name = $fileToUpload['name'];
     $type = $fileToUpload['type'];
     $tmp_name = $fileToUpload['tmp_name'];
     $size = $fileToUpload['size'];
     $explode = explode('.',$name);
     $file_ext = strtolower(end($explode));
     $extension = array("jpg","jpeg","png");
     $error =  array();
 
     if(in_array($file_ext,$extension) === false){
         $error[] = "Only jpg, jpeg and png file are supported";
     }
     if($size > 2097152){
         $error[] = "File size must be 2mb or lower";
     }
     if(empty($error) == true){
         move_uploaded_file($tmp_name,'upload/'.$name);
     }else{
         print_r($error);
     }
    }

    $updateQuery = "UPDATE post SET title='$post_title', description='$description', category='$category', author='$author', post_img='$name' WHERE  post_id = $post_id ;";
    $updateQuery .= "UPDATE category SET post = post - 1 WHERE category_id = $prev_cat_id;";
    $updateQuery .= "UPDATE category SET post = post + 1 WHERE category_id = $category";
    $runUpdateQuery = mysqli_multi_query($connection, $updateQuery)  or die("Failed to update data");
    if ($runUpdateQuery) {
        header("Location: {$hostname}/admin/post.php");
    }
    mysqli_close($connection);
    
}
?>