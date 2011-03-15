<?php

require_once("inc/core.php");

if(!isset($_POST['completed'])){
  die("Invalid option specified.");
}

$user_id = mysql_real_escape_string($_SESSION['user_id']);

// Set user's completion status 
if(isset($_POST['completed'])){
  mysql_query("UPDATE users SET completed = '1' WHERE id = '$user_id'");
}

echo mysql_error();