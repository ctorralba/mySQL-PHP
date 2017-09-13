<html overflow: scroll;>
<head>
<title>Item Add Page</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body overflow: scroll;>
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
<!-- ////////////// Inserting Items ///////////////////////////-->

<div class = 'pageWrapper'>
  <div class = 'header' style = 'background-color: navy;'>
    <p id = 'inputtext'> Please fill out the new item: </p>
  </div>
  <div class = 'insertionSpace'>
        <form action = "AdminItems.php" method = "POST">
        <table class = 'insertionData'>
          <tr>
		    <td>Insert Name: </td>
            <td><input type = "text" name = "insertItemName"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
		    <td>Insert Flatprice: </td>
            <td><input type = "text" name = "insertFlatPrice"></td>
		    <td>Insert Availability: </td>
            <td><input type = "text" name = "insertAvail"></td>
          </tr>
          <tr>
		    <td>Insert Description: </td>
            <td><input type = "text" name = "insertDescription"></td>
		    <td>Insert Warning: </td>
            <td><input type = "text" name = "insertWarning"></td>
          </tr>
          <tr>
		    <td>Insert Tags: </td>
            <td><input type = "text" name = "insertTags"></td>
		    <td>Insert Manufacturer: </td>
            <td><input type = "text" name = "insertManf"></td>
          </tr>
        </table>
	<?php
	//button
		echo "<br><input type = 'submit' id = 'insertBtn' name = 'insertButton'>";
	    echo "</form>";
  echo"</div>";
	/***********Constraint Checks*************************/
	//warning msg
  echo"<div class = 'insertWarn'>";
	$WarningMsg = "";
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertButton'])){
		if((empty($_POST['insertItemName']))||(empty($_POST['insertManf']))){
			if (empty($_POST['insertItemName'])&&(!empty($_POST['insertManf']))){
				$WarningMsg = "<br>Must insert an item name";
			}
			else if (empty($_POST['insertManf'])&&(!empty($_POST['insertItemName']))){
				$WarningMsg = "<br>There must be a Manufacturer";
			}
			else{
			$WarningMsg = "<br>An Item Must Contain a Name and a Manufacturer";
			}
		}
		else{
			$WarningMsg = "<br>Success!!!";
		}
	}
	echo $WarningMsg;
	echo "</div>";
	/**************Insertion Queries****************************/
	//0 = itemnumber, 1 = name, 2 = flatprice, 3 = availability, 4 = description, 5 = warning
	if(!empty($_POST['insertItemName'])){
		$ItemQuery = "SELECT max(Itemnumber) FROM ITEM;";
		$highestVal = $conn->query($ItemQuery);
		
		if ($highestVal->num_rows == 0){
			$itemNum = "0";
		}
		else {
			$row = $highestVal->fetch_assoc();
			$itemNum = $row['max(Itemnumber)'] + 1;
		}
		$newItem[0] = $itemNum;
		$newItem[1] = $_POST['insertItemName'];
		$newItem[2] = $_POST['insertFlatPrice'];
		$newItem[3] = $_POST['insertAvail'];
		$newItem[4] = $_POST['insertDescription'];
		$newItem[5] = $_POST['insertWarning'];
		$itemTagsList = $_POST['insertTags'];
		echo "<br>";
		$sql = "INSERT INTO ITEM (Itemnumber, Name, Flatprice, Availability, Description, Warning)";
		$sql2 = values($newItem);
		$sql = $sql . $sql2;
		$conn->query($sql);
		
		
		$sql = "Select Name from manufacturer where Name = '".$_POST['insertManf']."';";
		$result = $conn->query($sql);
		if ($result->num_rows == 0){
			$sql = "Insert into manufacturer (Name, Tis, Phone, Email) values ('".$_POST['insertManf']."', NULL, NULL, NULL);";
			$conn->query($sql);
		}

		
		$sql = "Insert into sells (Itemnumber, Manufacturer) values (".$itemNum.",'".$_POST['insertManf']."');";
		$conn->query($sql);
		
		
		$itemTag = explode(" ", $itemTagsList);
		$k = 0;
		while(!empty($itemTag[$k])){
			$sql = "INSERT INTO itemtag (Itemnumber, Tag) Values (".$newItem[0].", '".$itemTag[$k]."');";
			$k++;
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
      <form action = "AdminItems.php" method = "POST">
      <td>Search Item to Modify:</td>
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
		$deleteItemSQL = "DELETE FROM item where Itemnumber = ".$_GET['DeleteItemNo'];
		//delete cascasde was used in sql		
		
		if($conn->query($deleteItemSQL)){
			$modifyWarn = "Successful Deletion";
		}
	}
	if (isset($_GET['deleteItem'])){
		echo '<form method = "get" action = "AdminItems.php">';
		echo'<div class="alert">';
		$none = "'none'";
		echo '	<span class="closebtn" onclick="this.parentElement.style.display='.$none.';">&times;</span> 
            <div id = "warningDelete">
				<strong>Warning!</strong> Are you sure you want to delete this item?
            </div>
				<input type = "hidden" name = "DeleteItemNo" value = "'.$_GET['deleteItem'].'";>
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
				$searchSqlName = "Select * from item where name like '%". $searchTerms[$k] . "%';"; //search the word
				$searchSqlTag = "Select * from itemtag where Tag like '%". $searchTerms[$k] . "%';"; //search the tag
				if ($result = $conn->query($searchSqlName)){										//if it works
					if($result->fetch_assoc() > 0){												//check if its greater than 0
						$aResult = true;
					}
				}
				if ($result = $conn->query($searchSqlTag)){										
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
						echo"<th>Name</th>";
						echo"<th>Flat Price</th>";
						echo"<th>Availability</th>";
						echo"<th>Description</th>";
						echo"<th>Warning</th>";
					echo "</tr>";
				$k=0;$j = 0;$alreadyDisplayed=false;
				while (!empty($searchTerms[$k])){			//while terms being searched are not empty
					$searchSql = "Select * from item where Itemnumber IN( 
								  Select Itemnumber from item where name like '%". $searchTerms[$k] . "%'
								  UNION
								  Select Itemnumber from itemtag where Tag like '%".$searchTerms[$k] . "%');"; //select all names & types with similar search word
					$k++;		//incrememnt the search word
					$searchResults = $conn->query($searchSql); //put the query results into search results
					
					while ($modifyList = $searchResults->fetch_assoc()){ //go over all the rows, one at a time
						if ($j == 0){
							$displayData[$j] = $modifyList['Itemnumber'];
						}
						else{
							$m = 0;
							$alreadyDisplayed = false;
							while(!empty($displayData[$m])){
								if($displayData[$m] == $modifyList['Itemnumber']){
									$alreadyDisplayed = true;
								}
								$m++;
							}
							$displayData[$j] = $modifyList['Itemnumber'];
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
                                            $SendItemNo =  $modifyList['Itemnumber'];
                                            echo'<a style = "font-size: 10px;" href = "./modifyitem.php?itemnumber=' .$SendItemNo .'">Edit</a>';
                                            echo "   ";
                                            echo'<a style = "align: right; font-size: 10px;"  href = "./AdminItems.php?deleteItem=' .$SendItemNo . '">Delete</a>';
                                        echo"</div>";
                                    echo"</div>";
                                echo"</td>";
                                echo "<td>".$modifyList['Flatprice']."</td>";
                                echo "<td>".$modifyList['Availability']."</td>";
                                echo "<td>".$modifyList['Description']."</td>";
                                echo "<td>".$modifyList['Warning']."</td>";
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
</body>
</html>