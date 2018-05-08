<?php
require_once ('../sql_func/string_func.php');
require_once ('../sql_func/query_func.php');
session_start();
?>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Scanning files">
    <meta name="keywords" content="Infected files, Scan files, Safe file">
    <link rel="stylesheet" type="text/css" href="/style/style.css">
  </head>
  <body>
    <div id="navbar">
      <ul class="navButtons">
        <li><a href="../malware/checkfile.php">IDFile</a></li>
        <?php
          if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            echo '<li><a href="../malware/addfile.php">Add Malware</a></li>';
            echo '<li><a href="../logout/logout.php">Logout</a></li>';
          }
        ?>
      </ul>
    </div>
    <h2>Login</h2><br>
    <p>Please fill out the form to sign-in.</p>
    <form method="post">
      <label>Username:</label><br>
      <input type="text" name="username" placeholder="Username"><br>
      <label>Password:</label><br>
      <input type="password" name="pass" placeholder="Password"><br>
      <input type="submit" name="login" value="Login">
      <a href="../register/register.php">Don't have an account? Register here.</a>
    </form>
  </body>
</html>

<?php
  if(isset($_POST['login'])){
    if(!empty($_POST['username']) && !empty($_POST['pass'])){
      $conn = new mysqli($dbhn,$ddun,$dbpw,$db);
      //Check connection
      if($conn->connect_error) die("Failed to connect to database: ". $conn->connect_error);
        $user = entities_fix_string($conn,$_POST['username']);
        $pass = entities_fix_string($conn,$_POST['pass']);
        $info = verifyUser($conn,$user,$pass);
        $conn->close();
        if(!empty($info)){
            $_SESSION['username']=$info['Username'];
            $_SESSION['password']=$info['password'];
            $_SESSION['forename']=$info['FirstName'];
            $_SESSION['surname']=$info['LastName'];
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            header("Location: ../login/login.php?login=success");
            exit();
        }
        else die("Invalid username/password combination");
    } else {
      echo "You have left the username/password empty";
    }
  }


?>
