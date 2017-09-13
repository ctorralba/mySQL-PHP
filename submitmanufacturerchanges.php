<?php
require 'utility.php';
require 'serverlogin.php';
session_start();


$name = $_POST['name'];
$tis = $_POST['tis'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$location = $_POST['location'];


$sql = "UPDATE MANUFACTURER SET Tis=" . dq($tis) . ", Phone=" . dq($phone) . ", Email=" . dq($email) . ", Location=" . dq($location) . " WHERE Name=" . dq($name) . ";";
$result = $conn->query($sql);


if($result == TRUE) {
  $_SESSION['message'] = "changes were made succsessfully";
}
else {
  $_SESSION['message'] = "There was an error in making the changes";
}
header("Location: modifymanufacturer.php");
?>