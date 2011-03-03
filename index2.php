<?php

require_once("inc/core.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ManyTags Part 2</title>
  <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.9.custom.css" />
  <link rel="stylesheet" href="css/default.css" />
  <script src="js/jquery-1.5.min.js"></script>
  <script src="js/jquery-ui-1.8.9.custom.min.js"></script>
  <script src="js/json2.js"></script>
  <script src="js/history.adapter.jquery.js"></script>
  <script src="js/history.js"></script>
  <script src="js/history.html4.js"></script>
  <script src="js/jquery.hotkeys.js"></script>
  <script>
  
  var imageData = null;
  var p = 0;
  var History = window.History;
  	
  $(window).bind('statechange',function(){
    var state = History.getState();
    if (state.data.page != null){
      p = state.data.page;
    }
    updatePage();
  });
  	
  $(document).ready(function(){
      
    $("#progressbar").progressbar({
			value: 0
		});
		$.getJSON("get_orderlist.php", {select: 2}, function(data){
      imageData = data;
      loadedImageData();
      updatePage();
      //alert(data);
    });
		
		$(document).bind('keydown', 'p', function(){$("#back_button").click();});
		$(document).bind('keydown', 'n', function(){$("#forward_button").click();});
		
		$("#back_button").click(function(){
      if(p != 0){
        saveTagData();
        p--;
        updatePage();
        History.pushState({page: p}, "Many Tags Page "+p, "?page="+p);
      }
      else{
        saveTagData();
        updatePage();
      }
    });
    
    $("#forward_button").click(function(){
      if(p != 29){
        saveTagData();
        p++;
        updatePage();
        History.pushState({page: p}, "Many Tags Page "+p, "?page="+p);
      }
      else{
        saveTagData();
        $("#content_input").hide();
        $("#content_image").hide();
        $("#content_ratings").hide();
        $("#theend").show();
      }
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
    // Disable Back/Save Buttons
    $("#forward_button").attr("disabled", true);
    $("#back_button").attr("disabled", true);
    
    // Update Selected Data
    imageData[p].data = { 
      1: $("input[name=q1]:checked").val(), 
      2: $("input[name=q2]:checked").val(), 
      3: $("input[name=q3]:checked").val() };
      
    $("input:radio").removeAttr("checked");
    
    // Post data to server
    $.post("set_ratings.php", 
      { type_id : imageData[p].type_id, image_id : imageData[p].image_id, ratings_data : imageData[p].data },
      function(data){
        $("#forward_button").removeAttr("disabled");
        $("#back_button").removeAttr("disabled");
        
        if(data.length > 0){
          alert("Errors Occurred!");
        }
    },"json");
  }
  
  function restoreTagData(){
    if(imageData[p].data != null){
      $.each(imageData[p].data, function(k,v){
        $("input[name=q"+k+"][value='"+v+"']").click();
      });
    }
  }

  function updatePage(){
    restoreTagData();
    $("#content_image_img").attr("src", imageData[p].url);
    $("#progressbar").progressbar({
			value: (p+1) * 3.3
		});
		
		$("#content_tags").removeClass().html("");
		if(imageData[p].image_data != null){
  		switch(imageData[p].type_id){
        case "1":
        case "2":        
          $.each(imageData[p].image_data, function(k,v){
            $("#content_tags").append("<li><span class=\"tag_wrapper\">"+v+"</span></li>");
          });
          break;
        case "3":
          $("#content_tags").addClass("comments");
          $.each(imageData[p].image_data, function(k,v){
            $("#content_tags").append("<li>"+v+"</li>");
          });
          break;
        default:
          alert("An error occurred. Please let us know about how this occurred!");
          break;
      }
    }
    $("#debug").html("Image ID is "+imageData[p].image_id+", Type_ID is "+imageData[p].type_id+", URL is "+imageData[p].url);
  }

  </script>
</head>

<body>
  <header class="container_12">
    <div class="grid_12">
      <h1>ManyTags Part 2</h1>
    </div>
  </header>
  
  <div id="content" class="container_12">
    
  <div id="content_image" class="grid_8">
    <img src="img/pigeonsoftheworld.png" id ="content_image_img" />
  </div>

  <div id="content_input" class="grid_4">
    <!--<h3>Tags</h3>-->
    <ul id="content_tags">
      <li><span class="tag_wrapper">Tag1</span></li>
      <li><span class="tag_wrapper">Tag2</span></li>
    </ul>
  </div>
  
  <form>
  <div id="content_ratings" class="grid_12">
  
  <div class="question">
  <div class="question_title">These words accurately describe the image.</div>
  <ul class="radiolist">
    <li><input type="radio" name="q1" id="q1_1" value="1"><label for="q1_1">Strongly disagree</label></li>
    <li><input type="radio" name="q1" id="q1_2" value="2"><label for="q1_2">Disagree</label></li>
    <li><input type="radio" name="q1" id="q1_3" value="3"><label for="q1_3">Neither agree nor disagree</label></li>
    <li><input type="radio" name="q1" id="q1_4" value="4"><label for="q1_4">Agree</label></li>
    <li><input type="radio" name="q1" id="q1_5" value="5"><label for="q1_5">Strongly Agree</label></li>
  </ul>
  </div>
  
  <div class="question">
  <div class="question_title">These words would be useful for searching for this image.</div>
  <ul class="radiolist">
    <li><input type="radio" name="q2" id="q2_1" value="1"><label for="q2_1">Strongly disagree</label></li>
    <li><input type="radio" name="q2" id="q2_2" value="2"><label for="q2_2">Disagree</label></li>
    <li><input type="radio" name="q2" id="q2_3" value="3"><label for="q2_3">Neither agree nor disagree</label></li>
    <li><input type="radio" name="q2" id="q2_4" value="4"><label for="q2_4">Agree</label></li>
    <li><input type="radio" name="q2" id="q2_5" value="5"><label for="q2_5">Strongly Agree</label></li>
  </ul>
  </div>
  
  <div class="question">
  <div class="question_title">These words offer a different or interesting perspective of this image.</div>
  <ul class="radiolist">
    <li><input type="radio" name="q3" id="q3_1" value="1"><label for="q3_1">Strongly disagree</label></li>
    <li><input type="radio" name="q3" id="q3_2" value="2"><label for="q3_2">Disagree</label></li>
    <li><input type="radio" name="q3" id="q3_3" value="3"><label for="q3_3">Neither agree nor disagree</label></li>
    <li><input type="radio" name="q3" id="q3_4" value="4"><label for="q3_4">Agree</label></li>
    <li><input type="radio" name="q3" id="q3_5" value="5"><label for="q3_5">Strongly Agree</label></li>
  </ul>
  </div>
  
  </div>

  </form>  
  
  <div id="theend" class="grid_12">
    Thank you for completing the first part of this study.<br />
    Please visit <a href=\"\">this link</a> to continue with the survey.
  </div>

  </div>
  
  <div class="container_12">
    <div id="progressbar" class="grid_12 "></div>
    <div class="grid_12"><hr /></div>
    <form>
    <div class="grid_8">&nbsp;</div>
    <div id="controls_back" class="grid_1">
      <input type="button" value="Back" id="back_button" />
    </div>

    <div id="controls_forward" class="grid_3">
      <input type="button" value="Save and Continue" id="forward_button" />
    </div>
    </form>
  </div>
  
  <footer class="container_12">
    <div class="grid_12">
    <?php
    echo "User ID is {$_SESSION['user_id']}<br />";
    ?>
    <div id="debug"></div>
    </div>
  </foooter>
</body>

</html>