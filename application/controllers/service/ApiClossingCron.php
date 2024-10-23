<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ApiClossingCron extends CI_Controller {
        
        
        private $msg='';
    function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
    function is_logged_in() 
    {
                
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function get_string_between($string, $start, $end)
    { 
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
    }
   
    public function index()  
    {
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;

        $this->load->model("Api_model");

            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache"); 

    $add_date = $this->common->getDate();
    $str_api_names = '';
    $str_balance = '';

    $rsltapilist = $this->db->query("select Id,api_name from api_configuration 
        where 
        (
        api_name !='Random' or api_name != 'Denomination_wise' or api_name != 'Circle_wise' or api_name != 'STOP' or api_name != 'PENDING'
        ) 
        and enable_balance_check = 'yes' ");
    $i=1;
    $qmarks = '';
    $str_rows = $rsltapilist->num_rows();
    foreach ($rsltapilist->result() as $rwapi) 
    {
            $api_name = $rwapi->api_name;
            echo $api_name."<hr>";
            $balance = $this->Api_model->getBalance($rwapi->Id);
           // echo $balance;exit;
            if(preg_match("/|/", $balance) == 1)
            {
                     $balance = explode("|",$balance)[0];
            }
             $balance = trim($balance);
            $str_balance .=',"'.$balance.'"';

            $str_api_names .=','.$api_name;
            $qmarks .= ',?';
            

            
            $rsltcheck_column_rslt  = $this->db->query("SHOW COLUMNS FROM api_clossingBalance LIKE ?",array($api_name));
            if($rsltcheck_column_rslt->num_rows() == 0)
            {
                    $this->db->query("ALTER TABLE api_clossingBalance ADD  ".$api_name." VARCHAR(12) DEFAULT 0");
            }

            $i++;
    }
   // echo $str_balance;exit;

    $str_balance = str_replace(",,,", ",", $str_balance);

        var_dump( "insert into api_clossingBalance(add_date".$str_api_names.") values('".$add_date."'".$str_balance.")");        echo "<hr>";


    $this->db->query("insert into api_clossingBalance(add_date".$str_api_names.") values('".$add_date."'".$str_balance.") ");
    echo "END";exit;

    }       

}