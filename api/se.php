<?php

    class sqsSession {

        private $user_request = 0;
        private $login_user_id = 0;

        private $count_request = 0;
        private $request_datetime = 0;


        private $user_id = 0;
        // private $l_user_id = 0;
        // private $cat_id = 0;
        private $category_id = 0;
        private $cart_id = 0;
        private $product_info = Array();

        private $user_token;
        private $row;

        private $origin;
        
        // private $last_visits = Array();
        

        public function __construct() {
            $this->origin = getenv('ORIGIN');  
        }

    // Rate limit Web Service to one request per second per user session 

    public function is_rate_limited() {

        date_default_timezone_set('Australia/Brisbane');
        $limit_time = date("d-m-Y H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 1);
        $second = date("d-m-Y H:i:s") . "." . substr(explode(".", (microtime(true)+.5. ""))[1], 0, 1);
             
        if($this->user_request == 0) {
            $this->user_request = $limit_time;
            return true;
        }

        if($this->user_request == $second) {
            $this->user_request == 0 ;
            return false;
        }                                                                                                                                                                                           
        
        return true;
        
    }





    // public function is_rate_limited() {
             
    //     if($this->user_request == 0) {
    //         $this->user_request = time(); 
    //         return true;
    //     }

    //     if($this->user_request == time()) {
    //         return false;
    //     }                                                                                                                                                                                           
        
    //     return true;
        
    // }


    // // Limit per session request to 1,000 in a 24hours period 
    public function is_session_limited() {

        if($this->count_request == 0) {
            // count_request comes from each session
            return false;
            }else{
            //  once user login, 
            // if it takes 24 hours↓
                if(date("d-m-Y H:i:s",strtotime($this->request_datetime. "+1 day"))) {
                if ($this->count_request>=500) {
                    
                    $this->count_request=0;
                    return false;
                    
                    }else{
                        $this->count_request=0;
                        return true;
                    }
                    
                    return true;
            }else{
                //　time is less than 24 hours
                return true;
            }
        }       
    }

    // public function is_session_limited() {

    //         if($this->count_request == 0) {
    //             // count_request comes from each session
    //             return false;
    //             }else{
    //             //  once user login, 
    //             // if it takes 24 hours↓
    //                 if(date("d-m-Y H:i:s",strtotime($this->request_datetime. "+1 day"))) {
    //                 if ($this->count_request>=1000) {
                        
    //                     $this->count_request=0;
    //                     return false;
                        
    //                     }else{
    //                         // less than 1000 times
    //                         $this->count_request=0;
    //                         return true;
    //                     }
                        
    //                     return true;
    //             }else{
    //                 //　time is less than 24 hours
    //                 return true;
    //             }
    //         }       
    //     }

        //*****************************************************
        // Login part starts 
        //*****************************************************
        
        public function login($u) {
            date_default_timezone_set('Australia/Brisbane');
            $this->request_datetime = date("d-m-Y H:i:s");

            $this->user_id = $u;    
            $this->count_request ++;
        }

        //*****************************************************
        // Login part ends 
        //*****************************************************
        //*****************************************************
        // Register part starts 
        //*****************************************************

        // comes from register phase
        public function register($u) {
            $this->user_id = $u;
            $this->count_request ++;   
        }
        
        // used to retrieve last user id
        public function returnUser() {
            return $this->user_id;
        }


        //*****************************************************
        // Register part ends 
        //*****************************************************
        
        //  updated catefory information
        public function updatelist($n_cat){
            $this->category_id = $n_cat; 
            $this->count_request ++;
        }

        // return updated category information

        public function returnUpdateCat() {
            return $this->category_id;
        }

         //  Add item Cart information
         public function addToCart($cart){
            $this->cart_id = $cart; 
            $this->count_request ++;
        }

        // return stored information in a cart
        public function returnCart() {
            return $this->cart_id;
        }

        //*****************************************************
        // show product info starts 
        //*****************************************************

        public function showProduct($rows) {
            return $this->product_info =$rows;
        }

        public function returnProduct() {
            return $this->product_info;
        }

        //*****************************************************
        // show product info ends 
        //*****************************************************

        public function isLoggedIn() {
            if($this->user_id == 0) {
                echo("not logged in");
                return false;
            } else {
                echo("logged in");
                return true;
            }
        }
    }
?>
