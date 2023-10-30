<!DOCTYPE html>
<html>
<head>
<title>MITS INTERNSHIPS</title>
<link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
    <style>
        /* Style for the signup form */
        
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

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 1px;
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
        img#logo {
      margin-left: 10px;
      width: 100px;
      height: 100px;
      text-align: left;
      border-radius: 35%;
    }
    </style>
</head>
<body>

    <h2>Signup Form</h2>    
    <form action="signup.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="rollno">Roll No:</label>
        <input type="text" name="rollno" id="rollno" required><br><br>
        
        <label for="branch">Branch:</label>
        <select name="branch" required>
            <option value="">Select Branch</option>
            <option value="CSE">Computer Science and Engineering</option>
            <option value="CSD">Data Science</option>
            <option value="CAI">Artificial Intelligence</option>
            <option value="CST">Cyber Security</option>
            <option value="CIV">Civil Engineering</option>
            <option value="EEE">Electrical and Electronic Engineering</option>
            <option value="ECE">Electronics and Communication Engineering</option>
            <option value="MECH">Mechanical Engineering</option>
        </select><br><br>
        
        <label for="section">Section:</label>
        <select name="section" required>
            <option value="">Select Section</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
        </select><br><br>
        
        <label for="year">Year:</label>
        <select name="year" required>
            <option value="">Select Year</option>
            <option value="1">First Year</option>
            <option value="2">Second Year</option>
            <option value="3">Third Year</option>
            <option value="4">Fourth Year</option>
        </select><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <label for="retypepassword">Retype Password:</label>
        <input type="password" name="retypepassword" id="retypepassword" required><br><br>
        
        <input type="submit" name="signup" value="Signup">
    </form>
    <div id="error-message"></div>

    <?php
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

    if (isset($_POST['signup'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $rollno = $_POST['rollno'];
        $branch = $_POST['branch'];
        $section = $_POST['section'];
        $year = $_POST['year'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $retypepassword = $_POST['retypepassword'];

        // Check if passwords match
        if ($password !== $retypepassword) {
            $error = "Passwords do not match.";
        } elseif (empty($name) || empty($rollno) || empty($branch) || empty($section) || empty($year) || empty($email) || empty($password) || empty($retypepassword)) {
            $error = "All fields are required!";
        } else {
            // Check if the rollno already exists in the database
            $checkQuery = "SELECT * FROM users WHERE rollno = '$rollno'";
            $checkResult = $conn->query($checkQuery);

            if ($checkResult->num_rows > 0) {
                $error = "Roll No. already exists.";
            } else {
                // All fields are filled, insert the data into the database
                $insertQuery = "INSERT INTO users (name, rollno, branch, section, year, email, password) VALUES ('$name', '$rollno', '$branch', '$section', '$year', '$email', '$password')";
                
                if ($conn->query($insertQuery) === TRUE) {
                    $success = "Signup successful!";
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Error inserting data into the database: " . $conn->error;
                }
            }
        }

        if (isset($error)) {
            echo '<script>document.getElementById("error-message").innerHTML = "'. $error .'";</script>';
        }

        if (isset($success)) {
            echo '<script>document.getElementById("error-message").innerHTML = "'. $success .'";</script>';
        }
    }

    $conn->close();
    ?>
</body>
</html>
