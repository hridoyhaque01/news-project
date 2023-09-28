<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                    <div class="post-container">
                    <?php 

                        $post_id = $_GET['post_id'];
                        $getCategoryQuery = "SELECT * from post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE post_id='$post_id'";
                        $postSql = mysqli_query($connection, $getCategoryQuery) or die("Failed to fetch query");


                        $postSql = mysqli_query($connection, $getCategoryQuery) or die("Failed to fetch query");;
                        $categorySql = mysqli_query($connection, $getCategoryQuery) or die("Failed to fetch query");
                        while($row = mysqli_fetch_assoc($categorySql)){
                        ?>
                        <div class="post-content single-post">
                            <h3><?php echo $row['title']; ?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <?php echo $row['category_name']; ?>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php?auther_id=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $row['post_date']; ?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="images/post_1.jpg" alt=""/>
                            <p class="description">
                            <?php echo $row['description']; ?>
                            </p>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
