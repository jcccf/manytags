<?php

require_once("../inc/config.php");
require_once("../inc/db.php");

function in_iarray($str, $a){
foreach($a as $v){
if(strcasecmp($str, $v)==0){return true;}
}
return false;
}

function array_iunique($a){
$n = array();
foreach($a as $k=>$v){
if(!in_iarray($v, $n)){$n[$k]=$v;}
}
return $n;
}

$query = "SELECT u.email, u.completed, t.* FROM users AS u LEFT JOIN tags AS t ON u.id = t.user_id WHERE u.completed = 1 AND t.data != ''";

$valid = array();

echo "<h2>Invalid</h2>";

$q = mysql_query($query);
while($r = mysql_fetch_object($q)){
  $r->data = trim($r->data);
  switch($r->type_id){
    case "1": //Regex matching everything except space and underscore
      if(preg_match("/^[^\ _]*$/", $r->data)){ 
        $valid[] = $r;
      }
      else{
        echo $r->type_id." ".$r->data."&nbsp;//&nbsp;";
        print_r($r);
        echo "<br />";
      }
      break;
    case "2": //Regex matching everything containing space and underscore
      if(preg_match("/(\s+)|_/", $r->data)){
        $valid[] = $r;
      }
      else{
        echo $r->type_id." ".$r->data."&nbsp;//&nbsp;";
        print_r($r);
        echo "<br />";
      }
      break;
    case "3":
      $valid[] = $r;
      break;
    default:
      die("Invalid tag type provided!");
      break;
  }
}

echo "<h2>Valid</h2>";

// Initialize
$scount = 0;
$mcount = 0;
$ccount = 0;
$sarray = array();
$marray = array();
$carray = array();
$stags = array();
$mtags = array();
$ctags = array();

// By User
$users = array();

// By Image
$images = array();

mysql_query("TRUNCATE TABLE tags2");

foreach($valid as $r){
  //Write back to tags2
  $data = mysql_real_escape_string($r->data);
  mysql_query("INSERT INTO tags2 (type_id, image_id, data) VALUES('{$r->type_id}','{$r->image_id}','{$data}')");
  
  $users[$r->user_id][$r->type_id][] = $r->data;
  $images[$r->image_id][$r->type_id][] = $r->data;
  
  switch($r->type_id){
    case "1":
      $stags[] = $r->data;
      $scount++;
      $sarray[$r->user_id * 100 + $r->image_id] = 1;
      break;
    case "2":
      $mtags[] = $r->data;
      $mcount++;
      $marray[$r->user_id * 100 + $r->image_id] = 1;
      break;
    case "3":
      $ctags[] = $r->data;
      $ccount++;
      $carray[$r->user_id * 100 + $r->image_id] = 1;
      break;
  }
  echo $r->type_id." ".$r->data."&nbsp;//&nbsp;";
  print_r($r);
  echo "<br />";
}

// By Type
$t1 = fopen("tags_swt.txt", "w");
$t2 = fopen("tags_mwt.txt", "w");
$t3 = fopen("tags_com.txt", "w");
foreach($stags as $value){
  fwrite($t1,$value."\n");
}
foreach($mtags as $value){
  fwrite($t2,$value."\n");
}
foreach($ctags as $value){
  fwrite($t3,$value."\n");
}
fclose($t1);
fclose($t2);
fclose($t3);

// By Type, Unique
$t1 = fopen("tags_swt_u.txt", "w");
$t2 = fopen("tags_mwt_u.txt", "w");
$t3 = fopen("tags_com_u.txt", "w");
$stags = array_iunique($stags);
$mtags = array_iunique($mtags);
$ctags = array_iunique($ctags);
foreach($stags as $value){
  fwrite($t1,$value."\n");
}
foreach($mtags as $value){
  fwrite($t2,$value."\n");
}
foreach($ctags as $value){
  fwrite($t3,$value."\n");
}
fclose($t1);
fclose($t2);
fclose($t3);

// Print Overall
$user_count = count($users);
$sim_count = count($sarray);
$mim_count = count($marray);
$cim_count = count($carray);
$s_average = $scount / count($sarray);
$m_average = $mcount / count($marray);
$c_average = $ccount / count($carray);
$o = fopen("overall.txt", "w");
fwrite($o, "# of Users:\n$user_count\n\n");
fwrite($o, "Total # of Tags Applied:\nSWT: $scount, MWT: $mcount, COM: $ccount\n\n");
fwrite($o, "Average # of Tags Applied Per Image Per User:\nSWT: $s_average, MWT: $m_average, COM: $c_average\n\n");
fwrite($o, "# of Images Presented of Each Type:\nSWT: $sim_count MWT: $mim_count COM: $cim_count\n\n");
fclose($o);

// Print Individual User Tags
foreach($users as $userid => $tags){
  echo "Printing for user $userid...<br />";
  $f = fopen("user_$userid.txt","w");
  foreach($tags[1] as $key => $value){
    fwrite($f, $value."\n");
  }
  fwrite($f,"\n");
  foreach($tags[2] as $key => $value){
    fwrite($f, $value."\n");
  }
  fwrite($f,"\n");
  foreach($tags[3] as $key => $value){
    fwrite($f, $value."\n");
  }
  fclose($f);
}

// Print Individual Images
foreach($images as $imageid => $tags){
  echo "Printing for image $imageid...<br />";
  $f = fopen("image_$imageid.txt","w");
  $tags[1] = array_iunique($tags[1]);
  $tags[2] = array_iunique($tags[2]);
  $tags[3] = array_iunique($tags[3]);
  foreach($tags[1] as $key => $value){
    fwrite($f, $value."\n");
  }
  fwrite($f,"\n");
  foreach($tags[2] as $key => $value){
    fwrite($f, $value."\n");
  }
  fwrite($f,"\n");
  foreach($tags[3] as $key => $value){
    fwrite($f, $value."\n");
  }
  fclose($f);  
}

?>