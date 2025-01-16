<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location: login.php');
}
// print_r( $_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php
        include 'admin_css.php';
    ?>
</head>
<body>
    <?php
        include 'admin_sidebar.php';
    ?>
    <center>
    <div class="content" >
        <h1 style="color: red;">Welcome to the Admin Dashboard</h1>
        <p>This is the admin control panel for managing the W-School website.</p>
       
    </div>
    </center>
</body>
</html>
