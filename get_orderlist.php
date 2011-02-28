<?php

require_once("inc/core.php");

// Get Orderlist
$olist = array();
$ord_q = mysql_query("SELECT ol.image_id, i.url, ol.type_id FROM orderlists AS ol LEFT JOIN images AS i ON i.id = ol.image_id WHERE user_id='{$_SESSION['user_id']}' ORDER BY ol.order_num ASC");
while($row = mysql_fetch_array($ord_q)){
  $a = array();
  $a['image_id'] = $row[0];
  $a['url'] = $row[1];
  $a['type_id'] = $row[2];
  $olist[] = $a;
}

// Output JSON
echo json_encode($olist);

?>