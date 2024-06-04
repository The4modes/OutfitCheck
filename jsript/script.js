function validateLogin() {
  let login = document.forms["login"]["username"].value;
    if (login.trim().length<1) {
    alert("Skriv in ditt användarnamn");
    return false;
  }
  let psw = document.forms["login"]["password"].value;
  if (psw.trim().length<1) {
    alert("Skriv in ditt lösenord");
    return false;
  }
}


    function validateEmail(email){
      if(email.lastIndexOf(".") > email.indexOf("@") + 2 && email.indexOf("@") > 0 && email.length - email.lastIndexOf(".") >2 ){
          return true;
      }
      else
          return false;
  }

  function validateReg() {
    let x = document.forms["signup-form-container"]["username"].value;
    if (x.trim().length < 4) {
      alert("Användarnamnet måste vara minst 4 tecken långt.");
      return false;
    }
    let y = document.forms["signup-form-container"]["email"].value;
    if (!validateEmail(y)) {
      alert("Fyll i din email");
      return false;
    }
    let z = document.forms["signup-form-container"]["password"].value;
    if (!validatePassword(z)) {
      alert("Lösenordet måste vara minst 6 tecken samt innehålla minst en liten bokstav, en stor bokstav och en siffra.");
      return false;
    }
    return true;
  }

  function validatePassword(password) 
{ 
var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}$/;
if(password.match(passw)){
  return true
}
else {
  return false
}
}
    function validateEmail(email){
      if(email.lastIndexOf(".") > email.indexOf("@") + 2 && email.indexOf("@") > 0 && email.length - email.lastIndexOf(".") >2 ){
          return true;
      }
      else
          return false;
  }