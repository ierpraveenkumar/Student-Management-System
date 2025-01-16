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

//update posts

if ($_GET['type'] == 'postBtn') {


    if (isset($_GET['post_id'])) {
        $type = $_GET['type'];
        $post_id = $_GET['post_id'];
        $sql = "SELECT * FROM `posts` WHERE id='$post_id'";
        $result = mysqli_query($data, $sql);
        $info = mysqli_fetch_array($result);
    }

    if (isset($_POST['update_post'])) {
        $id = $_POST['id'];
        $post_name = $_POST['post_name'];
        $date = $_POST['post_updated_at'];
        $sql2 = "UPDATE `posts` SET post='$post_name', post_created_date='$date' WHERE id='$id'";
        $result2 = mysqli_query($data, $sql2);
        if ($result2) {
            header('location: admin_view_groups_and_candidate.php');
        }
    }


}
//update Candidates
if ($_GET['type'] == 'candidateBtn') {


    if (isset($_GET['candidate_id'])) {
        $candidate_id = $_GET['candidate_id'];
        $sql1 = "SELECT * FROM `candidate` WHERE id='$candidate_id'";
        $result_cand = mysqli_query($data, $sql1);
        $info_candidate = mysqli_fetch_assoc($result_cand);
    }


    $group_data = mysqli_query($data, "SELECT * FROM `groups` WHERE status='1'");
    $post_data = mysqli_query($data, "SELECT * FROM `posts`");
    $user_data = mysqli_query($data, "SELECT * FROM `user` WHERE usertype='student'");

    if (isset($_POST['Update_Candidate'])) {
        $id = $_POST['id'];
        $group_id = $_POST['group_id'];
        $user_id = $_POST['user_id'];
        $post = $_POST['post'];
        $profile_pic = $_FILES['profile_pic']['name'];
        $group_icon_path = "./image/" . $profile_pic;
        $group_icon_database = "image/" . $profile_pic;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $group_icon_path);
        $elected_year = $_POST['elected_year'];
        $sql = "UPDATE `candidate` SET group_id=$group_id, user_id=$user_id, post= $post, profile_pic=$group_icon_database, elected_year=$elected_year WHERE id= $id";
        $result = mysqli_query($data, $sql);
        if ($result) {
            header('location:admin_view_groups_and_candidate.php');
        }
    }



}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Posts and Candidate</title>
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
            <?php if ($_GET['type'] == 'postBtn') { ?>
                <h1>Update Post</h1>


                <form class="form_deg" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                    <div>
                        <label for="name">Post Name</label>
                        <input type="text" name="post_name" value="<?php echo $info['post']; ?>">
                    </div>
                    <div>
                        <label for="description">Post Updated On</label>
                        <input type="date" name="post_updated_at" value="<?php echo $info['post_created_date']; ?>">
                    </div>
                    <div>
                        <input class="btn btn-success" type="submit" name="update_post" value="Update Post">
                    </div>
                </form>
            <?php
            }
            if ($_GET['type'] == 'candidateBtn') {
                ?>
                <br>

                <h1>Update Candidate</h1>

                <form class="form_deg" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $info_candidate['id']; ?>">
                    <div>
                        <label for="">Select Group ID</label>
                        <select name="group_id" id="group_id">

                            <?php
                            while ($group = $group_data->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $group['id'] ?>"
                                    <?= ($info_candidate['group_id'] == $group['id']) ? 'selected' : '' ?>>
                                    <?php echo $group['group_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="">Select User ID</label>
                        <select name="user_id" id="user_id">

                            <?php
                            while ($user = $user_data->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $user['id'] ?>"
                                    <?= ($info_candidate['user_id'] == $user['id']) ? 'selected' : '' ?>><?php echo $user['name'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="">Select Post</label>
                        <select name="post" id="post">
                            <option value=""><?php echo $info_candidate['post']; ?></option>
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
                        <input type="date" name="elected_year" value="<?= $info_candidate['elected_year'] ?>">
                    </div>
                    <div>
                        <input class="btn btn-success" type="submit" name="Update_Candidate">
                    </div>
                </form>
            <?php } ?>
        </center>
    </div>
</body>

</html>