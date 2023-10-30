<!DOCTYPE html>
<html>
<head>
  <title>MITS INTERNSHIPS</title>
  <link rel="shortcut icon" href="https://mits.ac.in/images/mits-favicon.png" type="image/x-icon">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    h1 {
      text-align: center;
    }

    form {
      margin-bottom: 20px;
      display: flex;
      justify-content: center; /* Center the form horizontally */
      align-items: center;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    select, button {
      padding: 5px;
      font-size: 14px;
      margin-right: 10px;
    }

    button[type="submit"] {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }

    button[type="submit"], button[type="reset"] {
      margin-right: 10px;
    }

    table {
      border-collapse: collapse;
      width: 70%;
      margin: 0 auto; /* Center the table horizontally */
      align-items: center;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    a {
      color: #0066cc;
      text-decoration: none;
    }

    .print-button {
      background-color: #008CBA;
      color: white;
    }
  </style>
</head>
<body>
<div style="position: absolute; top: 10px; right: 10px;">
    <a href="index.html">Logout</a>
  </div>

  <h1>Admin Dashboard</h1>

  <form action="admin_dashboard.php" method="post">
    <label for="branch">Branch:</label>
    <select name="branch" id="branch">
      <option value="">Select Branch</option>
      <option value="CSE">Computer Science and Engineering</option>
      <option value="CSD">Data Science</option>
      <option value="CAI">Artificial Intelligence</option>
      <option value="CST">Cyber Security</option>
      <option value="CIV">Civil Engineering</option>
      <option value="EEE">Electrical and Electronic Engineering</option>
      <option value="ECE">Electronics and Communication Engineering</option>
      <option value="MECH">Mechanical Engineering</option>
      <!-- Add more options as needed -->
    </select>

    <label for="section">Section:</label>
    <select name="section" id="section">
      <option value="">Select Section</option>
      <option value="A">A</option>
      <option value="B">B</option>
      <option value="C">C</option>
      <option value="D">D</option>
      <option value="E">E</option>
      <option value="F">F</option>
      <!-- Add more options as needed -->
    </select>

    <label for="year">Year:</label>
    <select name="year" required>
      <option value="">Select Year</option>
      <option value="1">First Year</option>
      <option value="2">Second Year</option>
      <option value="3">Third Year</option>
      <option value="4">Fourth Year</option>
      <!-- Add more options for different years -->
    </select>

    <button type="submit" name="filter">Filter</button>
    <!-- <button type="reset" name="clear" onclick="clearTable()">Clear Filter</button> -->
    <button type="button" class="print-button" onclick="window.print()">Print</button>
  </form>

  <?php
// Database connection code here

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internships";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['filter'])) {
    // Fetch data from the database based on filter values
    $branch = $_POST['branch'];
    $section = $_POST['section'];
    $year = $_POST['year'];

    // Construct your database query here using the filter values
    $sql = "SELECT users.name, users.rollno, users.branch, users.section, certificates.startdate, certificates.enddate, certificates.company, certificates.role, certificates.filename, offer_letters.offerletter AS offerletter_filename
            FROM users
            LEFT JOIN certificates ON users.rollno = certificates.rollno
            LEFT JOIN offer_letters ON users.rollno = offer_letters.rollno
            WHERE 1"; // This condition ensures at least one record will be returned

    if (!empty($branch)) {
        $sql .= " AND users.branch = '$branch'";
    }

    if (!empty($section)) {
        $sql .= " AND users.section = '$section'";
    }

    if (!empty($year)) {
        $sql .= " AND users.year = $year";
    }

    $result = $conn->query($sql);

    if (!$result) {
        echo "Error: " . $conn->error;
    }

    if ($result->num_rows > 0) {
        // Display the data in a table
        echo "<table>
              <tr>
                <th>Name</th>
                <th>Pin No</th>
                <th>Branch</th>
                <th>Section</th>
                <th>StartDate</th>
                <th>EndDate</th>
                <th>Company</th>
                <th>Role</th>
                <th>Offer Letter</th>
                <th>Certificate</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['name'] . "</td>
                <td>" . $row['rollno'] . "</td>
                <td>" . $row['branch'] . "</td>
                <td>" . $row['section'] . "</td>
                <td>" . $row['startdate'] . "</td>
                <td>" . $row['enddate'] . "</td>
                <td>" . $row['company'] . "</td>
                <td>" . $row['role'] . "</td>";

            // Check if offer letter exists, if not, display "Not uploaded"
            if (!empty($row['offerletter_filename'])) {
                echo "<td><a href='uploads/" . $row['offerletter_filename'] . "' target='_blank'>Download</a></td>";
            } else {
                echo "<td>Not uploaded</td>";
            }

            // Check if certificate exists, if not, display "Not uploaded"
            if (!empty($row['filename'])) {
                echo "<td><a href='uploads/" . $row['filename'] . "' target='_blank'>Download</a></td>";
            } else {
                echo "<td>Not uploaded</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No results found.";
    }

    $result->free_result();
}

$conn->close();
?>

</body>
</html>