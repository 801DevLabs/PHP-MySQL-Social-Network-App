<?php

$con = mysqli_connect("localhost", "", "", "social");

if(mysqli_connect_errno()) {
  echo "Connection error " . mysqli_connect_errno();
}

// DECLARING VARIABLES TO PREVENT ERRORS
$fname = ""; // First name
$lname = ""; // Last name
$email = ""; // Email
$email2 = ""; // Email 2
$password = ""; // Password
$password2 = ""; // Password 2
$date = ""; // Sign up date
$error_array = ""; // Holds error messages

if(isset($_POST['register_button'])) {
  // Registration form values

  // First name
  $fname = strip_tags($_POST['reg_fname']); // Remove html tags
  $fname = str_replace(' ', '', $fname); // Remove spaces

  // Last name
  $lname = strip_tags($_POST['reg_lname']); // Remove html tags
  $lname = str_replace(' ', '', $lname); // Remove spaces

  // Email
  $email = strip_tags($_POST['reg_email']); // Remove html tags
  $email = str_replace(' ', '', $email); // Remove spaces

  // Email 2
  $email2 = strip_tags($_POST['reg_email2']); // Remove html tags
  $email2 = str_replace(' ', '', $email2); // Remove spaces

  // Password
  $password = strip_tags($_POST['reg_password']); // Remove html tags
  $password2 = strip_tags($_POST['reg_password2']); // Remove html tags

  $date = date("Y-m-d"); // Current date
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Welcome to the Social Network</title>
</head>
<body>
<form action="register.php" method="POST">
  <input type="text" name="reg_fname" placeholder="First Name" required>
  <br>
  <input type="text" name="reg_lname" placeholder="Last Name" required>
  <br>
  <input type="email" name="reg_email" placeholder="Email" required>
  <br>
  <input type="email" name="reg_email2" placeholder="Confirm Email" required>
  <br>
  <input type="password" name="reg_password" placeholder="Password" required>
  <br>
  <input type="password" name="reg_password2" placeholder="Confirm Password" required>
  <br>
  <input type="submit" name="register_button" value="register">
</form>
</body>
</html>