<?php

session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once ('database_connection.php');

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'admin') {
    header('location: login.php');
}


$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
// print_r($userid);

$sql1 = "SELECT *
          FROM user
          JOIN candidate ON user.id = candidate.user_id
          WHERE user.username = '$username' ";
$userData = mysqli_query($data, $sql1);
$userDatafetched = $userData->fetch_array();




$sql2 = "SELECT * FROM votes WHERE voter_id = '$userid' ";
$statusData = mysqli_query($data, $sql2);
//$statusDataFetched = $statusData->fetch_array();







$sql3 = "SELECT c.id candidate_id,c.profile_pic,c.post,g.group_name,g.group_icon,u.name FROM `groups` as g
JOIN `candidate` c ON g.id = c.group_id
JOIN `user` u ON c.user_id = u.id";


$groupsData = mysqli_query($data, $sql3);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .user {
            margin-top: 20px;
            margin-left: 110px;
            float: left;
            width: 40%;
            text-align: center;
            align-items: center;
            font-size: 20px;
            background-color: aquamarine;
        }

        img {
            float: right;
            margin-top: 14px;
            margin-right: 15px;
        }

        .line {
            border-top: 5px dashed red;
            border-radius: 5px;

        }

        .group {
            margin-top: 20px;
            margin-right: 10px;
            text-align: center;
            width: 50%;
            float: right;
            align-items: center;
            font-size: 20px;
            background-color: bisque;

        }
    </style>
    <?php
    include 'student_css.php';
    ?>
</head>

<body>
    <?php
    include 'student_sidebar.php';
    ?>
    <div class="user">
        <img height="90px" width="80px"
            src="https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg" alt="User Image">
        <br>
        Name : <?php echo $userDatafetched['name']; ?>
        <br>
        Mob No : <?php echo $userDatafetched['phone']; ?>
        <br>
        <?php
        $arrdata = [];
        while ($row = $statusData->fetch_assoc()) {
            $arrdata['vote'][$row['post']] = $row['votes']?? null;
            $arrdata['vote'][$row['candidate_id']][$row['post']] = $row['votes']?? null;
            if (empty($row['votes']) && $row['votes']!= 1) {
                $status = $row['post'].'- <b style="color:red">Not Voted</b>';
            } else {
                $status = $row['post'].'- <b style="color:green">Voted</b>';
            }
             echo '<br>Status:'. $status;
        }
        // echo "<pre>";
        // print_r($arrdata);
        // die;
        ?>
        
        


    </div>

    <div class="group">
        <?php
        $ardata = [];
        while ($info = $groupsData->fetch_assoc()) {
            $ardata[$info['post']][] = $info;
        }


        foreach ($ardata as $key => $value) { ?>
            <h1> <b style="color:blueviolet"> Post :</b><?= $key ?></h1>
            <?php foreach ($value as $value1) {
                ?>


                <div>

                    <img height="90px" width="90px" src="<?php echo $value1['profile_pic']; ?>" alt="groupImage">
                    <br>
                    <b style="color:darkgreen">Candidate Name:</b> <?php echo $value1['name']; ?>
                    <br>
                    <b style="color:darkcyan">Group:</b> <?php echo $value1['group_name']; ?>
                    <?php echo $value1['id']; ?>
                    <?php if($arrdata['vote'][$value1['post']] != 1){?>
                    <form action="voteStatusUpdate.php" method="post">
                        <input type="hidden" name="cid" value="<?php echo $value1['candidate_id']; ?>">
                        <input type="hidden" name="post" value="<?php echo $value1['post']; ?>">

                        <input style="color:brown;" type="submit" name="votebtn" value="Vote" id="votebtn">
                    </form>
                    <?php }
                    if($arrdata['vote'][$value1['candidate_id']][$value1['post']] == 1){
                        echo '<b style="color:green">Voted</b>';
                    }?>
                    <br>
                    <br>
                </div>



                <?php
            }
            ?>
            <hr class="line" style="color:red">
            <?php
        }

        ?>

    </div>
</body>

</html>