<?php

  session_start();

  $place_id = $_POST["place_id"];

  $db = new SQLite3("../db/outfitCheck.db");

  // if(isset($_SESSION["UserId"])){
  //   $user_id = $_SESSION["UserId"];
  //   $sql = "SELECT Role
  //   FROM User
  //   WHERE Id = '$user_id' AND ROLE = 'admin'";

  //   $result = $db->query($sql);
  //   if($row = $result->fetchArray()){
  //     $role = $row["Role"];
  //   }
  // }


  $sql = "SELECT * FROM Location WHERE PlaceId = '$place_id'";

  

  $result = $db->query($sql);

  $row = $result->fetchArray(SQLITE3_ASSOC);

  if($row){
    echo '<div class="mainpage-header-container">
    <div>
      <header>'. $row["LocationName"] .", ".$row["LocationCountry"] .'</header>
    </div>
  </div>';
  }


  $sql = "
  SELECT Post.Id, User.Username, Post.ImagePath, User.ProfilePicture, Post.Temperature, Post.Title
  FROM Post
  INNER JOIN User ON User.Id = Post.UserId
  WHERE LocationId = '$place_id'
  ORDER BY Post.Id DESC";

  $postsDB = $db->query($sql);

  $posts = '<div class="posts-container">';

  while ($row = $postsDB->fetchArray(SQLITE3_ASSOC)) {
    $postid = $row["Id"];
    $username = $row["Username"];
    $imagePath = $row["ImagePath"];
    $profileImagePath = $row["ProfilePicture"];
    $temperature = $row["Temperature"];
    $caption = $row["Title"];
    $posts = $posts . 
    '<div class="post-container">
        <div class="post-top-container">
          <div class="post-profile">
            <div class="post-profile-picture-container">';
    
    if($profileImagePath != null){
      $posts = $posts . '<img class="profile-picture" src="data:image/jpeg;base64,'. base64_encode($profileImagePath) .'">';
    }
    else{
      $posts = $posts . '<img class="post-profile-picture" src="./img/DALL·E 2023-04-07 16.48.17 - a bearded man that seems inviting in D&D style, _oil panting_.png">';
    }
    
    $posts = $posts . '</div>
            <p class="post-profile-username">' . $username . '</p>
          </div>
          <div class="temperature-container"><p class="temperature-p">'. $temperature .'°C</p></div>
        </div>';

    if(isset($_SESSION["Role"])){
      if($_SESSION["Role"] == "admin"){
        $posts = $posts . '<div class="remove-post" id='.$postid.'>X</div>';
      }
    }

    $posts = $posts . '<div class="post-title">
          <p>'. $caption .'</p>
        </div>
        
        <div class="post-image-container">
         <img class="post-image" src="data:image/jpeg;base64,'. base64_encode($imagePath).'">
        </div>
      </div>';

    
  }
  $posts = $posts . '</div>';

  echo $posts;

  $db->close();
?>