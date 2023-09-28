<?php include "header.php"; 

include "./config.php";

if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}else if($_SESSION["role"] != 1){
    header("Location:{$hostname}/admin/post.php");
}

$limit = 3;
if (isset($_GET['page'])) {
    $pageNumber = $_GET["page"];
} else {
    $pageNumber = 1;
}
$offset = ($pageNumber - 1) * $limit;
$getCategoryQuery = "SELECT * from category ORDER BY category_id DESC LIMIT $offset, $limit";
$categorySql = mysqli_query($connection, $getCategoryQuery) or die("Failed to fetch query");

// $selectQuery = "SELECT * FROM category";
// $categorySql = mysqli_query($connection,$selectQuery) or die("Failed to  fetch query");

if(mysqli_num_rows($categorySql) > 0){

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 0;
                        while($row = mysqli_fetch_assoc($categorySql)){
                            $i++;
                        ?>
                        <tr>
                            <td class='id'><?php echo $i ?></td>
                            <td><?php echo $row['category_name'] ?></td>
                            <td><?php echo $row['post'] ?></td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $row['category_id'] ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $row['category_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <ul class='pagination admin-pagination'>
                    <?php
                    $getLimitedUsers = "SELECT * from category";
                    $userSql = mysqli_query($connection, $getLimitedUsers) or die("Failed to fetch query");
                    $total = mysqli_num_rows($userSql);
                    $totalPage = ceil($total / 3);
                    if ($pageNumber == 1) {
                    ?>
                        <li><a href="category.php?page=<?php echo $pageNumber ?>">Prev</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="category.php?page=<?php echo ($pageNumber - 1) ?>">Prev</a></li>
                    <?php
                    }
                    for ($i = 1; $i <= $totalPage; $i++) {
                        if ($pageNumber == $i) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                    ?>
                        <li class="<?php echo $active ?>"><a href="category.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }

                    if ($totalPage == $pageNumber) {
                    ?>
                        <li><a href="category.php?page=<?php echo $pageNumber ?>">Next</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="category.php?page=<?php echo ($pageNumber + 1) ?>">Next</a></li>
                    <?php
                    }
                    ?>


                </ul>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php include "footer.php"; ?>
