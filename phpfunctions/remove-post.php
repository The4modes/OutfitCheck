<?php
  session_start();

  if($_SESSION["Role"] == "admin"){
    $postId = $_POST["postId"];

    $sql = "DELETE FROM Post
    WHERE Id = '$postId'";

    $db = new SQLite3("../db/outfitCheck.db");

    $db->exec($sql);
    $db->close();
    echo "deleted post";
  }
  else{
    echo "hej";
  }
?>