<?php
include "admin_auth.php";
$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM registrations WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: registrations.php");
exit();
?>