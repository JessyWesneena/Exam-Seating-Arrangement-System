<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome | Exam Seating Arrangement</title>

  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #89f7fe, #66a6ff);
    }

    .center {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    select {
      padding: 8px;
      margin: 10px;
      width: 200px;
    }
  </style>
</head>

<body>

  <!-- WELCOME BOX -->
  <div class="center">
    <h1>Welcome</h1>
    <p>Exam Seating Arrangement System</p>
  </div>

  <!-- DROPDOWN SECTION -->
  <div style="margin-top:30px; text-align:center;">

    <h3>Select Year & Exam Date</h3>

    <!-- YEAR DROPDOWN -->
    <select id="year">
      <option value="">--Select Year--</option>
      <option value="1">1st Year</option>
      <option value="2">2nd Year</option>
      <option value="3">3rd Year</option>
      <option value="4">4th Year</option>
    </select>

    <br>

    <!-- EXAM DATE DROPDOWN -->
    <select id="exam_date">
      <option>--Select Exam Date--</option>
    </select>

  </div>

  <!-- AJAX SCRIPT -->
  <script>
    document.getElementById("year").addEventListener("change", function () {
        let year = this.value;

        // reset dropdown if empty
        if (year === "") {
            document.getElementById("exam_date").innerHTML =
                "<option>--Select Exam Date--</option>";
            return;
        }

        fetch("get_exam_dates.php?year=" + year)
            .then(response => response.text())
            .then(data => {
                document.getElementById("exam_date").innerHTML = data;
            })
            .catch(error => {
                console.log("Error:", error);
            });
    });
  </script>

</body>
</html>
