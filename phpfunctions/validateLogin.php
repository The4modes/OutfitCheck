<?php
  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM User WHERE Email = '$email'";

  // echo $sql;
  $db = new SQLite3("../db/outfitCheck.db");

  $result = $db->query($sql);

  if($row = $result->fetchArray()){
    if($row["Email"] == $email && password_verify($password ,$row["Password"]) ){
      echo "success";

      session_start();
      session_regenerate_id();
      $_SESSION["UserId"] = $row["Id"];
      $_SESSION["Username"] = $row["Username"];
      $_SESSION["Role"] = $row["Role"];
    }
    else if($row){
      echo "wrong password";
    }
  }
  else{
    echo "No email found";
  }
  $db->close();
?>