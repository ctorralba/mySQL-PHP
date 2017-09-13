<?php
require 'utility.php';
require 'serverlogin.php';
session_start();


$jid = $_POST['jid'];
$description = $_POST['description'];
$expiration = $_POST['expiration'];
$postdate = $_POST['postdate'];
$title = $_POST['title'];

$sql = "UPDATE JOB SET Description=" . dq($description) . ", Expiration=" . dq($expiration) . ", Postdate=" . dq($postdate) . ", Title=" . dq($title) . " WHERE Jid=" . $jid . ";";
$result = $conn->query($sql);


if($result == TRUE) {
  $_SESSION['message'] = "changes were made succsessfully";
}
else {
  $_SESSION['message'] = "There was an error in making the changes";
}
header("Location: modifyjob.php");
?>