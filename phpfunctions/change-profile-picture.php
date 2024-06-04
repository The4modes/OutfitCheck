<?php
  session_start();


  if(isset($_SESSION["UserId"])){
    $userId = $_SESSION["UserId"];
    $image = $_FILES["file"];

    if($image['error'] === UPLOAD_ERR_OK && $image['size'] > 0){
      $fileTmpPath = $image['tmp_name'];
      $imageContent = file_get_contents($fileTmpPath);


      $sql = "UPDATE User
      SET ProfilePicture = :ProfilePicture
      WHERE Id = '$userId'";

      $db = new SQLite3("../db/outfitCheck.db");

      $stmt = $db->prepare($sql);
      $stmt->bindParam(":ProfilePicture", $imageContent, SQLITE3_BLOB);
  
      $stmt->execute();

      $db->close();
    }
    
  }
?>