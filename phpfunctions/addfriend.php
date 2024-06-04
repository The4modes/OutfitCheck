<?php
  session_start();

  $loggedInUserId = $_SESSION["UserId"];
  $friendToAddId = $_POST["UserId"];

  $sql = "SELECT * FROM User WHERE ID = '$friendToAddId'";
  $connectionSQL = "SELECT * 
  FROM FriendConnection 
  WHERE (UserId1 = '$loggedInUserId' AND UserId2 = '$friendToAddId') OR (UserId1 = '$friendToAddId' AND UserId2 = '$loggedInUserId')";

  // echo $sql;
  $db = new SQLite3("../db/outfitCheck.db");

  $result = $db->query($sql);
  $result2 = $db->query($connectionSQL);

  if($row = $result->fetchArray() && !$result2->fetchArray()){
    $sql = "INSERT INTO FriendConnection (UserId1, UserId2, Status) VALUES (:UserId1, :UserId2, :Status)";

    $status = "PENDING";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':UserId1', $loggedInUserId);
    $stmt->bindParam(':UserId2', $friendToAddId);
    $stmt->bindParam(':Status', $status);
    $stmt->execute(); 
    
  }
  else{
    echo "No User found";
  }
  $db->close();
?>