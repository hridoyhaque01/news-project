<?php include "header.php";
include "./config.php";


if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}else if($_SESSION["role"] != 1){
    header("Location:{$hostname}/admin/post.php");
}

if (isset($_POST['submit'])) {
    $userId = $_POST['user_id'];
    $first_name = mysqli_real_escape_string($connection, $_POST['f_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['l_name']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);

    $userCheckQuery = "SELECT username from user where username = '$username'";
    $runCheckQuery = mysqli_query($connection, $userCheckQuery) or die("Failed to check user");

    if (mysqli_num_rows($runCheckQuery) > 0) {
        echo "<script>alert('User Already Exist.')</script>";
    } else {
        $updateQuery = "UPDATE user SET first_name='$first_name', last_name='$last_name', username='$username',role='$role' WHERE  user_id = $userId";
        $runUpdateQuery = mysqli_query($connection, $updateQuery)  or die("Failed to update data");
        if ($runUpdateQuery) {
            header("Location: http://localhost/news-template/admin/users.php");
        }
        mysqli_close($connection);
    }
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

                    <?php
                    $userId = $_GET['id'];
                    $getUserDataQuery = "SELECT * from user where user_id = $userId";
                    $runGetUserQuery = mysqli_query($connection, $getUserDataQuery) or die("Failed to get user data");
                    if (mysqli_num_rows($runGetUserQuery) > 0) {
                        while ($user = mysqli_fetch_assoc($runGetUserQuery)) {
                    ?>
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?php echo $user['user_id'] ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control" value="<?php echo $user['first_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control" value="<?php echo $user['last_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $user['username'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role">
                                    <?php

                                    if ($user['role'] === '0') {
                                        echo " <option value='0' selected>normal User</option>
                                    <option value='1'>Admin</option>";
                                    } else {
                                        echo " <option value='0' >normal User</option>
                                    <option value='1' selected>Admin</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    <?php

                        }
                    } else {
                        echo "<p>No data found!</p>";
                    }
                    ?>
                </form>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>