
// ******************************
//   validation form part starts
// ******************************

function fillLogForm(){
  var log_name = document.getElementById('login_username');
  var log_pass = document.getElementById("login_password");
  var log_button = document.getElementById('login');

  // username part starts
  if(log_name.value.match(/^([a-zA-Z0-9]{4,})$/)){
    document.getElementById('l_usname').innerHTML = "";
    log_name.style.border="1px solid #ced4da";
    log_button.removeAttribute("disabled");
   
  }else{
    document.getElementById('l_usname').innerHTML = "Username at least 6 digits";
    log_name.style.border="1px solid red";
    log_button.setAttribute("disabled", "disabled");
  }
  // username part ends

  // password part starts
  if(log_pass.value.match(/^([a-zA-Z0-9]{6,})$/)){
    document.getElementById('l_pass').innerHTML = "";
    log_pass.style.border="1px solid #ced4da";
    log_button.removeAttribute("disabled");
  
    }else{
      document.getElementById('l_pass').innerHTML = "Password minimum 6 digits";
      log_pass.style.border="1px solid red";
      log_button.setAttribute("disabled", "disabled");
    }
  // password part ends
  
}



  
function fillRegForm(){
  var reg_name = document.getElementById('username_register');
  var reg_pass = document.getElementById("us_pass");
  var reg_repass = document.getElementById("us_pass2");
  var reg_button = document.getElementById('register_btn');

// username part starts

if(reg_name.value =='' || reg_pass.value.match == '' || reg_repass.value == ''){

  reg_button.setAttribute("disabled", "disabled");

}else{

  var check1 = false;
  var check2 = false; 
  reg_button.setAttribute("disabled", "disabled");

  if(reg_name.value.match(/^([a-zA-Z0-9]{4,})$/)){
        document.getElementById('r_usname').innerHTML = "";
        reg_name.style.border="1px solid #ced4da";
        check1 = true;
        // reg_button.removeAttribute("disabled");

      }else{
        document.getElementById('r_usname').innerHTML = "Alphabets & numbers with minimum 6 digits";
        reg_name.style.border="1px solid red";

      }

    // username part ends 

    // password part starts
    if(reg_pass.value.match(/^([a-zA-Z0-9]{6,})$/)){
      document.getElementById('r_pass').innerHTML = "";
      reg_pass.style.border="1px solid #ced4da";
      check2 = false;
    
          if (reg_pass.value == reg_repass.value){
                check2 = true;
                document.getElementById('r_re_pass').innerHTML = "";
            }else{
                document.getElementById('r_re_pass').innerHTML = "Passwords are not matched";
            }

      }else{
        document.getElementById('r_pass').innerHTML = "Password minimum 6 digits";
        reg_pass.style.border="1px solid red";
      }
    

      if(check1 == true && check2 == true){
        reg_button.removeAttribute("disabled");

      }else{
      reg_button.setAttribute("disabled", "disabled");
      }

     
    }
}



// ******************************
//   validation form part ends
// ******************************


// ******************************
//   function for link part starts
// ******************************
  
    // for the link
    function backtoPage() {
      document.getElementById('reg_category').setAttribute("hidden", "hidden");
      document.getElementById('register_content').removeAttribute("hidden");
  }

   function goRegPage(){
    document.getElementById('signin_content').setAttribute("hidden", "hidden");
      document.getElementById('register_content').removeAttribute("hidden");
   }

   function goLogPage(){
    document.getElementById('register_content').setAttribute("hidden", "hidden");
      document.getElementById('signin_content').removeAttribute("hidden");
   }

  function searchBox(){
    var s = document.getElementById('search_hidden');
    s.value = '     ';
    var len = s.value.length;
    s.focus();
    s.setSelectionRange(len, len);
  }

// ******************************
//  function for link part ends
// ******************************

// ******************************
//  close the dropdown menu starts
// ******************************
var count = 1;

function closeMenu(){
  var element = document.getElementById('dropnav');
  if(num  % 2!==0){
    element.click() == true;
  
  
    }else{
      element.click() ==  false;
    }
    count++;
}

// ******************************
//  close the dropdown menu ends
// ******************************


// ******************************
//  night mode starts
// ******************************

var num = 1;

function iconChange() {
  var element = document.getElementById('svgimage');
  var bodyClass = document.body;

  if(num  % 2!==0){
  element.setAttribute("class", "fas fa-moon fa-2x");
  bodyClass.setAttribute("class", "dark_mode");


  }else{
    element.setAttribute("class", "fas fa-sun fa-2x");
    bodyClass.removeAttribute("class");

  }
  num++;
}

// ******************************
//  night mode ends
// ******************************

// ******************************
//  show/remove help for users
// ******************************

function showHelp() {
  document.getElementById('help_screen').removeAttribute("hidden"); 
  document.getElementById('signin_content').setAttribute("hidden", "hidden");
}

function closeImg() {
  document.getElementById('help_screen').setAttribute("hidden", "hidden");
  document.getElementById('signin_content').removeAttribute("hidden"); 
}


// ******************************
//  show/remove help for users
// ******************************