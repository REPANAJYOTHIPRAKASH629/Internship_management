<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
    <style>
        /* Styles for the password reset form */

        * {
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(0.25turn, #3f87a6, #c3f49e, #f69d3c);
        }

        form {
            width: 300px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
        }
    </style>
</head>
<body>
<h2>Forgot Password</h2>

<form action="reset_password.php" method="POST">
    <label for="rollno">Roll No:</label>
    <input type="text" name="rollno" id="rollno" required><br>

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required><br>

    <label for="retype_password">Retype New Password:</label>
    <input type="password" name="retype_password" id="retype_password" required><br>

    <input type="submit" name="create_password" value="Create Password">
</form>
<p><a href="login.php">Back to Login</a></p>

</body>
</html>





