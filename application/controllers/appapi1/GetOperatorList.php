<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetOperatorList extends CI_Controller {
	
	
	
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
	public function index() 
	{
		$rslt = $this->db->query("select company_name,mcode from tblcompany where service_id = 1  order by company_name");
		echo json_encode($rslt->result());
      
	}
	
}