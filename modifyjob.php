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

if(isset($_GET['jid'])) {
  $_SESSION['jid'] = $_GET['jid'];
}
if(!isset($_SESSION['jid'])) {
  echo 'lost track';
  exit();
}
require 'serverlogin.php';
$sql = "SELECT * FROM JOB WHERE Jid= " . $_SESSION['jid'] . ";";
$result = $conn->query($sql);
if($result == FALSE) {
  echo "error please reload the page";
  exit();
}
$row = $result->fetch_assoc();
$_SESSION['description'] = $row['Description'];
$_SESSION['expiration'] = $row['Expiration'];
$_SESSION['postdate'] = $row['Postdate'];
$_SESSION['title'] = $row['Title'];
?>


<form action="submitjobchanges.php" method="post">
    <table class = 'inputText' id = 'moveModifyTable'>
        <tr>
	       <td>Title: </td>
            <td><input type="text" name="title" value="<?php echo $_SESSION['title'];?>"></td>
        </tr>
        <tr>
            <td>Description: </td>
            <td><input type="text" name="description" value="<?php echo $_SESSION['description'];?>"></td>
        </tr>
        <tr>
	       <td>Expiration: </td>
           <td><input type="date" name="expiration" value="<?php echo $_SESSION['expiration'];?>"></td>
        </tr>
        <tr>
	       <td>Postdate: </td>
           <td><input type="date" name="postdate" value="<?php echo $_SESSION['postdate'];?>"></td>
        </tr>
    </table>
    <input type="hidden" name="jid" value="<?php echo $_SESSION['jid']; ?>">
    
	<input type="submit" value="Submit" id ='moveModifySubmit'>
</form>

<div id = "pgWarn" style = "position:absolute; top: 265;">
<?php


if(isset($_SESSION['message'])) { 
  echo $_SESSION['message'];
  unset($_SESSION['message']);
}


unset($_SESSION['title']);
unset($_SESSION['description']);
unset($_SESSION['expiration']);
unset($_SESSION['postdate']);
?>
</div>
</div>
</body>
</div>
</html>