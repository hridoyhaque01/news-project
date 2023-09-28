<?php
include "header.php";
include "./config.php";

if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php
                        $limit = 3;
                        if (isset($_GET['page'])) {
                            $pageNumber = $_GET["page"];
                        } else {
                            $pageNumber = 1;
                        }
                        $offset = ($pageNumber - 1) * $limit;
                        $getUsersQuery = "SELECT * from post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                         ORDER BY user_id DESC LIMIT $offset, $limit";
                        $postSql = mysqli_query($connection, $getUsersQuery) or die("Failed to fetch query");

                        if (mysqli_num_rows($postSql) > 0) {
                            $i = 0;
                            while ($post = mysqli_fetch_assoc($postSql)) {
                                $i++;

                        ?>
                          <tr>
                              <td class='id'><?php echo $i ?></td>
                              <td><?php echo $post['title'] ?></td>
                              <td><?php echo $post['category_name'] ?></td>
                              <td><?php echo $post['post_date'] ?></td>
                              <td><?php echo $post['username'] ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $post['post_id'] ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $post['post_id'] ?>&category_id=<?php echo $post['category'] ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php

                            }
                        } else {
                        }
                        ?>

                    </tbody>
                </table>
                <ul class='pagination admin-pagination'>
                    <?php
                    $getLimitedPost = "SELECT * from post";
                    $postSql = mysqli_query($connection, $getLimitedPost) or die("Failed to fetch query");

                    $total = mysqli_num_rows($postSql);
                    $totalPage = ceil($total / 3);
                    if ($pageNumber == 1) {
                    ?>
                        <li><a href="post.php?page=<?php echo $pageNumber ?>">Prev</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="post.php?page=<?php echo ($pageNumber - 1) ?>">Prev</a></li>
                    <?php
                    }
                    for ($i = 1; $i <= $totalPage; $i++) {
                        if ($pageNumber == $i) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                    ?>
                        <li class="<?php echo $active ?>"><a href="post.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }

                    if ($totalPage == $pageNumber) {
                    ?>
                        <li><a href="post.php?page=<?php echo $pageNumber ?>">Next</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="post.php?page=<?php echo ($pageNumber + 1) ?>">Next</a></li>
                    <?php
                    }
                    ?>



                </ul>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
