<?php
session_start();
require_once('database_connection.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);    
    $data = htmlspecialchars($data);
    return $data;
}

function validate_mobile($mobile) {
    return preg_match('/^[0-9]{10}+$/', $mobile);
}

if ($data === false) {
    die("Connection error: " . mysqli_connect_error());
} else {
    echo "Connection successful... now let's proceed <br>";
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $name = test_input($_POST["username"]);
    $pass = $_POST['password'];

    $fields = "email";
    if (!filter_var($name, FILTER_VALIDATE_EMAIL)) {
        $fields = "username";
    }
    if (validate_mobile($name)) {
        $fields = "phone";
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user WHERE " . $fields . "=?";
    $stmt = mysqli_prepare($data, $sql);

    if ($stmt) {
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($pass, $row["password"])) {
                if ($row["usertype"] == "student") {
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['usertype'] = "student";
                    $_SESSION['userid'] = $row["id"];
                    $_SESSION['names']=$row['name'];
                    header("location: studenthome.php");
                    exit;
                } elseif ($row["usertype"] == "admin") {
                    $_SESSION['username'] = $name;
                    $_SESSION['usertype'] = "admin";
                    header("location: adminhome.php");
                    exit;
                }
            } else {
                echo "Invalid username and password combination.";
            }
        } else {
            echo "No user found with the provided credentials.";
        }

        $stmt->close();
    } else {
        echo "Statement preparation error: " . mysqli_error($data);
    }
}

mysqli_close($data); // Close the database connection at the end

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ($_SESSION['usertype'] == 'student') {
    header('location: studenthome.php');
} elseif ($_SESSION['usertype'] == 'admin') {
    header('location: adminhome.php');
}
?>