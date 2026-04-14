<?php
session_start();
include 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check admin table for username and password
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=? LIMIT 1");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Username or password is incorrect";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="/exam_seating/style.css">
  <style>
    /* Center body */
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #89f7fe, #66a6ff);
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

    /* Login card */
    .login-card {
      background: white;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 320px;
      text-align: center;
    }

    .login-card h1 {
      margin-bottom: 20px;
      font-size: 1.8em;
      color: #333;
    }

    /* Form */
    .login-form {
      display: flex;
      flex-direction: column;
      width: 100%;
      gap: 15px;
    }

    .form-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-row input {
      width: 150px;
      padding: 6px;
      font-size: 1em;
    }

    /* Button row */
    .button-row {
      display: flex;
      justify-content: center;
    }

    .button-row button {
      padding: 8px 20px;
      font-size: 1em;
      cursor: pointer;
      border-radius: 6px;
      background: linear-gradient(45deg, #ff6a00, #ee0979);
      color: white;
      border: none;
      box-shadow: 0 3px 6px rgba(0,0,0,0.2);
      transition: all 0.2s;
    }

    .button-row button:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0,0,0,0.25);
    }

    .error-msg {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <!-- Back button -->
  <a href="http://localhost/exam_seating/" class="back-button">
    <svg viewBox="0 0 24 24">
      <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
    </svg>
    Back
  </a>

  <div class="login-card">
    <h1>Admin Login</h1>

    <?php if($error) echo "<p class='error-msg'>$error</p>"; ?>

    <form method="POST" class="login-form">
      <div class="form-row">
        <label>Username:</label>
        <input type="text" name="username" required>
      </div>

      <div class="form-row">
        <label>Password:</label>
        <input type="password" name="password" required>
      </div>

      <div class="button-row">
        <button type="submit">Login</button>
      </div>
    </form>
  </div>

</body>
</html>
