<html>
<link rel="stylesheet" type="text/css" href="main.css">
<title> Admin Account </title>




<body style = 'overflow-y: scroll; overflow-x: hidden;'>
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
    <a href = '#'class = 'displayVerticalText' id = 'Home'> Home </a>
    <a href = 'login.php' class = 'displayVerticalText' id = 'logout'>Logout</a>
  </div>
</div>
<div id = 'adminPgContainer'>
  <div id ='userHeader'>
    <div class = 'blur' id = 'adminHead'>
    </div>
    <p id = 'headText'>Admin Page</p>
  </div>
  <div id = 'description'><p>As an administrator, there are several duties that you must fulfill in order to meet your daily quota. As you first start out, your paycheck will default to $25k/yr. In order for this to rise in the future, you must have to maintain and keep track of three parts of the website: items, jobs, and manufacturers. With all of these you have to take good care when inserting them into our database. These are essential to the growth and the future of this database. Starting off with the item page. When inserting an item into the database you must provide it's name, price, availability, description, warning, tags, and a manufacturer. Our system, rejects insertions who forgets to name the name of the item and the manufacturer of the item. Also, our tag system allows for users to search for these items in the database. The second part, jobs. You have to keep track of inserting new jobs for users. When inserting a job you must provide its title, description, post date, expiration, price, and a list of locations it is available at. There must be a job title in order to be properly inserted. The last part is manufacturers. As with the other data, when inserting these, you must provide a manufacturer name, top items they sold, phone number, email, and a location. With all this data being readily accessible, you can also modify and delete all the data you inserted. Make sure to add a dependent in order to keep track of you.</p></div>
  
  <br><br><p id = 'description' style = 'text-align: center;'>Choose an action: </p><br><br>

  <div id = 'choiceContainer'>
    <form action="Adminitems.php" method="post">
    <button type="submit" class = "choice" id = 'choice1'>Modify Items</button>
    </form>

    <form action="AdminManf.php" method="post">
    <button type="submit" class = 'choice' id = 'choice2'>Modify Manufacturer</button>
    </form>

    <form action="AdminJobs.php" method="post">
    <button type="submit" class = 'choice' id = 'choice3'>Modify Job</button>
    </form>

    <form action="adddependent.php">
    <button class = 'choice' id = 'choice4' type="submit">Add Dependent</button>
    </form>
</div>
</div>
</body>
</html>