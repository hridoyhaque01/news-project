<?php

include "./config.php";


$post_id = $_GET['id'];
$catgory_id = $_GET['category_id'];

$getPostQuery = "SELECT * FROM post WHERE post_id = $post_id";
$resultPostQuery = mysqli_query($connection,$getPostQuery) or die("Faild to get result");
$row = mysqli_fetch_assoc($resultPostQuery);

unlink('/upload'.$row['post_img']);

$deleteQuery = "DELETE FROM post where post_id= $post_id;";
$deleteQuery .= "UPDATE category SET post = post - 1 WHERE category_id = $catgory_id";

$runDeleteQuery = mysqli_multi_query($connection, $deleteQuery) or die("Failed to delete user");

if ($runDeleteQuery) {
    header("Location: {$hostname}/admin/post.php");
    mysqli_close($connection);
}
