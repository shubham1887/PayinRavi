<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Getutils extends CI_Controller {

    function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
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
	    if($_GET["text"])
	    {
	        $text = trim($_GET["text"]);
	        
	        $resp = "";
    		$rsltuser = $this->db->query("select user_id,businessname,username from tblusers where usertype_name = 'Agent' and username like '".$text."%' order by username limit 20");
    		foreach($rsltuser->result() as $row)
    		{
    			$resp.=$row->username.'^-^';
    		}
    		echo $resp."";
	    }
		
	}
	
}

