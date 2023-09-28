<?php
include "header.php";
include "./config.php";

if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}else if($_SESSION["role"] != 1){
    header("Location:{$hostname}/admin/post.php");
}


?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Role</th>
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
                        $getUsersQuery = "SELECT * from user ORDER BY user_id DESC LIMIT $offset, $limit";
                        $userSql = mysqli_query($connection, $getUsersQuery) or die("Failed to fetch query");

                        if (mysqli_num_rows($userSql) > 0) {
                            $i = 0;
                            while ($user = mysqli_fetch_assoc($userSql)) {
                                $i++;

                        ?>
                                <tr>
                                    <td class='id'><?php echo ($pageNumber == 1  || ($pageNumber * 3) < 10 ? "0" . ($limit * ($pageNumber - 1) + $i) : $limit * ($pageNumber - 1) + $i) ?></td>
                                    <td><?php echo $user['first_name'] . '' . $user['last_name']; ?></td>

                                    <td><?php echo $user['username']; ?></td>
                                    <td>
                                        <?php if ($user['role'] === '0') {
                                            echo "Normal User";
                                        } else {
                                            echo "Admin";
                                        } ?>
                                    </td>
                                    <td class='edit'><a href='update-user.php?id=<?php echo $user['user_id']; ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?php echo $user['user_id']; ?>'><i class='fa fa-trash-o'></i></a></td>
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
                    $getLimitedUsers = "SELECT * from user";
                    $userSql = mysqli_query($connection, $getLimitedUsers) or die("Failed to fetch query");

                    $total = mysqli_num_rows($userSql);
                    $totalPage = ceil($total / 3);
                    if ($pageNumber == 1) {
                    ?>
                        <li><a href="users.php?page=<?php echo $pageNumber ?>">Prev</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="users.php?page=<?php echo ($pageNumber - 1) ?>">Prev</a></li>
                    <?php
                    }
                    for ($i = 1; $i <= $totalPage; $i++) {
                        if ($pageNumber == $i) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                    ?>
                        <li class="<?php echo $active ?>"><a href="users.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }

                    if ($totalPage == $pageNumber) {
                    ?>
                        <li><a href="users.php?page=<?php echo $pageNumber ?>">Next</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="users.php?page=<?php echo ($pageNumber + 1) ?>">Next</a></li>
                    <?php
                    }
                    ?>



                </ul>
            </div>
        </div>
    </div>
</div>
<?php include "header.php"; ?>