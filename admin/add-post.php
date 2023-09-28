<?php
include "header.php";
include "./config.php";


if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}

if(isset($_POST['submit'])){
    $title = mysqli_escape_string($connection,$_POST['post_title']);
    $description = mysqli_escape_string($connection,$_POST['postdesc']);
    $category = mysqli_escape_string($connection,$_POST['category']);
    $date = date(("d Y, M"));
    $author = $_SESSION['user_id'];
    // image upload
    $fileToUpload = $_FILES['fileToUpload'];
    $name = $_FILES['fileToUpload']['name'];
    $type = $_FILES['fileToUpload']['type'];
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $size = $_FILES['fileToUpload']['size'];
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

    $uploadQuery = "INSERT INTO post (title,description,category,post_date,author,post_img) VALUES ('$title','$description','$category','$date','$author','$name');";
  $uploadQuery .= "UPDATE category SET post = post + 1 WHERE category_id = $category";
    $uploadSql = mysqli_multi_query($connection,$uploadQuery) or die("failed to upload");

    if($uploadSql){
        header("Location:{$hostname}/admin/post.php");
    }

}


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Category</label>
                        <select name="category" class="form-control">
                        <option value="" selected> Select Category</option>

                            <?php
                            
                            
                                $selectQuery = "SELECT * FROM category";
                                $categorySql = mysqli_query($connection,$selectQuery) or die("Failed to  fetch query");

                                if(mysqli_num_rows($categorySql) > 0){
                                    while($row = mysqli_fetch_assoc($categorySql)){
                                        ?>
                                            <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_name'] ?></option>
                                        <?php
                                    }
                            ?>
                        </select>
                        <?php
                                }else{
                                    echo "Failed to fetch";
                                }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Post image</label>
                        <input type="file" name="fileToUpload" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary" value="Save">Save</button>
                </form>
                <!--/Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>