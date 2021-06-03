<?php
require('vendor/autoload.php');
require('db.php');
require('se.php');

$sqsdb = new sqsModel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Dotenv\Dotenv;
// use Symfony\Component\RateLimiter\RateLimiterFactory;

$dotenv = new Dotenv();
$dotenv->load('.env');

$request = Request::createFromGlobals();
$response = new Response();
$session = new Session(new NativeSessionStorage(), new AttributeBag());

$response->headers->set('Content-Type', 'application/json');
$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->headers->set('Access-Control-Allow-Origin', 'https://lit-sea-18183.herokuapp.com/');
$response->headers->set('Access-Control-Allow-Credentials', 'true');

$session->start();


if(!$session->has('sessionObj')) {
    $session->set('sessionObj', new sqsSession);
}     

  // Rate limit Web Service to one request per second per user session 
  if($session->get('sessionObj')->is_rate_limited() == false) {
    $response->setStatusCode(429);
}

// Limit per session request to 1,000 in a 24hour period 
if($session->get('sessionObj')->is_session_limited() == false) {
    $response->setStatusCode(429);
}




// domain lock
if(strpos($request->headers->get('referer'),'lit-sea-18183.herokuapp.com')){

   
        if($request->getMethod() == 'POST') {   

        //*****************************************************
        //1. Login part starts(POST)
        //*****************************************************
            if($request->query->getAlpha('action') == 'loginmatch') {
                    

            if(empty($request->request->get('login_username'))||empty($request->request->get('login_password'))) {
                echo('empty values');
                $response->setStatusCode(418);
                }else{
                    
                    $res = $sqsdb->loginAccount($request->request->get('login_username'),
                        $request->request->get('login_password'));

                        if($res == false) {
                            echo('res false1'); 
                            $response->setStatusCode(400);
                        } else{
                            
                            $response->setContent(json_encode($res));
                            $session->get('sessionObj')->login($res, $request->getClientIp(),$session->getId());
                            $response->setStatusCode(200);
                        }

                        } 
            
            }

            //*****************************************************
            // Login part ends
            //*****************************************************

            //****************************************************
            //2. Register part1 check & create user info starts(POST)
            //******************************************************

            elseif($request->query->getAlpha('action') == 'checkaccount') {

                if(empty($request->request->get('username_register'))||empty($request->request->get('password_register'))||empty($request->request->get('repassword_register'))) {
                    $response->setStatusCode(418);
                }else{
                            $res = $sqsdb->checkUser($request->request->get('username_register'),
                            $request->request->get('password_register'));
            
                            // $session_id = $session->getId();
                            //  print_r($session_id);
                                if($res == false) {
                                    // user exists
                                    echo ('passing value is fail');
                                    $response->setStatusCode(401);
                                } else {
                                    // if user doesn't exist, create new user & save data in the sessin
                                    
                                    // $response->setContent(json_encode($res));
                                    $session->get('sessionObj')->register($res, $request->getClientIp(), $session->getId());
                                    $response->setStatusCode(200);
                                
                                }
                            
                    
                }                                       
            }

            //*********************************************
            // Register part1 check & create user info ends
            //*********************************************
            //***************************************************
            //3. Register part2 Creating category list starts(POST)
            //***************************************************

            elseif($request->query->getAlpha('action') == 'createcate') {

                if(!empty($request->request->get('categories'))){
                    // if($request->request->get('categories')){
                        $res = $sqsdb->creteList($request->request->get('categories'),
                        $session->get('sessionObj')->returnUser());
                        
                        if($res == false) {
                            $response->setStatusCode(400);
                        } else {
            
                            $response->setStatusCode(200);
                           
                        }
    
                    } else {
                    $response->setStatusCode(400);
                }    
            }

            //**********************************************
            // Register part2 Creating category list ends 
            //*********************************************
            //********************************************
            //4. Update user category list starts (POST)
            //********************************************

            elseif($request->query->getAlpha('action') == 'updatecat') {
        

                // if($request->request->get('ud_categories')){
                if(empty($request->request->get('ud_categories'))){
                        $response->setStatusCode(400);
                 
                  } else{
                    $res = $sqsdb->updateCatList(
                        $session->get('sessionObj')->returnUser(),
                        $request->request->get('ud_categories'));
    
                        
                        if($res == false) {
                            // Updating category list fail
                            $response->setStatusCode(400);
                        } else {
                            $session->get('sessionObj')->updatelist($res);
                            $response->setStatusCode(200);
                            $response->setContent(json_encode($res));
                        }
                } 
                
                
             }
            
            //********************************************
            // Update user category list ends 
            //********************************************

        
        }
            
        elseif($request->getMethod() == 'GET') {  

            //**********************************************
            //1. Displaying products by category list starts(GET)
            //***********************************************
            if($request->query->getAlpha('action') == 'showproduct') {
        
                $res = $sqsdb->showProducts($session->get('sessionObj')->returnUser());
                
                if ($res == false) {
                    echo('something wrong with sql');
                    $response->setStatusCode(401);
                } else {
                   $response->setContent(json_encode($res));
                   $response->setStatusCode(200);
                }
            }

            //***************************************** 
            // Displaying products by category list ends
            //******************************************

            //**********************************************
            //2. Calling category list created starts(GET)
            //***********************************************
            
            elseif($request->query->getAlpha('action') == 'callcatlist') {

                $res = $sqsdb->callCatlist($session->get('sessionObj')->returnUser());
                 
                if($res == false) {
                   
                    $response->setStatusCode(400);
                } else {
                    $response->setContent(json_encode($res));
                    $response->setStatusCode(200);
                }
            
            }

            //************************************
            // Calling category list created ends
            //************************************

            //**********************************
            //3.  Checking loggedin starts(GET)
            //**********************************

            elseif ($request->query->getAlpha('action')=='isLoggedin'){
                $check = $session->get('sessionObj')->isLoggedIn();

                if ($check == true) {
                  
                    $response->setStatusCode(200);
                }  else {
                    $response->setStatusCode(401);   
                }  
            }    

            
            //**********************************
            // checking loggedin ends
            //**********************************

            
            //**********************************
            //4. Logout starts(GET)
            //**********************************

            elseif($request->query->getAlpha('action') == 'logout') {
                $session->clear();
                $session->invalidate();
                $response->setStatusCode(200);  
            }

            //**********************************
            // Logout ends
            //**********************************
        }

}else{
    echo "unauthrised request";
    $response->setStatusCode(401);  
}

$response->send();

?>
