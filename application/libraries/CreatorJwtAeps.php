<?php 
//application/libraries/CreatorJwt.php
    

    class CreatorJwtAeps
    {
       

        /*************This function generate token private key**************/ 
 
       // PRIVATE $key = "oKPxEPVLqjCy1WAXgD9LKf7sb3FB5tilWeHcLU82MKY="; 
        PRIVATE $key = "fizO5hKi1VlO_bPwgy2ogNtvCPHTdI_XidCUe__kKXY=";
        public function GenerateToken($data)
        {          
            $jwt2 = JWT::encode($data, $this->key);
            return $jwt2;
        }
        

       /*************This function DecodeToken token **************/

        public function DecodeToken($token)
        {          
            $decoded = JWT::decode($token, $this->key, array('HS256'));
            $decodedData = (array) $decoded;
            return $decodedData;
        }
    }