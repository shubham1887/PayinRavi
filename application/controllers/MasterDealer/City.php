<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City extends CI_Controller {
	
	private $msg='';
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
	
	public function getCity() 
	{
		//$stateID = $this->input->post("StateID",TRUE);
		$stateID = $this->uri->segment(4);
		$str_query = "select * from tblcity where state_id = ? order by city_name";
		$result = $this->db->query($str_query,array($stateID));
		
		echo "<option value='0'>Select City</option>";	
		for($i=0; $i<$result->num_rows(); $i++)
		{
			echo "<option value='".$result->row($i)->city_id."'>".$result->row($i)->city_name."</option>";	
		}		
	}	

	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		
	}	
}