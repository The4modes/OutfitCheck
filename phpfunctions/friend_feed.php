<?php
  session_start();

  $user_id = $_SESSION["UserId"];

  $db = new SQLite3("../db/outfitCheck.db");


  echo '<div class="mainpage-header-container">
    <div>
      <header>Friends</header>
    </div>
  </div>';

  $sql = "SELECT DISTINCT p.Id, u.Username, p.ImagePath, u.ProfilePicture, p.Temperature, p.Title
  FROM (SELECT *
  FROM Post AS p
  INNER JOIN FriendConnection AS fc ON fc.UserId1 = p.UserId
  WHERE fc.UserId2 ='$user_id' AND fc.Status = 'APPROVED'
  UNION
  SELECT *
  FROM Post AS p
  INNER JOIN FriendConnection AS fc ON fc.UserId2 = p.UserId
  WHERE fc.UserId1='$user_id' AND fc.Status = 'APPROVED' OR p.UserId = '$user_id') AS p
  INNER JOIN User AS u ON u.Id = UserId
  ORDER BY p.Id DESC";


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