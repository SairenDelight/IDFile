<?php
require_once 'dblogin.php';

/*
This will add the user to the database for authentication next time
*/
function addUser($conn,$firstname,$lastname,$user,$token,$prefix,$suffix){
  $stmt = $conn->prepare('INSERT INTO users VALUES(?,?,?,?,?,?)');
  $stmt->bind_param('ssssss',$fn,$ln,$u,$t,$p,$s);
  $fn = $firstname;
  $ln = $lastname;
  $u = $user;
  $t = $token;
  $p = $prefix;
  $s = $suffix;
  $stmt->execute();
  $stmt->close();
}


/*
Use to authenticate the user
Returns an array of who the user is
*/
function verifyUser($conn,$username,$password){
  $verified = array();
  $query = "SELECT * FROM users";
  $result=$conn->query($query);

  //Check database query
  if(!$result)die("Database access failed: ".$conn->error);

  $rows=$result->num_rows;
  for($counter = 0; $counter < $rows; ++$counter){
    $result->data_seek($counter);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if($username == $row['Username']){
      $prefix = $row['Prefix'];
      $suffix = $row['Suffix'];
      $pass = $row['password'];
      $vtoken = hash('ripemd128',$prefix.$password.$suffix);
      if($pass == $vtoken)
        $verified = $row;
    }
  }
  return $verified;
}

/*
Check if username is taken
*/
function checkUserName($conn,$username){
  $query = "SELECT* FROM users WHERE username='$username'";
  $result = $conn->query($query);
  //Check database query
  if(!$result)die("Database access failed: ".$conn->error);
  $resultCheck = $conn->num_rows; 
  if($resultCheck > 0){
    return true;
  } else{
    return false;
  }
}

/*
This will find the malware signature inside the database
*/
function findMalware($conn,$sign){
  $malwarename = "";
  $signature = str_pad(bin2hex($sign),40,"0",STR_PAD_RIGHT);
  $query = "SELECT * FROM malwares";
  $result = $conn->query($query);
  //Check database query
  if(!$result)die("Database access failed: ".$conn->error);
  $rows = $result->num_rows;
  for($counter = 0; $counter < $rows; ++$counter){
    $result->data_seek($counter);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $mname = bin2hex($row['Name']);
    $sig = bin2hex($row['Signature']);
    if(bin2hex($row['Signature']) === $signature){
      $malwarename = $row['Name'];
      break;
    }
  }
  return $malwarename;
}


/*
This will add the malware into the database
*/
function addMalware($conn,$name,$signature){
  $stmt = $conn->prepare('INSERT INTO malwares VALUES(?,?)');
  $stmt->bind_param('ss',$n,$s);
  $n = $name;
  $s = $signature;
  $stmt->execute();
  $stmt->close();
}


?>
