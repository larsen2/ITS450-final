<?php

// This file is the home page. 
// This script is begun in Chapter 8.

// Require the configuration before any PHP code:
require ('./includes/config.inc.php');

// Include the header file:
$page_title = 'sitemap';
include ('./includes/header.html');

// Include the view:
include('./views/sitemap.html');

// Include the footer file:
include ('./includes/footer.html');
?>
