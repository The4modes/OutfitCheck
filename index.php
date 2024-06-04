<?php
  session_start();
  header("Access-Control-Allow-Origin: index.html");
  if(isset($_SESSION["UserId"])){
    header("Location: mainpage.php");
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
      $(".mainpage-container").ready(function(){

        $.post("./phpfunctions/update-mainpage.php", {
          place_id: "ChIJjasyhfvLX0YRBwiChQrpT6o"
        } ,function(data, status){
          $(".mainpage-container").html(data);
        });
      });

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

      
    });
  </script>
</head>
<body>
  <div class="leftside-container">
    <div class="leftside-header-container">
      <h1 id="Logo">OutfitCheck</h1>
    </div>
    <div class="leftside-divider-container">
      <div class="leftside-divider"></div>
    </div>
    <div class="navigation-container">
      
    </div>
    <div class="leftside-divider-container">
      <div class="leftside-divider"></div>
    </div>
    
    <div class="loggin-container">
      <a id="loginurl" href="inlogg.html">Login</a>
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
  </div>
</body>
</html>