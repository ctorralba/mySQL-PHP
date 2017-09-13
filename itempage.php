<html>
<link rel="stylesheet" type="text/css" href="main.css">
<title>ItemPage</title>
<body>

<div class = 'navBar'>
    <div id = 'scalableNavBar'>
    <div id = 'displayUser'>
      <div class = 'displayVerticalText'>
        Welcome,  
        <?php 
          session_start(); 
          if(!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
          }
        echo $_SESSION['username'];
        ?>
      </div>
    </div>
    <a href = 'userpage.php'class = 'displayVerticalText' id = 'Home'> Home </a>
    <a href= "Buyersearch.php" class ='displayVerticalText' id = 'GoBack'>Go Back</a>
    <a href = 'login.php' class = 'displayVerticalText' id = 'logout'>Logout</a>
    </div>
</div>


<div class = 'pageWrapper' style = 'height: 400px;'>
    <div class = 'insertionSpace'>
        <form action="itempage.php" method="post">
            Purchase: <input type="hidden" name="BUY" value="True">
            <div class = 'pageSubmit'>
	           <input type = "submit" value="Purchase">
            </div>
        </form>
    </div>

<?php 
require 'utility.php';
if($_SESSION['admin']) {
  header("Location: adminpage.php");
  exit();
}
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

$availability = $row['Availability'];
$price = $row['Flatprice'];
$name = $row['Name'];
$description = $row['Description'];
$warning = $row['Warning'];

echo "<div class = 'header' style = 'background-color: navy;'>";
        echo $name;
echo "</div>";
$sql = "SELECT Balance FROM BUYER WHERE Username =" . dq($_SESSION['username']) . ";";
$result = $conn->query($sql);
if($result == FALSE) {
  echo "error please reload the page";
  exit();  
}
$row = $result->fetch_assoc();
$balance = $row['Balance'];
if(isset($_POST['BUY'])){
  unset($_POST['BUY']);
  echo "<div id = 'pgWarn'>";
  if($availability == 0) {
    echo "There is none of the item available";
  }
  else {
    if($balance < $price) {
      echo "You do not have a sufficent balance to purchase that item";
    }
	else {
	  $balance = $balance - $price;
	  $availability = $availability - 1;
      $sql = "UPDATE Buyer SET Balance =" . $balance . " WHERE Username=" . dq($_SESSION['username']) . ";";
      $result = $conn->query($sql);
      if($result == FALSE) {
        echo "error please reload the page";
        exit();  
      }
	  $sql = "UPDATE ITEM SET Availability =" . $availability . " WHERE Itemnumber=" . $_SESSION['itemnumber'] . ";";
	  $result = $conn->query($sql);
      if($result == FALSE) {
        echo "error please reload the page";
        exit();  
      }
      $sql = "INSERT INTO PURCHASES (Username, Itemnumber) " . values(array($_SESSION['username'], $_SESSION['itemnumber']));
      $result = $conn->query($sql);
      echo "Your purchase was succsessfull";
	}
  }
  echo "</div>";
}  
//echo "<div class = 'displayDataPage'>";
    echo "<table class = 'displayDataPage'>";
        echo "<tr>";
            echo"<td>"; 
            echo "Price: </td>";
            echo "<td>";
            echo $price;
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>"; 
            echo "Availability: </td>";
            echo "<td>";
            echo $availability;
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>"; 
            echo "Description: </td>";
            echo "<td>";
            echo $description;
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>"; 
            echo "Warning: </td>";
            echo "<td>";
            echo $warning;
            echo "</td>";
        echo "</tr>";
      echo "</table>";
//echo "</div>";
echo "<div class = 'displayBalance'>";
echo "<br><br>" . "Balance: $" . $balance;
echo "</div>";

?>
    </div>
</div>
</body>
</html>