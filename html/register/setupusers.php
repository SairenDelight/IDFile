<?php
  require_once 'dblogin.php';
  /*Attempt to connect to MySQL database */
  $conn = new mysqli($dbhn,$ddun,$dbpw,$db);
  //Check the connection
  if($conn->connect_error) die("ERROR: Could not connect.". $conn->connect_error);

  $query = "CREATE TABLE users(
      FirstName char(64),
      LastName char(64),
      Username char(128),
      Password char(128),
      Prefix char(30),
      Suffix char(30),
      Type char(4)
    ) ENGINE MyISAM";
  $result = $conn->query($query);
  if(!$result)die($conn->error);
  $conn->close();
?>
