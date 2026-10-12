<?php
include "admin_auth.php";
include "admin_nav.php";

$events = $conn->query("SELECT COUNT(*) AS c FROM events")
              ->fetch_assoc()['c'];
$regs = $conn->query("SELECT COUNT(*) AS c FROM registrations")
             ->fetch_assoc()['c'];
$upcoming = $conn->query(
  "SELECT COUNT(*) AS c FROM events WHERE event_date >= CURDATE()"
)->fetch_assoc()['c'];
$past = $conn->query(
  "SELECT COUNT(*) AS c FROM events WHERE event_date < CURDATE()"
)->fetch_assoc()['c'];
?>
<div class="section">
  <p class="small-title">ADMIN PANEL</p>
  <h1>Event Management Dashboard</h1>
  <p>
    Welcome, <b><?php echo htmlspecialchars($_SESSION['admin']); ?></b>.
    Manage events and registrations from here.
  </p>

  <div class="dashboard">
    <div class="stat"><h3>Total Events</h3><h1><?php echo $events; ?></h1></div>
    <div class="stat"><h3>Registrations</h3><h1><?php echo $regs; ?></h1></div>
    <div class="stat"><h3>Upcoming Events</h3><h1><?php echo $upcoming; ?></h1></div>
    <div class="stat"><h3>Past Events</h3><h1><?php echo $past; ?></h1></div>
  </div>
  <br>
  <a class="main-btn" href="events.php">Manage Events</a>
  <a class="main-btn" href="add_event.php">Add New Event</a>
  <a class="main-btn" href="registrations.php">View Registrations</a>
</div>
</body>
</html>