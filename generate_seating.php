<?php
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ---------- INPUTS ---------- */
$year = $_POST['year'] ?? '';
$exam_date = $_POST['exam_date'] ?? '';

if ($year == '' || $exam_date == '') {
    die("Error: Year or Exam Date not received from form");
}

/* ---------- CLEAR OLD DATA ---------- */
$conn->query("DELETE FROM seating");

/* ---------- STUDENTS ---------- */
$result = $conn->query("SELECT * FROM students WHERE year='$year' ORDER BY branch, roll_no");

if (!$result) {
    die("Students Query Error: " . $conn->error);
}

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[$row['branch']][] = $row['roll_no'];
}

$branches = array_keys($students);

/* ---------- EXAMS ---------- */
$res = $conn->query("SELECT branch, subject FROM exams WHERE year='$year' AND exam_date='$exam_date'");

if (!$res) {
    die("Exam Query Error: " . $conn->error);
}

$branch_subjects = [];
while ($r = $res->fetch_assoc()) {
    $branch_subjects[$r['branch']] = $r['subject'];
}

/* ---------- ROOMS ---------- */
$result = $conn->query("SELECT * FROM rooms WHERE year='$year' ORDER BY room_no");

if (!$result) {
    die("Rooms Query Error: " . $conn->error);
}

$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

/* ---------- SEATING LOGIC ---------- */
$seating = [];
$room_index = 0;

while (!empty(array_filter($students)) && $room_index < count($rooms)) {

    $room = $rooms[$room_index];
    $half_capacity = floor($room['capacity'] / 2);

    $branchA = array_key_first(array_filter($students));
    $rollsA = array_splice($students[$branchA], 0, $half_capacity);

    if (!empty($rollsA)) {
        $seating[] = [
            'branch' => $branchA,
            'roll_range' => reset($rollsA) . '-' . end($rollsA),
            'room_no' => $room['room_no'],
            'capacity' => count($rollsA)
        ];
    }

    $subA = $branch_subjects[$branchA] ?? '';
    $branchB = null;

    foreach ($branches as $b) {
        if (!empty($students[$b]) && ($branch_subjects[$b] ?? '') != $subA && $b != $branchA) {
            $branchB = $b;
            break;
        }
    }

    if ($branchB) {
        $rollsB = array_splice($students[$branchB], 0, $half_capacity);

        if (!empty($rollsB)) {
            $seating[] = [
                'branch' => $branchB,
                'roll_range' => reset($rollsB) . '-' . end($rollsB),
                'room_no' => $room['room_no'],
                'capacity' => count($rollsB)
            ];
        }
    }

    $room_index++;
}

/* ---------- INSERT INTO DB ---------- */
foreach ($seating as $s) {
    $conn->query("INSERT INTO seating (branch, roll_range, room_no, capacity)
    VALUES (
        '{$s['branch']}',
        '{$s['roll_range']}',
        '{$s['room_no']}',
        '{$s['capacity']}'
    )");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seating Generated</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            text-align: center;
            width: 80%;
            max-width: 900px;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: linear-gradient(135deg, #007bff, #0056d2);
            color: white;
            padding: 14px;
            text-transform: uppercase;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f2f7ff;
        }

        button {
            margin: 20px 10px;
            padding: 10px 25px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(135deg, #007bff, #0056d2);
            color: white;
            cursor: pointer;
        }

        button:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

<div class="container">

<?php
$formatted_date = date("d-m-Y", strtotime($exam_date));
?>

<h2>SEATING GENERATED FOR YEAR <?php echo $year; ?> ON <?php echo $formatted_date; ?></h2>

<table>
<tr>
    <th>Branch</th>
    <th>Room No</th>
    <th>Roll Range</th>
    <th>No. of Students</th>
</tr>

<?php
$res = $conn->query("SELECT branch, roll_range, room_no, capacity FROM seating");

if (!$res) {
    die("Seating Fetch Error: " . $conn->error);
}

while ($row = $res->fetch_assoc()) {
    echo "<tr>
        <td>{$row['branch']}</td>
        <td>{$row['room_no']}</td>
        <td>{$row['roll_range']}</td>
        <td>{$row['capacity']}</td>
    </tr>";
}
?>

</table>

<br>

<button onclick="window.print()">Print</button>
<button onclick="window.location='admin.php'">Back</button>

</div>

</body>
</html>
