<html  overflow: scroll;>
<head>
<title>Manufacturer Add Page</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body  overflow: scroll;>
<?php
	require'serverlogin.php';
	//session_start();
	include('utility.php');
	date_default_timezone_set("America/Belize");
?>
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
<br> <br>
<div class = 'pageWrapper'>
  <div class = 'header' style = 'background-color: navy;'>
    <p id = 'inputtext'> Inserting new manufacturer: </p>
  </div>
  <div class = 'insertionSpace'>
    <form action = "AdminManf.php" method = "POST">
    <table class = 'insertionData'>
      <tr>
        <td>Insert Name: </td>
        <td><input type = "text" name = "insertManfName"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
	     <td>Insert Top Items Sold: </td>
         <td><input type = "text" name = "insertTis"></td>
	     <td>Insert Phone Number: </td>
         <td><input type = "text" name = "insertManfPhone"></td>
      </tr>
      <tr>
	     <td>Insert Email: </td>
         <td><input type = "text" name = "insertManfEmail"></td>
	     <td>Insert Location: </td>
        <td><input type = "text" name = "insertManfLoc"></td>
      </tr>
    </table>
	<?php
		echo "<input type = 'submit' id = 'insertBtn' name = 'insertButton'>";
	echo "</form>";
  echo "</div>";
	/***********Constraint Checks*************************/
	//warning msg
    echo "<div class = 'insertWarn'>";
	$WarningMsg = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['insertButton'])){
		if(empty($_POST['insertManfName'])){
			$WarningMsg = "<br>A Manufacturer Must Contain a Name";
		}
		else{
			$WarningMsg = "<br>Success!!!";
		}
	}
	echo $WarningMsg;
	echo "</div>";
	/**************Insertion Queries****************************/
	if(!empty($_POST['insertManfName'])){
		$newManf[0] = $_POST['insertManfName'];
		$newManf[1] = $_POST['insertTis'];
		$newManf[2] = $_POST['insertManfPhone'];
		$newManf[3] = $_POST['insertManfEmail'];
		$newManf[4] = $_POST['insertManfLoc'];
		
		echo "<br>";
		$sql = "INSERT INTO Manufacturer (Name, Tis, Phone, Email, Location)";
		$sql2 = values($newManf);
		$sql = $sql . $sql2;
		$conn->query($sql);
	}
	?>

<br><br><br><br>
<hr class='stylized'>
<!--////////////// Modification Inputs /////////////////-->
<div id = 'modifySearch' style = 'top:-30px;'>
  <table>
    <tr>
      <form action = "AdminManf.php" method = "POST">
      <td>Search Manufacturer to Modify:</td>
      <td><input type = "text" name = "modifyName"></td>
      <input type = "submit" name = "modifyBtn" id = "modifybtn" value = "Search">
      </form>
    </tr>
  </table>
</div>
<?php
    /******************* Constraint Checking **********************************/
	/******************Deletion************/
	$modifyWarn = "";
	if (isset($_GET['yesDelete'])){
		$deleteManfSQL = "DELETE FROM manufacturer where Name = '".$_GET['DeleteItemNo']."';";
		//delete cascasde was used in sql
		
		if($conn->query($deleteManfSQL)){
			$modifyWarn = "Successful Deletion";
		}
	}
	if (isset($_GET['deleteManf'])){
		echo '<form method = "get" action = "AdminManf.php">';
		echo'<div class="alert">';
		$none = "'none'";
		echo '	<span class="closebtn" onclick="this.parentElement.style.display='.$none.';">&times;</span> 
            <div id = "warningDelete">
				<strong>Warning!</strong> Are you sure you want to delete this manufacturer?
            </div>
				<input type = "hidden" name = "DeleteItemNo" value = "'.$_GET['deleteManf'].'";>
				<input type = "submit" onclick="this.parentElement.style.display='.$none.';" name = "yesDelete" id = "moveDeleteYes" value = "Yes">
				<input type = "submit" onclick="this.parentElement.style.display='.$none.';" name = "noDelete" id = "moveDeleteNo"value = "No">
		      </div>';
		echo '</form>';
		
	}
	if (isset($_POST['modifyBtn'])){
		if($_POST['modifyName'] == NULL){
			$modifyWarn = "A name is needed for search.";
		}
		else{
			$searchTerms = explode(" ", $_POST['modifyName']);
			$k = 0;
			$aResult = false;
			while (!empty($searchTerms[$k])){
				$searchSqlName = "Select * from manufacturer where name like '%". $searchTerms[$k] . "%';"; //search the word
				if ($result = $conn->query($searchSqlName)){										//if it works
					if($result->fetch_assoc() > 0){												//check if its greater than 0
						$aResult = true;
					}
				}
				$k++;
			}

			if (!$aResult){
				echo "No results from searching '" . $_POST['modifyName'] . "'";
			}
			else{
				/*****************************Table Creation *****************************/
				echo "<table class = 'modifyTable'>";
					echo"<tr>";
					echo"<br>";
						echo"<th>Name</th>";
						echo"<th>Top Items Sold</th>";
						echo"<th>Phone</th>";
						echo"<th>Email</th>";
						echo"<th>Location</th>";
					echo "</tr>";
				$k=0;$j = 0;$alreadyDisplayed=false;
				while (!empty($searchTerms[$k])){			//while terms being searched are not empty
					$searchSql = "Select * from manufacturer where name like '%". $searchTerms[$k] ."%';";
					$k++;		//incrememnt the search word
					$searchResults = $conn->query($searchSql); //put the query results into search results
					
					while ($modifyList = $searchResults->fetch_assoc()){ //go over all the rows, one at a time
						if ($j == 0){
							$displayData[$j] = $modifyList['Name'];
						}
						else{
							$m = 0;
							$alreadyDisplayed = false;
							while(!empty($displayData[$m])){
								if($displayData[$m] == $modifyList['Name']){
									$alreadyDisplayed = true;
								}
								$m++;
							}
							$displayData[$j] = $modifyList['Name'];
						}
						$j++;
						
						if(!$alreadyDisplayed){
							echo"<style>";
							echo".hide {opacity:0; position: absolute; top: 0; right: 0; padding-left: 151px; padding-right: 5px; padding-bottom:2px;}";
							echo".hide:hover {opacity:100; position: absolute;}";
							echo"</style>";
								echo "<tr>";
									echo "<td style = 'position: relative;width: 200px;'>";
										echo "<p>".$modifyList['Name']."</p>";
										echo "<div class = 'hoverArea'>";
											echo "<div class = 'hide'>";
												$SendMName =  $modifyList['Name'];
												echo'<a style = "font-size: 10px;" href = "./modifymanufacturer.php?name=' .$SendMName .'">Edit</a>';
												echo "   ";
												echo'<a style = "align: right; font-size: 10px;"  href = "./AdminManf.php?deleteManf=' .$SendMName . '">Delete</a>';
											echo"</div>";
										echo"</div>";
									echo"</td>";
									echo "<td>".$modifyList['Tis']."</td>";
									echo "<td>".$modifyList['Phone']."</td>";
									echo "<td>".$modifyList['Email']."</td>";
									echo "<td>".$modifyList['Location']."</td>";
								echo "</tr>";
						}
					}
				}
			}
		}
	}

	echo "<p id = 'modifyWarn' > ".$modifyWarn."</p>";
	
?>
</div>
</div>
</div>
</body>
</html>