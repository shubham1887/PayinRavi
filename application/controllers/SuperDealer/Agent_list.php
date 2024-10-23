<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class agent_list extends CI_Controller {

	

	

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
	public function pageview()
	{ 
	    
	    // error_reporting(E_ALL);
	    //ini_set("display_errors",1);
	    //$this->db->db_debug = TRUE;
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		$start_row = $this->uri->segment(4);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$user_id = $this->session->userdata("SdId");
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
		$result = $this->db->query("select user_id from tblusers where usertype_name = 'Agent' and host_id = ?",array($user_id));
		$total_row = $result->num_rows();
		$this->load->library('pagination');
		$config['base_url'] = base_url()."SuperDealer/agent_list/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();

		$this->view_data['result_dealer'] = $this->db->query("
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
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'Agent'  and a.host_id = ?
		order by a.businessname limit ?,? ",array($user_id,intval($start_row),intval($per_page)));
        $this->view_data['txtAGENTName'] ="";
		$this->view_data['txtAGENTId'] ="";
		$this->view_data['txtMOBILENo'] ="";
		$this->view_data['txtParentMobile'] =$txtParentMobile;
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/agent_list_view',$this->view_data);		

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
			
				$txtAGENTName = $this->input->post("txtAGENTName",TRUE);
				$txtAGENTId = $this->input->post("txtAGENTId",TRUE);		
				$txtMOBILENo = $this->input->post("txtMOBILENo",TRUE);	
				$txtParentMobile = $this->input->post("txtParentMobile",TRUE);	
				if($txtMOBILENo != "")							
				{
					$result = $this->Search("Mobile",$txtMOBILENo);	
				
				}
				else if($txtAGENTId != "")							
				{
					$result = $this->Search("UserID",$txtAGENTId);	
				}
				else if($txtAGENTName != "")							
				{
					$result = $this->Search("Agent",$txtAGENTName);	
				}
				else if($txtParentMobile != "")							
				{
					$result = $this->Search("ParentMobile",$txtParentMobile);	
				}
				else
				{
					$result = $this->Search("",$txtMOBILENo);	
				}
					
				$this->view_data['result_dealer'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['txtAGENTName'] =$txtAGENTName;
				$this->view_data['txtAGENTId'] =$txtAGENTId;
				$this->view_data['txtMOBILENo'] =$txtMOBILENo;
				$this->view_data['txtParentMobile'] =$txtParentMobile;
				$this->view_data['pagination'] = NULL;
				$this->load->view('SuperDealer/agent_list_view',$this->view_data);						
			}	
			else
			{
                    $this->pageview();
			}

		} 

	}	
	public function Search($SearchBy,$SearchWord)
	{
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
		$user_id = $this->session->userdata("SdId");
		if($SearchBy == "Mobile")
		{
			
			$result = $this->db->query("
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
		a.dmr_group 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		where 
		a.usertype_name = 'Agent' and  a.host_id = ? and
		a.mobile_no = ?
		order by a.username",array($host_id,$SearchWord));
		return $result;	
		}		
		if($SearchBy == "Agent")
		{
			
			$result = $this->db->query("
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
		a.dmr_group 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		where 
		a.usertype_name = 'Agent' and 
		a.host_id = ? and
		a.businessname like '".$SearchWord."%'
		order by a.username",array($user_id));
		return $result;	
		}		
		if($SearchBy == "UserID")
		{
			
			$result = $this->db->query("
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
		a.dmr_group 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		where 
		a.usertype_name = 'Agent' and
		a.host_id = ? and
		a.username like '".$SearchWord."%'
		order by a.username",array($user_id));
		return $result;	
		}
		if($SearchBy == "ParentMobile")
		{
		    
		    
		    $result = $this->db->query("
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
		a.dmr_group 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		where 
		a.usertype_name = 'Agent' and
		a.host_id = ? and
		p.mobile_no =  ?
		order by a.username",array($user_id,$SearchWord));
		return $result;	
		}
		else
		{
			redirect(base_url()."SuperDealer/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));
		}				
	}
	public function getbalance()
	{
		
		$id = $_GET["id"];
	    echo $id."#".round($this->Common_methods->getAgentBalance($id),2)."#".round($this->Ew2->getAgentBalance($id),2);exit;
		
		
	}



	private function getClossingBalance($date,$user_id)
	{
		$rslt = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) <= ? order by Id desc limit 1",array($user_id,$date));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->balance;
		}
		return 0;
	}
	public function dataexporttwo()
	{
		
		ini_set('memory_limit', '-1');
				$i = 0;
			
			$data = array();

			$date = $this->input->get("txtDate");

			$host_id = $this->session->userdata("SdId");
			
				$userlist = $this->db->query("
							select 
		a.host_id,
		a.user_id,
		a.parentid,
		a.businessname,
		a.mobile_no,
		info.birthdate,
		info.deactive_date,
		a.usertype_name,
		a.add_date,
		a.status,
		a.username,
		a.password,
		a.txn_password,
		state.state_name,
		city.city_name,
		a.grouping,
		a.mt_access,
		a.dmr_group,
		g.group_name,
		p.businessname as parent_name,
		p.username as parent_username,
		p.mobile_no as parent_mobile,
		pinfo.pan_no as parentpan,
		f.businessname as fos_name,
		f.username as fos_username,
		f.mobile_no as fos_mobile
		from tblusers a 
		left join tblusers_info info on info.user_id = a.user_id
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblusers f on a.fos_id = f.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		left join tblusers_info pinfo on p.user_id = pinfo.user_id
		where 
		a.usertype_name != 'Admin'  and a.host_id = ?
		order by a.businessname",array($host_id));
				foreach($userlist->result() as $result)
				{
					if($result->status == true){ $status =  "Active";}else {$status =  "Deactive";}
					
					
					
					
					
					
					$temparray = array(
									"Date" =>$date,
									"Id" =>  $result->user_id, 
									"Name" =>  $result->businessname, 
									"username" =>  $result->username, 
									"Mobile" =>  "91".$result->mobile_no,
									"BirthDate" =>  $result->birthdate, 
									"Reg.Data" =>  $result->add_date, 
									"UserType" =>  $result->usertype_name, 
									"Status" =>  $status, 
									"Balance" =>  $this->getClossingBalance($date,$result->user_id), 
									"ParentName" =>  $result->parent_name, 
									"ParentId" =>  $result->parent_username, 
									"ParentMobile" =>  $result->parent_mobile,
									"ParentPan" =>  $result->parentpan,
									"FosName" =>  $result->fos_name, 
									"FosId" =>  $result->fos_username, 
									"FosMobile" =>  $result->fos_mobile,
									"HostName" =>  $this->Common_methods->getHostName($result->host_id), 
									"DeactiveDate"=>$result->deactive_date
									);
					
					
					
					array_push( $data,$temparray);
				}
				
			
    function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
    $fileName = "Agent List.xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    foreach($data as $row) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($row, 'filterData');
        echo implode("\t", array_values($row)) . "\n";

    }
    
    exit;
			
	
	}
}