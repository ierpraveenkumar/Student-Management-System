<?php
session_start();
require_once ('database_connection.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($data) {
    echo ("connection success");
} else {
    die("connection error");

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <style>
        /* CSS */
        .link {
            color: aqua;
            text-decoration: none;
            font-weight: bold;
        }

        .link:hover {
            text-decoration: none;
            color: blanchedalmond;
            /* Change color on hover */
            font-size: larger;
        }
    </style>
</head>
<?php
if (!isset($_SESSION['usertype'])) {
    ?>

    <body style="background-image: url('image/c1.jpeg');" class="body_deg">
        <center>
            <div class="form_deg">
                <h2 class="title_deg">Login Form</h2>



                <form action="login_check.php" method="post" class="login_form">
                    <div>
                        <label class="label_deg">Username</label>
                        <input type="text" name="username">
                    </div>
                    <div>
                        <label class="label_deg">Password</label>
                        <input type="password" name="password">
                    </div>
                    <div>
                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                    </div>
                    <br>
                    <div>
                        <a href="registration.php" class="link">Not Yet Registered??</a>
                    </div>

                </form>
            </div>
        </center>
        <?php
} else {
    if ($_SESSION['usertype'] == "student") {
        header("location: studenthome.php");
    } else {
        header("location: adminhome.php");
    }
}
?>
</body>

</html>