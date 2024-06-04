<?php
  session_start();
  $userId1 = $_POST["UserId"];
  $choice = $_POST["choice"];
  $userId2 = $_SESSION["UserId"];
  $sql = "";

  if($choice == "APPROVED"){
    $sql = "UPDATE FriendConnection
    SET Status = 'APPROVED'
    WHERE UserId2 = '$userId2' AND UserId1 = '$userId1' AND Status = 'PENDING'";

  }else if($choice == "DECLINED"){
    $sql = "DELETE FROM FriendConnection
    WHERE UserId2 = '$userId2' AND UserId1 = '$userId1' AND Status = 'PENDING'";
  }

  if($sql != ""){
    $db = new SQLite3("../db/outfitCheck.db");

    $db->exec($sql);
    $db->close();
  }
  
?>