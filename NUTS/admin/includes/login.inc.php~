<?php

$error = "";

$e= mysql_real_escape_string($_POST['email']);
$e= addslashes($e);
$e = str_replace(array("'",'>','<','&','|',';','\\'), '',$e);

$p= mysql_real_escape_string($_POST['pass']);
$p= addslashes($p);
$p = str_replace(array("'",'>','<','&','|',';','\\'), '',$p);

$q = "SELECT user_id, username, type, first_name, last_name, phone, emergency_contact_name, emergency_contact_phone, city, date_created FROM Users WHERE (email='$e' AND pass='" . get_password_hash($p)  . "' AND type='admin')";

$r = mysqli_query($dbc,$q);


if (!$r) {
    die(mysqli_error($dbc)); 
}

if (mysqli_num_rows($r) == 1) // a match is made
{
  
  session_start();


  $row = mysqli_fetch_array($r, MYSQL_NUM);

  $_SESSION['user_id'] = $row[0];
  $_SESSION['username'] = $row[1];
  $_SESSION['type'] = $row[2];
  $_SESSION['first_name'] = $row[3];
  $_SESSION['last_name'] = $row[4];
  $_SESSION['email'] = $e;
  $_SESSION['phone'] = $row[5];
  $_SESSION['emergency_name'] = $row[6];
  $_SESSION['emergency_phone'] = $row[7];
  $_SESSION['city'] = $row[8];
  $_SESSION['date_created'] = $row[9];
}
else
{
   $error = "no match";
   echo $error;

}



