<?php

// This script sends a receipt out in HTML format.
// This script is created in Chapter 10.

// Create the message body in two formats:
$body_plain = "Your order confirmation number is {$_SESSION['order_id']}.\n
All orders are processed & shipped on the next business day.\nWe will contact you immediately regarding any delays.\n\n\n\n\n\n";

$body_html = '<html><head><style type="text/css" media="all">
	body {font-family:Tahoma, Geneva, sans-serif; font-size:100%; line-height:.875em; color:#70635b;}
</style></head><body>
<p><strong>Your order confirmation number is: ' . $_SESSION['order_id'] . '.</strong><br>All orders are processed & shipped on the next business day.<br>We will contact you immediately regarding any delays.</p><br><br><br><br><br><br>
<table border="0" cellspacing="8" cellpadding="6">
	<tr>
		<th align="center">Item</th>
		<th align="center">Quantity</th>
		<th align="right">Price</th>
		<th align="right">Subtotal</th>
	</tr>';

// Get the cart contents for the confirmation email:
$r = mysqli_query($dbc, "CALL get_order_contents({$_SESSION['order_id']})");

// Fetch each product:
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
	// Add to the plain version:
	$body_plain .= "{$row['category']}::{$row['name']} ({$row['quantity']}) @ \${$row['price_per']} each: $" . $row['subtotal'] . "\n";
	
	// Add to the HTML:
	$body_html .= '<tr><td>' . $row['category'] . '::' . $row['name'] . '</td>
		<td align="center">' . $row['quantity'] . '</td>
		<td align="right">$' . $row['price_per'] . '</td>
		<td align="right">$' . $row['subtotal'] . '</td>
	</tr>
	';
	
	// For reference after the loop:
	$shipping = $row['shipping'];
	$total = $row['total'];

} // End of WHILE loop. 

// Clear the stored procedure results:
mysqli_next_result($dbc);

// Add the shipping:
$body_plain .= "Shipping & Handling: \$$shipping\n";
$body_html .= '<tr>
	<td colspan="2"> </td><th align="right">Shipping &amp; Handling</th>
	<td align="right">$' . $shipping . '</td>
</tr>
';


// Add the total:
$body_plain .= "Total: \$$total\n";
$body_html .= '<tr>
	<td colspan="2"> </td><th align="right">Total</th>
	<td align="right">$' . $total . '</td>
</tr>
';

// Complete the HTML body:
$body_html .= '</table></body></html>';

//////////////////////////////////////////////////////////////////////////////////////////////////

//For Zend:
// Include the Zend library
set_include_path('./library/');
include('Zend/Mail.php');

// Create a Zend mail object:
$mail = new Zend_Mail();

$mail->setFrom("We Are Nuts");
$mail->addTo($_SESSION['email']);
$mail->setSubject("Thank you for your order at We Are Nuts!");

$mail->setBodyText($body_plain);
$mail->setBodyHtml($body_html); 
$mail->send();  

//////////////////////////////////////////////////////////////////////////////////////////////////

