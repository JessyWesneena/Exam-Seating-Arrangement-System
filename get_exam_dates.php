<?php
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ---------- GET YEAR ---------- */
$year = $_GET['year'] ?? '';

/* ---------- DEFAULT OPTION ---------- */
echo "<option value=''>--Select Exam Date--</option>";

/* ---------- CHECK YEAR ---------- */
if ($year == '') {
    echo "<option value=''>Select year first</option>";
    exit;
}

/* ---------- FETCH DATES ---------- */
$query = "SELECT DISTINCT exam_date 
          FROM exams 
          WHERE year = '$year' 
          ORDER BY exam_date";

$result = $conn->query($query);

/* ---------- ERROR CHECK ---------- */
if (!$result) {
    die("<option>Query Error: " . $conn->error . "</option>");
}

/* ---------- DISPLAY DATES ---------- */
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        // Format date as dd-mm-yyyy
        $formatted_date = date("d-m-Y", strtotime($row['exam_date']));

        echo "<option value='".$row['exam_date']."'>".$formatted_date."</option>";
    }
} else {
    echo "<option value=''>No dates found for this year</option>";
}
?>
