<?php 
//application/libraries/CreatorJwt.php
    require APPPATH . '/libraries/JWT.php';

    class CreatorJwt
    {
       

        /*************This function generate token private key**************/ 
 
       // PRIVATE $key = "oKPxEPVLqjCy1WAXgD9LKf7sb3FB5tilWeHcLU82MKY="; 
        PRIVATE $key = "AWuthW3LNZ2og-ABqMPCzQKbF6GbANmJqu4QRtRLszo=";
        public function GenerateToken($data)
        {          
            $jwt = JWT::encode($data, $this->key);
            return $jwt;
        }
        

       /*************This function DecodeToken token **************/

        public function DecodeToken($token)
        {          
            $decoded = JWT::decode($token, $this->key, array('HS256'));
            $decodedData = (array) $decoded;
            return $decodedData;
        }
    }