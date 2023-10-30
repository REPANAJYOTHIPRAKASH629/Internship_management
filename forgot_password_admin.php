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

if (isset($_POST['reset'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $retypePassword = $_POST['retype_password'];

    // Check if the email exists in the admin table
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Check if the new password and retype password match
        if ($newPassword === $retypePassword) {
            // Update the admin's password in the database without hashing
            $updateQuery = "UPDATE admins SET password = '$newPassword' WHERE email = '$email'";
            
            if ($conn->query($updateQuery) === TRUE) {
                echo '<script>alert("Password reset successfully.");</script>';
            } else {
                echo '<script>alert("Password reset failed.");</script>';
            }
        } else {
            echo '<script>alert("Passwords do not match. Please retype the new password correctly.");</script>';
        }
    } else {
        echo '<script>alert("Email not found. Please provide a valid email address.");</script>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>MITS INTERNSHIPS - Forgot Password</title>
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
        input[type="email"],
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>
    
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required><br>

    <label for="retype_password">Retype New Password:</label>
    <input type="password" name="retype_password" id="retype_password" required><br>

    <input type="submit" name="reset" value="Reset Password">
</form>

<p><a href="admin_login.php">Back to Login</a></p>

</body>
</html>
