<?php
include "db.php";
$done = false;
$msg = "";
$ticket = [];
$selected = isset($_GET['event']) ? (int)$_GET['event'] : 0;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $stmt = $conn->prepare("INSERT INTO registrations
    (event_id, name, email, phone, department, year_of_study)
    VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isssss", $_POST['event_id'], $_POST['name'],
    $_POST['email'], $_POST['phone'], $_POST['department'],
    $_POST['year']);
  if ($stmt->execute()) {
    $done = true;
    $regId = $conn->insert_id;
    $q = $conn->prepare("SELECT title, event_date, venue FROM events WHERE id=?");
    $q->bind_param("i", $_POST['event_id']);
    $q->execute();
    $ev = $q->get_result()->fetch_assoc();
    $ticket = [
      "id" => $regId, "name" => $_POST['name'],
      "dept" => $_POST['department'], "year" => $_POST['year'],
      "title" => $ev['title'], "venue" => $ev['venue'],
      "date" => date("d-m-Y", strtotime($ev['event_date']))
    ];
  } else {
    $msg = "Registration failed. Please try again.";
  }
  $stmt->close();
}
$events = $conn->query("SELECT * FROM events ORDER BY event_date");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Event Registration - CampusEvents</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { background: #f3f1fb; }
    .wz { width: 720px; max-width: 94%; margin: 40px auto; }
    .wz-title { text-align: center; margin-bottom: 25px; }
    .wz-title h1 { margin: 5px 0; color: #1f1b4d; }
    .wz-title p { color: #666; margin: 0; }

    .wz-progress { display: flex; justify-content: space-between; margin-bottom: 25px; }
    .wz-dot { flex: 1; text-align: center; font-size: 13px; color: #999; }
    .wz-dot span {
      display: block; width: 34px; height: 34px; line-height: 34px;
      margin: 0 auto 6px; border-radius: 50%; background: #ddd; color: #fff;
      font-weight: bold;
    }
    .wz-dot.active { color: #5b3fd1; font-weight: bold; }
    .wz-dot.active span { background: #5b3fd1; }
    .wz-dot.complete span { background: #2e9e5b; }

    .wz-card { background: white; border-radius: 14px; padding: 35px; box-shadow: 0 6px 24px #d6d2ee; }
    .wz-step { display: none; }
    .wz-step.show { display: block; }
    .wz-step h3 { margin-top: 0; color: #1f1b4d; }

    .wz-pills { display: flex; gap: 10px; margin-top: 8px; }
    .wz-pills label { margin: 0; flex: 1; }
    .wz-pills input, .wz-ev input { display: none; }
    .wz-pills span {
      display: block; text-align: center; padding: 11px; font-weight: normal;
      border: 2px solid #ddd; border-radius: 8px; cursor: pointer;
    }
    .wz-pills input:checked + span { border-color: #5b3fd1; background: #efebff; color: #5b3fd1; font-weight: bold; }

    .wz-ev { margin-top: 12px; }
    .wz-box { display: block; padding: 16px; border: 2px solid #ddd; border-radius: 10px; cursor: pointer; font-weight: normal; }
    .wz-box b { font-size: 17px; }
    .wz-box small { display: block; color: #666; margin-top: 4px; }
    .wz-ev input:checked + .wz-box { border-color: #e8590c; background: #fff4ec; }

    .wz-sum { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .wz-sum td { text-align: left; border: 0; border-bottom: 1px solid #eee; padding: 10px 4px; }
    .wz-sum td:first-child { color: #777; width: 38%; }

    .wz-nav { display: flex; justify-content: space-between; margin-top: 25px; }
    .wz-btn { width: auto; margin: 0; padding: 12px 28px; border-radius: 6px; }
    .wz-back { background: #e5e5ee; color: #333; }
    .wz-back:hover { background: #d3d3e0; }
    .wz-err { background: #fdeaea; color: #b00020; padding: 10px; margin-top: 15px; border-radius: 6px; display: none; }

    .ticket { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 6px 24px #d6d2ee; }
    .ticket-top { background: linear-gradient(135deg, #2e9e5b, #1f7a45); color: white; padding: 30px; text-align: center; }
    .ticket-top h2 { margin: 0 0 6px; }
    .ticket-body { padding: 30px; }
    .ticket-body .wz-sum td { font-size: 16px; }
    .ticket-actions { text-align: center; padding: 0 30px 30px; }
  </style>
</head>
<body>
<nav>
  <h2>CampusEvents</h2>
  <div>
    <a href="index.php">Home</a>
    <a href="login.php">Admin Login</a>
  </div>
</nav>

<div class="wz">
<?php if ($done) { ?>

  <div class="ticket">
    <div class="ticket-top">
      <h2>You're Registered!</h2>
      <p>Registration No: #<?php echo $ticket['id']; ?></p>
    </div>
    <div class="ticket-body">
      <table class="wz-sum">
        <tr><td>Name</td><td><?php echo htmlspecialchars($ticket['name']); ?></td></tr>
        <tr><td>Department / Year</td><td><?php echo htmlspecialchars($ticket['dept']); ?> - <?php echo htmlspecialchars($ticket['year']); ?> Year</td></tr>
        <tr><td>Event</td><td><?php echo htmlspecialchars($ticket['title']); ?></td></tr>
        <tr><td>Date</td><td><?php echo $ticket['date']; ?></td></tr>
        <tr><td>Venue</td><td><?php echo htmlspecialchars($ticket['venue']); ?></td></tr>
      </table>
    </div>
    <div class="ticket-actions">
      <a class="main-btn" href="register.php">Register for Another Event</a>
      <a class="main-btn" href="index.php">Back to Home</a>
    </div>
  </div>

<?php } else { ?>

  <div class="wz-title">
    <p class="small-title">STUDENT REGISTRATION</p>
    <h1>Reserve Your Spot</h1>
    <p>Three quick steps and you're in.</p>
  </div>

  <div class="wz-progress">
    <div class="wz-dot active" id="dot1"><span>1</span>Your Details</div>
    <div class="wz-dot" id="dot2"><span>2</span>Choose Event</div>
    <div class="wz-dot" id="dot3"><span>3</span>Confirm</div>
  </div>

  <div class="wz-card">
    <?php if ($msg != "") { echo "<p class='error'>" . htmlspecialchars($msg) . "</p>"; } ?>
    <form method="POST" id="regForm" onsubmit="goNext(); return false;">

      <div class="wz-step show" id="step1">
        <h3>Tell us about yourself</h3>
        <label>Full Name</label>
        <input type="text" id="name" name="name" placeholder="Your full name">
        <label>College Email</label>
        <input type="email" id="email" name="email" placeholder="you@college.edu">
        <label>Mobile Number</label>
        <input type="text" id="phone" name="phone" placeholder="10 digit mobile number">
        <label>Department</label>
        <select id="department" name="department">
          <option value="">Select department</option>
          <option>CSE</option><option>IT</option><option>ECE</option>
          <option>EEE</option><option>MECH</option><option>CIVIL</option>
        </select>
        <label>Year of Study</label>
        <div class="wz-pills">
          <label><input type="radio" name="year" value="I"><span>I</span></label>
          <label><input type="radio" name="year" value="II"><span>II</span></label>
          <label><input type="radio" name="year" value="III"><span>III</span></label>
          <label><input type="radio" name="year" value="IV"><span>IV</span></label>
        </div>
      </div>

      <div class="wz-step" id="step2">
        <h3>Pick the event you want to join</h3>
        <?php while ($e = $events->fetch_assoc()) { ?>
        <label class="wz-ev">
          <input type="radio" name="event_id" value="<?php echo $e['id']; ?>"
                 data-title="<?php echo htmlspecialchars($e['title']); ?>"
                 data-date="<?php echo date("d-m-Y", strtotime($e['event_date'])); ?>"
                 <?php if ($selected == $e['id']) echo "checked"; ?>>
          <span class="wz-box">
            <b><?php echo htmlspecialchars($e['title']); ?></b>
            <small><?php echo htmlspecialchars($e['category']); ?> |
              <?php echo date("d-m-Y", strtotime($e['event_date'])); ?> |
              <?php echo htmlspecialchars($e['venue']); ?></small>
          </span>
        </label>
        <?php } ?>
      </div>

      <div class="wz-step" id="step3">
        <h3>Check your details</h3>
        <table class="wz-sum">
          <tr><td>Name</td><td id="s_name"></td></tr>
          <tr><td>Email</td><td id="s_email"></td></tr>
          <tr><td>Mobile</td><td id="s_phone"></td></tr>
          <tr><td>Department</td><td id="s_dept"></td></tr>
          <tr><td>Year</td><td id="s_year"></td></tr>
          <tr><td>Event</td><td id="s_event"></td></tr>
        </table>
      </div>

      <div class="wz-err" id="err"></div>

      <div class="wz-nav">
        <button type="button" class="wz-btn wz-back" id="backBtn" onclick="goBack()" style="visibility:hidden">Back</button>
        <button type="button" class="wz-btn" id="nextBtn" onclick="goNext()">Next</button>
      </div>
    </form>
  </div>

<script>
var step = 1;

function showStep(n) {
  for (var i = 1; i <= 3; i++) {
    document.getElementById("step" + i).className = "wz-step" + (i == n ? " show" : "");
    var d = document.getElementById("dot" + i);
    d.className = "wz-dot" + (i == n ? " active" : (i < n ? " complete" : ""));
  }
  document.getElementById("backBtn").style.visibility = (n == 1) ? "hidden" : "visible";
  document.getElementById("nextBtn").innerText = (n == 3) ? "Confirm Registration" : "Next";
  document.getElementById("err").style.display = "none";
}

function error(text) {
  var e = document.getElementById("err");
  e.innerText = text;
  e.style.display = "block";
  return false;
}

function checked(name) {
  return document.querySelector('input[name="' + name + '"]:checked');
}

function validateStep(n) {
  if (n == 1) {
    var name = document.getElementById("name").value.trim();
    var email = document.getElementById("email").value.trim();
    var phone = document.getElementById("phone").value.trim();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (name == "") return error("Please enter your name");
    if (!emailPattern.test(email)) return error("Please enter a valid email address");
    if (phone.length != 10 || isNaN(phone)) return error("Please enter a valid 10 digit mobile number");
    if (document.getElementById("department").value == "") return error("Please select your department");
    if (!checked("year")) return error("Please select your year of study");
  }
  if (n == 2) {
    if (!checked("event_id")) return error("Please choose an event");
  }
  return true;
}

function fillSummary() {
  document.getElementById("s_name").innerText = document.getElementById("name").value.trim();
  document.getElementById("s_email").innerText = document.getElementById("email").value.trim();
  document.getElementById("s_phone").innerText = document.getElementById("phone").value.trim();
  document.getElementById("s_dept").innerText = document.getElementById("department").value;
  document.getElementById("s_year").innerText = checked("year").value + " Year";
  var ev = checked("event_id");
  document.getElementById("s_event").innerText = ev.getAttribute("data-title") + " (" + ev.getAttribute("data-date") + ")";
}

function goNext() {
  if (!validateStep(step)) return;
  if (step == 3) {
    document.getElementById("regForm").submit();
    return;
  }
  step++;
  if (step == 3) fillSummary();
  showStep(step);
}

function goBack() {
  if (step > 1) { step--; showStep(step); }
}
</script>

<?php } ?>
</div>
</body>
</html>