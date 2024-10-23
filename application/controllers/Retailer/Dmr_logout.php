<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_logout extends CI_Controller {


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
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			$this->session->unset_userdata("MTLOGIN");
			$this->session->unset_userdata("MTSENDERMOBILE");
			$this->session->unset_userdata("MTAGENTID");
			$this->session->unset_userdata("REMITTERID");
			redirect(base_url()."login?crypt=".$this->Common_methods->encrypt("MyData"));
		} 
		else 
		{ 
			
			$this->session->unset_userdata("MTLOGIN");
			$this->session->unset_userdata("MTSENDERMOBILE");
			$this->session->unset_userdata("MTAGENTID");
			$this->session->unset_userdata("REMITTERID");
			redirect(base_url()."Retailer/recharge_home?crypt=".$this->Common_methods->encrypt("MyData"));
			
			
		}
	}
}	