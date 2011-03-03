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
  $(document).ready(function(){
    // Simple Registration Form Checking
    $("#reg_form").submit(function(){
      if($("#reg_form_email").val() == "@cornell.edu" || $("#reg_form_humantest").val() == ""){
        alert("Please fill in all fields.");
        return false;
      }
    });
  });
  </script>
</head>

<body>
  <header class="container_12">
    <div class="grid_12">
      <h1>ManyTags</h1>
    </div>
  </header>

  <div id="content" class="container_12">
    <div class="grid_12">
      This study has been approved by the IRB.<br />
      Type in your email address.
    </div>
    
    <hr />
    
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" id="reg_form">
    
    <div class="grid_6">
      Email Address<br />
      <input type="email" value="@cornell.edu" size="30" name="email" id="reg_form_email" />
    </div>
    
    <div class="grid_6">
      What is 3 plus 4?<br />
      <input type="text" size="30" name="humantest" id="reg_form_humantest" />
    </div>
    
    <div class="grid_12">
      <hr />
      
      <input type="submit" value="Continue" />
    </div>
    
    </form>
  </div>
  
  <div id="content" class="container_12">

  </div>

<?php

$a = array("image_url" => "hello.png", "type_id" => 3);
echo json_encode($a);
?>

  
  <footer>
    
  </foooter>
</body>

</html>