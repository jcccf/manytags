<?php

require_once("inc/core.php");

$errors = array();

if(!isset($_POST['type_id']) || !isset($_POST['image_id']) || !isset($_POST['ratings_data'])){
  die("Please post type id, image id and ratings data.");
}

$user_id = mysql_real_escape_string($_SESSION['user_id']);
$type_id = mysql_real_escape_string($_POST['type_id']);
$image_id = mysql_real_escape_string($_POST['image_id']);
$ratings_data = $_POST['ratings_data'];

// Delete all existing data first
mysql_query("DELETE FROM ratings WHERE user_id = '$user_id' AND image_id = '$image_id'");

// Insert new data
foreach($ratings_data as $question_id => $rating){
  if(!is_numeric($question_id) || !is_numeric($rating)){
    $errors[] = "Some invalid values provided!";
  }
  else{
    mysql_query("INSERT INTO ratings (user_id, image_id, type_id, question_id, rating) VALUES ('$user_id', '$image_id', '$type_id', '$question_id', '$rating')");
    if(mysql_error() != "")
      $errors[] = mysql_error();
  }
}

// Output JSON Result
echo json_encode($errors);

?>