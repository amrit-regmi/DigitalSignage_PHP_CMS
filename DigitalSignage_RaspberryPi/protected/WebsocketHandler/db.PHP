<?php
global $conn;
$conn = new mysqli("localhost","root","","Bigyapan");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>