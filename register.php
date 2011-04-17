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
  <script src="js/jquery-1.5.2.min.js"></script>
  <script src="js/jquery-ui-1.8.9.custom.min.js"></script>
  <script>
  $(document).ready(function(){
    // Simple Registration Form Checking
    $("#reg_form").submit(function(){
      if($("#reg_form_email").val() == "@cornell.edu" || $("#reg_form_humantest").val() == "" || $("#reg_form_flname").val() == ""){
        alert("Please fill in all fields.");
        return false;
      }
    });
  });
  </script>
</head>

<body>
  <div class="container_12">
    <div class="grid_12">
      <h1>ManyTags</h1>
    </div>
  </div>

  <div id="content" class="container_12">
    <div class="grid_12">
      
      <h4>What is this study about?</h4>
      The purpose of this study is to learn how people use tags and comments with different images.
      
      <h4>What is tagging?</h4>
      <ul class="instructions">
        <li>Tags are like labels used to describe the things around you.
        <li>Just like price tags or gift tags, they provide descriptions of stuff.
        <li>They are keywords that you use to help you and other people around you organize data.
      </ul>

      <h4>What do I do?</h4>
      <ul class="instructions">
        <li>On the next few screens, you will be presented with a series of 30 images, one on each page.
        <li>You may be asked to tag or comment the image by using a box located on the right of the image.
        <li>You can add multiple tags or comments to an image.
        <li>Tag or comment the images in whatever way suits you best!
        <li>There is a short survey at the end for you to fill out.
        <li>All this should take approximately 45 minutes to complete.
      </ul>

      <h4>What are the risks and benefits?</h4>
      We do not anticipate any risks to you participating in this study other than those encountered in day-to-day life. There are no direct benefits to you.
      
      <h4>Do I get compensation?</h4>
      You may earn extra credit if you are taking a class that offers credit for research studies. Credit is assigned according to class policy.
      
      <h4>Your answers will be confidential.</h4>
      The records of this study will be kept private. In any sort of report we make public we will not include any information making it possible to identify you. Research records will be kept in a secure database; only the researchers will have access to the records.
      We anticipate that your participation in this survey presents no greater risk than everyday use of the Internet.
      
      <h4>Taking part is voluntary.</h4>
      Taking part in this study is completely voluntary. You may skip any questions that you do not want to answer. If you decide not to take part or to skip some of the questions, it will not affect your current or future relationship with Cornell University. If you decide to take part, you are free to withdraw at any time.
      
      <h4>If you have questions,</h4>
      <p>The primary researcher conducting this study is Evan Fay Earle. You may contact Evan at <i>efe4 at cornell dot edu</i> or PHONENUMBER. If you have any questions or concerns regarding your rights as a subject in this study, you may contact the Institutional Review Board (IRB) at 607-255-5138 or access their website at http://www.irb.cornell.edu. You may also report your concerns or complaints anonymously through Ethicspoint or by calling toll free at 1-866-293-3077. Ethicspoint is an independent organization that serves as a liaison between the University and the person bringing the complaint so that anonymity can be ensured. You will be emailed a copy of this form to keep for your records. 
        
    <br /><br />

    <h3>By typing your name and email address in the boxes below, you declare that you are over 18 years old and consent to taking part in this study.</h3>
    </div>
    
    <hr />
    
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" id="reg_form">
    
    <div class="grid_6">
      <h4>First and Last Name</h4>
      <input type="text" value="" placeholder="Your name here" size="30" name="flname" id="reg_form_flname" required />
    </div>
    
    <div class="grid_6">
      <h4>Email Address</h4>
      <input type="email" value="@cornell.edu" size="30" name="email" id="reg_form_email" required />
    </div>
    
    <div class="grid_6">
      <h4>What is 3 plus 4?</h4>
      <input type="text" size="30" name="humantest" id="reg_form_humantest" required />
    </div>
    
    <div class="grid_12">
      <hr />
      
      <input type="submit" value="Continue" />
    </div>
    
    </form>
  </div>
  
  <div id="content" class="container_12">
    <div class="grid_12"><hr /></div>

  </div>
  
  <footer>
    
  </foooter>
</body>

</html>