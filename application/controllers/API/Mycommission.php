<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mycommission extends CI_Controller {
	
	
	private $msg='';
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
	public function pageview()
	{
	
		$user_id = $this->session->userdata("ApiId");
		$scheme_id = $this->session->userdata("ApiSchemeId");
	
		$mycomm = $this->db->query("
		select 
		    a.company_name,
		    IFNULL(b.commission,0) as commission,
		    b.commission_type,
		    b.loadlimit,
		    b.usedlimit
		    from tblcompany a 
		    left join tbluser_commission b on a.company_id = b.company_id  and b.user_id =?
		    where   (a.service_id = 1 or a.service_id = 2 or a.service_id = 3)  order by a.service_id,a.company_name",array($user_id));
		//print_r($mycomm->result());exit;
		$this->view_data['mycomm'] = $mycomm;
		$this->view_data['message'] =$this->msg;
		$this->view_data['pagination'] = "";
		$this->view_data['cmpl_flag'] =0;
		
		$this->load->view('API/mycommission_view',$this->view_data);		
	}
	
	public function index() 
	{
	
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSubmit'))
			{
			
				$Fromdate = $this->input->post('txtFromDate',true);
				$Todate = $this->input->post('txtToDate',true);
				$txtNumId = $this->input->post('txtNumId',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				$this->pageview();
									
			}
			else
			{
				
					$this->pageview();
				
			}
		} 
	}	
	
}