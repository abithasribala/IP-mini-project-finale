<?php
session_start();
include "db.php";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $username = $_POST['username'];
  $password = hash('sha256', $_POST['password']);

  $stmt = $conn->prepare(
    "SELECT id FROM admin WHERE username=? AND password=?"
  );
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "Invalid username or password";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Login - CampusEvents</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
  <h2>CampusEvents</h2>
  <a href="index.php">Home</a>
</nav>

<div class="form-box">
  <p class="small-title center">ADMIN AREA</p>
  <h2>Admin Login</h2>
  <p class="center">Login to manage events and registrations.</p>
  <?php if ($error != "") {
    echo "<p class='error'>" . htmlspecialchars($error) . "</p>";
  } ?>
  <form method="POST">
    <label>Username</label>
    <input type="text" name="username" placeholder="Enter username" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter password" required>

    <button type="submit">Login</button>
  </form>
  <p class="center">Demo Login: <b>admin</b> / <b>admin123</b></p>
</div>
</body>
</html>