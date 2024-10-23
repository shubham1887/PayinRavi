<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TermsAndConditions extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('DistUserType') != "Distributor") 
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
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	

			if(isset($_POST["accept_terms"]) )
			{

				$user_id = $this->session->userdata("DistId");
				$accept_terms = $this->input->post("accept_terms");
				
				if($accept_terms == "yes")
				{
					$this->db->query("update tblusers set terms_and_conditions = 'yes' where user_id = ?",array($user_id));
					redirect(base_url()."Retailer/TermsAndConditions");
				}
				else
				{
					redirect(base_url()."Retailer/TermsAndConditions");
				}
			}					
			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
					$user_id = $this->session->userdata("DistId");
					$user_info = $this->db->query("select terms_and_conditions from tblusers where user_id = ?",array($user_id));
					$terms_and_conditions = $user_info->row(0)->terms_and_conditions;
					$this->view_data["message"] = "";
					$this->view_data["terms_and_conditions"] = $terms_and_conditions;
					$this->load->view("Distributor_new/TermsAndConditions_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
}