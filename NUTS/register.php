<?php
require('./includes/config.inc.php');

// Include the header file:
$page_title = 'Admin registration';
include ('./includes/header.html');

require(MYSQL);

if ($_SERVER['REQUEST_METHOD'] == "POST") // If form is submitted
{
// fill variables from the POST
// FIRST NAME
$fn= mysql_real_escape_string($_POST['first_name']);
$fn= addslashes($fn);
$fn = str_replace(array("'",'>','<','&','|',';','\\'), '',$fn);
// LAST NAME
$ln= mysql_real_escape_string($_POST['last_name']);
$ln= addslashes($ln);
$ln = str_replace(array("'",'>','<','&','|',';','\\'), '',$ln);
// USERNAME
$u= mysql_real_escape_string($_POST['username']);
$u= addslashes($u);
$u = str_replace(array("'",'>','<','&','|',';','\\'), '',$u);
//CITY
$c= mysql_real_escape_string($_POST['city']);
$c= addslashes($c);
$c = str_replace(array("'",'>','<','&','|',';','\\'), '',$c);
//PHONE
$ph= mysql_real_escape_string($_POST['phone']);
$ph= addslashes($c);
$ph = str_replace(array("'",'>','<','&','|',';','\\'), '',$ph);
//EMAIL
$e= mysql_real_escape_string($_POST['email']);
$e= addslashes($e);
$e = str_replace(array("'",'>','<','&','|',';','\\'), '',$e);
// PASS 1
$p= mysql_real_escape_string($_POST['pass1']);
$p= addslashes($p);
$p = str_replace(array("'",'>','<','&','|',';','\\'), '',$p);
// PASS2
$p2= mysql_real_escape_string($_POST['pass2']);
$p2= addslashes($p2);
$p2 = str_replace(array("'",'>','<','&','|',';','\\'), '',$p2);
// EMERGENCY NAME
$em1= mysql_real_escape_string($_POST['emergency_name']);
$em1= addslashes($em1);
$em1 = str_replace(array("'",'>','<','&','|',';','\\'), '',$em1);
// EMERGENCY PHONE
$em2= mysql_real_escape_string($_POST['emergency_phone']);
$em2= addslashes($em2);
$em2 = str_replace(array("'",'>','<','&','|',';','\\'), '',$em2);
// SPECIAL
$key= mysql_real_escape_string($_POST['special']);
$key= addslashes($key);
$key = str_replace(array("'",'>','<','&','|',';','\\'), '',$key);

//VALIDATE EMAIL BEFORE GOING FORWARD
if (strpos($e, '@') == false || strpos($e, '.') == false || strpos($e, "'") !== false) {
echo 'There was an error in the email format..';
include('./includes/footer.html');
exit();
}

//VALIDATE SECRET KEY BEFORE GOING FORWARD
if ($key <> 'ITS450') {
echo 'There was an error in special key';
include('./includes/footer.html');
exit();
}


        // Check to see if user already exists
	$q = "SELECT * FROM Users WHERE email='$e' OR username='$u'";
	$r = mysqli_query($dbc, $q);
	$rows = mysqli_num_rows($r);

	if ($rows == 0) // Not Found, Ok to Proceed
	{   if ($fn=="" || $ln=="" || $u=="" || $c=="" || $ph=="" || $e=="" || $p=="" || $p2=="" || $em1=="" || $em2=="" ) { // validation for blanks
            echo "sorry there was blank fields!";
           }
            else {
              if ($p <> $p2) { // validation that passwords match
                echo "passwords do not match, try again!";
              }
              else { // no blanks, and passwords match, proceed
                 if ($key == "ITS450") { //if they have correct admin key, then make admin account
                    $q1 = "INSERT INTO Users (type, username, email, pass, first_name, last_name, phone, emergency_contact_name, emergency_contact_phone, city)  VALUES ('admin','$u','$e','" . get_password_hash($p) .  "','$fn','$ln','$ph','$em1','$em2','$c')";
                 } //Secret key was correct, type is admin
                 else {
 		 $q1 = "INSERT INTO Users (type, username, email, pass, first_name, last_name, phone, emergency_contact_name, emergency_contact_phone, city)  VALUES ('customer','$u','$e','" . get_password_hash($p) .  "','$fn','$ln','$ph','$em1','$em2','$c')";
                 } // Secret key was not correct, type is customer
 		 $r = mysqli_query($dbc, $q1); // attempt to insert
 		 if (mysqli_affected_rows($dbc) > 0) // Print Confirmation if it was successful in registering the account
 		 {
                 echo '<p style="color: blue; text-align: right">';
                 echo "ACCOUNT CREATED SUCCESSFULLY!" . "<br />" ;
                 echo "Thank you for registering " . $fn . " " . $ln , "!" . "<br />"; // prints their name
                 // Print Account Type
                 if ($key == "ITS450") {
                 echo "<b>Account Type:</b> " . "admin" . "<br />" ;
                 } //ADMIN
                 else {
                 echo "<b>Account Type:</b> " . "customer" . "<br />" ;
                 } //CUSTOMER

                 echo "<b>City:</b> " . $c . "<br />";
                 echo "<b>Phone:</b> " . $ph . "<br />";
                 echo "<b>Email:</b> " . $e . "<br />";
                 echo "<b>Emergency Contact Name:</b> " . $em1 . "<br />";
                 echo "<b>Emergency Contact Phone:</b> " . $em2 . "<br />";
                 
                 echo "---------------------------------- <br />";
                 echo "<a href='index.php'>Return Home to Login</a>"; // Direct them back to Home
                 echo '<p>';
     		 include('./includes/footer.html');
     		 exit();
		 } // END OF if (mysqli_affected_rows($dbc) > 0)
               } //END of validation password else
            } // end of validation for blank fields   
	} // END OF if ($rows == 0)

} //END OF if ($_SERVER['REQUEST_METHOD'] == "POST")
?>

<?php
///////////////////FORM VIEW VALIDATION: A user already logged in has no need to see a registration form, check for session variables to either hide or show form.//////////////////////
if (isset($_SESSION['email']) OR isset($_SESSION['username']) ) //If they are already logged in, it will give them an overview of their account
{
  echo "You are already registered! Thank You" . " " . $_SESSION['first_name'] . " " . $_SESSION['last_name']  . "." . "<br />";
  echo "Your email on file is " . $_SESSION['email'] . "<br />";
  echo "Your username on file is " . $_SESSION['username'] . "<br />";
  echo "<a href='index.php'>Return Home</a>";

}
else{ // They are not logged in, ok to go ahead and add a new account
?>

<div class="box alt">
	<div class="left-top-corner">
   	<div class="right-top-corner">
      	<div class="border-top"></div>
      </div>
   </div>
   <div class="border-left">
   	<div class="border-right">
           	<div class="inner">

<div id="register">
<h2>Register</h2>
<form action="register.php" method="post" >
<p style="text-align: right">
First Name: <input type="text" name="first_name" /><br /><br />
Last Name: <input type="text" name="last_name" /><br /><br />
Username: <input type="text" name="username" /><br /><br />
City: <input type="text" name="city" /><br /><br />
Phone: <input type="text" name="phone" /><br /><br />
Email: <input type="text" name="email" /><br /><br />
Password: <input type="text" name="pass1" /><br /><br />
Confirm Password: <input type="text" name="pass2" /><br /><br />
Emergency Contact Name: <input type="text" name="emergency_name" /><br /><br />
Emergency Contact Phone: <input type="text" name="emergency_phone" /><br /><br />
Admin special key: <input type="text" name="special" /><br /><br />
<input type="submit" name="submit_button" id="submit_button" value="Register" /><br /><br />
</p>
</form>
</div>

</div>	
      </div>
   </div>
   <div class="left-bot-corner">
   	<div class="right-bot-corner">
      	<div class="border-bot"></div>
      </div>
   </div>
</div>

<?php
}

include('./includes/footer.html');

?>
