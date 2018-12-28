<?php

$con = mysqli_connect("localhost", "", "", "social");

if(mysqli_connect_errno()) {
  echo "Connection error " . mysqli_connect_errno();
}

$query = mysqli_query($con, "INSERT INTO test VALUES(NULL, 'Name')");

// $query = "INSERT INTO test (name) VALUES ('Name')";
// $result = mysqli_query($con, $query) or die ("Could not save to database");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Social Network</title>
</head>
<body>
  <h1>Welcome to PHP!</h1>
</body>
</html>