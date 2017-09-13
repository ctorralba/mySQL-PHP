<html style = 'overflow: visible;'>
<link rel="stylesheet" type="text/css" href="main.css">
<body style = 'overflow: visible;'>
  
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
        echo $_SESSION['username']; 
        ?>
      </div>
    </div>
    <a href = 'adminpage.php'class = 'displayVerticalText' id = 'Home'> Home </a>
    <a href = 'login.php' class = 'displayVerticalText' id = 'logout'>Logout</a>
  </div>
</div>

<div class = 'boxContainer' id = 'dependent'>
  <div class = 'header'>
    Enter the information for the new dependent
  </div>
  <table class = 'inputText' id = 'loginText'>
    <form action="adddependenthandler.php" method="post">
      <tr>
        <td><label>First Name: </label></td>
        <td><input type="text" name="fname"></td>
      </tr>
      <tr>
        <td><label>Relationship: </label></td>
        <td><input type="text" name="relationship"></td>
      </tr>
      <tr>
        <td><label>Date of Birth:</label></td>
        <td><input type="text" name="dob" placeholder = 'YYYY-MM-DD *Required'></td>
  </table>
    <input type="submit">
    </form>
  <p class = 'WarningMsg' id = 'loginWarn'>
<?php
if(isset($_SESSION['dm'])){
  echo $_SESSION['dm'];
  unset($_SESSION['dm']);
}
?>
  </p>
</div>

  <div class = 'boxContainer' id = 'dependentList'>
    <div class = 'header'>
      List of Dependents:
    </div>
    <br><br><br>
<?php
require 'serverlogin.php';
//session_start();
$sql = "Select * from dependent where Dusername = '".$_SESSION['username']."';";
$sqlresult = $conn->query($sql);
while ($display = $sqlresult->fetch_assoc()){
	$DobYear = $display['Dob'][0] . $display['Dob'][1] . $display['Dob'][2] . $display['Dob'][3];
	$DobYear = intval($DobYear);
	$age = date("Y") - $DobYear;
    echo "<table id = 'dependentText'>";
    echo "<tr>";
	 echo "<td style = 'text-align: right;'>First Name:</td>";
     echo "<td style = 'text-align: left;'>".$display['Fname']."</td>";
    echo "</tr>";
    echo "<tr>";
      echo "<td style = 'text-align: right;'>Relationship: </td>";
      echo "<td style = 'text-align: left;'>".$display['Relationship']."</td>";
    echo "</tr>";
    echo "<tr>";
      echo "<td style = 'text-align: right;'>Date of Birth: </td>";
      echo "<td style = 'text-align: left;'>".$display['Dob']."</td>";
    echo "</tr>";
    echo "<tr>";
      echo "<td style = 'text-align: right;'>Age: </td>";
      echo "<td style = 'text-align: left;'>".$age."</td>";
    echo "</tr>";
    echo "</table>";
    
}
?>

  </div>
</div>
</body>
</html>