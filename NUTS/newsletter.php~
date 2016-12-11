<?php

// Require the configuration before any PHP code:
require ('./includes/config.inc.php');

// Include the header file:
$page_title = 'We Are Nuts - Contact Us';
include ('./includes/header.html');

// Require the database connection:
require (MYSQL);

// Contact Us form begins -------------------------------------------------------- 
if ($_SERVER['REQUEST_METHOD'] == 'POST')    /* hide the form */
    {
    /* PHP send the submitted email */
    $email= mysql_real_escape_string($_POST['email']);
    $email= addslashes($email);
    $email = str_replace(array("'",'>','<','&','|',';','\\'), '',$email);
    if ($email=="")
        {
        // email was blank
        echo "Please fill out the email form!";
        } // end of if email is blank
    else{        
        if (strpos($email, '@') !== false && strpos($email, '.') !== false && strpos($email, "'") == false) {
        // query to make sure the email doesn't exist
        $q = "SELECT * FROM newsletter_signup WHERE email='$email'";
        $email_exists = $dbc->query($q);
        $rows = mysqli_num_rows($email_exists);
        }
        else {
             echo 'There was an error in email format, please try again!';
             include ('./includes/footer.html');
             exit();
        }
        	if ($rows == 0) {  //It does not exist, ok to write to DB
                     // validate that it includes @ and .
                     if (strpos($email, '@') !== false && strpos($email, '.') !== false && strpos($email, "'") == false) {
		             $q1 = "INSERT INTO newsletter_signup (email) VALUES ('$email')";
		             $r = mysqli_query($dbc, $q1); //attempt to insert
		                    if(mysqli_affected_rows($dbc) > 0) { //success
		                         echo "Success! Thanks for signing up for the newsletter! <a href='index.php'>Return Home</a>";
		                    }
		                    else { //fail
		                          echo "Error! There was a problem. <a href='index.php'>Return Home</a>";
		                    } 
                     }
                      else {
                         echo "Error! Email was in the wrong format. <a href='newsletter.php'>Try again</a>";
                      }
                } // end of if rows are 0
                else { // email was found in db
                     echo "Thanks, you are already signed up for the newsletter! <a href='index.php'>Return Home</a>";
                }
                
        }
    }  
    
else { /* display the newsletter form */
// Include the newsletter view:
include('./views/newsletter.html');
 
    } 


// Include the footer file:
include ('./includes/footer.html');
?>
