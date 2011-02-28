<?php

// Connect to DB
$db = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
if (!$db) {
    die("DB Connect Error: ".mysql_error());
}
$db_selected = mysql_select_db(DB_DATABASE, $db);
if (!$db_selected) {
    die ("DB Select Error: ".mysql_error());
}

// Helper Functions

function db_initialize_user($email){
  
  $email = mysql_real_escape_string($email);
  
  // Create user and get back userid
  mysql_query("INSERT INTO users (email) VALUES('{$email}')");
  echo mysql_error();
  $user_id = mysql_insert_id();
  
  // Generate Orderlist
  $image_id_order = range(1, 30);
  shuffle($image_id_order);
  $type_id_order = array_merge(array_fill(0, 10, 1), array_fill(0, 10, 2), array_fill(0, 10, 3));
  shuffle($type_id_order);

  // Populate Orderlist
  for($i=0;$i<count($image_id_order);$i++){
    mysql_query("INSERT INTO orderlists (user_id, order_num, image_id, type_id) VALUES('$user_id', '$i', '{$image_id_order[$i]}', '{$type_id_order[$i]}')");
    echo mysql_error();
  }
  
  return $user_id;
}

?>