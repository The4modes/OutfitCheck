<?php
  session_start();
  header("Access-Control-Allow-Origin: index.html");
  if(!isset($_SESSION["UserId"])){
    header("Location: inlogg.html");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Styles/style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <title>Document</title>
  <script>
    $(document).ready(function(){
      $.post("./phpfunctions/update-friend-requests.php",{},
      function(data){
        // console.log("hej");
        $("#pending-requests-container").html(data);
      });

      $(".mainpage-container").on("click", ".remove-post", function(){
        var id = $(this).attr('id');

        console.log(id);

        if(confirm("Are you sure you want to delete the post?")){
          $.post("./phpfunctions/remove-post.php", {
          postId: id
          }, function(data){
            console.log(data);
          });

          location.reload();
        }
        
      })

      $("#change-profile-picture").on("click", function(){
        $("#darken-body").css("z-index", "9");
        $("#change-profile-picture-upload").css("z-index", "10")
      })

      $("#darken-body").on("click", function(){
        $("#darken-body").css("z-index", "-10");
        $("#change-profile-picture-upload").css("z-index", "-10")
      })

      $("#upload-profile-picture").on("submit", function(submit){
        submit.preventDefault();

        // console.log("hej");
          var form_data = new FormData(this);

          $.ajax({
            url: './phpfunctions/change-profile-picture.php', // <-- point to server-side PHP script 
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'POST',
            success: function(){
              location.reload(true);
            }
          });

          $("#darken-body").css("z-index", "-10");
          $("#change-profile-picture-upload").css("z-index", "-10");
      });



      $.post("./phpfunctions/profile-picture.php", function(data){
        // console.log(data);
        $(".profile-picture-container").html(data);
      });

      $("#location-feed").on("click", function(){
        $.post("./phpfunctions/update-mainpage.php", {
          place_id: "ChIJjasyhfvLX0YRBwiChQrpT6o"
        }, function(data){
          $(".mainpage-container").html(data);
        })
      });

      $("#friends-feed").on("click", function(){
        $.post("./phpfunctions/friend_feed.php", function(data){
          $(".mainpage-container").html(data);
        })
      });
      
      $("#sign-out").on("click", function(){
       
        $.post("./phpfunctions/destroy.php",{});
        window.location = "inlogg.html";
      })

      $("#addfriend").keyup(function(){
        var searchQuery = $("#addfriend").val();
        console.log(searchQuery);

        $.post("./phpfunctions/searchfriend.php", {
          searchQuery: searchQuery
        }, function(data){
          $("#friend-suggestions").html(data);

          if (!$("#friend-suggestions").html()) {
            // console.log("test");
            $("#addfriend").css("border-bottom-left-radius", "12px");
            $("#addfriend").css("border-bottom-right-radius", "12px");
          }
          else{
            // console.log("test");
            $("#addfriend").css("border-bottom-left-radius", "0px");
            $("#addfriend").css("border-bottom-right-radius", "0px");
          }
        });
      });

      //Startar här
      $("#friend-suggestions").on("click", ".suggestion", function(event){

        $("#friend-suggestions").html("");
        $("#addfriend").css("border-bottom-left-radius", "12px");
        $("#addfriend").css("border-bottom-right-radius", "12px");

        var id = event.target.closest('div').id;

        $("#addfriend").val("");
        $.post("./phpfunctions/addfriend.php", {
        UserId: id
        });
      });

      $("#pending-requests-container").on("click", ".green-checks-img", function(event){

        var id = event.target.closest('div').id;

        $.post("./phpfunctions/changeStatus.php", {
        UserId: id,
        choice: "APPROVED"
        });

        location.reload(true);
      });

      $("#pending-requests-container").on("click", ".red-checks-img", function(event){

        var id = event.target.closest('div').id;

        $.post("./phpfunctions/changeStatus.php", {
        UserId: id,
        choice: "DECLINED"
        });

        location.reload(true);
        
      });

      //Slutar här


      $(".mainpage-container").ready(function(){

        $.post("./phpfunctions/update-mainpage.php", {
          place_id: "ChIJjasyhfvLX0YRBwiChQrpT6o"
        } ,function(data, status){
          $(".mainpage-container").html(data);
        });
      });

      //#region LocationSearch
      $("#location-suggestions").on("click", ".suggestion", function(event){

        $("#location-suggestions").html("");
        $("#location-search-input").css("border-bottom-left-radius", "12px");
        $("#location-search-input").css("border-bottom-right-radius", "12px");

        var id = event.target.closest('div').id;
        
        $.post("./phpfunctions/update-mainpage.php", {
        place_id: id
        } ,function(data, status){
          $(".mainpage-container").html(data);
        });
      });
      
      $("#location-search-input").keyup(function(){
        var locationString = $("#location-search-input").val();
        // console.log("hej");
        $.post("./phpfunctions/suggestions.php", {
          suggestion: locationString
        }, function(data, status){
          $("#location-suggestions").html(data);

          if (!$("#location-suggestions").html()) {
            // console.log("test");
            $("#location-search-input").css("border-bottom-left-radius", "12px");
            $("#location-search-input").css("border-bottom-right-radius", "12px");
          }
          else{
            // console.log("test");
            $("#location-search-input").css("border-bottom-left-radius", "0px");
            $("#location-search-input").css("border-bottom-right-radius", "0px");
          }
        });
      });

      $("#place-search-form").on("submit", function(submit){
        submit.preventDefault();
        
        var locationString = $("#location-search-input").val();

        $.post("./phpfunctions/getlocation.php", {
          searchQuery: locationString
        }, function(data, status){
          $("#location-suggestions").html(data);

          if (!$("#location-suggestions").html()) {
            // console.log("test");
            $("#location-search-input").css("border-bottom-left-radius", "12px");
            $("#location-search-input").css("border-bottom-right-radius", "12px");
          }
          else{
            console.log("test");
            $("#location-search-input").css("border-bottom-left-radius", "0px");
            $("#location-search-input").css("border-bottom-right-radius", "0px");
          }
        });
      });
//#endregion

      $("#upload-suggestions").on("click", ".suggestion", function(event){

        $("#upload-suggestions").html("");
        $("#upload-location-search-input").css("border-bottom-left-radius", "12px");
        $("#upload-location-search-input").css("border-bottom-right-radius", "12px");

        var id = event.target.closest('div').id;
        var para = event.target.closest('div').firstElementChild;

        var text = $(para).html();
        // console.log(para);
        $("#upload-location-search-input").val(text);

        $.post("./phpfunctions/update_session.php", {
          place_id: id
        })
      });

      $("#upload-form").on("submit", function(submit){
          submit.preventDefault();
          
          var file_data = $('#upload-file').prop('files')[0];
          var caption = $("#post-content").val();
          
          console.log(caption);
          if(file_data && caption) {
            var form_data = new FormData(this);                  
            // form_data.append('file', file_data);
            // form_data.append('post', caption);
            // alert(form_data); 
  
            $.ajax({
              url: './phpfunctions/uploadImage.php', // <-- point to server-side PHP script 
              dataType: 'text',  // <-- what to expect back from the PHP script, if anything
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,                         
              type: 'POST',
              success: function(data){
                alert(data);
                location.reload(true);
              }
            });
            
          }
        });

      $("#upload-location-search-input").keyup(function(){
        var locationString = $("#upload-location-search-input").val();
        
        $.post("./phpfunctions/suggestions.php", {
          suggestion: locationString
        }, function(data, status){
          $("#upload-suggestions").html(data);

          if (!$("#upload-suggestions").html()) {
            // console.log("test");
            $("#upload-location-search-input").css("border-bottom-left-radius", "12px");
            $("#upload-location-search-input").css("border-bottom-right-radius", "12px");
          }
          else{
            // console.log("test");
            $("#upload-location-search-input").css("border-bottom-left-radius", "0px");
            $("#upload-location-search-input").css("border-bottom-right-radius", "0px");
          }
        });
      });
    });
  </script>
</head>
<body>
  <div id="darken-body"></div>
  <div id="change-profile-picture-upload">
        <form action="" method="post" id="upload-profile-picture" enctype="form-data">
          <label id="change-picture-label">Change Profile Picture</label>
          <input type="file" name="file" id="change-picture">
          <input type="submit">
        </form>
  </div>
  <div class="leftside-container">
    <div class="leftside-header-container">
      <h1 id="Logo">OutfitCheck</h1>
    </div>
    <div class="leftside-divider-container">
      <div class="leftside-divider"></div>
    </div>
    <div class="navigation-container">
      <ul class="navigation-items">
        <li id="location-feed"><p>Locations</p></li>
        <li id="friends-feed"><p>Friends</p></li>
      </ul>
    </div>
    <div class="leftside-divider-container">
      <div class="leftside-divider"></div>
    </div>
    <div class="add-friend-container">
      <input type="text" name="addfriend" id="addfriend" placeholder="Add Friends">
      <div class="suggestions" id="friend-suggestions">
      </div>
    </div>
    <div class="leftside-divider-container">
      <div class="leftside-divider"></div>
    </div>
    <div class="friend-requests-container">
      <div class="request-header-container">
        <h2>Friend Requests</h2>
      </div>
      <div class="pending-requests-container" id="pending-requests-container">
      </div>
    </div>
    <div class="profile-container">
      <div class="profile-name"><p>
        <?php 
          echo $_SESSION["Username"];
        ?>
    </p>
  </div>
      <div class="profile-picture-container">
        
      </div>
    </div>
    <div id="handle-profile-container">
      <div id="sign-out">Sign Out</div>
      <div id="change-profile-picture">
        Change Picture
      </div>
    </div>
  </div>
  <div class="mainpage-container">
    
  </div>
  <div class="rightside-container">
    <div class="location-search-container">
      <div class="suggestions" id="location-suggestions"></div>
      <form id="place-search-form" action="" method="post">
        <input class="location-search-input" id="location-search-input" type="text" name="location-search" placeholder="Location">
      </form>
    </div>
    <div class="rightside-middle-container"></div>
    <div class="upload-post-container">
      <div class="upload-header-container">
        <h2>Upload</h2>
      </div>
      <div class="upload-form-container">
        <form action="" method="post" id="upload-form" enctype="multipart/form-data">
          <input class="location-search-input" id="upload-location-search-input" type="text" name="location-search" placeholder="Location">
          <div class="suggestions" id="upload-suggestions">
          </div>
          <input type="text" name="post-content" id="post-content" placeholder="Caption" maxlength="45">
          <input type="file" name="file" id="upload-file">
          <input type="submit">
        </form>
      </div>
      
    </div>
  </div>
</body>
</html>