<?php
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $role = "user";

  function ValidateReg(){
    $name = trim($_POST['username']);
    $email = $_POST['email'];
    $password = trim($_POST['password']);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    if($name=="") {
        return false;
          }
    elseif(!$uppercase || !$lowercase || !$number || strlen($password) < 6)
    {
        return false;
      }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;}

      return true;
    }



  if(ValidateReg()){
    $db = new SQLite3("../db/outfitCheck.db");

  $sql = "SELECT * FROM User WHERE Email = '$email'";

  $result = $db->query($sql);

  if (!$result ->fetchArray()) {
    $sql = "INSERT INTO User (Username, Role, Email, Password) VALUES (:Username, :Role, :Email, :Password)";
    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':Username', $username);
    $stmt->bindParam(':Role', $role);
    $stmt->bindParam(':Email', $email);
    $stmt->bindParam(':Password', $password);
    $stmt->execute(); 

    echo "success";
  }
  else{
    echo "Email already exists";
  }
  $db->close();
  }
  else{
    echo "You have bypassed the client validation and one or more of Username, Email and Password is not correct format.";
  }
  
?>