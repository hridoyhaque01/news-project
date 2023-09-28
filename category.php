<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <h2 class="page-heading">Category Name</h2>
                  <?php 

                        $category_id = $_GET['category_id'];
                  
                        $limit = 3;
                        if (isset($_GET['page'])) {
                            $pageNumber = $_GET["page"];
                        } else {
                            $pageNumber = 1;
                        }
                        $offset = ($pageNumber - 1) * $limit;
                        $getCategoryQuery = "SELECT * from post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                         ORDER BY user_id DESC LIMIT $offset, $limit";
                        $postSql = mysqli_query($connection, $getCategoryQuery) or die("Failed to fetch query");


                        $postSql = mysqli_query($connection, $getCategoryQuery) or die("Failed to fetch query");;
                        $categorySql = mysqli_query($connection, $getCategoryQuery) or die("Failed to fetch query");
                        while($row = mysqli_fetch_assoc($categorySql)){
                        ?>
                    <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php"><img src="images/post-format.jpg" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?post_id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?category_id=<?php echo $row['category_id'] ?>'><?php echo $row['category_name'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?auther_id=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date'] ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row['description'],0,130).'...'; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?post_id=<?php echo $row['post_id'] ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    
                    <ul class='pagination'>
                    <?php
                    $getPosts = "SELECT * from post";

                    $userSql = mysqli_query($connection, $getPosts) or die("Failed to fetch query");
                    $total = mysqli_num_rows($userSql);

                    $totalPage = ceil($total / 3);
                    if ($pageNumber == 1) {
                    ?>
                        <li><a href="category.php?category=<?php echo $row['category_name']?>&page=<?php echo $pageNumber ?>">Prev</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="category.php?category=<?php echo $row['category_name']?>&page=<?php echo ($pageNumber - 1) ?>">Prev</a></li>
                    <?php
                    }
                    for ($i = 1; $i <= $totalPage; $i++) {
                        if ($pageNumber == $i) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                    ?>
                        <li class="<?php echo $active ?>"><a href="category.php?category=<?php echo $row['category_name']?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }

                    if ($totalPage == $pageNumber) {
                    ?>
                        <li><a href="category.php?category=<?php echo $row['category_name']?>&page=<?php echo $pageNumber ?>">Next</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="category.php?category=<?php echo $row['category_name']?>&page=<?php echo ($pageNumber + 1) ?>">Next</a></li>
                    <?php
                    }
                    ?>
                    </ul>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
