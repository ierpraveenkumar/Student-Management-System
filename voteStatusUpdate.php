<?php
session_start();
require_once ('database_connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// print_r($_POST);die;
if ($_POST['votebtn'] == "Vote") {
    $check = mysqli_query($data, "SELECT * FROM votes where voter_id = '".$_SESSION['userid']."' and post='".$_POST['post']."'");
    $check_record = $check->fetch_array();
    $num = mysqli_num_rows($check);

   // $vote = $check_record['votes'];


    if ($num == 0) {
        $cid = $_POST['cid'];
        $uid = $_SESSION['userid']; //voterid
        $date = date('d-m-y h:i:s');
        $votes = 1;
        $post=$_POST['post'];
        $sql = "INSERT INTO votes (candidate_id, voter_id, voting_date, votes , post) VALUES ($cid, $uid, '$date', $votes , '$post')";
        $insert = mysqli_query($data, $sql);
        header('location:vote.php');
    }
}

?>