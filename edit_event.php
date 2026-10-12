<?php
include "admin_auth.php";
$id = (int)$_GET['id'];

if (isset($_POST['update'])) {
  $stmt = $conn->prepare("UPDATE events SET title=?, category=?,
    event_date=?, venue=?, description=? WHERE id=?");
  $stmt->bind_param("sssssi", $_POST['title'], $_POST['category'],
    $_POST['event_date'], $_POST['venue'], $_POST['description'], $id);
  $stmt->execute();
  header("Location: events.php");
  exit();
}

$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
include "admin_nav.php";
?>
<div class="form-box">
  <p class="small-title center">EVENT MANAGEMENT</p>
  <h2>Edit Event</h2>
  <form method="POST">
    <label>Event Title</label>
    <input type="text" name="title" required
           value="<?php echo htmlspecialchars($row['title']); ?>">

    <label>Category</label>
    <select name="category">
      <?php foreach (["Technical","Cultural","Sports","Workshop"] as $c) { ?>
      <option <?php if ($row['category'] == $c) echo "selected"; ?>>
        <?php echo $c; ?>
      </option>
      <?php } ?>
    </select>

    <label>Event Date</label>
    <input type="date" name="event_date" required
           value="<?php echo $row['event_date']; ?>">

    <label>Venue</label>
    <input type="text" name="venue" required
           value="<?php echo htmlspecialchars($row['venue']); ?>">

    <label>Description</label>
    <textarea name="description" rows="4" required><?php
      echo htmlspecialchars($row['description']); ?></textarea>

    <button type="submit" name="update">Update Event</button>
  </form>
</div>
</body>
</html>