<html>
<link rel="stylesheet" type="text/css" href="main.css">
<title>Job Page</title>

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
   
<?php
	require'serverlogin.php';
	include('utility.php');
	date_default_timezone_set("America/Belize");
	
	$sql = "Select * from job where Jid = ".$_GET['Jid'];
	$result = $conn->query($sql);
		
	$sqlbal =  "select Balance from buyer where Username = '" . $_SESSION['username']."';";
	$querybal = $conn -> query($sqlbal);
	$bal = $querybal->fetch_assoc();
	echo "Balance: " .$bal['Balance'] ."<br>";
	echo "<div id = 'inputText'>";
	echo "<table class = 'displayDataPage'>";
	$display = $result->fetch_assoc(); //go over all the rows, one at a time put it in an array
        echo "<div class = 'header' style = 'background-color: navy;'>";
        echo $display['Title'];
        echo "</div>";
		echo "<tr>";
			echo"<td>";
            echo"Description: </td>";
            echo"<td>";
            echo $display['Description'];
            echo"</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>";
            echo"Expiration: </td>";
            echo"<td>";
            echo $display['Expiration'];
            echo"</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>";
            echo"Post Date: </td>";
            echo"<td>";
            echo $display['Postdate'];
            echo"</td>";
        echo "</tr>";
        echo "<tr>";
			echo"<td>";
            echo"Price: </td>";
            echo"<td>";
            echo $display['Price'];
            echo"</td>";
        echo "</tr>";
echo "</table>";

     
echo "<div class = 'insertionSpace'>";
echo "<form method = 'GET' action = 'jobPage.php'>";
	echo '<input type = "hidden" name = "Jid" value = "'.$_GET['Jid'].'">';
	echo '<input type = "submit" name = "searchBtn" class = "pageSubmit" value = "Order" id = "jobOrdering">';
echo "<form>";
echo"</div>";
if(isset($_GET['searchBtn'])){
    echo "<div id = 'pgWarn' style = 'position: absolute; top: 180; left: 510px;'>";
	$sql =  "select Balance from buyer where Username = '" . $_SESSION['username']."';";
	$enoughMoney = $conn -> query($sql);
	$result = $enoughMoney->fetch_assoc();
	if ($result['Balance'] < $display['Price']){
		echo "<br><br>Not enough money";
	}
	else{
		$newBalance = $result['Balance'] - $display['Price'];
		$sql = "update buyer set Balance =  ".$newBalance." where Username = '".$_SESSION['username']."';";
		$sqlorder = "insert into joborder (Username, Jid) values ('".$_SESSION['username']."',".$_GET['Jid'].");";
		$conn->query($sqlorder);
		if ($conn->query($sql)){
			echo "<br><br>Ordered!";
			
		}
	}
    echo "</div>";
}


?>
</body>
</div>
</html>