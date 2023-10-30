<!DOCTYPE html>
<html>
<head>
<title>MITS INTERNSHIPS</title>
<link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
    <style>
         /* Style for the signup form */
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
        
        select {
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
    </style>
</head>
<body>
    <h2>Admin Signup</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $userPassword = $_POST['password'];
        $repassword = $_POST['repassword'];

        // Validate if the passwords match
        if ($userPassword !== $repassword) {
            echo "Error: Passwords do not match!";
            exit;
        }

        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "internships";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and execute the SQL statement
        $sql = "INSERT INTO admins (name, email, password)
                VALUES ('$name', '$email', '$userPassword')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Admin user created successfully!";
            header("Location: admin_login.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        // Close the database connection
        $conn->close();
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" minlength="6" maxlength="8" required>
        </div>
        <div>
            <label for="repassword">Confirm Password:</label>
            <input type="password" id="repassword" name="repassword" required>
        </div>
        <div>
            <input type="submit" value="Sign Up">
        </div>
    </form>
</body>
</html>
