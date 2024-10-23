<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dumyrecharge_cron extends CI_Controller {
	
	
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
    public function getpreviousdate()
	{
		$date = $this->common->getMySqlDate();
		$date1 = str_replace('-', '/', $date);
		$preciusday = date('Y-m-d',strtotime($date1 . "-1 days"));
		return date_format(date_create($preciusday),'Y-m-d');
	}
	
	public function index()  
	{
	    error_reporting(-1);
	    ini_set('display_errors',1);
	    $this->db->db_debug = TRUE;
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache"); 
        $userinfo  = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by Rand() limit 1");
        $circle_code = "*";
        $company_info = $this->db->query("select company_id,service_id from tblcompany where service_id = 1 order by Rand() limit 1");
        $company_id = $company_info->row(0)->company_id;
        $Amount = rand(10,120);
        $MobileNo = rand(6000120000,9999999999);
        $recharge_type = "Mobile";
        $service_id =  $company_info->row(0)->service_id;
        $rechargeBy = "WEB";
        $this->load->model("Do_recharge_model");
        $response = $this->Do_recharge_model->ProcessRecharge($userinfo,$circle_code,$company_id,$Amount,$MobileNo,$recharge_type,$service_id,$rechargeBy,"");
        

	}	

}