<?php
    class sqsAdminSession {
        // attributes will be stored in session, but always test incognito
      
        private $origin;
        
        // private $last_visits = Array();
        

        public function __construct() {
            $this->origin = getenv('ORIGIN');  
        }


       
    }
?>
