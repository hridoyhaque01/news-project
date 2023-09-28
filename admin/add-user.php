<?php 
include "header.php";
include "./config.php";

if(!isset($_SESSION["user_id"])){
    header("Location:{$hostname}/admin/");
}else if($_SESSION["role"] != 1){
    header("Location:{$hostname}/admin/post.php");
}

if (isset($_POST['save'])) {
    $first_name = mysqli_real_escape_string($connection, $_POST['fname']);
    $last_name = mysqli_real_escape_string($connection, $_POST['lname']);
    $username = mysqli_real_escape_string($connection, $_POST['user']);
    $password = mysqli_real_escape_string($connection, md5($_POST['password']));
    $role = mysqli_real_escape_string($connection, $_POST['role']);

    $userCheckQuery = "SELECT username from user where username = '$username'";
    $runCheckQuery = mysqli_query($connection, $userCheckQuery) or die("Failed to check user");

    if (mysqli_num_rows($runCheckQuery) > 0) {
        echo "<script>alert('User Already Exist.')</script>";
    } else {
        $insertQuery = "INSERT INTO user(first_name,last_name,username,password,role) VALUE ('$first_name','$last_name','$username','$password','$role')";
        $runInsertQuery = mysqli_query($connection, $insertQuery)  or die("Failed to insert data");
        if ($runInsertQuery) {
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
                <h1 class="admin-heading">Add User</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="user" class="form-control" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select class="form-control" name="role">
                            <option value="0">Normal User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <button type="submit" name="save" class="btn btn-primary" value="Save">Save</button>
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>