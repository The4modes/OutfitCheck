<?php
  session_start();
  $UserId = $_SESSION["UserId"];


  $sql = "SELECT Username, UserId1
  FROM FriendConnection AS FC
  INNER JOIN User AS u ON u.Id = FC.UserId1
  WHERE FC.UserId2 = '$UserId' AND FC.Status = 'PENDING'";

  $db = new SQLite3("../db/outfitCheck.db");

  $result = $db->query($sql);

  
  // var_dump($rows);
  while ($row = $result->fetchArray()) {
    echo '<div class="request">
    <p class="profile-name">'. $row["Username"] .'</p>
    <div class="request-choice-container" id="'. $row["UserId1"] .'">
      <img class="green-checks-img" src="./ico/greencheck.png"> 
      <img class="red-checks-img" src="./ico/redcross.png"> 
    </div>
    </div>';
  }

  $db->close();
?>