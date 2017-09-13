<?php 


require 'serverlogin.php';
session_start();


$username = $_POST["username"];
$password = $_POST["password"];


if($username == "") {
  $_SESSION['errormessage'] = "Please enter a username";
  header("Location: login.php");
  exit();
}


if($password == "") {
  $_SESSION['errormessage'] = "Please enter a password";
  header("Location: login.php");
  exit();
}


$sql = "SELECT U.Username, U.Password FROM user U WHERE U.Username = \"" . $username . "\";";
$result = $conn->query($sql);
if($result == FALSE) {
  $_SESSION['errormessage'] = "There was an error in the query";
  header("Location: login.php");
  exit();
}
if($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  if($row['Password'] == $password) {
	echo "login attempt successfull";
	$sql = "SELECT A.Username FROM admin A WHERE A.Username = \"" . $username . "\";";
	$result = $conn->query($sql);
	if($result == FALSE) {
	  $_SESSION['errormessage'] = "There was an error in the query";
      header("Location: login.php");
      exit();
	}
	$_SESSION['username'] = $username;
	if($result->num_rows == 1){
	  //Go to Admin page
	  $_SESSION['admin'] = true;
	  header("Location: adminpage.php");
	  exit();
	}
	else {
	  //Go to buyer login page
	  $_SESSION['admin'] = false;
	  header("Location: userpage.php");
	  exit();
	}
  }
  else {
    $_SESSION['errormessage'] = "Invalid Password";
    header("Location: login.php");
    exit();
  }	  
}
else {
    $_SESSION['errormessage'] = "There is no account with that username";
    header("Location: login.php");
    exit();
}
?>


