<?php
require 'serverlogin.php';
require 'utility.php';
session_start();
$dusername = $_SESSION['username'];
$fname = $_POST['fname'];
$relationship = $_POST['relationship'];
$dob = $_POST['dob'];

if(empty($dob))
{
  $_SESSION['dm'] = "You must enter a date of birth";
  header("Location: adddependent.php");
  exit();
}

$sql = "INSERT INTO DEPENDENT(Dusername, Fname, Relationship, Dob) " . values(array($dusername, $fname, $relationship, $dob)) . ";"; 
$result = $conn->query($sql);
if($result == FALSE) {
  $_SESSION['dm'] = "There was an error";
  header("Location: adddependent.php");
  exit();
}
else
{
  $_SESSION['dm'] = "dependent was added succsessfully";
  header("Location: adddependent.php");
  exit();
}
?>