<html>
<link rel="stylesheet" type="text/css" href="main.css">
<div id = 'inputText'>
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

if(isset($_GET['name'])) {
  $_SESSION['name'] = $_GET['name'];
}
if(!isset($_SESSION['name'])) {
  echo 'lost track';
  exit();
}
require 'serverlogin.php';
require 'utility.php';
$sql = "SELECT * FROM MANUFACTURER WHERE Name= " . dq($_SESSION['name']) . ";";
$result = $conn->query($sql);
if($result == FALSE) {
  echo "error please reload the page";
  exit();
}
$row = $result->fetch_assoc();
$_SESSION['tis'] = $row['Tis'];
$_SESSION['phone'] = $row['Phone'];
$_SESSION['email'] = $row['Email'];
$_SESSION['location'] = $row['Location'];
?>

<form action="submitmanufacturerchanges.php" method="post">
    <table class = 'inputText' id = 'moveModifyTable'>
        <tr>
            <td>Top Items Sold: </td>
            <td><input type="text" name="tis" value="<?php echo $_SESSION['tis'];?>"></td>
        </tr>
        <tr>
	       <td>Phone Number: </td>
           <td><input type="text" name="phone" value="<?php echo $_SESSION['phone'];?>"></td>
        </tr>
        <tr>
	       <td>Email: </td>
            <td><input type="text" name="email" value="<?php echo $_SESSION['email'];?>"></td>
        </tr>
        <tr>
	       <td>Location: </td>
           <td><input type="text" name="location" value="<?php echo $_SESSION['location'];?>"</td>
        </tr>
    <input type="hidden" name="name" value="<?php echo $_SESSION['name']; ?>">
    </table>
	<input type="submit" id = 'moveModifySubmit' value="Submit">
</form>

<div id = "pgWarn" style = "position:absolute; top: 275;">
<?php


if(isset($_SESSION['message'])) { 
  echo $_SESSION['message'];
  unset($_SESSION['message']);
}


unset($_SESSION['tis']);
unset($_SESSION['phone']);
unset($_SESSION['email']);
unset($_SESSION['location']);
?>
</div></div>
</body>
</div>
</html>