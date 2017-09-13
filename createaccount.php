<html>
<title> Create Account </title>

<link rel="stylesheet" type="text/css" href="main.css">
<body>
<div class = 'boxContainer'>
    <div class = 'header'>
        Enter information below to create an account:
    </div>
    <form action="createaccounthandler.php" method="post"><br>
      <table class = 'inputText'>
        <tr>
          <td><label>Username:</label></td>
          <td><label><input type="text" name="username" placeholder="*Required"></label></td>
        </tr>
        <tr>
          <td><label>Password:</label></td>
          <td><input type="password" name="password" placeholder="*Required"></td>
        </tr>
        <tr>
          <td><label>Phone Number:</label></td>
          <td><input type="text" name="phone"></td>
        </tr>
        <tr>
          <td><label>Address:</label></td>
          <td><input type="text" name="address"></td>
        </tr>
        <tr>
          <td><label>Email:</label></td>
          <td><input type="text" name="email"></td>
        </tr>
        <tr>
          <td><label>First Name:</label></lael></td>
          <td><input type="text" name="fname"></td>
        </tr>
        <tr>
          <td><label>Middle Name:</label></td>
          <td><input type="text" name="mname"></td>
        </tr>
        <tr>
          <td><label>Last Name:</label></td>
          <td><input type="text" name="lastname"></td>
        </tr>
      </table>
      <input type="submit">
    </form>
    <div class = "WarningMsg">
    <?php
      session_start();
      if(isset($_SESSION['errormessage']) and $_SESSION['errormessage'] != ""){
        echo $_SESSION['errormessage'];
        $_SESSION['errormessage'] = "";
      }
    ?>
    </div>
</div>
</body>


</html>


