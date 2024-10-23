<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Call_me_list extends CI_Controller {
	
	
	private $msg='';
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
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$start_row = $this->uri->segment(4);
		$per_page = $this->common_value->getPerPage();
		
		$mobile_no = $this->session->userdata("mobile_no");
		$from = $this->session->userdata("from");
		$to = $this->session->userdata("to");
	//	echo $from."  ".$to;exit;
		
		if(trim($start_row) == ""){$start_row = 0;}
		$userrows = $this->db->query("select 
		
            		count(a.Id) as totalcount
            		from callreq a 
            		left join tblusers b on a.user_id = b.user_id
            		where 
            		
    			    (a.status = 'DONE') and 
    			    if(? != '',b.mobile_no = ?,true) and
    			    Date(a.add_date) >= ? and
    			    Date(a.add_date) <= ?
    				order by a.Id",array($mobile_no,$mobile_no,$from,$to));
		
		$total_row = $userrows->row(0)->totalcount;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/call_me_list/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		
		
		$this->view_data['rsltcallreq'] = $this->db->query("
		select 
		
            		a.Id,
            		a.user_id,
            		a.add_date,
            		a.status,
            		a.remark,
            		a.last_update,
            		b.businessname,
            		b.username,
            		b.mobile_no,
            		p.businessname as parent_name,
            		p.username as parent_id
            		from callreq a 
            		left join tblusers b on a.user_id = b.user_id 
    			    left join tblusers p on b.parentid = p.user_id
    				where 
    			    (a.status = 'DONE') and 
    			    if(? != '',b.mobile_no = ?,true) and
    			    Date(a.add_date) >= ? and
    			    Date(a.add_date) <= ?
    				order by a.Id desc limit ?,?
		
		",array($mobile_no,$mobile_no,$from,$to,intval($start_row),intval($per_page)));
		
		//print_r($this->view_data['rsltcallreq']);exit;
		$this->view_data['message'] =$this->msg;
		$this->view_data['from'] =$from;
		$this->view_data['to'] =$to;
		$this->view_data['mobile_no'] =$mobile_no;
		$this->view_data['txtNumId'] ="";
		
		$this->load->view('_Admin/call_me_list_view',$this->view_data);		
	}
	
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
		
		 	 if($this->input->post('btnSubmit'))
			{
			
				$txtFrom = $this->input->post("txtFrom",TRUE);
				$txtTo = $this->input->post("txtTo",TRUE);
				$txtNumber = $this->input->post("txtNumber",TRUE);
				$this->session->set_userdata("from",$txtFrom);
				$this->session->set_userdata("to",$txtTo);
				$this->session->set_userdata("mobile_no",$txtNumber);
				$this->pageview();
			}					
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
				    $this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function Search($SearchBy,$SearchWord)
	{
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
		a.dmr_group ,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'Agent' and
		a.mobile_no = '".$SearchWord."'
		order by a.username");
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
		a.dmr_group ,
		g.group_name 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'Agent' and
		a.businessname like '".$SearchWord."%'
		order by a.username");
		return $result;	
		}		
		if($SearchBy == "UserID")
		{
			
			$result = $this->db->query("
		select 
		a.user_id,
		a.parentid,
		a.scheme_id,
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
		a.dmr_group  ,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'Agent' and
		a.username like '".$SearchWord."%'
		order by a.username");
	//	print_r($result->result());exit;
		return $result;	
		}
		else
		{
			redirect(base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));
		}				
	}
	public function minRechargeLimit()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$minreclimit = $_GET["minrechargelimit"];
		$user_id = $_GET["id"];
		$rslt = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		if($rslt->num_rows() == 1)
		{
			$this->db->query("update tblusers set min_bal_limit = ? where user_id = ?",array($minreclimit,$user_id));
		}
	}
	public function changedmrgroup()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$id = $_GET["id"];
		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($id));
		$field = $_GET["field"];
		if($userinfo->num_rows() == 1)
		{
		
			$this->db->query("update tblusers set dmr_group = ? where user_id = ?",array($field,$id));
			echo $field;
		}
	}
	public function  togglegroup()
	{
		if(isset($_GET["id"]) and isset($_GET["sts"]))
		{
			$id = trim($_GET["id"]);
			$sts = trim($_GET["sts"]);
			$this->db->query("update tblusers set 	grouping=? where user_id = ?",array($sts,$id));
			echo "Success";exit;
		}
	}
	public function getbalance()
	{
		
		$id = $_GET["id"];
	   echo $id."#".$this->Common_methods->getAgentBalance($id)."#".round($this->Ew2->getAgentBalance($id),2);exit;
		
		
	}
	public function setvalues()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "";exit;
		}
		$id = $_GET["Id"];
		$val= $_GET["val"];
		$userinfo = $this->db->query("select user_id from tblusers where user_id = ?",array($id));
		$field = $_GET["field"];
		
		if($userinfo->num_rows() == 1)
		{
			
			if($field == "MT")
			{
					
				$this->db->query("update tblusers set mt_access = ? where user_id = ?",array($val,$id));
				echo $val;	
			}
			
		}
	}
	public function dataexporttwo()
	{
		
		ini_set('memory_limit', '-1');
				$i = 0;
			
			$data = array();
			
			
				$userlist = $this->db->query("
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
		f.mobile_no as fos_mobile,
	
		(select e.balance from tblewallet e where a.user_id = e.user_id order by e.Id desc limit 1) as balance
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblusers f on a.fos_id = f.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		left join tblusers_info pinfo on p.user_id = pinfo.user_id
		where 
		a.usertype_name != 'Admin'  
		order by a.businessname");
				foreach($userlist->result() as $result)
				{
					if($result->status == true){ $status =  "Active";}else {$status =  "Deactive";}
					
					
					
					
					
					
					$temparray = array(
									"Name" =>  $result->businessname, 
									"username" =>  $result->username, 
									"Mobile" =>  "91".$result->mobile_no, 
									"Reg.Data" =>  $result->add_date, 
									"UserType" =>  $result->usertype_name, 
									"Status" =>  $status, 
									"Balance" =>  $result->balance, 
									"ParentName" =>  $result->parent_name, 
									"ParentId" =>  $result->parent_username, 
									"ParentMobile" =>  $result->parent_mobile,
									"ParentPan" =>  $result->parentpan,
									"FosName" =>  $result->fos_name, 
									"FosId" =>  $result->fos_username, 
									"FosMobile" =>  $result->fos_mobile, 
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