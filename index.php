<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>PHP File Upload</title>
</head>
<body>
  <form method="POST" action="upload.php" enctype="multipart/form-data">
    <div>
      <input type="file" name="uploadedFile"> 
      <br>
      <input type="file" name="uploadedFile1">
    </div>
 
    <input type="submit" name="uploadBtn" value="Upload" />
  </form>
  <?php

  
  
  ?>
</body>
</html>
