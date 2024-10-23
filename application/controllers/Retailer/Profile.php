<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Profile extends CI_Controller 
{
        
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
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
		    		
			
		
			$this->view_data["message"]  = "";	
			$this->view_data["message"]  = ""; 
			$this->load->view("Retailer/profile_view",$this->view_data);
		
		
	}
}