<?php

session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}

require_once('database_connection.php');


if (isset($_POST['Add_Teacher'])) {
    $t_name = $_POST['name'];
    $t_desc = $_POST['description'];
    $file = $_FILES['image']['name'];
    $dst = "./image/" . $file;
    $dst_db = "image/" . $file;
    move_uploaded_file($_FILES['image']['tmp_name'],$dst); 

    $sql = "INSERT INTO teacher (name, description, image) VALUES ('$t_name', '$t_desc', '$dst_db')"; 
    $result = mysqli_query($data, $sql);
    if($result){
        header('location:admin_view_teacher.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <?php
    include 'admin_css.php';
    ?>
    <style>
        .div_deg {
            background-color: skyblue;
            padding-top: 70px;
            padding-bottom: 70px;
            width: 500px;
        }
    </style>
</head>
<body>
    <?php
    include 'admin_sidebar.php';
    ?>
    <div class="content">
        <center>
            <h1>Add Teacher</h1>
            <br><br>
            <div class="div_deg">
                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="">Teacher Name</label>
                        <input type="text" name="name">
                    </div>
                    <div>
                        <label for="">Description</label>
                        <textarea name="description"></textarea>
                    </div>
                    <div>
                        <label for="">Image</label>
                        <input type="file" name="image">
                    </div>
                    <div>
                        <input class="btn btn_primary" type="submit" name="Add_Teacher">
                    </div>
                </form>
            </div>
        </center>
    </div>
</body>
</html>
