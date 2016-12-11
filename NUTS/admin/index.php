<?php

// This is the adminstrative home page.
// This script is created in Chapter 11.

// Require the configuration before any PHP code as configuration controls error reporting.
require ('../includes/config.inc.php');

// Require the database connection:
require (MYSQL);

if ($_SERVER['REQUEST_METHOD']=='POST')
{
  include('./includes/login.inc.php');
}
 
if (isset($_SESSION['first_name'])) {
// Set the page title and include the header:
$page_title = 'We Are Nuts - Administration';
include ('./includes/header.html');
// The header file begins the session.
?>
<p>
This area of the We Are Nuts website is for Administrators only!
</p>

<?php
include ('./includes/footer.html');
}
else {
echo  "<h3>&nbsp Only Admins Allowed!!!!</h3>";
include ('./includes/login_form.inc.php');

}

 ?>
