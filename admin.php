<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin | Exam Seating Arrangement</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* --- Page Background --- */
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #89f7fe, #66a6ff);
      overflow: hidden;
    }

    /* --- Card Container --- */
    .center {
      background: #ffffff;
      padding: 50px 70px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      text-align: center;
      width: 420px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .center:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    /* --- Heading --- */
    h1 {
      color: #333;
      margin-bottom: 30px;
      font-size: 26px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* --- Labels --- */
    label {
      display: block;
      text-align: left;
      margin-bottom: 8px;
      font-weight: bold;
      color: #444;
    }

    /* --- Dropdowns --- */
    select {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
      outline: none;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    select:focus {
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* --- Buttons --- */
    button {
      background: linear-gradient(135deg, #007bff, #0056d2);
      border: none;
      color: white;
      padding: 12px 35px;
      font-size: 16px;
      border-radius: 30px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      margin-top: 15px;
    }

    button:hover {
      background: linear-gradient(135deg, #0056d2, #0041a8);
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
    }

    /* --- Back Button --- */
    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      display: flex;
      align-items: center;
      text-decoration: none;
      font-size: 18px;
      font-weight: bold;
      color: #333;
      background: rgba(255, 255, 255, 0.8);
      padding: 8px 14px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      transition: background 0.3s, box-shadow 0.3s;
    }

    .back-button svg {
      width: 20px;
      height: 20px;
      margin-right: 5px;
      fill: #333;
      transition: fill 0.2s;
    }

    .back-button:hover {
      background: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
      color: #000;
    }

    .back-button:hover svg {
      fill: #000;
    }

    /* --- Footer --- */
    footer {
      position: absolute;
      bottom: 20px;
      text-align: center;
      width: 100%;
      color: #fff;
      font-size: 14px;
      opacity: 0.9;
    }

    footer span {
      font-weight: bold;
    }

    /* --- Animation for smooth appearance --- */
    .center {
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

  <script>
    // AJAX fetch exam dates dynamically
    function fetchExamDates(year) {
      if (year == "") {
        document.getElementById("exam_dates").innerHTML = "<option value=''>--Select Exam Date--</option>";
        return;
      }

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("exam_dates").innerHTML = this.responseText;
        }
      };
      xhr.open("GET", "get_exam_dates.php?year=" + year, true);
      xhr.send();
    }
  </script>
</head>

<body>

  <!-- Back button -->
  <a href="http://localhost/exam_seating/exam_seating.php" class="back-button">
    <svg viewBox="0 0 24 24">
      <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
    </svg>
    Back
  </a>

  <!-- Centered Card -->
  <div class="center">
    <h1>Admin - Generate Seating</h1>
    <form action="generate_seating.php" method="POST">
      
      <label for="year">Select Year:</label>
      <select name="year" id="year" onchange="fetchExamDates(this.value)" required>
        <option value="">--Select Year--</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
      </select>

      <br><br>

      <label for="exam_dates">Select Exam Date:</label>
      <select name="exam_date" id="exam_dates" required>
        <option value="">--Select Exam Date--</option>
      </select>

      <br><br>

      <button type="submit">Generate Seating</button>
    </form>
  </div>


</body>
</html>
