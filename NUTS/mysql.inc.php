<?php

// This file contains the database access information. 
// This file establishes a connection to MySQL and selects the database.
// This script is begun in Chapter 7.

// Set the database access information as constants:
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'toor');
DEFINE ('DB_HOST', 'WeAreNuts.com');
DEFINE ('DB_NAME', 'ecommerce2');

// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Set the character set:
mysqli_set_charset($dbc, 'utf8');

// Omit the closing PHP tag to avoid 'headers already sent' errors!

function get_password_hash($password)
{
  global $dbc;
  return hash_hmac('sha256', $password, 'c#har1891', true);
}
