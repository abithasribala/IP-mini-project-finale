<?php
// Included at the top of every admin page
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include "db.php";
?>