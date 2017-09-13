<html>
<link rel="stylesheet" type="text/css" href="main.css">
<title>Add Balance</title>
<div class = 'navBar'>
  <div id = 'scalableNavBar'>
    <div id = 'displayUser'>
      <div class = 'displayVerticalText'>
        Welcome,  
        <?php 
          session_start(); 
        echo $_SESSION['username']; 
        ?>
      </div>
    </div>
    <a href = 'adminpage.php'class = 'displayVerticalText' id = 'Home'> Home </a>
    <a href = 'login.php' class = 'displayVerticalText' id = 'logout'>Logout</a>
  </div>
</div>

<div class = "boxContainer" id = 'boxLogin' style = 'margin: auto 0; margin-left: -125;width: 250; top: 100px;'>
    <div class = 'header'>
        Add to your balance:
    </div>
<form action="addbalance.php" method="post">
    Amount to add: <input type="text" name="addition" id = 'addBalanceText' value=0><br>
</form>

<?php
require 'serverlogin.php';
require 'utility.php';
$username = $_SESSION['username'];
$sql = "SELECT Balance FROM Buyer WHERE Username= " . dq($username) . ";";
$result = $conn->query($sql);
if($result == FALSE) {
  echo "error please reload the page";
  exit();
}
$row = $result->fetch_assoc();

if(isset($_POST['addition']) and $_POST['addition'] > 0) {
	$newbalance = $row['Balance'] + $_POST['addition'];
	unset($_POST['addition']);
	$sql = "UPDATE BUYER SET Balance=" . $newbalance . " WHERE Username=" . dq($username) . ";";
	$result = $conn->query($sql);
	if($result == FALSE) {
      echo "error please reload the page";
    }
	else {
	  echo "<p id = 'balanceSetter'>Balance added</p>" . "<br>";
	}
	echo "<p id = 'balanceSetter'> Current Balance: " . $newbalance . "</p><br>";
}
else {
  echo "<p id = 'balanceSetter'> Current Balance: " . $row['Balance'] . "</p><br>";	
}
?>
</div>
<html>