<?php
require 'utility.php';
require 'serverlogin.php';
session_start();


$itemnumber = $_POST['itemnumber'];
$name = $_POST['name'];
$flatprice = $_POST['flatprice'];
$availability = $_POST['availability'];
$description = $_POST['description'];
$warning = $_POST['warning'];


$sql = "UPDATE ITEM SET Name=" . dq($name) . ", Flatprice=" . $flatprice . ", Availability=" . $availability . ", Description=" . dq($description) . ", Warning=" . dq($warning) . " WHERE Itemnumber=" . $itemnumber . ";";
$result = $conn->query($sql);


if($result == TRUE) {
  $_SESSION['message'] = "changes were made succsessfully";
}
else {
  $_SESSION['message'] = "There was an error in making the changes";
}
header("Location: modifyitem.php");
?>


