<?php


    class sqsModel {

        private $dbconn;

        public function __construct() {
            $dbURI = 'mysql:host='. 'us-cdbr-east-03.cleardb.com'.';port=3306;dbname='.'heroku_2b09551ff158f6f';
            $this->dbconn = new PDO($dbURI, 'b6605f1810869e', '7e535a4e');
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
    //*****************************************************
    // Login part starts(POST)
    //*****************************************************
    function loginAccount($u, $lp) {
        $sql = "SELECT * FROM user WHERE username = :username AND password = :pass";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindParam(':username', $u, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $lp, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($stmt->rowCount() > 0) {
                return $rows['userID']; 
            } else {
                
                return false; 
               
            }
     }               

    //*****************************************************
    // Login part ends
    //*****************************************************

    //******************************************************
    // Register part1 check & create user info starts(POST)
    //******************************************************      
     function checkUser($u,$p) {
            $sql = "SELECT * FROM user WHERE username = :username";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':username', $u, PDO::PARAM_STR);
            $stmt->execute();
            
            if($stmt->rowCount() > 0) { 
                // if user exists
                echo('use exist');
                return false;
                exit();
            } else {
                // if user doesn't exist, create user info in user db
                $sql2 = "INSERT INTO user(username, password) VALUE(:username,:password)";
                $stmt2 = $this->dbconn->prepare($sql2);
                $stmt2->bindParam(':username', $u, PDO::PARAM_STR);
                $stmt2->bindParam(':password', $p, PDO::PARAM_STR);
                $res2 = $stmt2->execute();
               
                 $user = $this->dbconn->lastInsertId(); 
                if($res2 == true) {     
                    return $user;    
                }else {
                    echo('error, last  is undifined');
                    return false;
                }
              }  
         }

    //*********************************************
   // Register part1 check & create user info ends
    //*********************************************
     //***************************************************
    // Register part2 Creating category list starts(POST)
    //***************************************************

    function creteList($c, $u) { 
        $cats = explode(",", $c);
        print_r($cats);
        print_r(gettype($cats));

        if (is_array($cats)){        
            
            for($i = 0; $i<count($cats) ; $i = $i + 1){       
            
              $sql ="INSERT INTO usercategory(categoryID, userID) VALUE(:cat,:us)";
              $stmt = $this->dbconn->prepare($sql);
              $stmt->bindParam(':cat',$cats[$i], PDO::PARAM_INT);
              $stmt->bindParam(':us',$u, PDO::PARAM_INT);
              $res=$stmt->execute();
 
                if($res == false){
                    echo('loop false');
                   return false;
                }
             }

             return $cats;

             }else{
                 return false;
             }     
        
         }     

    //**********************************************
    // Register part2 Creating category list ends 
    //*********************************************
    //********************************************
     // Update user category list starts (POST)
     //********************************************
        function updateCatList($u, $ud_c) { 
            $sql ="SELECT * FROM usercategory WHERE userID = :us";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':us',$u, PDO::PARAM_INT);
            $res=$stmt->execute();
            $rows = $stmt->fetchAll();

            $n_cat = explode(",", $ud_c);
            print_r($n_cat);
            print_r(gettype($n_cat));
        
                if(count($rows) == 1){
                    for($i = 0; $i<count($n_cat) ; $i = $i + 1){       

                    $sql ="UPDATE usercategory SET categoryID = :cat WHERE userID = :us";
                    $stmt = $this->dbconn->prepare($sql);
                    $stmt->bindParam(':cat',$n_cat[$i], PDO::PARAM_INT);
                    $stmt->bindParam(':us',$u, PDO::PARAM_INT);
                    $res=$stmt->execute();
        
                        if($res == false){
                            echo('loop false');
                            return false;
                        }
                    }
                    return $n_cat;
    
                  }

                  if($rows > 1){
                        $sql ="DELETE FROM usercategory WHERE userID = :us";
                        $stmt = $this->dbconn->prepare($sql);
                        $stmt->bindParam(':us',$u, PDO::PARAM_INT);
                        $res=$stmt->execute();

                        if($res==true){
                         for($i = 0; $i < count($n_cat) ; $i = $i + 1){      
                            $sql2 ="INSERT INTO usercategory(categoryID, userID) VALUE(:cat,:us)";
                             $stmt2 = $this->dbconn->prepare($sql2);
                             $stmt2->bindParam(':cat',$n_cat[$i], PDO::PARAM_INT);
                             $stmt2->bindParam(':us',$u, PDO::PARAM_INT);
                             $res2=$stmt2->execute();

                            // safe

    
                                if($res2 == false){
                                    echo('loop false');
                                    return false;
                                    }

                            }
                                    
                               return $n_cat;


                            }else{
                                echo('fail to delete and update');
                                return false; 
                            }


                        }
                     
                }
                       
    //********************************************
    // Update user category list ends 
    //********************************************

   

       // ↑ ↑ ↑  POST Method  ↑ ↑ ↑
       // ↓ ↓ ↓  Get Method ↓ ↓ ↓

   //*************************************************
   // Displaying products by category list starts(GET)
   // **Comes form Login part& register part   
   //**************************************************

        function showProducts($u) {
    
            $sql = "SELECT product.productPrice,product.productName, product.productImg
            FROM product JOIN category 
            ON product.categoryID = category.categoryID 
            RIGHT JOIN usercategory ON category.categoryID = usercategory.categoryID WHERE userID = :us";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':us', $u, PDO::PARAM_INT);
            $res = $stmt->execute();
            $rows = $stmt->fetchAll();

            if($res === true) { 

                return $rows;
            } else {
                return false;
            }

        }

    //***************************************** 
    // Displaying products by category list ends
    //******************************************

     //**********************************************
    // Calling category list created(GET)
    //***********************************************

    function callCatlist($u) {
        $sql = "SELECT category.categoryID, category.categoryName FROM category 
        JOIN usercategory ON category.categoryID = usercategory.categoryID WHERE userID = :us";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bindParam(':us', $u, PDO::PARAM_INT);
        $res = $stmt->execute();
        $rows = $stmt->fetchAll();
           
        if($res === true) {  
            return $rows;
        } else {
            return false;
        }

    }
    
    //***************************************** 
    // Displaying products by category list ends
    //***************************************** 

        function logEvent($u, $url, $resp_code, $source_ip) {
            $sql = "INSERT INTO logtable (url, u, response_code, ip_addr) 
                VALUES (:url, :u, :resp_code, :ip);";
            $stmt = $this->$dbconn->prepare($sql);
            $stmt->bindParam(':u', $u, PDO::PARAM_INT);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':resp_code', $resp_code, PDO::PARAM_INT);
            $stmt->bindParam(':ip', $source_ip, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result === true) {
                return true;
            } else {
                return false;
            }
        }


     //**********************************************************
    //Managing Product information starts(GET) still developping
    //***********************************************************  

    // function getOrdersForUser($u){
    //     $sql = "SELECT * FROM orderdata WHERE userID = :user";
    //     $stmt = $this->dbconn->prepare($sql);
    //     $stmt->bindParam(':user', $u, PDO::PARAM_INT);
    //     $result = $stmt->execute();
    //     $rows = $stmt->fetchAll();
    //         if($result === true) {  
    //             return $rows;
    //         } else {
    //             return false;
    //         }
    //     }

    //*************************************
    // Managing Product information ends 
    //************************************* 


    }
    
?>
