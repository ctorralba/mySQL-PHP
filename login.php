<html overflow: hidden;>
<link rel="stylesheet" type="text/css" href="main.css">
<title>Login</title>		
<body style ='overflow: hidden;'>
<div class = "boxContainer" id = 'boxLogin'>
    <div class = 'header'>
        Log In:
    </div>
    <table class = 'inputText' id = 'loginText'>
      <form action="loginhandler.php" method="post">
      <tr>
        <td><label>Username:</label></td>
        <td><input type="text" name="username" placeholder="*Required"></td>
      </tr>
      <tr>
        <td><label>Password:</label></td>
        <td><input type="password" name="password" placeholder="*Required"></td>
      </tr>
    </table>
      <input type="submit" id = 'loginSubmit' >
      </form>


     <p><a id = 'NoAccount' href="createaccount.php">Don't have an account?</a></p>
      <p id = 'loginWarn'>
      <?php
      session_start();
      if(isset($_SESSION['errormessage'])){
        echo $_SESSION['errormessage'];
        session_unset();
      }
      session_destroy();
      ?>
      </p>
</div>
</body>
</html>


