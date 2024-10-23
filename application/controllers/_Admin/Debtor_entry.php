<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debtor_entry extends CI_Controller {
	
	
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
		if(trim($start_row) == ""){$start_row = 0;}
		$userrows = $this->db->query("select count(user_id) as total from tblusers where usertype_name = 'Agent'");
		
		$total_row = $userrows->row(0)->total;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/debtor_list/pageview";
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
		a.enabled,
		a.balance,
		info.birthdate,
		info.autoaccounting
		from tblusers a 
		left join tblusers_info info on a.user_id = info.user_id
		
		where 
		info.autoaccounting = 'yes' 
		order by a.businessname limit ?,?",array(intval($start_row),intval($per_page)));
		$this->view_data['message'] =$this->msg;
		$this->view_data['txtAGENTName'] ="";
		$this->view_data['txtAGENTId'] ="";
		$this->view_data['txtMOBILENo'] ="";
		$this->view_data['txtParentMobile'] ="";
		
		$this->load->view('_Admin/debtor_list_view',$this->view_data);		
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
		    if($this->input->post('HIDACTION') == "INSERT")
			{
				$txtMobileNumber = $this->input->post("txtMobileNumber");
				$txtOutstanding = $this->input->post("txtOutstanding");
				$txtRemark = $this->input->post("txtRemark");
				$rslt_userinfo = $this->db->query("select a.user_id,info.autoaccounting from tblusers a  left join tblusers_info info on a.user_id = info.user_id where (a.username = ? or a.mobile_no = ?) and a.host_id = 1",array($txtMobileNumber,$txtMobileNumber));
			    if($rslt_userinfo->num_rows() == 1)
				{
				   
			        $autoaccounting = $rslt_userinfo->row(0)->autoaccounting;
			        $user_id = $rslt_userinfo->row(0)->user_id;
			        if($autoaccounting != 'yes')
			        {
			            $this->load->model("credit_model");
			            $parent_id = 1;
			            $chield_id = $user_id;
			            $credit_amount =  $txtOutstanding;
			            $creditrevert = 0;
			            $payment_received = 0;
			            $remark = "Opening Outstanding";
			            $reference_id = 0;
			            $cash_ref_id = 0;
			           
			            $resp = $this->credit_model->credit_debit_entry($parent_id,$chield_id,$credit_amount,$creditrevert,$payment_received,$remark,$reference_id,$cash_ref_id,$cash_ref_id);
			            if($resp == true)
			            {
			                $this->db->query("update tblusers_info set autoaccounting = 'yes' where user_id = ?",array($user_id));
			                //,
			                $this->session->set_flashdata("MESSAGEBOXTYPE","success");
			                $this->session->set_flashdata("MESSAGEBOX","Debtor Account Successfully Created");
			               
			            }
			        }
				        
				    
				}
				redirect(base_url()."_Admin/debtor_list");
				
				
				
			}
		 	 else if($this->input->post('btnSubmit') == "Search")
			{
			    
			    $txtAGENTName = $this->input->post("txtAGENTName",TRUE);
				$txtAGENTId = $this->input->post("txtAGENTId",TRUE);		
				$txtMOBILENo = $this->input->post("txtMOBILENo",TRUE);	
				$txtOutstanding = $this->input->post("txtOutstanding",TRUE);	
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
			    
			    
				
					
					
					
					
					
				$this->view_data['result_dealer'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['txtAGENTName'] =$txtAGENTName;
				$this->view_data['txtAGENTId'] =$txtAGENTId;
				$this->view_data['txtMOBILENo'] =$txtMOBILENo;
				$this->view_data['txtParentMobile'] =$txtParentMobile;
				$this->view_data['pagination'] = NULL;
				$this->load->view('_Admin/debtor_list_view',$this->view_data);						
			}
			
			else if($this->input->post('hidaction') == "Set")
			{							
			
				$status = $this->input->post("hidstatus",TRUE);
				$user_id = $this->input->post("hiduserid",TRUE);
				$start_page = $this->input->post("startpage",TRUE);
				$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
				if($userinfo->num_rows() == 1)
				{
					if($userinfo->row(0)->status == 0)
					{
						$password = $this->common->GetPassword();
						$this->db->query("update tblusers set status = 1,password = ? where user_id = ?",array($password,$user_id));
						$this->load->model('Sms');
						$this->Sms->passwordreset($userinfo->row(0)->username,$password,$userinfo->row(0)->mobile_no,$userinfo->row(0)->emailid,$userinfo->row(0)->businessname);
						$this->msg="Action Submit Successfully.";
						redirect(base_url()."_Admin/debtor_list");
					}
					else if($userinfo->row(0)->status == 1)
					{
						//$password = $this->common->GetPassword();
						$this->db->query("update tblusers set status = 0 where user_id = ?",array($user_id));
						//$this->load->model('Sms');
						//$this->Sms->passwordreset($userinfo->row(0)->username,$password,$userinfo->row(0)->mobile_no,$userinfo->row(0)->emailid,$userinfo->row(0)->businessname);
						$this->msg="Action Submit Successfully.";
						redirect(base_url()."_Admin/debtor_list");
					}
					
			
				}
				else
				{
					$this->msg="Invalid Action.";
						redirect(base_url()."_Admin/debtor_list");
				}
				
			}
			else if($this->input->post("action") == "delete")
			{
			    $mdid = $this->input->post("hidValue");
			    
			    $userinfo = $this->db->query("select * from tblusers where user_id = ? and usertype_name = 'Agent'",array($mdid));
			
			    if($userinfo->num_rows() == 1)
			    {
			      $w1 = $this->Common_methods->getAgentBalance($mdid);
			      $w2 = $this->Ew2->getAgentBalance($mdid);
			      if($w1 != 0)
			      {
			        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
		            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","To Delete User, Balance Must Be zero");
		            redirect(base_url()."_Admin/debtor_list?crypt=".$this->Common_methods->encrypt("MyData"));
			      }
			      else if($w2 != 0)
			      {
			        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
		            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","To Delete User, Balance Must Be zero");
		            redirect(base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));
			      }
			      else
			      {
			        $rsltdownline = $this->db->query("select * from tblusers where parentid = ?",array($mdid));
			        if($rsltdownline->num_rows()  >= 1)
			        {
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","You Cant Delete This User");
			            redirect(base_url()."_Admin/debtor_list?crypt=".$this->Common_methods->encrypt("MyData"));
			        }
			        else
			        {
			            $this->db->query("delete from tblusers where user_id = ?",array($userinfo->row(0)->user_id));
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","User Deleted Successfully");
			            
			            redirect(base_url()."_Admin/debtor_list?crypt=".$this->Common_methods->encrypt("MyData"));
			        }   
			      }
			    }
			    else
			    {
			        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
		            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Some Error Occured");
		            redirect(base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));
			    }
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
    private function validatepayment_id($user_id,$payment_id)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		
		$rslt = $this->db->query("insert into manpay_locking.creditmaster_creditentry_locker (payment_id,add_date) values(?,?)",array($payment_id,$this->common->getDate()));
	  if($rslt == true)
	  {
		return true;
	  }
	  else
	  {
		return false;
	  }
	}
    public function tempentry()
    {
        if( isset($_GET["date"]))
        {
           // $mobile_no = $this->input->get("mobile_no");
            $date = $this->input->get("date");
            
            
                $this->load->model("credit_model");
              
               $entries = $this->db->query("
                        select 
                			a.*,
                			cr.user_id as cr_user_id,
                			dr.user_id as dr_user_id,
                			cr.businessname as bname,
                			cr.username as username,
                			cr.usertype_name as usertype,
                			dr.businessname as dr_bname,
                			dr.username as dr_username,
                			dr.usertype_name as dr_usertype 
                			from tblewallet a
                			left join tblpayment p on a.payment_id = p.payment_id
                			left join tblusers cr on p.cr_user_id = cr.user_id
                			left join tblusers dr on p.dr_user_id = dr.user_id
                			where 
                			a.user_id = ? and 
                			DATE(a.add_date) = ? and 
                			
                			
                			a.remark NOT LIKE  '%Commission%'
                			order by a.Id",array(1,$date));
                		
                			if($entries->num_rows() >= 1)
                			{
                			    foreach($entries->result() as $row)
                			    {
                			          $cr_user_id = $row->cr_user_id;
                			           $dr_user_id = $row->dr_user_id;
                			           //echo $cr_user_id."  >> ".$dr_user_id;exit;
                			        $addbalance__debit_amount = $row->debit_amount;
                			        $revert_balance__credit_amount = $row->credit_amount;
                			        
                			        
                			        
                		            $parent_id = $dr_user_id;
                		            $chield_id = $cr_user_id;
                		            $credit_amount =  $addbalance__debit_amount;
                		            $creditrevert =  $revert_balance__credit_amount;
                		            $payment_received = 0;
                		            $remark = $row->remark;
                		            $reference_id = $row->payment_id;
                		            
                		            if($this->validatepayment_id($user_id,$row->payment_id))
                		            {
                		                $resp = $this->credit_model->credit_debit_entry($parent_id,$chield_id,$credit_amount,$creditrevert,$payment_received,$remark,$reference_id);    
                		                echo $resp;
                		                echo "<br>";
                		            }
                		            
                		            
                			    }
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
		info.birthdate,
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
		left join tblusers_info info on info.user_id = a.user_id
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
									"BirthDate" =>  $result->birthdate, 
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