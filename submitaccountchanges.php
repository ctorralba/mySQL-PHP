<?php 
require 'utility.php';
require 'serverlogin.php';
session_start();


if(!isset($_POST['account'])) {
  header("Location: modifyaccount.php");
  exit();
}


$account = $_POST['account'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$email = $_POST['email'];
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];


if(empty($password)) {
  $_SESSION['message'] = "Please enter a valid password";
  header("Location: modifyaccount.php");
  exit();
}


$sql = "UPDATE USER SET Password=" . dq($password) . ", Phone=" . dq($phone) . ", Address=" . dq($address) . ", Email=" . dq($email) . ", Fname=" . dq($fname) . ", Mname=" . dq($mname) . ", Lname=" . dq($lname) . "WHERE Username=" . dq($account) . ";";
$result = $conn->query($sql);
if($result == TRUE) {
  $_SESSION['message'] = "changes where made succsessfully";
}
else {
  $_SESSION['message'] = "There was an error in making the changes";
}
header("Location: modifyaccount.php");


?>


