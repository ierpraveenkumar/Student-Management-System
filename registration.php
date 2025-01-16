<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        /* CSS */

        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            padding: 10;
            background-color: #f7f7f7;
            height: 50%;
            width: 48%;
            align-items: center;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .link {
            color: blue;
            text-decoration: none;
            font-weight: bold;
        }

        .link:hover {
            text-decoration: none;
            color: palegreen;
            /* Change color on hover */
            font-size: larger;
        }

        h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 14px;
            display: block;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h2>Registration Form</h2><span><a class="link" href="login.php">Already Registered? Login Here</a></span>
    <form id="registrationForm" action="registrationProcess.php" method="post">
        <div>
            <label for="username">Username</label>
            <input id="username" type="text" name="username"
                value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            <span class="error" id="usernameError"><?php echo $username_err; ?></span>
        </div>
        <div>
            <label for="phone">Phone</label>
            <input id="phone" type="text" name="phone"
                value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
            <span class="error" id="phoneError"><?php echo $phone_err; ?></span>
        </div>
        <div>
            <label for="email">Email</label>
            <input id="email" type="text" name="email"
                value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <span class="error" id="emailError"><?php echo $email_err; ?></span>
        </div>
        <div>
            <label for="usertype"> Select Usertype</label>
            <select name="usertype" id="usertype">
                <option value="admin" <?= ($_POST['usertype'] == "admin") ? 'selected' : ''; ?>>admin</option>
                <option value="student" <?= ($_POST['usertype'] == "student") ? 'selected' : ''; ?>>student</option>
            </select>
            <span class="error" id="usertypeError"><?php echo $usertype_err; ?></span>
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" value="">
            <span class="error" id="passwordError"><?php echo $password_err; ?></span>
        </div>

        <input type="submit" value="Submit" name="submit" id="submitBtn">
    </form>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {




            $('#username').blur(function (event) {
                event.preventDefault(); // Prevent default form submission

                var username = $('#username').val();

                $.ajax({
                    type: 'POST',
                    url: 'registrationProcess.php',
                    data: {
                        username: username,
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            // If no errors, allow form submission
                            $('#registrationForm').unbind('submit').submit();
                        } else {
                            // Display error messages
                            $('#usernameError').text(response.username_err);
                        }
                    }
                });
            });



            $('#phone').blur(function (event) {
                event.preventDefault(); // Prevent default form submission
                var phone = $('#phone').val();
                $.ajax({
                    type: 'POST',
                    url: 'registrationProcess.php',
                    data: {
                        phone: phone,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // If no errors, allow form submission
                            $('#registrationForm').unbind('submit').submit();
                        } else {
                            // Display error messages
                            $('#phoneError').text(response.phone_err);
                        }
                    }
                });
            });




            $('#email').blur(function (event) {
                event.preventDefault(); // Prevent default form submission

                var email = $('#email').val();

                $.ajax({
                    type: 'POST',
                    url: 'registrationProcess.php',
                    data: {
                        email: email
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // If no errors, allow form submission
                            $('#registrationForm').unbind('submit').submit();
                        } else {
                            // Display error messages
                            $('#emailError').text(response.email_err);
                        }
                    }
                });
            });



            $('#usertype').blur(function (event) {
                event.preventDefault(); // Prevent default form submission

                var usertype = $('#usertype').val();

                $.ajax({
                    type: 'POST',
                    url: 'registrationProcess.php',
                    data: {
                        usertype: usertype,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // If no errors, allow form submission
                            $('#registrationForm').unbind('submit').submit();
                        } else {
                            // Display error messages
                            $('#usertypeError').text(response.usertype_err);
                        }
                    }
                });
            });


            $('#password').blur(function (event) {
                event.preventDefault(); // Prevent default form submission
                var password = $('#password').val();

                $.ajax({
                    type: 'POST',
                    url: 'registrationProcess.php',
                    data: {
                        password: password,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // If no errors, allow form submission
                            $('#registrationForm').unbind('submit').submit();
                        } else {
                            // Display error messages
                            $('#passwordError').text(response.password_err);
                        }
                    }
                });
            });






            $('#registrationForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                var username = $('#username').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var usertype = $('#usertype').val();
                var password = $('#password').val();

                $.ajax({
                    type: 'POST',
                    url: 'registrationProcess.php',
                    data: {
                        username: username,
                        phone: phone,
                        email: email,
                        usertype: usertype,
                        password: password
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            window.location.href = response.redirect; // Redirect if registration successful
                        } else {
                            // Display error messages
                            $('#usernameError').text(response.username_err);
                            $('#phoneError').text(response.phone_err);
                            $('#emailError').text(response.email_err);
                            $('#usertypeError').text(response.usertype_err);
                            $('#passwordError').text(response.password_err);
                        }
                    }
                });
            });






        });
    </script>







</body>

</html>