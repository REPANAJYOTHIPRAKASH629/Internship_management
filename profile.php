<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit;
    }

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "internships";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $rollno = $_SESSION['rollno'];

    $query = "SELECT u.name, u.rollno, ol.offerletter, c.name AS certificate_name, c.filename AS certificate_filename
    FROM users u
    LEFT JOIN offer_letters ol ON u.rollno = ol.rollno
    LEFT JOIN certificates c ON u.rollno = c.rollno
    WHERE u.rollno = '$rollno'";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = htmlspecialchars($row['name']);
        $pinno = htmlspecialchars($row['rollno']);
        $offerletter = $row['offerletter'];
        $certificates = htmlspecialchars($row['certificate_name']);
        $certificate_filename = $row['certificate_filename'];
    } else {
        $name = "N/A";
        $pinno = "N/A";
        $offerletter = "N/A";
        $certificates = "N/A";
        $certificate_filename = "";
    }

    mysqli_close($conn);
    ?>

    <h1>Welcome, <?php echo $name; ?>!</h1>
    <p>Here are your details:</p>
    <ul>
        <li>Pin No: <?php echo $pinno; ?></li>
        <li>Offer Letter: 
            <?php if (!empty($offerletter)): ?>
                <a href="uploads/<?php echo $offerletter; ?>" target="_blank">preview Offer letter</a>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </li>
        <li>Certificate: 
            <?php if (!empty($certificate_filename)): ?>
                <a href="uploads/<?php echo $certificate_filename; ?>" target="_blank">preview Certificate</a>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </li>
    </ul>
</body>
</html>
