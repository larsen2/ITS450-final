<?php
 
//destroy session
// redirect or display
require('./includes/config.inc.php');
session_start();
$_SESSION = array();
session_destroy();
unset($_SESSION);
redirect_invalid_user();

/*
if (isset($_SESSION['email'])) {
$_SESSION = array();
session_destroy();
echo '<h3>You are now logged out</h3>';
redirect_invalid_user();
}
else
{
echo '<h3>You were not logged in!</h3>';
redirect_invalid_user();
}
*/

?>
