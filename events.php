<?php
include "admin_auth.php";
include "admin_nav.php";

$result = $conn->query(
  "SELECT e.*, COUNT(r.id) AS total
   FROM events e LEFT JOIN registrations r ON e.id = r.event_id
   GROUP BY e.id ORDER BY e.event_date"
);
?>
<div class="section">
  <p class="small-title">EVENT MANAGEMENT</p>
  <h1>All Events</h1>
  <p>View, update and delete college events.</p>

  <table>
    <tr>
      <th>ID</th><th>Title</th><th>Category</th><th>Date</th>
      <th>Venue</th><th>Registered</th><th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['category']); ?></td>
      <td><?php echo $row['event_date']; ?></td>
      <td><?php echo htmlspecialchars($row['venue']); ?></td>
      <td><?php echo $row['total']; ?></td>
      <td>
        <a class="action" href="edit_event.php?id=<?php echo $row['id']; ?>">Edit</a>
        |
        <a class="action" href="delete_event.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this event and its registrations?')">
          Delete
        </a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>