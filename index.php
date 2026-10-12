<?php
include "db.php";
$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>CampusEvents - College Event Management</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
  <h2>CampusEvents</h2>
  <div>
    <a href="index.php">Home</a>
    <a href="#about">About</a>
    <a href="#features">Features</a>
    <a href="#events">Events</a>
    <a href="#contact">Contact</a>
    <a href="login.php">Admin Login</a>
  </div>
</nav>

<section class="hero">
  <div class="hero-content">
    <p class="small-title">WELCOME TO CAMPUSEVENTS</p>
    <h1>Discover. Participate.<br> Celebrate Campus Life.</h1>
    <p>
      One place to explore college events, symposiums, cultural
      fests and sports meets - and register in just a few clicks.
    </p>
    <a class="main-btn" href="register.php">Register Now</a>
    <a class="second-btn" href="#events">View Events</a>
  </div>
</section>

<section id="about" class="section">
  <p class="small-title">ABOUT THE SYSTEM</p>
  <h2>Events Made Simple</h2>
  <p>
    The College Event Management System helps the college publish
    events and lets students register online. The administrator can
    manage events and track every registration from one dashboard.
  </p>
  <a class="main-btn" href="register.php">Register for an Event</a>
</section>

<section id="features" class="section light">
  <p class="small-title center">WHY CAMPUSEVENTS</p>
  <h2 class="center">Everything You Need For Events</h2>
  <div class="cards">
    <div class="card">
      <h3>Easy Registration</h3>
      <p>Students register for any event using a simple online form.</p>
    </div>
    <div class="card">
      <h3>Event Details</h3>
      <p>Date, venue, category and description of every event.</p>
    </div>
    <div class="card">
      <h3>Admin Control</h3>
      <p>Add, edit and delete events from a secure admin panel.</p>
    </div>
    <div class="card">
      <h3>Track Participants</h3>
      <p>View and manage all registrations event by event.</p>
    </div>
  </div>
</section>

<section id="events" class="section">
  <p class="small-title center">EVENTS</p>
  <h2 class="center">Upcoming Campus Events</h2>
  <div class="cards">
    <?php while ($e = $events->fetch_assoc()) { ?>
    <div class="card">
      <span class="tag"><?php echo htmlspecialchars($e['category']); ?></span>
      <h3><?php echo htmlspecialchars($e['title']); ?></h3>
      <p><b>Date:</b> <?php echo date("d-m-Y", strtotime($e['event_date'])); ?></p>
      <p><b>Venue:</b> <?php echo htmlspecialchars($e['venue']); ?></p>
      <p><?php echo htmlspecialchars($e['description']); ?></p>
      <a class="main-btn" href="register.php?event=<?php echo $e['id']; ?>">
        Register
      </a>
    </div>
    <?php } ?>
  </div>
</section>

<section class="quote">
  <h2>"Great colleges are built by great campus experiences."</h2>
  <p>Take part. Learn more. Make memories.</p>
</section>

<section id="contact" class="section contact">
  <p class="small-title center">CONTACT US</p>
  <h2 class="center">Event Coordination Cell</h2>
  <div class="contact-box">
    <div><h3>Location</h3><p>Main Block, College Campus</p></div>
    <div><h3>Phone</h3><p>+91 98765 43210</p></div>
    <div><h3>Email</h3><p>events@college.edu</p></div>
    <div><h3>Office Hours</h3><p>9:00 AM - 4:30 PM</p></div>
  </div>
</section>

<footer>
  <h3>CampusEvents</h3>
  <p>Participate - Learn - Celebrate</p>
  <p>&copy; 2026 College Event Management System</p>
</footer>
</body>
</html>