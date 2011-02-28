<?php

require_once("inc/core.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ManyTags</title>
  <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.9.custom.css" />
  <link rel="stylesheet" href="css/default.css" />
  <script src="js/jquery-1.5.min.js"></script>
  <script src="js/jquery-ui-1.8.9.custom.min.js"></script>
  <script>
  
  var imageData = null;
  var p = 0;
  	
  $(document).ready(function(){
    $("#progressbar").progressbar({
			value: 0
		});
    $.getJSON("get_orderlist.php", function(data){
      imageData = data;
      loadedImageData();
      updatePage();
    });
    
    $("#back_button").click(function(){
      if(p != 0){
        p--;
        updatePage();
      }
    });
    $("#forward_button").click(function(){
      if(p != 29){
        p++;
        updatePage();
      }
      //TODO if at the end go to the survey
    });
  });
  
  function loadedImageData(){
    var tmpImg = new Image();
    //alert(imageData);
    $.each(imageData, function(k,v){
      //alert(v.image_id);
      tmpImg.src = v.url; // Preload all images
    });
  }
  
  function updatePage(){
    $("#content_image_img").attr("src", imageData[p].url);
    $("#progressbar").progressbar({
			value: p * 3
		});
		// TODO Set textbox text
		// TODO Save data to database
  }
  </script>
</head>

<body>
  <header class="container_12">
    <div class="grid_12">
      <h1>ManyTags</h1>
    </div>
    <div id="progressbar" class="grid_12 ">
    </div>
  </header>

  <div id="content" class="container_12">
    <hr />
    </div>
  
  <div id="content" class="container_12">
    
  <div id="content_image" class="grid_8">
    <img src="img/pigeonsoftheworld.png" id ="content_image_img" />
  </div>

  <div id="content_input" class="grid_4">
    <div id="instructions">
    Type <strong>single-word</strong> tags below. Separate your tags by line.
    </div>
    
    <form>
    <textarea spellcheck="false"></textarea>  
    </form>
    
    <div id="controls_back" class="grid_1 alpha">
      <div id="back_button">Back</div>
    </div>

    <div id="controls_forward" class="grid_3 omega">
      <div id="forward_button">Save and <b>Continue</b></div>
    </div>
    
  </div>

  </div>
  
  <footer>
    <?php
    echo "User ID is {$_SESSION['user_id']}<br />";
    ?>
  </foooter>
</body>

</html>