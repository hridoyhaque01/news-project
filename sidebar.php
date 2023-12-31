<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <?php 


                    $getPostQuery = "SELECT * from post
                    LEFT JOIN category ON post.category = category.category_id
                     ORDER BY post.post_id DESC LIMIT 0, 4";
                    $postSql = mysqli_query($connection, $getPostQuery) or die("Failed to fetch query");
                    $categorySql = mysqli_query($connection, $getPostQuery) or die("Failed to fetch query");
                    if(mysqli_num_rows($categorySql) === 0){
                        echo "<div>No data found</div>";
                    }else{
                        
                    while($row = mysqli_fetch_assoc($categorySql)){
                    ?>
                    <div class="recent-post">
                        <a class="post-img" href="">
                            <img src="images/post-format.jpg" alt=""/>
                        </a>
                        <div class="post-content">
                            <h5><a href="single.php?post_id<?php echo $row["post_id"]; ?>"><?php echo $row["title"]; ?></a></h5>
                            <span>
                                <i class="fa fa-tags" aria-hidden="true"></i>
                                <a href='category.php'><?php echo $row["category_name"]; ?></a>
                            </span>
                            <span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo $row["post_date"]; ?>
                            </span>
                            <a class="read-more" href="single.php?post_id=<?php echo $row['post_id'] ?>">read more</a>
                        </div>
                    </div>
        <?php }} ?>
    </div>
    <!-- /recent posts box -->
</div>
