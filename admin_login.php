<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "internships";

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch admin details
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    if ($row && $password === $row['password']) {
        $_SESSION["admin_id"] = $row["admin_id"];
        $_SESSION["name"] = $row["name"];
        header("Location: admin_dashboard.php");
        exit();
    }

    // Incorrect email or password
    $error = "Invalid email or password.";

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>MITS INTERNSHIPS</title>
<link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
    <style>
         /* Style for the login form */
        *{
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

        .error {
          color: red;
          margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Admin Login</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="Login">

        <p><a href="forgot_password_admin.php">Forgot Password?</a></p>
        
        <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
