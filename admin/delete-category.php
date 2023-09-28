<?php
include "./config.php";

$id = $_GET['id'];

$deleteQuery = "DELETE FROM category WHERE category_id = $id";
$deleteSql = mysqli_query($connection,$deleteQuery) or die("Failed to delete query");
if($deleteSql){
    header("Location:{$hostname}/admin/category.php");
} 