<?php
require_once ('../sql_func/string_func.php');
destroy_session_and_data();
header("Location: ../malware/checkfile.php");
exit();
$html =<<<HTML
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
    <p>You have successfully logged out</p>
  </body>
</html>
HTML;




?>
