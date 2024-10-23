<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {
	
	
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
   
	public function index() 
	{
	        $data = array();
	        $rsltadmininfo = $this->db->query("select * from admininfo");
	        foreach($rsltadmininfo->result() as $rwainf)
	        {
	            $data[$rwainf->param]=$rwainf->value;
	            
	        }
	        
	        
			$this->view_data["data"]=$data;
			$this->view_data["theme_path"]="templates/theme02";
		    $this->view_data["message"]="";
		    $this->load->view("templates/theme02/service_view",$this->view_data);
		 
	}	
}