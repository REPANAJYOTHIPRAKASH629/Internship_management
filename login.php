
<!DOCTYPE html>
<html>
<head>
    <title>MITS INTERNSHIPS</title>
    <link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
    <style>
        /* Styles for the login form */

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
<h2>Login Form</h2>

<form action="login.php" method="POST">
    <label for="rollno">Roll No:</label>
    <input type="text" name="rollno" id="rollno" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>

    <input type="submit" name="login" value="Login">
</form>

<p><a href="forgot_password.php">Forgot Password?</a></p>

<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internships";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    // Retrieve form data
    $rollno = $_POST['rollno'];
    $password = $_POST['password'];

    // Prepare and execute the query
    $query = "SELECT * FROM users WHERE rollno = '$rollno' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Successful login, store the roll number in a session variable
        $_SESSION['loggedin'] = true;
        $_SESSION['rollno'] = $rollno;
        header("Location: welcome_student.html");
        exit();
    } else {
        // Incorrect login details, display error message
        echo '<script>alert("Incorrect login details. Please provide correct roll number and password.");</script>';
    }
}

$conn->close();
?>

</body>
</html>

