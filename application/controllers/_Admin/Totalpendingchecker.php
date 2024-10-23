<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Totalpendingchecker extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 error_reporting(-1);
	 ini_set('display_errors',1);
	 $this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function index()
    {
        
        $rsltcompany = $this->db->query("select company_id from tblcompany where service_id = 1 or service_id = 2 or  service_id = 3");
        foreach($rsltcompany->result() as $company)
        {
            $apiinfo = $this->db->query("select Id from api_configuration");
            foreach($apiinfo->result() as $api)
            {
                $rsltpending = $this->db->query("select count(recharge_id) as total from tblpendingrechares where company_id = ? and api_id = ?",array($company->company_id,$api->Id));	
                if($rsltpending->num_rows() == 1)
                {
                    
                    $total = $rsltpending->row(0)->total;
                    $this->db->query("update pf_values set totalpending = ? where company_id = ? and api_id = ?",array($total,$company->company_id,$api->Id));
                }    
            }    
        }
    }
}