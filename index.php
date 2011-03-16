<?php

require_once("inc/core.php");

$user_id = mysql_real_escape_string($_SESSION['user_id']);
// Get Completion
$q = mysql_query("SELECT completed FROM users WHERE id = '$user_id'");
$r = mysql_fetch_array($q);
$completed = ($r[0] == "1") ? "true" : "false";

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
  <script src="js/json2.js"></script>
  <script src="js/history.adapter.jquery.js"></script>
  <script src="js/history.js"></script>
  <script src="js/history.html4.js"></script>
  <script src="js/jquery.hotkeys.js"></script>
  <script>
  
  var imageData = null;
  var p = 0;
  var completed = <?php echo $completed ?>;
  var History = window.History;
  	
  $(window).bind('statechange',function(){
    var state = History.getState();
    if (state.data.page != null){
      p = state.data.page;
    }
    updatePage();
  });
  	
  $(document).ready(function(){
    
    if(completed) endOfStudy();
    
    $( "#dialog-message" ).dialog({
      modal: true,
      width: 960,
      minWidth: 960,
      buttons: {
      	Ok: function() {
      		$( this ).dialog( "close" );
      	}
      }
    });
    
      $("#dialogagain").click(function(){
        $( "#dialog-message" ).dialog("open");
      });
      
    $("#progressbar").progressbar({
			value: 0
		});
    $.getJSON("get_orderlist.php", function(data){
      imageData = data;
      loadedImageData();
      updatePage();
    });
    
    $("#back_button").click(function(){
      if(completed) return false;
      if(p != 0){
        saveTagData();
        p--;
        updatePage();
        History.pushState({page: p}, "Many Tags Page "+p, "?page="+p);
      }
      else{
        saveTagData();
      }
    });
    
    $("#forward_button").click(function(){
      if(completed) return false;
      if(p != 29){
        saveTagData();
        p++;
        updatePage();
        History.pushState({page: p}, "Many Tags Page "+p, "?page="+p);
      }
      else{
        saveTagData();
        endOfStudy();
      }
    });
    
    $(document).bind('keydown', 'p', function(){$("#back_button").click();});
		$(document).bind('keydown', 'n', function(){$("#forward_button").click();});
    
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
    if (imageData[p].data != $("#content_input_textarea").val()){ // Update only if text got changed
      imageData[p].data = $("#content_input_textarea").val();
      
      // TODO Disable Back/Save Buttons
      $("#forward_button").attr("disabled", true);
      $("#back_button").attr("disabled", true);
      
      // Post data to server
      $.post("set_tags.php", 
        { type_id : imageData[p].type_id, image_id : imageData[p].image_id, tag_data : imageData[p].data },
        function(data){
          $("#forward_button").removeAttr("disabled");
          $("#back_button").removeAttr("disabled");
          
          if(data.length > 0){
            alert("Errors Occurred!");
          }
      },"json");
    }
  }
  
  function restoreTagData(){
    $("#content_input_textarea").val(imageData[p].data);
  }
  
  // Update page state to reflect any changes
  function updatePage(){
    if(completed) return false;
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
  
  function endOfStudy(){
    completed = true;
    $("#content_input").hide();
    $("#content_image").hide();
    $("#theend_pre").show();
    $.post("set_options.php", {completed: 1}, function(){
      $("#theend_pre").hide();
      $("#theend").show();
    });
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

  <div id="divider" class="container_12">
    <hr />
  </div>
  
  <div id="content" class="container_12">
    
  <div id="content_image" class="grid_8">
    <img src="img/pigeonsoftheworld.png" id ="content_image_img" />
  </div>

  <div id="content_input" class="grid_4">
    <div>
    <span id="instructions">Type <strong>single-word</strong> tags below. Separate your tags by line.</span>&nbsp;<a id="dialogagain" href="#">[?]</a>
    </div>
    <form>
    <textarea spellcheck="false" id="content_input_textarea" autofocus></textarea>  
    
    
    <div id="controls_back" class="grid_1 alpha">
      <input type="button" value="Back" id="back_button" />
    </div>

    <div id="controls_forward" class="grid_3 omega">
      <input type="button" value="Save and Continue" id="forward_button" />
    </div>
    
    </form>
    
  </div>
  
  <!-- End of Study Instructions -->
  <div id="theend_pre" style="display: none" class="grid_12">
  Please wait...  
  </div>
  <div id="theend" class="grid_12">
    Thank you for completing the first part of this study.<br />
    Please visit <b><a href=\"\">this link</a></b> to continue with the survey.
  </div>

  </div>
  
  <!-- Instructions -->
  <div id="dialog-message" title="Instructions">
  		You will be asked to tag images in three different ways - using tags made up of a single word, using tags made up of more than one word, or using a comment.
  		<br /><br />
  	  <b>Examples of tags with a single word:</b> "<i>hello</i>" or "<i>maple</i>"<br /><br />
  	  <b>Examples of tags with more than one word:</b> "<i>optimus prime</i>" or "<i>around_the_flask</i>"<br /><br />
  	  <b>Example of a comment:</b> "<i>This is a comment and it can be as long or as short as I want.</i>"
  </div>
  
  <footer class="container_12">
    <?php
    echo "User ID is $user_id<br />";
    ?>
    <div id="debug"></div>
  </foooter>
</body>

</html>