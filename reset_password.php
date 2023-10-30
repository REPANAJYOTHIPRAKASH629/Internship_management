<?php
$conn = mysqli_connect("localhost", "root", "", "internships");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollno = $_POST["rollno"];
    $newPassword = $_POST["new_password"];
    $retypePassword = $_POST["retype_password"];

    // Check if the rollno exists in your database
    // Modify this query according to your database structure
    $query = "SELECT * FROM users WHERE rollno = '$rollno'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        if ($newPassword === $retypePassword) {
            // Passwords match, update the password
            $updateQuery = "UPDATE users SET password = '$newPassword' WHERE rollno = '$rollno'";
            mysqli_query($conn, $updateQuery);

            // Password updated successfully
            echo "<script>alert('Password updated successfully.');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            // Passwords don't match
            echo "<script>alert('Passwords does not matched.');</script>";
        }
    } else {
        // Rollno not found in the database
        echo "<script>alert('Roll No not found.');</script>";
    }
}

// Close your database connection if necessary
// mysqli_close($conn);
?>
