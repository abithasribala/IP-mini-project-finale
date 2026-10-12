<?php
include "admin_auth.php";

if (isset($_POST['save'])) {
  $stmt = $conn->prepare("INSERT INTO events
    (title, category, event_date, venue, description)
    VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $_POST['title'], $_POST['category'],
    $_POST['event_date'], $_POST['venue'], $_POST['description']);
  $stmt->execute();
  header("Location: events.php");
  exit();
}
include "admin_nav.php";
?>
<div class="form-box">
  <p class="small-title center">EVENT MANAGEMENT</p>
  <h2>Add New Event</h2>
  <form method="POST">
    <label>Event Title</label>
    <input type="text" name="title" required>

    <label>Category</label>
    <select name="category">
      <option>Technical</option>
      <option>Cultural</option>
      <option>Sports</option>
      <option>Workshop</option>
    </select>

    <label>Event Date</label>
    <input type="date" name="event_date" required>

    <label>Venue</label>
    <input type="text" name="venue" required>

    <label>Description</label>
    <textarea name="description" rows="4" required></textarea>

    <button type="submit" name="save">Save Event</button>
  </form>
</div>
</body>
</html>