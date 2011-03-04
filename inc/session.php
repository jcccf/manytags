<?php

session_start();

// Force all participants to register their email
if (!isset($_SESSION['user_id']) && $_SERVER['SCRIPT_NAME'] != "/register.php") {
  header("Location: register.php");
}

// Register a new user
if ($_SERVER['SCRIPT_NAME'] == "/register.php") {
  if (isset($_POST['email']) && isset($_POST['humantest']) && isset($_POST['flname'])){
    if (trim($_POST['humantest']) == "7" || trim($_POST['humantest'] == "seven")) {
      $_SESSION['user_id'] = db_initialize_user($_POST['flname'], $_POST['email']);
      header("Location: index.php");
    }
  }
}

// Logout
// Use ?logout=1 on any page to logout
if (isset($_GET['logout']) && $_GET['logout'] == 1){
  unset($_SESSION['user_id']);
  header("Location: register.php");
}

?>