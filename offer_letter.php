<!DOCTYPE html>
<html>
<head>
    <title>MITS INTERNSHIPS</title>
    <link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
    <style>
        /* Style for the form */

        * {
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(0.25turn, #3f87a6, #c3f49e, #f69d3c);
        }

        form {
            width: 400px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type="date"] {
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

        p.error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Internship Offer Letter</h2>
    <form action="offer_letter.php" method="POST" enctype="multipart/form-data">
        <label for="name">Student Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="rollno">Roll No:</label>
        <input type="text" name="rollno" id="rollno" required><br>

        <label for="company">Company Name:</label>
        <input type="text" name="company" id="company" required><br>

        <label for="role">Role:</label>
        <input type="text" name="role" id="role" required><br>

        <label for="internshipstartdate">Internship Start Date:</label>
        <input type="date" name="internshipstartdate" id="internshipstartdate" required><br>

        <label for="offerletter">Offer Letter (PDF, max 2MB):</label>
        <input type="file" name="offerletter" id="offerletter" accept="application/pdf" required><br>

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
        $name = $_POST['name'];
        $rollno = $_POST['rollno'];
        $company = $_POST['company'];
        $role = $_POST['role'];
        $internshipstartdate = $_POST['internshipstartdate'];

        // File upload handling
        $targetDir = "uploads/";
        $fileName = basename($_FILES["offerletter"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if the file is a PDF and within the size limit
        if ($fileType != "pdf") {
            echo '<p class="error">Only PDF files are allowed!</p>';
        } elseif ($_FILES["offerletter"]["size"] > 2097152) {
            echo '<p class="error">File size exceeds the limit of 2MB!</p>';
        } else {
            // Move the uploaded file to the designated folder
            if (move_uploaded_file($_FILES["offerletter"]["tmp_name"], $targetFilePath)) {
                // Insert data into the database
                $insertQuery = "INSERT INTO offer_letters (name, rollno, company, role, internshipstartdate, offerletter) VALUES ('$name', '$rollno', '$company', '$role', '$internshipstartdate', '$fileName')";

                if ($conn->query($insertQuery) === TRUE) {
                    echo '<script>alert("Offer letter submitted successfully!");</script>';
                } else {
                    echo '<p class="error">Error inserting data into the database: ' . $conn->error . '</p>';
                }
            } else {
                echo '<p class="error">Error uploading the file.</p>';
            }
        }
    }

    $conn->close();
    ?>
</body>
</html>
