<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: login.php');
}

require_once ('database_connection.php');
$type= $_GET['type'];
//insert into groups
if (isset($_POST['Add_Group'])) {
    $group_name = $_POST['group_name'];
    $group_icon = $_FILES['group_icon']['name'];
    $group_icon_path = "./image/" . $group_icon;
    $group_icon_database = "image/" . $group_icon;
    move_uploaded_file($_FILES['group_icon']['tmp_name'], $group_icon_path);
    $group_created_at = date('d-m-y h:i:s');
    $status = $_POST['status'];
    $sql = "INSERT INTO `groups` (group_name, group_icon, group_created_at, status) VALUES ('$group_name', '$group_icon_database', '$group_created_at','$status')";
    $result = mysqli_query($data, $sql);
    if ($result) {
        header('location:admin_view_groups_and_candidate.php');
    }
}


//insert into posts
if (isset($_POST['Add_Post'])) {
    $post_name = $_POST['post_name'];
    $post_created_date = date('d-m-y h:i:s');
    $sql = "INSERT INTO `posts` (post,post_created_date) VALUES ('$post_name','$post_created_date')";
    $result = mysqli_query($data, $sql);
    if ($result) {
        header('location:admin_view_groups_and_candidate.php');
    }
}

//isert into candidates
$group_data = mysqli_query($data, "SELECT * FROM `groups` WHERE status='1'");
$post_data = mysqli_query($data, "SELECT * FROM `posts`");
$user_data = mysqli_query($data, "SELECT * FROM `user` WHERE usertype='student'");

if (isset($_POST['Add_Candidate'])) {
    $group_id = $_POST['group_id'];
    $user_id = $_POST['user_id'];
    $post = $_POST['post'];
    $profile_pic = $_FILES['profile_pic']['name'];
    $group_icon_path = "./image/" . $profile_pic;
    $group_icon_database = "image/" . $profile_pic;
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $group_icon_path);
    $elected_year = $_POST['elected_year'];
    $sql = "INSERT INTO `candidate` (group_id,user_id,post,profile_pic,elected_year) VALUES ('$group_id','$user_id','$post','$group_icon_database','$elected_year')";
    $result = mysqli_query($data, $sql);
    if ($result) {
        header('location:admin_view_groups_and_candidate.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Groups Posts And Candidates</title>
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
            <?php if ($type == 'group') { ?>

                <h1>Add Groups, Posts And Candidates</h1>
                <h2>Add Groups </h2>
                <br>
                <div class="div_deg">
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                        <div>
                            <label for="">Group Name</label>
                            <input type="text" name="group_name">
                        </div>

                        <div>
                            <label for="">Group Icon</label>
                            <input type="file" name="group_icon">
                        </div>
                        <div>
                            <label for="">Status</label>
                            <select name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div>
                            <input class="btn btn_primary" type="submit" name="Add_Group">
                        </div>
                    </form>
                </div>
            <?php }
            if ($type == 'post') {

                ?>

                <br>
                <h2>Add Posts </h2>

                <div class="div_deg">
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                        <div>
                            <label for="">Post Name</label>
                            <input type="text" name="post_name">
                        </div>
                        <div>
                            <input class="btn btn_primary" type="submit" name="Add_Post">
                        </div>
                    </form>
                </div>
            <?php }
            if ($type == 'candidate') { ?>

                <br>
                <h2>Add Candidates </h2>
                <br>
                <div class="div_deg">
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                        <div>
                            <label for="">Select Group ID</label>
                            <select name="group_id" id="group_id">
                                <option value="">Select Group id</option>
                                <?php
                                while ($group = $group_data->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $group['id'] ?>"><?php echo $group['group_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="">Select User ID</label>
                            <select name="user_id" id="user_id">
                                <option value="">Select User ID</option>
                                <?php
                                while ($user = $user_data->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $user['id'] ?>"><?php echo $user['name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="">Select Post</label>
                            <select name="post" id="post">
                                <option value="">Select Post</option>
                                <?php
                                while ($post = $post_data->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $post['post'] ?>"><?php echo $post['post'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="">Choose Profile Image</label>
                            <input type="file" name="profile_pic">
                        </div>
                        <div>
                            <label for="">Nominated Year</label>
                            <input type="date" name="elected_year">
                        </div>
                        <div>
                            <input class="btn btn_primary" type="submit" name="Add_Candidate">
                        </div>
                    <?php } ?>

                </form>
            </div>


        </center>
    </div>
</body>

</html>