<?php

session_start();
require_once('database_connection.php');


if($_GET['student_id']){

    $user_id=$_GET['student_id'];
    $sql="DELETE FROM user WHERE id='$user_id'";

    $result=mysqli_query($data,$sql);
    if($result){

        $_SESSION['message']='Student Deleted Successfully';
        header("location:admin_view_student.php");
    }
}
?>