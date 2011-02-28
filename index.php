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
  var tagData = new Array(30);
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
        saveTagData();
        p--;
        updatePage();
      }
    });
    
    $("#forward_button").click(function(){
      if(p != 29){
        saveTagData();
        p++;
        updatePage();
      }
      //TODO if at the end go to the survey
    });
    
  });
  
  // Preload all images
  function loadedImageData(){
    var tmpImg = new Image();
    $.each(imageData, function(k,v){
      tmpImg.src = v.url; 
    });
  }
  
  // Save tag data locally and to server
  function saveTagData(){
    if (tagData[p] != $("#content_input_textarea").val()){ // Update only if text got changed
      tagData[p] = $("#content_input_textarea").val();
      
      // Post data to server
      $.post("set_tags.php", 
        { type_id : imageData[p].type_id, image_id : imageData[p].image_id, tag_data : tagData[p] },
        function(data){
          if(data.length > 0){
            alert("Errors Occurred!");
          }
      },"json");
    }
  }
  
  function restoreTagData(){
    $("#content_input_textarea").val(tagData[p]);
  }
  
  // Update page state to reflect any changes
  function updatePage(){
    restoreTagData();
    $("#content_image_img").attr("src", imageData[p].url);
    $("#progressbar").progressbar({
			value: (p+1) * 3.3
		});
    switch(imageData[p].type_id){
      case "1":
        $("#instructions").html("Type <strong>single-word</strong> tags below, with one tag on each line.");
        break;
      case "2":
        $("#instructions").html("Type tags consisting of <strong>more than one word</strong> below. Separate your tags by line.");
        break;
      case "3":
        $("#instructions").html("<strong>Comment</strong> on the image using the text box below.");
        break;
      default:
        alert("An error occurred. Please let us know about how this occurred!");
        break;
    }
		$("#debug").html("Image ID is "+imageData[p].image_id+", Type_ID is "+imageData[p].type_id+", URL is "+imageData[p].url);
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
    <textarea spellcheck="false" id="content_input_textarea"></textarea>  
    </form>
    
    <div id="controls_back" class="grid_1 alpha">
      <div id="back_button">Back</div>
    </div>

    <div id="controls_forward" class="grid_3 omega">
      <div id="forward_button">Save and <b>Continue</b></div>
    </div>
    
  </div>

  </div>
  
  <footer class="container_12">
    <?php
    echo "User ID is {$_SESSION['user_id']}<br />";
    ?>
    <div id="debug"></div>
  </foooter>
</body>

</html>