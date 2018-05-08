<?php
function entities_fix_string($conn,$string){
  return sanitizeString(mysql_fix_string($conn,$string));
}

function mysql_fix_string($conn,$string){
  if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return $conn->real_escape_string($string);
}


function sanitizeString($var){
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
}

/*
Generates salt
*/
function saltgen(){
  $salt = random_bytes(5);
  return $salt;
}

/*
This will give the file handler
*/
function fileHandle($locationOfFile){
  $handle = fopen($locationOfFile,'r') or die('Failed to read file');
  return $handle;
}

/*
This will read 20 bytes of the signature
*/
function readSignature($handle){
  $fileSignature = fread($handle,20);
  return $fileSignature;
}

/*
This will move the file pointer by a byte
*/
function moveFilePointer($handle,$counter){
  fseek($handle,$counter,SEEK_SET);
}

function destroy_session_and_data(){
  session_start();
  $_SESSION= array();
  setcookie(session_name(),'',time()-2592000,'/');
  session_destroy();

}

?>
