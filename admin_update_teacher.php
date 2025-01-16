<?php
session_start();
error_reporting(1);

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}

require_once('database_connection.php');


if (isset($_GET['teacher_id'])) {
    $t_id = $_GET['teacher_id'];
// print_r($t_id);
    $sql = "SELECT * FROM teacher WHERE id='$t_id'";
    $result = mysqli_query($data, $sql);
    $info = mysqli_fetch_assoc($result);
}

if (isset($_POST['update_teacher'])) {
    $id = $_POST['id'];
    // print_r($id);
    $t_name = $_POST['name'];
    $t_desc = $_POST['description'];
    $file = $_FILES['image']['name'];

    // print_r($file);
     $dst = "image/" . $file;
    $dst_db = "image/" . $file;
// $_FILES
    if (!empty($file)) {
        if(move_uploaded_file($_FILES['image']['tmp_name'], $dst)){
            $sql2 = "UPDATE teacher SET name='$t_name', description='$t_desc', image='$dst_db' WHERE id='$id'";
         }else{
            echo "Image is not uploaded.";
            die;
         }
    } else {
        $sql2 = "UPDATE teacher SET name='$t_name', description='$t_desc' WHERE id='$id'";
    }

    $result2 = mysqli_query($data, $sql2);
    if ($result2) {
        header('location: admin_view_teacher.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teachers Data</title>
    <?php 
    include 'admin_css.php';
    ?>
    <style type="text/css">
        label {
            display: inline-block;
            width: 150px;
            text-align: right;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .form_deg {
            background-color: skyblue;
            width: 600px;
            padding-top: 70px;
            padding-bottom: 70px;
        }
    </style>
</head>
<body>
<?php
include 'admin_sidebar.php';
?>
<div class="content">
    <center>
    <h1>Update Teachers Data</h1>

    <form class="form_deg" action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
        <div>
            <label for="name">Teacher Name</label>
            <input type="text" name="name" value="<?php echo $info['name']; ?>">
        </div>
        <div>
            <label for="description">About Teacher</label>
            <textarea rows="4" name="description"><?php echo $info['description']; ?></textarea>
        </div>
        <div>
            <label for="image">Teacher Old Image</label>
            <img width="100px" height="100px" src="<?php echo $info['image']; ?>" alt="Teacher Image">
        </div>
        <div>
            <label for="new_image">Choose Teachers New Image</label>
            <input type="file" name="image">
        </div>
        <div>
            <input class="btn btn-success" type="submit" name="update_teacher" value="Update Teacher">
        </div>
    </form>
    </center>
</div>
</body>
</html>
