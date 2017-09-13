<html>
<link rel="stylesheet" type="text/css" href="main.css">
<title>Manufacturer Page</title>

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
    
<body>
<div class = 'pageWrapper' style = 'height: 400px;'>
    <div class = 'insertionSpace'>
    </div>

<?php
	require'serverlogin.php';
	
	$sql = "Select * from manufacturer where Name = '".$_GET['Name']."'";
	$row = $conn->query($sql);
    $result = $row->fetch_assoc();
    echo "<div class = 'header' style = 'background-color: navy;'>";
        echo $result['Name'];
    echo "</div>";
	echo "<table class = 'displayDataPage' id = 'manfDataMove'>";
	    echo "<tr>";
            echo"<td>"; 
            echo "Description: </td>";
            echo "<td>";
            echo $result['Tis'];
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>"; 
            echo "Phone: </td>";
            echo "<td>";
            echo $result['Phone'];
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>"; 
            echo "Email: </td>";
            echo "<td>";
            echo $result['Email'];
            echo "</td>";
        echo "</tr>";
        echo "<tr>";
            echo"<td>"; 
            echo "Location: </td>";
            echo "<td>";
            echo $result['Location'];
            echo "</td>";
        echo "</tr>";
    echo "</table>";

?>
</div>
</body>
</div>
</html>