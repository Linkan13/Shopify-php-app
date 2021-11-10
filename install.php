<?php

// Set variables for our request
$shop = $_GET['shop'];

$api_key = "fd31ad753404c3be4767930c396176f6";
$scopes = "read_orders,write_orders,write_products,read_products,read_themes,write_themes";
$redirect_uri = "https://phpstack-102119-1956372.cloudwaysapps.com/token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();