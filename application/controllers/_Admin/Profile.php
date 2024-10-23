<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	
	public function index()
	{
							
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
		    
		    
		  //  error_reporting(-1);
		  //  ini_set('display_errors',1);
		  //  $this->db->db_debug = TRUE;
			$type =  $this->Common_methods->decrypt($this->input->get("usertype"));
			
			$user_id = $this->Common_methods->decrypt($this->input->get("user_id"));
		//	echo $user_id;exit;
			$rslt = $this->db->query("
			select 
		a.user_id,
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
		g.group_name,
		info.emailid,
		info.pan_no,
		info.postal_address,
		info.landline,
		info.contact_person,
		info.pincode
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		left join tblusers_info info on a.user_id = info.user_id
		where 
		a.user_id = ?
			",array($user_id));
			
   
			
			$data['type'] = $type;
			$data['dataprofile']=$rslt;
			$data['message']='';				
			$this->load->view('_Admin/profile_view',$data);
			
		} 		
	}

}
