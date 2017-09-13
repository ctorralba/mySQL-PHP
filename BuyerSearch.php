<html>
<head>
<title>Search Results</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body style = 'overflow-y: scroll; overflow-x: hidden;'>
<div class = 'navBar'>
    <div id = 'scalableNavBar'>
    <div id = 'displayUser'>
      <div class = 'displayVerticalText'>
        Welcome,  
        <?php 
          require'serverlogin.php';
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
    <a href = 'login.php' class = 'displayVerticalText' id = 'logout'>Logout</a>
    </div>
</div>

<!--////////////// Modification Inputs /////////////////-->
<div id = 'adminPgContainer' style = 'height: 350px;'>
    <div id = 'userHeader'>
            <div class = 'blur' id = 'searchHead'></div>
            <p id = 'headText'>Search</p>
    </div>
    <form action = "BuyerSearch.php" method = "POST">
    <div id = 'buyerSearchBar'>
        <table>
        <tr>
        <td id = 'searchInput'>Type Here to Search:  <input type = "text" name = "search" style = 'width: 200px;'></td>
        </tr>
        </table>
        <input type = "submit" name = "searchBtn" value = "Search" id = 'searchBtn'>
    </div>
    </form>
    <?php	
        $modifyWarn = "";
        if (isset($_POST['searchBtn'])){
            if($_POST['search'] == NULL){
                $modifyWarn = "A name is needed for search.";
            }
        
            else{
                $searchTerms = explode(" ", $_POST['search']);
                $k = 0;
                $aResult = false;
                $iResult = false;
                $jResult = false;
                $wResult = false;
                while (!empty($searchTerms[$k])){
                    $searchSqlName = "Select * from item where name like '%". $searchTerms[$k] . "%';"; //search the word
                    $searchSqlTag = "Select * from itemtag where Tag like '%". $searchTerms[$k] . "%';"; //search the tag
                    $searchSqlTitle = "Select * from job where Title like '%". $searchTerms[$k] . "%';"; //search the title
                    $searchSqlLoc = "Select * from joblocation where Location like '%". $searchTerms[$k] . "%';"; //search the location
                    $searchSqlMname = "Select * from manufacturer where Name like '%". $searchTerms[$k] . "%';"; //search the title
                    if ($result = $conn->query($searchSqlName)){										
                        if($result->fetch_assoc() > 0){
                            $aResult = true;
                            $iResult = true;
                        }
                    }
                    if ($result = $conn->query($searchSqlTag)){										
                        if($result->fetch_assoc() > 0){
                            $aResult = true;
                            $iResult = true;
                        }
                    }
                    if ($result = $conn->query($searchSqlTitle)){										
                        if($result->fetch_assoc() > 0){
                            $aResult = true;
                            $jResult = true;
                        }
                    }
                    if ($result = $conn->query($searchSqlLoc)){										
                        if($result->fetch_assoc() > 0){
                            $aResult = true;
                            $jResult = true;
                        }
                    }
                    if ($result = $conn->query($searchSqlMname)){										
                        if($result->fetch_assoc() > 0){
                            $aResult = true;
                            $wResult = true;
                        }
                    }
                    $k++;
                }
                if (!$aResult){
                    $modifyWarn = "No results from searching '" . $_POST['search'] . "'";
                }
                else{
                    /*****************************Item Table *****************************/
                    echo "<div id = 'aggregate'>";
                        $sql = "select max(Flatprice) from item ";
                        $result = $conn ->query($sql);
                        $highest = $result ->fetch_assoc();
                        $max = $highest['max(Flatprice)'];
                        $sql = "select min(Flatprice) from item ";
                        $result = $conn ->query($sql);
                        $lowest = $result ->fetch_assoc();
                        $min = $lowest['min(Flatprice)'];
                        $range = $max - $min;
                        echo "<table id = 'aggTable'>";
                            echo "<tr>";
                                echo "<td>Highest Recorded Cost: </td>";
                                echo "<td>".$max."</td>";
                            echo "</tr>";
                            echo "<tr>";
                                echo "<td>Lowest Recorded Cost: </td>";
                                echo "<td>".$min."</td>";
                            echo "</tr>";
                            echo "<tr>";
                                echo "<td>Range of values in database: </td>";
                                echo "<td>".$range."</td>";
                            echo "</tr>";
                        echo "</table>";
                    echo"</div>";
                    if($iResult){
                        echo "<p class = 'searchText'>Items: </p>";
                        echo "<table class = 'modifyTable' id = 'searchTable'>";
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

                            while ($searchList = $searchResults->fetch_assoc()){ //go over all the rows, one at a time put it in an array
                                if ($j == 0){									// see if the item is already being displayed
                                    $displayData[$j] = $searchList['Itemnumber'];
                                }
                                else{
                                    $m = 0;
                                    $alreadyDisplayed = false;
                                    while(!empty($displayData[$m])){
                                        if($displayData[$m] == $searchList['Itemnumber']){
                                            $alreadyDisplayed = true;
                                        }
                                        $m++;
                                    }
                                    $displayData[$j] = $searchList['Itemnumber'];
                                }
                                $j++;

                                if(!$alreadyDisplayed){
                                    echo"<style>";
                                    echo".hide {opacity:0; position: absolute; top: 0; right: 0; padding-left: 151px; padding-right: 5px; padding-bottom:2px;}";
                                    echo".hide:hover {opacity:100; position: absolute;}";
                                    echo"</style>";
                                        echo "<tr>";
                                            echo "<td style = 'position: relative;width: 200px;'>";
                                                echo "<a style = 'text-decoration: none; 'href='./itempage.php?itemnumber=".$searchList['Itemnumber']."'>".$searchList['Name']."</a>";
                                            echo"</td>";
                                            echo "<td>".$searchList['Flatprice']."</td>";
                                            echo "<td>".$searchList['Availability']."</td>";
                                            echo "<td>".$searchList['Description']."</td>";
                                            echo "<td>".$searchList['Warning']."</td>";
                                        echo "</tr>";
                                }
                            }
                        }
                        echo "</table> <br>";
                    }
                    //********************Job Table *********************************************/
                    if($jResult){
                        echo "<p class = 'searchText'>Jobs: </p>";
                        echo "<table class = 'modifyTable' id = 'searchTable'>";
                        echo"<tr>";
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

                            while ($searchList = $searchResults->fetch_assoc()){ //go over all the rows, one at a time put it in an array
                                if ($j == 0){									// see if the item is already being displayed
                                    $displayData[$j] = $searchList['Jid'];
                                }
                                else{
                                    $m = 0;
                                    $alreadyDisplayed = false;
                                    while(!empty($displayData[$m])){
                                        if($displayData[$m] == $searchList['Jid']){
                                            $alreadyDisplayed = true;
                                        }
                                        $m++;
                                    }
                                    $displayData[$j] = $searchList['Jid'];
                                }
                                $j++;

                                if(!$alreadyDisplayed){
                                    echo"<style>";
                                    echo".hide {opacity:0; position: absolute; top: 0; right: 0; padding-left: 151px; padding-right: 5px; padding-bottom:2px;}";
                                    echo".hide:hover {opacity:100; position: absolute;}";
                                    echo"</style>";
                                        echo "<tr>";
                                            echo "<td style = 'position: relative;width: 200px;'>";
                                                echo "<a style = 'text-decoration: none; 'href = './jobPage.php?Jid=".$searchList['Jid']."'>".$searchList['Title']."</a>";
                                            echo"</td>";
                                            echo "<td>".$searchList['Description']."</td>";
                                            echo "<td>".$searchList['Postdate']."</td>";
                                            echo "<td>".$searchList['Expiration']."</td>";
                                            echo "<td>".$searchList['Price']."</td>";
                                        echo "</tr>";
                                }
                            }
                        }
                        echo "</table>";
                    }
                    //********************Manufacturer Table *********************************************/
                    if($wResult){
                        echo "<p class = 'searchText'>Manufacturer: </p>";
                        echo "<table class = 'modifyTable' id = 'searchTable'>";
                        echo"<tr>";
                            echo"<th>Name</th>";
                            echo"<th>Top Items Sold</th>";
                            echo"<th>Phone</th>";
                            echo"<th>Email</th>";
                            echo"<th>Location</th>";
                        echo "</tr>";
                        $k=0;$j = 0;$alreadyDisplayed=false;
                        while (!empty($searchTerms[$k])){			//while terms being searched are not empty
                            $searchSql = "Select * from manufacturer where Name like '%".$searchTerms[$k]."%'";

                            $k++;		//incrememnt the search word
                            $searchResults = $conn->query($searchSql); //put the query results into search results

                            while ($searchList = $searchResults->fetch_assoc()){ //go over all the rows, one at a time put it in an array
                                if ($j == 0){									// see if the item is already being displayed
                                    $displayData[$j] = $searchList['Name'];
                                }
                                else{
                                    $m = 0;
                                    $alreadyDisplayed = false;
                                    while(!empty($displayData[$m])){
                                        if($displayData[$m] == $searchList['Name']){
                                            $alreadyDisplayed = true;
                                        }
                                        $m++;
                                    }
                                    $displayData[$j] = $searchList['Name'];
                                }
                                $j++;

                                if(!$alreadyDisplayed){
                                    echo"<style>";
                                    echo".hide {opacity:0; position: absolute; top: 0; right: 0; padding-left: 151px; padding-right: 5px; padding-bottom:2px;}";
                                    echo".hide:hover {opacity:100; position: absolute;}";
                                    echo"</style>";
                                        echo "<tr>";
                                            echo "<td style = 'position: relative;width: 200px;'>";
                                                echo "<a style = 'text-decoration: none; 'href = './manfPage.php?Name=".$searchList['Name']."'>".$searchList['Name']."</a>";
                                            echo"</td>";
                                            echo "<td>".$searchList['Tis']."</td>";
                                            echo "<td>".$searchList['Phone']."</td>";
                                            echo "<td>".$searchList['Email']."</td>";
                                            echo "<td>".$searchList['Location']."</td>";
                                        echo "</tr>";
                                }
                            }
                        }
                        echo "</table>";
                    }
                }
            }
        }
        echo "<div class = 'WarningMsg' id = 'buyerWarn'>";
        echo $modifyWarn;
        echo "</div>";
    ?>
    </div>
</body>
</html>