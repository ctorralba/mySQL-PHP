<html>
<link rel="stylesheet" type="text/css" href="main.css">
<body>
  <div class = 'navBar'>
  <div id = 'scalableNavBar'>
    <div id = 'displayUser'>
      <div class = 'displayVerticalText'>
        Welcome,  
        <?php 
          session_start(); 
          if(!$_SESSION['admin']) {
            header("Location: userpage.php");
            exit();
          }
        $adminCheck = true;
        echo $_SESSION['username']; 
        ?>
      </div>
    </div>
    <a href = 'adminpage.php'class = 'displayVerticalText' id = 'Home'> Home </a>
    <a href = 'login.php' class = 'displayVerticalText' id = 'logout'>Logout</a>
  </div>
</div>
    
<div class = 'pageWrapper' style = 'height: 432px;'>
  <div class = 'header' style = 'background-color: navy;'>
    <p id = 'inputtext'> Account Info: </p>
  </div>
<?php 

if(isset($_GET['itemnumber'])) {
  $_SESSION['itemnumber'] = $_GET['itemnumber'];
}
if(!isset($_SESSION['itemnumber'])) {
  echo 'lost track';
  exit();
}
require 'serverlogin.php';
$sql = "SELECT * FROM ITEM WHERE Itemnumber= " . $_SESSION['itemnumber'] . ";";
$result = $conn->query($sql);
if($result == FALSE) {
  echo "error please reload the page";
  exit();  
}
$row = $result->fetch_assoc();
$_SESSION['name'] = $row['Name'];
$_SESSION['flatprice'] = $row['Flatprice'];
$_SESSION['availability'] = $row['Availability'];
$_SESSION['description'] = $row['Description'];
$_SESSION['warning'] = $row['Warning'];
?>

<form action="submititemchanges.php" method="post">
    <table class ='inputText' id = 'moveModifyTable'>
        <tr>
            <td>Name: </td>
            <td><input type="text" name="name" value="<?php echo $_SESSION['name'];?>"></td>
        </tr>
        <tr>
            <td>Flatprice: </td>
            <td><input type="text" name="flatprice" value="<?php echo $_SESSION['flatprice'];?>"></td>
        </tr>
        <tr>
            <td>Availability: </td>
            <td><input type="text" name="availability" value="<?php echo $_SESSION['availability'];?>"></td>
        </tr>
        <tr>
            <td>Description: </td>
            <td><input type="text" name="description" value="<?php echo $_SESSION['description'];?>"></td>
        </tr>
        <tr>
            <td>Warning: </td>
            <td><input type="text" name="warning" value="<?php echo $_SESSION['warning'];?>"></td>
        <tr>
        <input type="hidden" name="itemnumber" value="<?php echo $_SESSION['itemnumber']; ?>">
    </table>
	<input type="submit" value="Submit" id ='moveModifySubmit'>
</form>

<div id = "pgWarn" style = "position:absolute; top: 310;">
<?php


if(isset($_SESSION['message'])) { 
  echo $_SESSION['message'];
  unset($_SESSION['message']);
}


unset($_SESSION['name']);
unset($_SESSION['flatprice']);
unset($_SESSION['availability']);
unset($_SESSION['description']);
unset($_SESSION['warning']);
?>
</div>
</div>
</body>
</html>


