<?php
session_start();



require_once('database_connection.php');



if ($data === false) {
    die("Connection error: " . mysqli_connect_error());
}

if (isset($_POST['apply'])) {
    $data_name = $_POST['name'];
    $data_email = $_POST['email'];
    $data_phone = $_POST['phone'];
    $data_message = $_POST['message'];

    // Fix the SQL query
    $sql = "INSERT INTO admission (name, email, phone, message) 
            VALUES ('$data_name', '$data_email', '$data_phone', '$data_message')";
    $result = mysqli_query($data, $sql);

    if ($result) {
     $_SESSION['message']="your application sent successfully";
     header('location: index.php');
    } else {
        echo "Application submission failed: " . mysqli_error($data);
    }
    
    // Close the database connection
    mysqli_close($data);
}
?>
