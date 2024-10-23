<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ApiLogout extends CI_Controller {
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ApiUserType') != "APIUSER") 
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
		
			$this->session->unset_userdata('ApiId');
			$this->session->unset_userdata('ApiLoggedIn');	
			$this->session->unset_userdata('ApiUserType');	
			
			$this->session->unset_userdata('ApiBusinessName');
			$this->session->unset_userdata('ApiUserName');
			$this->session->unset_userdata('ApiEmail');
			$this->session->unset_userdata('ApiPostalAddress');
			$this->session->unset_userdata('AdminId');
			redirect(base_url());
		
	}	
}
