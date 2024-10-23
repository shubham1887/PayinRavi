<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DistAgent_list extends CI_Controller {

	

	

	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
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
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache"); 
        if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}
		else 		
		{
 			if($this->input->post('btnSubmit') == "Search")
			{
			
				
				$txtParentMobile = trim($this->input->post("txtParentMobile",TRUE));	
				if(strlen($txtParentMobile) == 10)
				{
					$user_id = $this->session->userdata("SdId");
					$host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
					$this->view_data['result_dealer'] = $this->db->query("
					select 
					a.user_id,
					a.balance,
					a.parentid,
					a.businessname,
					a.mobile_no,
					a.usertype_name,
					a.add_date,
					a.status,
					a.username,
					a.password,
					a.txn_password,
					state.state_name,
					city.city_name,
					p.businessname as parent_name,
					p.username as parent_username,
					a.grouping,
					a.mt_access,
					a.dmr_group,
					g.group_name
					from tblusers a 
					left join tblstate state on a.state_id = state.state_id
					left join tblcity city on a.city_id = city.city_id
					left join tblusers p on a.parentid = p.user_id
					left join tblgroup	g on a.scheme_id = g.Id
					where 
					a.host_id = ? and
					p.mobile_no = ?
					order by a.businessname",array($user_id,$txtParentMobile));
					$this->view_data['txtParentMobile'] =$txtParentMobile;
					$this->view_data['message'] =$this->msg;
					$this->load->view('SuperDealer/distAgent_list_view',$this->view_data);	
				}
				else
				{
					$this->view_data['txtParentMobile'] ="Invalid Mobile Number";
					$this->view_data['message'] = "";
					$this->load->view('SuperDealer/distAgent_list_view',$this->view_data);	
				}
				
										
			}	
			else
			{
                $this->view_data['txtParentMobile'] ="";
				$this->view_data['message'] = "";
				$this->load->view('SuperDealer/distAgent_list_view',$this->view_data);	
			}

		} 

	}	
}