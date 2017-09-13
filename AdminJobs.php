<html overflow: scroll;>
<head>
<link rel="stylesheet" type="text/css" href="main.css">
<title>Job Add Page</title>
</head>

<body>
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
    <p> Insert the new job: </p>
  </div>
  <div class = 'insertionSpace'>
      <form action = "AdminJobs.php" method = "POST">
      <table class = 'insertionData'>
        <tr>
	       <td>Insert Title: </td>
           <td><input type = "text" name = "insertJobTitle"></td>
	       <td>Insert Description: </td>
           <td><input type = "text" name = "insertJobDesc"></td>
        </tr>
        <tr>
	       <td>Insert Expiration: </td>
           <td><input type = "date" name = "insertJobExp"></td>
	       <td>Insert Postdate: </td>
           <td><input type = "date" name = "insertJobPost"></td>
        </tr>
        <tr>
	       <td>Insert Price: </td>
           <td><input type = "text" name = "insertPrice"></td>
	       <td>List Locations: </td>
          <td><input type = "text" name = "insertJobLoc"></td>
        </tr>
      </table>
	<?php
	//button
		echo "<input type = 'submit' id = 'insertBtn' name = 'insertButton'>";
	echo "</form>";
  echo"</div>";
	/***********Constraint Checks*************************/
	//warning msg
    echo "<div class = 'insertWarn'>";
	$WarningMsg = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['insertButton'])){
		if(empty($_POST['insertJobTitle'])){
			$WarningMsg = "<br>Job must contain title";
		}
		else{
			$WarningMsg = "<br>Success!!!";
		}
	}
	echo $WarningMsg;
	echo "</div>";
	/**************Insertion Queries****************************/
	if(!empty($_POST['insertJobTitle'])){
		$JobQuery = "SELECT max(Jid) FROM JOB;";
		$highestVal = $conn->query($JobQuery);
		
		if ($highestVal->num_rows == 0){
			$jid = "0";
		}
		else {
			$row = $highestVal->fetch_assoc();
			$jid = $row['max(Jid)'] + 1;
		}
		$newJob[0] = $jid;
		$newJob[1] = $_POST['insertJobDesc'];
		$newJob[2] = $_POST['insertJobExp'];
		$newJob[3] = $_POST['insertJobPost'];
		$newJob[4] = $_POST['insertJobTitle'];
		$newJob[5] = $_POST['insertPrice'];
		$JobLocationList = $_POST['insertJobLoc'];
		echo "<br>";
		$sql = "INSERT INTO job (Jid, Description, Expiration, Postdate, Title, Price)";
		$sql2 = values($newJob);
		$sql = $sql . $sql2;
		$conn->query($sql);
		
		$JobLoc = explode(",", $JobLocationList);
		$k = 0;
		while(!empty($JobLoc[$k])){
            $sql = "INSERT INTO joblocation (Jid, Location) Values (".$newJob[0].", '".$JobLoc[$k]."');";
            $k++;
            //echo $sql;
            $conn->query($sql);
		}
	}
	?>
<br><br><br><br>
<hr class="stylized">
<!--////////////// Modification Inputs /////////////////-->
 <div id = 'modifySearch'>
   <table>
     <tr>
        <form action = "AdminJobs.php" method = "POST">
          <td>Search Job to Modify:</td>
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
		$deleteJobSQL = "DELETE FROM Job where Jid = '".$_GET['DeleteItemNo']."';";
		//delete cascasde was used in sql
		
		if($conn->query($deleteJobSQL)){
			$modifyWarn = "Successful Deletion";
		}
	}
	if (isset($_GET['deleteJob'])){
		echo '<form method = "get" action = "AdminJobs.php">';
		echo'<div class="alert">';
		$none = "'none'";
		echo '	<span class="closebtn" onclick="this.parentElement.style.display='.$none.';">&times;</span> 
             <div id = "warningDelete">
				<strong>Warning!</strong> Are you sure you want to delete this job?
            </div>
				<input type = "hidden" name = "DeleteItemNo" value = "'.$_GET['deleteJob'].'";>
				<input type = "submit" onclick="this.parentElement.style.display='.$none.';" name = "yesDelete" id = "moveDeleteYes" value = "Yes">
				<input type = "submit" onclick="this.parentElement.style.display='.$none.';" name = "noDelete" id = "moveDeleteNo" value = "No">
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
				$searchSqlName = "Select * from job where Title like '%". $searchTerms[$k] . "%';"; //search the word
				$searchSqlLoc = "Select * from joblocation where Location like '%". $searchTerms[$k] . "%';"; //search the tag
				if ($result = $conn->query($searchSqlName)){										//if it works
					if($result->fetch_assoc() > 0){												//check if its greater than 0
						$aResult = true;
					}
				}
				if ($result = $conn->query($searchSqlLoc)){										
					if($result->fetch_assoc() > 0){
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
						echo"<th>Title</th>";
						echo"<th>Description</th>";
						echo"<th>Postdate</th>";
						echo"<th>Expiration</th>";
						echo"<th>Price</th>";
					echo "</tr>";
				$k=0;$j = 0;$alreadyDisplayed=false;
				while (!empty($searchTerms[$k])){			//while terms being searched are not empty
					$searchSql = "Select * from job where Jid IN(
									Select Jid from job where Title like '%".$searchTerms[$k]."%'
									UNION
									Select Jid from joblocation where Location like '%".$searchTerms[$k]."%');"; //select all names & types with similar search word
					$k++;		//incrememnt the search word
					$searchResults = $conn->query($searchSql); //put the query results into search results
					while ($modifyList = $searchResults->fetch_assoc()){ //go over all the rows, one at a time
						if ($j == 0){
							$displayData[$j] = $modifyList['Jid'];
						}
						else{
							$m = 0;
							$alreadyDisplayed = false;
							while(!empty($displayData[$m])){
								if($displayData[$m] == $modifyList['Jid']){
									$alreadyDisplayed = true;
								}
								$m++;
							}
							$displayData[$j] = $modifyList['Jid'];
						}
						$j++;
						
						if(!$alreadyDisplayed){
							echo"<style>";
							echo".hide {opacity:0; position: absolute; top: 0; right: 0; padding-left: 151px; padding-right: 5px; padding-bottom:2px;}";
							echo".hide:hover {opacity:100; position: absolute;}";
							echo"</style>";
								echo "<tr>";
									echo "<td style = 'position: relative;width: 200px;'>";
										echo "<p>".$modifyList['Title']."</p>";
										echo "<div class = 'hoverArea'>";
											echo "<div class = 'hide'>";
												$sendjid =  $modifyList['Jid'];
												echo'<a style = "font-size: 10px;" href = "./modifyjob.php?jid=' .$sendjid .'">Edit</a>';
												echo "   ";
												echo'<a style = "align: right; font-size: 10px;"  href = "./Adminjobs.php?deleteJob=' .$sendjid . '">Delete</a>';
											echo"</div>";
										echo"</div>";
									echo"</td>";
									echo "<td>".$modifyList['Description']."</td>";
									echo "<td>".$modifyList['Postdate']."</td>";
									echo "<td>".$modifyList['Expiration']."</td>";
									echo "<td>".$modifyList['Price']."</td>";
								echo "</tr>";
						}
					}
				}
			}
		}
	}

	echo "<p id = 'modifyWarn' > ".$modifyWarn."</p>";
	
?>
</body>
</html>




