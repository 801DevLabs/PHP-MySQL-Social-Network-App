<?php

session_start();

$con = mysqli_connect("localhost", "admin", "admin", "social");

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
$error_array = []; // Holds error messages

if(isset($_POST['register_button'])) {
  // Registration form values

  // First name
  $fname = strip_tags($_POST['reg_fname']); // Remove html tags
  $fname = str_replace(' ', '', $fname); // Remove spaces
  $_SESSION['reg_fname'] = $fname; // Stores first name into session variable

  // Last name
  $lname = strip_tags($_POST['reg_lname']); // Remove html tags
  $lname = str_replace(' ', '', $lname); // Remove spaces
  $_SESSION['reg_lname'] = $lname; // Stores last name into session variable

  // Email
  $email = strip_tags($_POST['reg_email']); // Remove html tags
  $email = str_replace(' ', '', $email); // Remove spaces
  $_SESSION['reg_email'] = $email; // Stores email into session variable

  // Email 2
  $email2 = strip_tags($_POST['reg_email2']); // Remove html tags
  $email2 = str_replace(' ', '', $email2); // Remove spaces
  $_SESSION['reg_email2'] = $email2; // Stores email 2 into session variable

  // Password
  $password = strip_tags($_POST['reg_password']); // Remove html tags
  $password2 = strip_tags($_POST['reg_password2']); // Remove html tags

  $date = date("Y-m-d"); // Current date

  if($email == $email2) {
    echo 'Same val';

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);

      // Check if email already exists
      $e_check = mysqli_query($con, "SELECT email FROM users WHERE email = '$email'");

      // Count the number of rows returned
      $num_rows = mysqli_num_rows($e_check);

      if($num_rows > 0) {
        array_push($error_array, "Email already in use");
      }
    } else {
      array_push($error_array, "Invalid email format");
    }
  } else {
    array_push($error_array, "Emails don't match");
  }

  if(strlen($fname) > 25 || strlen($fname) < 2) {
    array_push($error_array, "Your first name musty be between 2 and 25 characters");
  }

  if(strlen($lname) > 25 || strlen($lname) < 2) {
    array_push($error_array, "Your last name musty be between 2 and 25 characters");
  }

  if($password != $password2) {
    array_push($error_array, "Your passwords do not match");
  } else {
    if(preg_match('/[^A-Za-z0-9]/', $password)) {
      array_push($error_array, "You password can only contain english characters or numbers");
    }
  }

  if(strlen($password) > 30 || strlen($password) < 5 ) {
    array_push($error_array, "Your password must be between 5 and 30 characters");
  }

  if(empty($error_array)) {
    $password = md5($password); // Encrypt password before sending to database

    // Generate username by concatenating first name and last name
    $username = strtolower($fname . "_" . $lname);
    $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");

    $i = 0;
    // If username exsists add number to username
    while(mysqli_num_rows($check_username_query) != 0) {
      $i++; // Add 1 to i
      $username = $username . "_" . $i;
      $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
    }
    // Profile picture assignment
    $profile_pic = "assets/images/profile_pics/defaults/blue.jpg";

    $query = mysqli_query($con, "INSERT INTO users VALUES(NULL, '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

    array_push($error_array, "<span style='color:#14c800'>You're all set! Go ahead and login!</span><br>");

    // Clear session variables
    $_SESSION['reg_fname'] = "";
    $_SESSION['reg_lname'] = "";
    $_SESSION['reg_email'] = "";
    $_SESSION['reg_email2'] = "";
  }
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
  <input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])) {
    echo $_SESSION['reg_fname'];
  }
  ?>" required>
  <br>
  <?php
    if(in_array("Your first name musty be between 2 and 25 characters", $error_array)) {
      echo "Your first name musty be between 2 and 25 characters<br/>";
    }
  ?>

  
  <input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])) {
    echo $_SESSION['reg_lname'];
  }
  ?>" required>
  <br>
  <?php
    if(in_array("Your last name musty be between 2 and 25 characters", $error_array)) {
      echo "Your last name musty be between 2 and 25 characters<br/>";
    }
  ?>


  <input type="email" name="reg_email" placeholder="Email" value="<?php if(isset($_SESSION['reg_email'])) {
    echo $_SESSION['reg_email'];
  }
  ?>" required>
  <br>
  

  <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if(isset($_SESSION['reg_email2'])) {
    echo $_SESSION['reg_email2'];
  }
  ?>" required>
  <br>
  <?php
    if(in_array("Email already in use", $error_array)) {
      echo "Email already in use<br/>";
    }

    else if(in_array("Invalid email format", $error_array)) {
      echo "Invalid email format<br/>";
    }

    else if(in_array("Emails don't match", $error_array)) {
      echo "Emails don't match<br/>";
    }
  ?>


  <input type="password" name="reg_password" placeholder="Password" >
  <br>


  <input type="password" name="reg_password2" placeholder="Confirm Password" >
  <br>
  <?php
    if(in_array("Your passwords do not match", $error_array)) {
      echo "Your passwords do not match<br/>";
    }

    else if(in_array("You password can only contain english characters or numbers", $error_array)) {
      echo "You password can only contain english characters or numbers<br/>";
    }

    else if(in_array("Your password must be between 5 and 30 characters", $error_array)) {
      echo "Your password must be between 5 and 30 characters<br/>";
    }
  ?>


  <input type="submit" name="register_button" value="register">
  <br>

<?php
    if(in_array("<span style='color:#14c800'>You're all set! Go ahead and login!</span><br>", $error_array)) {
      echo "<span style='color:#14c800'>You're all set! Go ahead and login!</span><br>";
    }
  ?>
  
</form>
</body>
</html>