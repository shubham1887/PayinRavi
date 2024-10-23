<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reroot_tester extends CI_Controller { 
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
		 error_reporting(E_ALL);
        ini_set('display_errors', 1);
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
	    if(isset($_GET["recharge_id"]))
	    {
	        $recharge_id = $this->input->get("recharge_id");
	        $this->load->model("Reroot_model");
            $this->Reroot_model->doReroot($recharge_id);    
	    }
        
	}
}
