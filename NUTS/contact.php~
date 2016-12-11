<?php

// Require the configuration before any PHP code:
require ('./includes/config.inc.php');

// Include the header file:
$page_title = 'We Are Nuts - Contact Us';
include ('./includes/header.html');

// Require the database connection:
//require (MYSQL);

// Contact Us form begins -------------------------------------------------------- 
if ($_SERVER['REQUEST_METHOD'] == 'POST')    /* hide the form */
    {
    /* PHP send the submitted email */
    /* htmlspecialchars() prevents against XSS */
    $first_name=htmlspecialchars($_POST['first_name']);
    $last_name=htmlspecialchars($_POST['last_name']);
    $email=htmlspecialchars($_POST['email']);
    $message=htmlspecialchars($_POST['message']);
    if (($first_name=="")||($last_name=="")||($email=="")||($message==""))
        {
        echo "All fields are required, please fill in the missing fields.";
        }
    else{        
	if (strpos($email, '@') !== false && strpos($email, '.') !== false && strpos($email, "'") == false) {
	        $from="From: $first_name, $last_name<$email>\r\nReturn-path: $email";
	        $subject="Contact Form  |  Inquiry from " . $email;
		mail("garza0@pnw.edu", $subject, $message, $from);
	        echo "Your Email was sent! We will respond to you shortly! GO NUTS!";
        }
        else {
        echo "Email was in the wrong format!.";
        }
        }
    }  
    
else {
/* Display the contact form
   Include the contact us view: */
include('./views/contact.html');
    } 

// Include the footer file:
include ('./includes/footer.html');
?>
