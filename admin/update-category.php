<?php include "header.php"; 

include "./config.php";

if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}else if($_SESSION["role"] != 1){
    header("Location:{$hostname}/admin/post.php");
}

$id = $_GET['id'];

if(isset($_POST['submit'])){
    $categoryName = $_POST['cat_name'];

    $updateQuery = "UPDATE category SET category_name = '$categoryName' WHERE category_id = $id";
    $updateSql = mysqli_query($connection,$updateQuery) or die("Failed to update query");
    
    if($updateSql){
        header("Location:{$hostname}/admin/category.php");
    } 
    
}


$selectQuery = "SELECT * FROM category WHERE category_id = $id";
$categorySql = mysqli_query($connection,$selectQuery) or die("Failed to  fetch query");
if(mysqli_num_rows($categorySql) > 0){

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                  <?php 
                        $i = 0;
                        while($row = mysqli_fetch_assoc($categorySql)){
                        ?>
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="1" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name'] ?>"  placeholder="" required>
                      </div>
                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                      <?php } ?>

                  </form>
                </div>
              </div>
            </div>
    <?php } ?>

          </div>
<?php include "footer.php"; ?>
