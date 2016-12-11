<?php

// This file is the print receipt page. 

// Require the configuration before any PHP code:
require ('./includes/config.inc.php');

if (isset($_GET['orderid'])) {


// Require the database connection:
require (MYSQL);


$body_html = '<html><head><style type="text/css" media="all">
	body {font-family:Tahoma, Geneva, sans-serif; font-size:100%; line-height:.875em; color:#70635b;}
</style></head><body>
<p>Thank you for your order. Your order number is ' . $_GET['orderid'] . '. All orders are processed on the next business day. You will be contacted in case of any delays.</p>
<table border="0" cellspacing="8" cellpadding="6">
	<tr>
		<th align="center">Item</th>
		<th align="center">Quantity</th>
		<th align="right">Price</th>
		<th align="right">Subtotal</th>
	</tr>';

// Get the cart contents for the confirmation email:
$r = mysqli_query($dbc, "CALL get_order_contents({$_GET['orderid']})");

// Fetch each product:
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
	
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
$body_html .= '<tr>
	<td colspan="2"> </td><th align="right">Shipping &amp; Handling</th>
	<td align="right">$' . $shipping . '</td>
</tr>
';


// Add the total:
$body_html .= '<tr>
	<td colspan="2"> </td><th align="right">Total</th>
	<td align="right">$' . $total . '</td>
</tr>
';

// Complete the HTML body:
$body_html .= '</table></body></html>';


include ('./views/receipt.html');
}
else {
echo "There was an error!";
}

?>         

