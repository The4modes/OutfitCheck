<?php
  session_start();
  $loggedInUserId = $_SESSION["UserId"];

  $searchQuery = $_POST["searchQuery"];


  $sql = "SELECT * FROM User";

  $users = array();

  $db = new SQLite3("../db/outfitCheck.db");

  $result = $db->query($sql);

  while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    array_push($users, $row["Username"] . "%%%%" . $row["Id"]);
  }

  if(!empty($searchQuery)){
    foreach ($users as $user) {
      if(strpos(strtolower($user), strtolower( $searchQuery)) !== false){
        $userarray = explode('%%%%', $user);
        if($userarray[1] != $loggedInUserId){
          echo '<div class="suggestion" id="' . $userarray[1] . '">
            <p class="suggestion-p">'. $userarray[0] . '</p>
            </div>';
        }
      }
    }
  }

  $db->close();
?>