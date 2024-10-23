<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Gototheme extends CI_Controller { 
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
        $show_template_rslt = $this->db->query("select value from admininfo where param = 'show_template' and host_id = 1");
        $ddltemplate_rslt = $this->db->query("select value from admininfo where param = 'web_template_id' and host_id = 1");
        if($show_template_rslt->row(0)->value == "yes")
        {
            $template_info = $this->db->query("select * from tbltemplates where Id = ?",array($ddltemplate_rslt->row(0)->value)); 
            if($template_info->num_rows() == 1)
            {
                $path = $template_info->row(0)->directory_path;
                redirect(base_url()."Home");
            }
            else
            {
                redirect(base_url()."login");
            }
        }
        else
        {
                redirect(base_url()."login");
        }
        
	    	
	}
}
