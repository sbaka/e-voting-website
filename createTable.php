<?php
//include it so the d bgets created
include("createDB.php");
// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'db_student') or die("0? cant connect");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS db_student (
matricule BIGINT  PRIMARY KEY,
nom VARCHAR(30) NOT NULL,
prenom VARCHAR(30) NOT NULL,
est_candidat TINYINT(1) NOT NULL DEFAULT 0 ,
a_voter TINYINT(1) NOT NULL DEFAULT 0,
score INT(255) NOT NULL DEFAULT 0
)";

if (!mysqli_query($conn, $sql)) {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
