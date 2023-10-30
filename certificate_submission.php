<!DOCTYPE html>
<html>
<head>
    <title>MITS INTERNSHIPS</title>
    <link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
    <style>
        /* Style for the certificate submission form */
        
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
        input[type="date"],
        input[type="file"] {
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
    </style>
</head>
<body>
<!-- <img id="logo" src="Images/mitslogo.png" alt="MITS Logo"> -->
    <h2>Internship Certificate Submission</h2>
    <form action="certificate_submission.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="rollno">Roll No:</label>
        <input type="text" name="rollno" id="rollno" required><br><br>
        
        <label for="startdate">Internship Start Date:</label>
        <input type="date" name="startdate" id="startdate" required><br><br>
        
        <label for="enddate">Internship End Date:</label>
        <input type="date" name="enddate" id="enddate" required><br><br>
        
        <label for="company">Company Name:</label>
        <input type="text" name="company" id="company" required><br><br>
        
        <label for="role">Role:</label>
        <input type="text" name="role" id="role" required><br><br>
        
        <label for="certificate">Upload Certificate (PDF, max 2MB):</label>
        <input type="file" name="certificate" id="certificate" required><br><br>
        
        <input type="submit" name="submit" value="Submit">
    </form>

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

    if (isset($_POST['submit'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $rollno = $_POST['rollno'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $company = $_POST['company'];
        $role = $_POST['role'];

        // File upload handling
        $file = $_FILES['certificate'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTmp = $file['tmp_name'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        // Check if file is a PDF and within the size limit
        $allowedExtensions = ['pdf'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            $error = "Only PDF files are allowed.";
        } elseif ($fileSize > $maxFileSize) {
            $error = "File size exceeds the limit of 2MB.";
        } elseif ($fileError !== 0) {
            $error = "Error uploading the file.";
        } else {
            // Move the uploaded file to a desired directory
            $uploadDirectory = 'uploads/';
            $newFileName = uniqid('cert_') . '.' . $fileExtension;
            $destination = $uploadDirectory . $newFileName;

            if (move_uploaded_file($fileTmp, $destination)) {
                // File upload successful, insert data into the database
                $insertQuery = "INSERT INTO certificates (name, rollno, startdate, enddate, company, role, filename) 
                                VALUES ('$name', '$rollno', '$startdate', '$enddate', '$company', '$role', '$newFileName')";

                if ($conn->query($insertQuery) === TRUE) {
                    $success = "Certificate submitted successfully!";
                } else {
                    $error = "Error inserting data into the database: " . $conn->error;
                }
            } else {
                $error = "Error moving the uploaded file.";
            }
        }

        if (isset($error)) {
            echo '<script>alert("'.$error.'");</script>';
        }

        if (isset($success)) {
            echo '<script>alert("'.$success.'");</script>';
        }
    }

    $conn->close();
    ?>
</body>
</html>
