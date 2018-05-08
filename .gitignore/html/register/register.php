<?php
require_once ('../sql_func/string_func.php');
require_once ('../sql_func/query_func.php');
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
          <li><a href="../login/login.php">Login</a></li>
        </ul>
      </div>
      <h2>Register</h2><br>
      <p>Please fill out the following form to create an account.</p>
      <form method="post">
        <label>First Name:</label><br>
        <input type="text" name="forename" placeholder="First Name"><br>
        <label>Last Name:</label><br>
        <input type="text" name="surname" placeholder="Last Name"><br>
        <label>Username:</label><br>
        <input type="text" name="username" placeholder="Username"><br>
        <label>Password:</label><br>
        <input type="password" name="pass" placeholder="Password"><br>
        <input type="password" name="checkpass" placeholder="Password"><br>
        <input type="submit" name="sign-up" value="Sign Up">
        <a href="../login/login.php"><p>Already a user? Login here</p></a>
      </form>
    </body>
  </html>

<?php

  if(isset($_POST['sign-up'])){
    if(!empty($_POST['username']) || !empty($_POST['pass'])){
          if($_POST['pass']!==$_POST['checkpass']){
            header("Location: ../register/register.php?register=pass");
          } else {
              $conn = new mysqli($dbhn,$ddun,$dbpw,$db);
              //Check connection
              if($conn->connect_error) die("Failed to connect to database: ". $conn->connect_error);

              $firstname = entities_fix_string($conn,$_POST['forename']);
              $lastname = entities_fix_string($conn,$_POST['surname']);
              $user = entities_fix_string($conn,$_POST['username']);
              $pass = entities_fix_string($conn,$_POST['pass']);
              $prefix = saltgen();
              $suffix = saltgen();
              $token = hash('ripemd128',$prefix.$pass.$suffix);
              addUser($conn,$firstname,$lastname,$user,$token,$prefix,$suffix);
              $conn->close();
              echo "You have signed up!";
          }
  //  }
    } else {
      header("Location: ../register/register.php?register=empty");
      exit();
    }
  }

?>
