<?php
session_start();

// Require the configuration before any PHP code as configuration controls error reporting.
require ('../includes/config.inc.php');
if (isset($_SESSION['email'])) {
// Set the page title and include the header:
$page_title = 'View A Customer';
include ('./includes/header.html');
// The header file begins the session.

// Validate the order ID:
$customer_id = false;
if (isset($_GET['cid']) && (filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) ) { // First access
	$customer_id = $_GET['cid'];
	$_SESSION['customer_id'] = $customer_id;
} elseif (isset($_SESSION['customer_id']) && (filter_var($_SESSION['customer_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) ) {
	$customer_id = $_SESSION['customer_id'];
}

// Stop here if there's no $customer_id:
if (!$customer_id) {
	echo '<h3>Error!</h3><p>This page has been accessed in error.</p>';
	include ('./includes/footer.html');
	exit();
}

// Require the database connection:
require(MYSQL);

// ------------------------


// Define the query:
$q = 'SELECT * FROM customers WHERE id=' . $customer_id . ' ';

$r = mysqli_query($dbc, $q);
if (mysqli_num_rows($r) > 0) { 

	echo '<h3>View a Customer</h3>';
        
	// Get the first row:
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	
	// Display the customer information:
	echo "<p><strong>Customer ID</strong>: $customer_id<br /><br /><strong>Customer First Name</strong>: {$row['first_name']}<br /><strong>Customer Last Name</strong>: {$row['last_name']}<br /><strong>Customer Address</strong>: {$row['address1']} <br /><strong>Customer Email</strong>: {$row['email']}<br /><strong>Customer Phone</strong>: {$row['phone']}<br /></p>";
	
	

} else { // No records returned!
	echo '<h3>Error!</h3><p>This page has been accessed in error.</p>';
	include ('./includes/footer.html');
	exit();	
}
}
else
{
echo 'You are not logged in as admin!';
}
include ('./includes/footer.html');
?>
