<?php
  session_start();
  if(isset($_SESSION["UserId"])){
    $userId = $_SESSION["UserId"];
    $sql = "SELECT ProfilePicture 
      FROM User
      WHERE Id = '$userId' AND ProfilePicture NOT NULL";

    $db = new SQLite3("../db/outfitCheck.db");

    $profilePictureDB = $db->query($sql);

    if($row = $profilePictureDB->fetchArray()){
      $image = $row["ProfilePicture"];
      echo '<img class="profile-picture" src="data:image/jpeg/png;base64,'. base64_encode($image) .'">';
    }
    else{
      echo  '<img class="profile-picture" src="./img/DALL·E 2023-04-07 16.48.17 - a bearded man that seems inviting in D&D style, _oil panting_.png">';
    }
    $db->close();
  }

  

?>