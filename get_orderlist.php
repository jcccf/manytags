<?php

require_once("inc/core.php");

// See if any existing data
$datalist = array();
$data_q = mysql_query("SELECT image_id, data FROM tags WHERE user_id='{$_SESSION['user_id']}'");
while($row = mysql_fetch_array($data_q)){
  if(array_key_exists($row[0],$datalist)){
    $datalist[$row[0]] .= "\n".$row[1];
  }
  else{
    $datalist[$row[0]] = $row[1];
  }
}

// Get Orderlist
$olist = array();
$ord_q = mysql_query("SELECT ol.image_id, i.url, ol.type_id FROM orderlists AS ol LEFT JOIN images AS i ON i.id = ol.image_id WHERE user_id='{$_SESSION['user_id']}' ORDER BY ol.order_num ASC");
while($row = mysql_fetch_array($ord_q)){
  $a = array();
  $a['image_id'] = $row[0];
  $a['url'] = $row[1];
  $a['type_id'] = $row[2];
  $a['data'] = $datalist[$row[0]];
  $olist[] = $a;
}

// Output JSON
echo json_encode($olist);

?>