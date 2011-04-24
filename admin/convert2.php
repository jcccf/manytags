<?php

require_once("../inc/config.php");
require_once("../inc/db.php");

$query = "SELECT u.email, u.completed, r.* FROM ratings AS r LEFT JOIN users AS u ON u.id = r.user_id WHERE u.completed = 1";

$ratings = array();
$ratings[] = array('type_id', 'user_id', 'image_id', 'question_id', 'rating');

echo "Writing out CSV...";
$q = mysql_query($query);
while($r = mysql_fetch_object($q)){
  $rating = array();
  $rating[] = $r->type_id;
  $rating[] = $r->user_id;
  $rating[] = $r->image_id;
  $rating[] = $r->question_id;
  $rating[] = $r->rating;
  $ratings[] = $rating;
}

$f = fopen('ratings.csv','w');
foreach($ratings as $row){
  fputcsv($f, $row);
}
fclose($f);
echo "Done!";
?>