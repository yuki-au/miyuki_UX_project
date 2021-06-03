document.getElementById('loginform').addEventListener('submit', function(e) {fetchlogin(e)});
document.getElementById('registerform').addEventListener('submit', function(e) {registerCheck(e)});
document.getElementById('categoryform').addEventListener('submit', function(e) {categoryList(e)});
document.getElementById('update_cat_form').addEventListener('submit', function(e) {updateCatList(e)});
document.getElementById('link_catlist').addEventListener('click', function(e) {goCatlist(e)});
document.getElementById('modal_content').addEventListener('submit', function(e) {showProductinfo(e)});
document.getElementById('update_cat').addEventListener('click', function(e) {showProductinfo(e)});
document.getElementById('back_home').addEventListener('click', function(e) {showProductinfo(e)});
document.getElementById('logoutbutton').addEventListener('click', function(e) {fetchlogout(e)});



//*****************************************************
//1.  Login part starts(POST) 
//*****************************************************
function fetchlogin(evt) {
    evt.preventDefault();
    var fd = new FormData(loginform);
    var p_name="";

    fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=loginmatch',
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function (headers) {
        if (headers.status == 400) {
            alert("Invalid username or password");
            return;
        }else if (headers.status == 200) {
             
            return fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=showproduct', 
                {
                    method: 'GET',
                    credentials: 'include'
                })
                .then(function (headers) {
                    if (headers.status == 401) {
                        alert('Can not receive your category information');
                        return;
                    }else if (headers.status == 200) {

                        
                        document.getElementById('signin_content').setAttribute("hidden", "hidden");
                        document.getElementById('shopping_screen').removeAttribute("hidden");
                      
                        headers.json().then(function(body){
                            
                            body.forEach((item) => {

                                p_name +=  '<div class="col-xs-2">'
                                           +"<a>"+'<img src='+ '"'+item.productImg +'"'+'alt='+item.productName+">"+"</a>"
                                           +'<h4 class="card-title">' + item.productName +"</h4>" 
                                           +'<p class="card-text">' + item.productPrice + "</p>"
                                           +"</div>";
                               
                            })
                            
                            
                            product_info.innerHTML = p_name;
                            
                            })
                        }   
                    })
                 }
            })
            .catch(error => console.log(error));
            }


        

//*****************************************************
// Login part ends
//*****************************************************

//*****************************************************
//2.  Register part1 check & create user info starts(POST)
//*****************************************************
    function registerCheck(evt) {
    evt.preventDefault();

    var fd = new FormData(registerform);
    fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=checkaccount',
    {
        method: 'POST',
        body: fd,
        credentials: 'include'
    })
    .then(function (headers) {
        if (headers.status == 401) {
           
            alert("your username already exist");
            return;
        }else if (headers.status == 200) {
            // user does not exist
           
            console.log('you return 200!!!');
            document.getElementById('register_content').setAttribute("hidden", "hidden");
            document.getElementById('reg_category').removeAttribute("hidden");
            return;
        }
    })
    .catch(error => console.log(error));
        }

    //**********************************************
    // Register part1 check & create user info ends
    //**********************************************
   //***************************************************
    //3. Register part2 Creating category list starts(POST)
    //***************************************************
     
    function categoryList(evt){
    evt.preventDefault();
    var categories = document.querySelectorAll('input[name="cat[]"]:checked');
    var items = Array();
    
    categories.forEach(item => items.push(item.value));
   

    var fd = new FormData();
    fd.append('categories', items);
    fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=createcate',
    {
        method: 'POST',
        body:fd,
        credentials: 'include'
    })
    .then(function (headers) {
             if (headers.status == 400) {
                alert('Error Please try it again');
                localStorage.removeItem('cat_item');
                 return;
               }else if (headers.status == 200) {
               
                localStorage.setItem('cat_item', JSON.stringify(items));
                document.getElementById('modal_user').removeAttribute("hidden");
                document.getElementById('modal_number').innerHTML = items.length;
                return;
                 }
              })
    }

   //**********************************************
   // Register part2 Creating category list ends 
   //*********************************************
  
  //********************************************
  //4. Update user category list starts (POST)
  //********************************************

    function updateCatList(evt) {
        evt.preventDefault();
        var categories = document.querySelectorAll('input[name="cat2[]"]:checked');
        var items = Array();
        categories.forEach(item => items.push(item.value));
        var fd = new FormData();
        fd.append('ud_categories', items);

        fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=updatecat', 
        {
            method: 'POST',
            body: fd,
            credentials: 'include'            
        })
        .then(function (headers) {
            if (headers.status == 400) {
               alert('Error Please try it again');
                return;
              }else if (headers.status == 200) {
               document.getElementById('modal_user2').removeAttribute("hidden");
               return;
                }
             })
   }

  //********************************************
  // Update user category list ends 
  //********************************************


        // ↑ ↑ ↑  POST Method  ↑ ↑ ↑
       // ↓ ↓ ↓  Get Method ↓ ↓ ↓

    //****************************************************
    //1.  Displaying products by category list starts(GET)
    //*****************************************************

    function showProductinfo(evt) {
        evt.preventDefault();
        var icon = document.getElementById('svgimage');
        var p_name="";
        fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=showproduct', 
        {
            method: 'GET',
            credentials: 'include'
        })
        .then(function (headers) {
            if (headers.status == 401) {
                alert('Error');
                localStorage.removeItem('theme');
                localStorage.removeItem('proname');
                return;
            }else if (headers.status == 200) {
            
                document.getElementById('modal_user').setAttribute("hidden", "hidden");
                document.getElementById('reg_category').setAttribute("hidden", "hidden");
                document.getElementById('shopping_screen').removeAttribute("hidden");
                document.getElementById('categylist').setAttribute("hidden", "hidden");

                headers.json().then(function(body){

                            
                    body.forEach((item) => {

                        p_name +=  '<div class="col-xs-2">'
                                   +"<a>"+'<img src='+ '"'+item.productImg +'"'+'alt='+item.productName+">"+"</a>"
                                    +'<h4 class="card-title">' + item.productName +"</h4>" 
                                    +'<p class="card-text">' + item.productPrice + "</p>"
                                   +"</div>";

                        
                       
                    })
   
                    localStorage.setItem('theme', icon.className);
                    localStorage.setItem('proname',JSON.stringify(body));
                   
                    product_info.innerHTML = p_name;
                    
                    })

                }
            })
            
    }

    //*******************************************
    // Displaying products by category list ends
    //*******************************************
    //*************************************
    //2. Calling category list that already created(GET)
    //************************************

  function goCatlist(evt) {
    evt.preventDefault();
    fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=callcatlist', 
    {     
        method: 'GET',
        credentials: 'include'
    })
    .then(function (headers) {
        if (headers.status == 400) {
           alert('Error');
            return;
        }else if (headers.status == 200) {
    
            var cat1 = document.getElementById("check1");
            var cat2 = document.getElementById("check2");
            var cat3 = document.getElementById("check3");
            var cat4 = document.getElementById("check4");
            var cat5 = document.getElementById("check5");
            var cat6 = document.getElementById("check6");
            var cat7 = document.getElementById("check7");
            var cat8 = document.getElementById("check8");
            
            
            document.getElementById('categylist').removeAttribute("hidden");
            document.getElementById('shopping_screen').setAttribute("hidden", "hidden");
            document.getElementById('modal_user2').setAttribute("hidden", "hidden");

              headers.json().then(function(body){
                
            // ↓ To call checked category lists 
                for(var i = 0; i < body.length; i++){
                
                        if(body[i].categoryID == 1){
                                cat1.setAttribute("checked", true);
                             }
    
                        if(body[i].categoryID ==2){
                                cat2.setAttribute("checked", true);
                             }
    
                             if(body[i].categoryID == 3){
                                cat3.setAttribute("checked", true);
                             }
    
                             if(body[i].categoryID ==  4){
                                cat4.setAttribute("checked", true);
                             }
    
                             if(body[i].categoryID ==  5){
                                cat5.setAttribute("checked", true);
                             }

                             if(body[i].categoryID ==  6){
                                cat6.setAttribute("checked", true);
                             }
    
                             if(body[i].categoryID == 7){
                                cat7.setAttribute("checked", true);
                             }
    
                             if(body[i].categoryID ==  8){
                                cat8.setAttribute("checked", true);   
                             }
                }
               
                 })
                 
             
            }
        })
}

    //*******************************************
    // Displaying products by category list ends
    //*******************************************
 
    //**********************************
    //3. checking loggedin starts(GET)
    //**********************************
    window.addEventListener('DOMContentLoaded', function(evt) {
    evt.preventDefault();
    fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=isLoggedin', 
    {
        method: 'GET',
        credentials: 'include'
    })
    .then(function(headers) {

        if(headers.status == 401) {
            localStorage.removeItem('cat_item');
            localStorage.removeItem('theme');
            localStorage.removeItem('proname');
                

            document.getElementById('signin_content').removeAttribute("hidden");
            document.getElementById('register_content').setAttribute("hidden", "hidden");
            document.getElementById('reg_category').setAttribute("hidden", "hidden");
            document.getElementById('modal_user').setAttribute("hidden", "hidden");
            document.getElementById('shopping_screen').setAttribute("hidden", "hidden");
            document.getElementById('categylist').setAttribute("hidden", "hidden");
            return;
            
        }else if (headers.status == 200) {
            console.log('loggedin');
            return;
                }
    })
    .catch(error => console.log(error));
})

    //**********************************
    // checking loggedin ends
    //**********************************

    //**********************************
    // 4. Logout starts(GET)
    //**********************************

    function fetchlogout(evt) {
    evt.preventDefault();
    fetch('https://lit-sea-18183.herokuapp.com/api/api.php?action=logout',
        {
            method: 'GET',
            credentials: 'include'
        })
        .then(function (headers) {
            if(headers.status == 200) {
                document.getElementById('signin_content').removeAttribute("hidden");
                document.getElementById('register_content').setAttribute("hidden", "hidden");
                document.getElementById('reg_category').setAttribute("hidden", "hidden");
                document.getElementById('modal_user').setAttribute("hidden", "hidden");
                document.getElementById('shopping_screen').setAttribute("hidden", "hidden");
                document.getElementById('categylist').setAttribute("hidden", "hidden");

                localStorage.removeItem('cat_item');
                localStorage.removeItem('theme');
                localStorage.removeItem('proname');
  
                return;
            }
        })
        .catch(error => console.log(error));
}
    //**********************************
    // Logout ends
    //**********************************

    //**********************************************************
    //Managing Product information starts(GET) still developping
    //***********************************************************   

    // function getOrdersinfo(evt) {
    //     evt.preventDefault();
    //     fetch('http://localhost/match/api/api.php?action=getOrdersForUser', 
    //     {
    //         method: 'GET',
    //         credentials: 'include'
    //     })
    //     .then(function (headers) {
    //         if (headers.status == 400) {
    //         alert('Error');
    //             return;
    //         }else if (headers.status == 200) {
         
    //         return;
    //             }
    //         })
    // }

    //*************************************
    // Managing Product information ends 
    //************************************* 
