<?php include "header.php"; 

?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="save-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
        <?php
            $post_id = $_GET['id'];
            $getPostDataQuery = "SELECT * from post where post_id = $post_id";
            $runGetPostQuery = mysqli_query($connection, $getPostDataQuery) or die("Failed to get user data");
            if (mysqli_num_rows($runGetPostQuery) > 0) {
                while ($post = mysqli_fetch_assoc($runGetPostQuery)) {
            ?>

            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $post['post_id'] ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value=<?php echo $post['title'] ?>>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $post['description'] ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select name="category" class="form-control">
                    <option value="" disabled> Select Category</option>

                        <?php
                            $selectQuery = "SELECT * FROM category";
                            $categorySql = mysqli_query($connection,$selectQuery) or die("Failed to  fetch query");
                            if(mysqli_num_rows($categorySql) > 0){
                                while($row = mysqli_fetch_assoc($categorySql)){
                                    if($row['category_id'] == $post['category']){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    ?>
                                        <option value="<?php echo $row['category_id'] ?>" <?php echo $selected ?>><?php echo $row['category_name'] ?></option>
                                    <?php
                                }
                            }

                        ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="./upload/<?php echo $post['post_img'] ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $post['post_img'] ?>">
                <input type="hidden" name="category_id" value="<?php echo $post['category'] ?>">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <?php
                }
            } else {
                echo "<p>No data found!</p>";
            }
            ?>
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
