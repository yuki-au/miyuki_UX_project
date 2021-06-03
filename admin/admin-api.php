<?php

require('../api/vendor/autoload.php');
require('admin-db.php');
require('admin-se.php');

$sqsdb = new sqsAdminModel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();
$dotenv->load('.env');

$request = Request::createFromGlobals();
$response = new Response();
$session = new Session(new NativeSessionStorage(), new AttributeBag());

$response->headers->set('Content-Type', 'application/json');
$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->headers->set('Access-Control-Allow-Origin', 'https://evening-beach-09775.herokuapp.com');
$response->headers->set('Access-Control-Allow-Credentials', 'true');


$session->start();



if(!$session->has('sessionObj')) {
    $session->set('sessionObj', new sqsAdminSession);
}     
   
        if($request->getMethod() == 'POST') {   
          
        //*****************************************************
        //1. Admin Login part starts(POST) 
        //*****************************************************
            if($request->query->getAlpha('action') == 'adminLogin') {
                
             //   ↓ remove "" in the password
               $pass = trim($request->request->get('pass'), '""');
             //   ↓ encrypt the password
               $encoded =  password_hash($pass, PASSWORD_DEFAULT);
             
               $res = $sqsdb->loginPanel($request->request->get('name'), $encoded);

                if($res == false) {
                    echo ('res false'); 
                    $response->setStatusCode(400);
                    } else{
                    $response->setContent(json_encode($res));
                    $response->setStatusCode(200);
                    } 
                }

            //*****************************************************
            // Login part ends
            //*****************************************************

            //****************************************************
            //2.Delete product infromation(POST) from table
            //******************************************************

            elseif($request->query->getAlpha('action') == 'deletePro') {

                      echo($request->request->get('productID')); 
               
                        $res = $sqsdb->deletePro($request->request->get('productID'));

                        if($res == false) {
                            echo ('res false'); 
                            $response->setStatusCode(400);
                        } else{
                           echo('successful to delete!!');
                            $response->setStatusCode(200);
                        }
            
             }
                            
                    
                                                  
      
            //*********************************************
            // 2.Delete product infromation from table ends
            //*********************************************
            //***************************************************
            //3.Delete user infromation from table(POST)
            //***************************************************

             elseif($request->query->getAlpha('action') == 'deleteUser') {
                echo($request->request->get('userID')); 
               
                $res = $sqsdb->deleteUsers($request->request->get('userID'));

                if($res == false) {
                    echo ('res false'); 
                    $response->setStatusCode(400);
                } else{
                   echo('successful to delete!!');
                    $response->setStatusCode(200);
                }

               }
            }

            //***************************************************
            //3.Delete user infromation from table ends
            //***************************************************
            
        elseif($request->getMethod() == 'GET') {  

            //*********************************
           //1. Displaying all products(GET)
            //*********************************
            if($request->query->getAlpha('action') == 'callProduct') {
        
                $res = $sqsdb->getProducts();
                
                if ($res == false) {

                    $response->setStatusCode(400);
                } else {
                   $response->setContent(json_encode($res));
                   $response->setStatusCode(200);
                }
            }

            //*********************************
           //Displaying all products ends
            //*********************************

           //*********************************
           //2. Displaying all users(GET)
            //*********************************
            
            elseif($request->query->getAlpha('action') == 'callUser') {
        
                $res = $sqsdb->getusers();
                
                if ($res == false) {

                    $response->setStatusCode(400);
                } else {
                   $response->setContent(json_encode($res));
                   $response->setStatusCode(200);
                }
            }


            //*********************************
           // Displaying all users ends
            //*********************************

            
            //**********************************
            // Admin Logout starts(GET)
            //**********************************

            elseif($request->query->getAlpha('action') == 'adminlogout') {
                $session->clear();
                $session->invalidate();
                $response->setStatusCode(200);  
            }

            //**********************************
            // Admin Logout ends
            //**********************************
        // }

         }



$response->send();

?>
