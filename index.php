<?php 
include 'header.php';
include "./admin/config.php"
 ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">

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
                        
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php"><img src="images/post-format.jpg" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?post_id=<?php echo $post['post_id'] ?>'><?php echo $post['title'] ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?category_id=<?php echo $post['category'] ?>'><?php echo $post['category_name'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?auther_id=<?php echo $post['author'] ?>'><?php echo $post['username'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $post['post_date'] ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($post['description'],0,130).'...' ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?post_id=<?php echo $post['post_id'] ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                        }
                        } else {
                        }
                        ?>
                        <ul class='pagination admin-pagination'>
                    <?php
                    $getLimitedPost = "SELECT * from post";
                    $postSql = mysqli_query($connection, $getLimitedPost) or die("Failed to fetch query");

                    $total = mysqli_num_rows($postSql);
                    $totalPage = ceil($total / 3);
                    if ($pageNumber == 1) {
                    ?>
                        <li><a href="index.php?page=<?php echo $pageNumber ?>">Prev</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="index.php?page=<?php echo ($pageNumber - 1) ?>">Prev</a></li>
                    <?php
                    }
                    for ($i = 1; $i <= $totalPage; $i++) {
                        if ($pageNumber == $i) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                    ?>
                        <li class="<?php echo $active ?>"><a href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }

                    if ($totalPage == $pageNumber) {
                    ?>
                        <li><a href="index.php?page=<?php echo $pageNumber ?>">Next</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="index.php?page=<?php echo ($pageNumber + 1) ?>">Next</a></li>
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
