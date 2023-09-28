<?php

include "./config.php";


$user_id = $_GET['id'];

$deleteQuery = "DELETE FROM user where user_id= $user_id";

$runDeleteQuery = mysqli_query($connection, $deleteQuery) or die("Failed to delete user");

if ($runDeleteQuery) {
    header("Location: http://localhost/news-template/admin/users.php");
    mysqli_close($connection);
}
