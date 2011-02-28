<?php

require_once("inc/core.php");

$errors = array();

if(!isset($_POST['type_id']) || !isset($_POST['image_id']) || !isset($_POST['tag_data'])){
  die("Please post type id, image id and tag data.");
}

$user_id = mysql_real_escape_string($_SESSION['user_id']);
$type_id = mysql_real_escape_string($_POST['type_id']);
$image_id = mysql_real_escape_string($_POST['image_id']);
$tag_data = mysql_real_escape_string($_POST['tag_data']);



// Delete all existing data first
mysql_query("DELETE FROM tags WHERE user_id = '$user_id' AND image_id = '$image_id'");

// Insert new data
if($type_id != 3){
  $tag_data = explode("\\n",$tag_data);
  foreach($tag_data as $tag){
    mysql_query("INSERT INTO tags (user_id, image_id, type_id, data) VALUES ('$user_id', '$image_id', '$type_id', '$tag')");
    if(mysql_error() != "")
      $errors[] = mysql_error();
  }
}
else{
  mysql_query("INSERT INTO tags (user_id, image_id, type_id, data) VALUES ('$user_id', '$image_id', '$type_id', '$tag_data')");
  if(mysql_error() != "")
    $errors[] = mysql_error();
}

// Output JSON Result
echo json_encode($errors);

?>