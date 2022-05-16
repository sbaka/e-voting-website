<?php

// Create connection
$conn = mysqli_connect("localhost", "root", "");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS db_student";
if (!mysqli_query($conn, $sql)) {
  echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>