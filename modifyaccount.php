<html>
<link rel="stylesheet" type="text/css" href="main.css">
<title>Modify Account</title>
<div id = 'inputText'>
<body>
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
    
<div class = 'pageWrapper' style = 'height: 500px;'>
  <div class = 'header' style = 'background-color: navy;'>
    <p id = 'inputtext'> Account Info: </p>
  </div>
<?php 
require 'utility.php';
require 'serverlogin.php';


if(isset($_POST['account'])) {
  $_SESSION['account'] = $_POST['account'];
}
$sql = "SELECT * FROM USER U WHERE U.username = \"" . $_SESSION['account'] . "\";";
$result = $conn->query($sql);
if($result == FALSE) {
  echo "error please reload the page";
  exit();  
}
$row = $result->fetch_assoc();


$_SESSION['password'] = $row['Password'];
$_SESSION['phone'] = $row['Phone'];
$_SESSION['address'] = $row['Address'];
$_SESSION['email'] = $row['Email'];
$_SESSION['fname'] = $row['Fname'];
$_SESSION['mname'] = $row['Mname'];
$_SESSION['lname'] = $row['Lname'];
?>


<form action="submitaccountchanges.php" method="post">
    <table class = 'inputText' id ='moveModifyTable'>
        <tr>
            <td>Password: </td>
            <td><input type="text" name="password" value="<?php echo $_SESSION['password'];?>"></td>
        </tr>
        <tr>
            <td>Phone: </td>
            <td><input type="text" name="phone" value="<?php echo $_SESSION['phone'];?>"></td>
        </tr>
        <tr>
	       <td>Address: </td>
            <td><input type="text" name="address" value="<?php echo $_SESSION['address'];?>"></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><input type="text" name="email" value="<?php echo $_SESSION['email'];?>"></td>
        </tr>
	    <tr>
            <td>First Name: </td>
            <td><input type="text" name="fname" value="<?php echo $_SESSION['fname'];?>"></td>
        </tr>
        <tr>
	       <td>Middle Name: </td>
           <td><input type="text" name="mname" value="<?php echo $_SESSION['mname'];?>"></td>
        </tr>
        <tr>
	       <td>Last name: </td>
            <td><input type="text" name="lname" value="<?php echo $_SESSION['lname'];?>"></td>
        </tr>
	<input type="hidden" name="account" value="<?php echo $_SESSION['account'];?>">
     </table>
    <input type="submit" value="Submit" id ='moveModifySubmit'>
</form>

<div id = "pgWarn" style = "position:absolute; top: 375;">

<?php
//clear session variables
unset($_SESSION['password']);
unset($_SESSION['phone']);
unset($_SESSION['address']);
unset($_SESSION['email']);
unset($_SESSION['fname']);
unset($_SESSION['mname']);
unset($_SESSION['lname']);






if(isset($_SESSION['message'])) { 
  echo $_SESSION['message'];
  unset($_SESSION['message']);
}
?>

</div>
</div>
</body>
</html>


