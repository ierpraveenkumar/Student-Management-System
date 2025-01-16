<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}

require_once('database_connection.php');


if (isset($_POST['add_student'])) {
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_phone = $_POST['phone'];
    $user_password = $_POST['password'];
    $user_password = password_hash($user_password,PASSWORD_DEFAULT);
    $usertype = "student"; // Fix the variable name here.
    
    $check="SELECT * FROM user WHERE username= '$user_name' ";
    $check_user=mysqli_query($data,$check);
    $row_count=mysqli_num_rows($check_user);//here we r counting same username 

    if($row_count==1){
        echo "<script type='text/javascript' > alert('Username Already Exists So plz Try Another One'); </script>";
    }

    else{

    $sql = "INSERT INTO user (username, email, phone, usertype, password) 
    VALUES ('$user_name', '$user_email', '$user_phone', '$usertype', '$user_password')";
    $result = mysqli_query($data, $sql);

    if ($result) {
        echo "<script type='text/javascript' > alert('Data Uploaded Successfully'); </script>";
    } else {
        echo "<script type='text/javascript' > alert('Sorry Couldnot Be  Upload'); </script>";
    }



}
}

//mysqli_close($data);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

<style type="text/css" >

label{
    display: inline-block;
    text-align: right;
    width: 100px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.div_deg{
    background-color: skyblue;
    width: 400px;
    padding-top: 70px;
    padding-bottom: 70px;
}
</style>

    <?php 
include 'admin_css.php';
    ?>



</head>
<body>
<?php
include 'admin_sidebar.php';
?>
<div class="content" >
    <center>
    <h1>Add Student</h1>
    <div class="div_deg">
        <form action="#" method="POST" >

<div> <label>Username</label> <input type="text" name="name" >  </div>
<div> <label>Email</label> <input type="email" name="email" >  </div>
<div> <label>Phone</label> <input type="number" name="phone" >  </div>
<div> <label>Password</label> <input type="text" name="password" >  </div>
<div>  <input class="btn btn-primary" type="submit" name="add_student" value="Add Student" >  </div>

        </form>
    </div>
    </center>
</div>

</body>
</html>