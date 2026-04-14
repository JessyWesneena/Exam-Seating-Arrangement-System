<?php
$host = "localhost";
$user = "root";
$password = ""; // MySQL password
$dbname = "exam_seating";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
