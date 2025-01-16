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

$type = $_GET['type'];
//to show groups
$sql = "SELECT * FROM `groups`";
$result = mysqli_query($data, $sql);

//delete post
// if ($_GET['post_id']) {
//     $post_id = $_GET['post_id'];
//     $sql2 = "DELETE FROM `posts`   WHERE id='$post_id'";
//     $result2 = mysqli_query($data, $sql2);
//     if ($result2) {
//         header('location:admin_view_groups_and_candidate.php');
//     }
// }

//to show posts
$sqlpost = "SELECT * FROM `posts`";
$postdata = mysqli_query($data, $sqlpost);


//to show candidate
$candidateSql = "SELECT * FROM `candidate`";
$candidate = mysqli_query($data, $candidateSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Groups</title>
    <?php
    include 'admin_css.php';
    ?>
    <style type="text/css">
        .table_th {
            padding: 20px;
            font-size: 20px;
        }

        .table_td {
            padding: 20px;
            background-color: skyblue;
        }
    </style>
</head>

<body>
    <?php
    include 'admin_sidebar.php';
    ?>
    <div class="content">
        <center>
            <!-- <h1>View All Groups , Candidates And Their Posts</h1> -->

            <?php if ($type == 'group') { ?>
                <!-- table to view groups -->
                <h2>View All Groups </h2>
                <table border="1px">
                    <tr>
                        <th class="table_th">Group Name</th>
                        <th class="table_th">Group Icon </th>
                        <th class="table_th">Group Created Date</th>
                        <th class="table_th">Group Status</th>
                    </tr>
                    <?php
                    while ($info = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td class="table_td"><?php
                            echo "{$info['group_name']}";
                            ?></td>
                            <td class="table_td"><img height="100px" width="100px" src="<?php
                            echo "{$info['group_icon']}";
                            ?>" alt=""></td>
                            <td class="table_td"><?php
                            echo "{$info['group_created_at']}";
                            ?></td>
                            <td class="table_td"><?php
                            echo ($info['status'] == 0) ? 'ACTIVE' : 'INACTIVE';
                            ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php
             }?>
           

                <!-- table to view posts -->
                <br>
             <?php   if ($type == 'post') { ?>
                <h2>View All Posts </h2>
                <table border="1px">
                    <tr>
                        <th class="table_th">Post Name</th>
                        <th class="table_th">Post Created Date</th>
                        <!-- <th class="table_th">Delete</th> -->
                        <th class="table_th">Update</th>
                    </tr>
                    <?php
                    while ($record = $postdata->fetch_assoc()) {
                        ?>
                        <tr>
                            <td class="table_td"><?php
                            echo "{$record['post']}";
                            ?></td>

                            <td class="table_td"><?php
                            echo "{$record['post_created_date']}";
                            ?></td>
                            <!-- <td class="table_td"> -->
                            <?php
                            // echo "<a onClick=\"javascript:return confirm('Are You Sure To Delete This')\" class='btn btn-danger' href='admin_view_groups_and_candidate.php?post_id={$record['id']}'>Delete</a> ";
                            ?>
                            <!-- </td> -->
                            <td class="table_td">
                                <?php
                                echo "<a class='btn btn-primary' href='admin_update_groups_and_candidate.php?post_id={$record['id']}&type=postBtn'>Update</a>";
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php }
            if ($type == 'candidate') { ?>


                <!-- table to view candidates -->
                <h2>View All Candidates </h2>
                <table border="1px">
                    <tr>
                        <th class="table_th">Group ID</th>
                        <th class="table_th">User ID </th>
                        <th class="table_th">Post</th>
                        <th class="table_th">Profile Pic</th>
                        <th class="table_th">Elected Year</th>
                        <th class="table_th">Update</th>
                    </tr>
                    <?php
                    while ($candidt = $candidate->fetch_assoc()) {
                        ?>
                        <tr>
                            <td class="table_td"><?php
                            echo "{$candidt['group_id']}";
                            ?></td>
                            <td class="table_td"><?php
                            echo "{$candidt['user_id']}";
                            ?></td>
                            <td class="table_td"><?php
                            echo "{$candidt['post']}";
                            ?></td>
                            <td class="table_td"><img height="100px" width="100px" src="<?php
                            echo "{$candidt['profile_pic']}";
                            ?>" alt=""></td>
                            <td class="table_td"><?php
                            echo "{$candidt['elected_year']}";
                            ?></td>
                            <td class="table_td">
                                <?php
                                echo "<a class='btn btn-primary' href='admin_update_groups_and_candidate.php?candidate_id={$candidt['id']}&type=candidateBtn'>Update</a>";
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php } ?>

        </center>
    </div>

</body>

</html>