<html>
<link rel="stylesheet" type="text/css" href="main.css">
<title>User Account</title>
<body style = 'overflow-y: scroll; overflow-x: hidden;'> 
<div id = 'inputText'>
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
    <a href = 'login.php' class = 'displayVerticalText' id = 'logout'>Logout</a>
    </div>
</div>

<div id = 'adminPgContainer' style = 'height: 100%;'>
    <div id = 'userHeader'>
        <div class = 'blur' id = 'userHead'></div>
        <p id = 'headText'>User Page</p>
    </div>
    <div id = 'description'><p>As a user, please feel free to search any items that may be in our database. Our database has three categories in which you are able to search from: items, manufacturers, and jobs. The item search is self-explanatory, you look up an item based on a related search field or their name and a result showing a list of attributes will show up. You will also have the option to search a job and order. Given a specific post date and expiration date, you may order a job to be done. In which you may fulfill the job or request for the job depending on the title of the job. Both of these options come at a price. Depending on whether you're able to pay for the item, you will be allowed to check out a job/order and item and the price will be deducted from your account. The result of doing this though will result in the database having one less available item, and if you chose to pick a specific job it would do nothing for that request. This means that multiple users can request multiple jobs. A user also has the option to look up any manufacturers, if they choose. If there is a certain circumstance in which a manufacturer, job/order, and item is named the same, the search query will result in showing all the data relating to the name or tag. Although displayed in different tables for consistency. As a user, I would also recommend to change your user information.</p></div>
    
    <br><br><p id = 'description' style = 'text-align: center; '>Choose your action: </p><br><br>
    
    <div id = 'choiceContainer'>
        <form action="Buyersearch.php">
        <button type="submit" class = "choice" id = 'uchoice1'>Browse For Information</button>
        </form>


        <form action="modifyaccount.php" method="post">
        <input type="hidden" name="account" value="<?php echo $_SESSION['username'];?>">
        <button type="submit" class = "choice" id = 'uchoice2'>Modify Account</button>
        </form>

        <form action="addbalance.php">
        <button type="submit" class = "choice" id = 'uchoice3'>Add Balance</button>
        </form>
        </div>
</div>
</body>
</html>
