function validateForm() {
  let name = document.getElementById("name").value.trim();
  let email = document.getElementById("email").value.trim();
  let phone = document.getElementById("phone").value.trim();
  let dept = document.getElementById("department").value;
  let year = document.getElementById("year").value;
  let eventId = document.getElementById("event").value;
  let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (name == "") {
    alert("Please enter your name");
    return false;
  }
  if (!emailPattern.test(email)) {
    alert("Please enter a valid email address");
    return false;
  }
  if (phone.length != 10 || isNaN(phone)) {
    alert("Please enter a valid 10 digit phone number");
    return false;
  }
  if (dept == "") {
    alert("Please select your department");
    return false;
  }
  if (year == "") {
    alert("Please select your year of study");
    return false;
  }
  if (eventId == "") {
    alert("Please select an event");
    return false;
  }
  return true;
}