<?php include "header.php"; 

include "./config.php";

if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}else if($_SESSION["role"] != 1){
    header("Location:{$hostname}/admin/post.php");
}


if(isset($_POST['save'])){
    $categoryName = $_POST['cat'];
    $addCatQuery = "INSERT INTO category (category_name,post) VALUES ('$categoryName',0)";
    $categorySql = mysqli_query($connection,$addCatQuery) or die("Failed to add");

    if(!$categorySql){
        echo "<script>alert('Failed to add category')</script>";
    }
}

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <button type="submit" name="save" class="btn btn-primary">Save</button>
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
