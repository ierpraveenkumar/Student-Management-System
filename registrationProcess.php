<?php
require_once ('database_connection.php');

$response = array('success' => false); // Initialize response

$username = $phone = $email = $usertype = $password = "";
$username_err = $phone_err = $email_err = $password_err = $usertype_err = "";

function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile);
}

function check($data, $type, $value)
{
    $sql_check = "SELECT * FROM user WHERE " . $type . " = ?";
    if ($stmt_check = mysqli_prepare($data, $sql_check)) {
        $stmt_check->bind_param("s", $value);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        $matchedError = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row[$type] === $value) {
                    $matchedError = $type . " already exists.";
                }
            }
        }
        return $matchedError;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && !empty(trim($_POST["username"]))) {
        $username = trim($_POST["username"]);
        $username_err = check($data, 'username', $username);
    } else {
        $username_err = "Please enter a username.";
    }

    if (isset($_POST["phone"]) && !empty(trim($_POST["phone"]))) {
        $phone = trim($_POST["phone"]);
        if (!validate_mobile($phone)) {
            $phone_err = "Phone number is invalid.";
        } else {
            $phone_err = check($data, 'phone', $phone);
        }
    } else {
        $phone_err = "Please enter a phone number.";
    }

    if (isset($_POST["email"]) && !empty(trim($_POST["email"]))) {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        } else {
            $email_err = check($data, 'email', $email);
        }
    } else {
        $email_err = "Please enter an email.";
    }

    if (isset($_POST["usertype"]) && !empty(trim($_POST["usertype"]))) {
        $usertype = trim($_POST["usertype"]);
    } else {
        $usertype_err = "Please select a usertype.";
    }

    if (isset($_POST["password"]) && !empty(trim($_POST["password"]))) {
        $password = trim($_POST["password"]);
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>ยง~])(?=.{8,})/';
        if (!preg_match($pattern, $password)) {
            $password_err = "Password must have minimum 8 characters, one uppercase letter, one lowercase letter, one digit, and one special character.";
        }
    } else {
        $password_err = "Please enter a password.";
    }

    if (empty($username_err) && empty($phone_err) && empty($email_err) && empty($usertype_err) && empty($password_err)) {
        $response['success'] = true;
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql_insert = "INSERT INTO user (username, phone, email,usertype, password) VALUES (?, ?, ?, ?, ?)";
        if ($stmt_insert = mysqli_prepare($data, $sql_insert)) {
            $stmt_insert->bind_param("sssss", $username, $phone, $email, $usertype, $password);
            if ($stmt_insert->execute()) {
                $response['redirect'] = 'login.php';
            } else {
                $response['error'] = "Something went wrong. Please try again later.";
            }
            $stmt_insert->close();
        }
    } else {
        $response['username_err'] = $username_err;
        $response['email_err'] = $email_err;
        $response['phone_err'] = $phone_err;
        $response['usertype_err'] = $usertype_err;
        $response['password_err'] = $password_err;
    }
    echo json_encode($response);
    exit(); // Terminate script after sending response
}
?>
