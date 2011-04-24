<?php

require_once("../inc/config.php");
require_once("../inc/db.php");

$query = "SELECT u.id, SUBSTRING_INDEX(u.email,'@',1) as netid FROM users as u WHERE completed = 1";

echo "Writing out ids...";
$f = fopen("id_netids.txt", "w");
$q = mysql_query($query);
while($r = mysql_fetch_object($q)){
  fwrite($f, $r->id."\t".$r->netid."\n");
}
fclose($f);
echo "Done!";
?>