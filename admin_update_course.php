<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}

require_once('database_connection.php');


if (isset($_GET['course_id'])) {
    $t_id = $_GET['course_id'];
    $sql = "SELECT * FROM course WHERE id='$t_id'";
    $result = mysqli_query($data, $sql);
    $info = $result->fetch_assoc();
}

if (isset($_POST['update_course'])) {
    $id = $_POST['id'];
    $t_name = $_POST['name'];
    $t_desc = $_POST['description'];
    $file = $_FILES['image']['name'];
    $dst = "./image/" . $file;
    $dst_db = "image/" . $file;
    move_uploaded_file($_FILES['image']['tmp_name'], $dst);
    if ($file) {
        $sql2 = "UPDATE course SET name='$t_name', description='$t_desc', image='$dst_db' WHERE id='$id'"; // Corrected here
    } else {
        $sql2 = "UPDATE course SET name='$t_name', description='$t_desc' WHERE id='$id'"; // Corrected here
    }
    $result2 = mysqli_query($data, $sql2);
    if ($result2) {
        header('location: admin_view_course.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course Data</title>
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
    <h1>Update Course Data</h1>

    <form class="form_deg" action="#" method="post" enctype="multipart/form-data"> <!-- Corrected enctype here -->
        <input type="text" name="id" value="<?php echo $info['id']; ?>" hidden>
        <div>
            <label for="name">Course Name</label>
            <input type="text" name="name" value="<?php echo $info['name']; ?>">
        </div>
        <div>
            <label for="description">About Course</label>
            <textarea rows="4" name="description"><?php echo $info['description']; ?></textarea>    
        </div>
        <div>
            <label for="image">Course Old Image</label>
            <img width="100px" height="100px" src="<?php echo $info['image']; ?>" alt="Course Image">
        </div>
        <div>
            <label for="new_image">Choose Course New Image</label>
            <input type="file" name="image">
        </div>
        <div>
            <input class="btn btn-success" type="submit" name="update_course">
        </div>
    </form>
    </center>
</div>
</body>
</html>
