<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class List_recharge extends CI_Controller {
	
	
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
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
		
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;
    }
	public function pageview()
	{
		$word = "";
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		$txtNumId = $this->session->userdata("txtNumId");
		$ddlstatus = $this->session->userdata("ddlstatus");
		$ddloperator = $this->session->userdata("ddloperator");
		$ddlapi  = $this->session->userdata("ddlapi");
		$ddluser  = $this->session->userdata("ddluser");
		$ddlreroot  = $this->session->userdata("ddlreroot");
		$ddldb  = $this->session->userdata("ddldb");
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		
		$total_row = $this->gettablerowscount($fromdate,$todate,$ddlapi,$ddloperator,$ddlstatus,$txtNumId,$start_row,$per_page,$ddluser);	
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/list_recharge/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
        $this->db->reconnect();
		
		
		
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total,
										Sum(a.commission_amount) as retComm,
										Sum(a.DComm) as DComm,
										Sum(a.MdComm) as MdComm,
										Sum(a.roffer) as roffer,
										Sum(a.AdminComm) as AdminComm,
										Sum(a.flat_commission) as flatcomm
										FROM tblrecharge a 
										left join tblusers user on a.user_id = user.user_id
										where 
										Date(a.add_date) BETWEEN ? and ? and
										if(? != '',user.username = ?,true)

										 group by a.recharge_status ",array($fromdate,$todate,$ddluser,$ddluser));
		
		
		$flatcommission = 0;
		$totalsuccess = 0;
		$totalfailure = 0;
		$totalpending = 0;
		$totalcommission = 0;
		$total_retailercomm = 0;
		$total_dcomm = 0;
		$total_mdcomm = 0;
		$total_admincomm = 0;
		$total_roffer = 0;
		$total_admincomm = 0;
		if($rslt_sf->num_rows() > 0)
		{
			foreach($rslt_sf->result() as $row)
			{
				if($row->recharge_status == "Success")
				{
					$totalsuccess = $row->total;
					$total_retailercomm = $row->retComm;
					$total_dcomm = $row->DComm;
					$total_mdcomm = $row->MdComm;
					$total_roffer = $row->roffer;
					$total_admincomm = $row->AdminComm;
					$flatcommission = $row->flatcomm;
				
				}
				if($row->recharge_status == "Failure")
				{
					$totalfailure = $row->total;	
				}
				if($row->recharge_status == "Pending")
				{
					$totalpending = $row->total;	
				}
			}
	
		}
	
		
		$this->view_data['totalRecahrge'] =$totalsuccess;
		$this->view_data['totalpRecahrge'] =$totalpending;
		$this->view_data['totalfRecahrge'] =$totalfailure;
		$this->view_data['roffer'] =$total_roffer;
		$this->view_data['retComm'] =$total_retailercomm;
		$this->view_data['DComm'] =$total_dcomm;
		$this->view_data['MdComm'] =$total_mdcomm;
		$this->view_data['AdminComm'] =$total_admincomm;
		$this->view_data['flatcommission'] =$flatcommission;
		
		
		$this->view_data['txtNumId'] =$txtNumId; 
		$this->view_data['from'] =$fromdate; 
		$this->view_data['to'] =$todate; 
		$this->view_data['ddlstatus'] =$ddlstatus; 
		$this->view_data['ddloperator'] =$ddloperator;
		$this->view_data['ddlreroot'] =$ddlreroot; 
		$this->view_data['ddlapi'] =$ddlapi; 
		$this->view_data['ddluser'] =$ddluser; 
		$this->view_data['ddldb'] =$ddldb; 
		$this->view_data['result_recharge'] = $this->gettablerows($fromdate,$todate,$ddlapi,$ddloperator,$ddlstatus,$txtNumId,$start_row,$per_page,$ddluser,$ddlreroot,$ddldb);
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/list_recharge_view',$this->view_data);			
	}
	
	public function index() 
	{
//	error_reporting(-1);
//ini_set('display_errors',1);
//	$this->db->db_debug = TRUE;
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post("txtSearchNumber"))
			{
				$serachbumber = trim($this->input->post("txtSearchNumber"));
				$this->view_data['totalRecahrge'] ="";
				$this->view_data['totalpRecahrge'] ="";
				$this->view_data['totalfRecahrge'] ="";
				
				$this->view_data['txtNumId'] =$serachbumber; 
				$this->view_data['from'] =""; 
				$this->view_data['to'] =""; 
				$this->view_data['ddlstatus'] ="ALL"; 
				$this->view_data['ddloperator'] ="ALL"; 
				$this->view_data['ddlapi'] ="ALL"; 
				$this->view_data['ddluser'] ="ALL"; 
				$this->view_data['ddldb'] ="LIVE"; 
				
				
				if( preg_match('/FS/',$serachbumber) == 1)
				{
				    $date = $this->common->getMySqlDate();
				    if( preg_match('/FS=/',$serachbumber) == 1)
				    {
				        $date = explode("FS=",$serachbumber)[1];
				    }
				    $this->view_data['result_recharge'] = $this->db->query("
            		select
            				a.transaction_id,
            				a.updated_by,
            				a.user_id, 	
                            a.state_id,
            				a.edit_date,
            				a.update_time,
            				a.retry,
            				a.recharge_id,
            				a.company_id,
            				a.balance,
            				a.mobile_no,
            				a.amount,
            				a.recharge_by,
            				a.ExecuteBy,
            				a.ewallet_id,
            				a.user_id,
            				b.company_name,
            				b.mcode,
            				a.commission_amount,
            				a.add_date,
            				a.update_time,
            				a.operator_id,
            				a.recharge_status,
            				a.MdComm,
            				a.MdId,
            				a.DId,
            				a.DComm,
            				a.lapubalance,
            				c.businessname,
            				c.username,
            				p.businessname as parent_name,
            				state.state_name,
            				state.code as statecode
            							from tblrecharge a
            							left join tblcompany b on a.company_id = b.company_id
            							left join tblusers c on a.user_id = c.user_id
            							left join tblusers p  on c.parentid = p.user_id
                                        left join tblstate state on a.state_id = state.state_id
            							where 
            							(a.edit_date = '60'  or a.edit_date = '5')
            							and Date(a.add_date) = ?
            							 order by a.recharge_id desc",array($date));
				}
				else
				{
				    $this->view_data['result_recharge'] = $this->db->query("
            		select
            				a.transaction_id,
            				a.updated_by,
            				a.user_id, 	
                            a.state_id,
            				a.edit_date,
            				a.update_time,
            				a.retry,
            				a.recharge_id,
            				a.company_id,
            				a.balance,
            				a.mobile_no,
            				a.amount,
            				a.recharge_by,
            				a.ExecuteBy,
            				a.ewallet_id,
            				a.user_id,
            				b.company_name,
            				b.mcode,
            				a.commission_amount,
            				a.add_date,
            				a.update_time,
            				a.operator_id,
            				a.recharge_status,
            				a.MdComm,
            				a.MdId,
            				a.DId,
            				a.DComm,
            				a.lapubalance,
            				c.businessname,
            				c.username,
            				p.businessname as parent_name,
            				state.state_name,
            				state.code as statecode
            							from tblrecharge a
            							left join tblcompany b on a.company_id = b.company_id
            							left join tblusers c on a.user_id = c.user_id
            							left join tblusers p  on c.parentid = p.user_id
                                        left join tblstate state on a.state_id = state.state_id
            							where 
            							a.mobile_no = ? or a.recharge_id = ?
            							 order by a.recharge_id desc",array($serachbumber,$serachbumber));
				}
				
				
							 
							
				$this->view_data['message'] =$this->msg;
				$this->load->view('_Admin/list_recharge_view',$this->view_data);	
			}
			else if($this->input->post('hidaction') == "Set")
			{	
			    			
				$status = $this->input->post("hidstatus",TRUE);
				$recharge_id = $this->input->post("hidrechargeid",TRUE);
				$hidid = $this->input->post("hidid",TRUE);
				$recharge_info = $this->db->query("select recharge_id,recharge_status,edit_date from tblrecharge where recharge_id = ? and recharge_status = 'Success'",array($recharge_id));
				if($recharge_info->num_rows() == 1)
				{
					$oldStatus = $recharge_info->row(0)->recharge_status;
					if($oldStatus != $status)
					{
                       
						if($oldStatus == "Success" )
						{
							if($status == "Failure")
							{
								$this->db->query("update tblrecharge set edit_date = 3, recharge_status = ?, operator_id = ?,update_time=?,update_ip=? where recharge_id = ?",array($status,$hidid,$this->common->getDate(),$this->common->getRealIpAddr(),$recharge_id));
								$this->load->model("Insert_model");
								$this->Insert_model->refundOfAcountReportEntry($recharge_id);
								
								$checkcomplain = $this->db->query("select complain_id from tblcomplain where recharge_id = ? and complain_status = 'Pending'",array($recharge_id));
								if($checkcomplain->num_rows() == 1)
								{
								    $this->db->query("update tblcomplain set complain_status = 'Solved',complainsolve_date = ?,response_message = 'Refund Done' where complain_id = ?",array($this->common->getDate(),$checkcomplain->row(0)->complain_id));
								}
								
							}
						}
					}
				}
				else
				{
				 
				     $recharge_info = $this->db->query("select a.user_id,a.amount,a.mobile_no,a.recharge_id,a.recharge_status,a.edit_date,b.company_name from tblrecharge a left join tblcompany b on a.company_id = b.company_id where a.recharge_id = ? and a.recharge_status = 'Failure'",array($recharge_id));
				    
				    if($recharge_info->num_rows() == 1)
    				{
    				    
    					$oldStatus = $recharge_info->row(0)->recharge_status;
    				    
    					if($oldStatus == $status)
    					{
    				        if($oldStatus == "Failure" )
    						{
    						   
    						   
    							if($status == "Failure")
    							{
    							    
    							 
    								$this->db->query("update tblrecharge set edit_date = 3,reverted = 'no',debited = 'yes', recharge_status = ?, operator_id = ?,update_time=?,update_ip=? where recharge_id = ?",array($status,$hidid,$this->common->getDate(),$this->common->getRealIpAddr(),$recharge_id));
    								$this->load->model("Insert_model");
    								$this->Insert_model->refundOfAcountReportEntry($recharge_id);
    								
    								$checkcomplain = $this->db->query("select complain_id from tblcomplain where recharge_id = ? and complain_status = 'Pending'",array($recharge_id));
    								if($checkcomplain->num_rows() == 1)
    								{
    								    $this->db->query("update tblcomplain set complain_status = 'Solved',complainsolve_date = ?,response_message = 'Refund Done' where complain_id = ?",array($this->common->getDate(),$checkcomplain->row(0)->complain_id));
    								}
    								
    							}
    						
    						}	    
    					}
    					else if($oldStatus != $status)
    					{
    				        if($oldStatus == "Failure" )
    						{
    						   
    						   
    						    if($status == "Rollback")
    							{
    							    
    							  $Description = "Recharge : ".$recharge_info->row(0)->company_name." | ".$recharge_info->row(0)->mobile_no." | ".$recharge_info->row(0)->amount;
    								$this->db->query("update tblrecharge set edit_date = 9,reverted = 'no',debited = 'yes', recharge_status =  ?, operator_id = ?,update_time=?,update_ip=? where recharge_id = ?",array("Success",$hidid,$this->common->getDate(),$this->common->getRealIpAddr(),$recharge_id));
    								$this->Insert_model->tblewallet_Recharge_DrEntry($recharge_info->row(0)->user_id,$recharge_id,"Recharge",$recharge_info->row(0)->amount,$Description);
    								
    							}
    						}	    
    					}
    				}
				}
				 
				
				
					$this->msg="Action Submit Successfully.";
					$this->pageview();	
				
			}
			
			
			else if($this->input->post('btnSubmit'))
			{
			   
				$Fromdate = $this->input->post('txtFrom',true);
				$Todate = $this->input->post('txtTo',true);
				$txtNumId = $this->input->post('txtNumId',true);
				$ddlstatus = $this->input->post('ddlstatus',true);
				$ddloperator = $this->input->post('ddloperator',true);
				$ddlreroot = $this->input->post('ddlreroot',true);
				$ddlapi = $this->input->post('ddlapi',true);
				$ddluser = $this->input->post('ddluser',true);
			
				$ddldb = $this->input->post('ddldb',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				$this->session->set_userdata("ddlstatus",$ddlstatus);
				$this->session->set_userdata("ddloperator",$ddloperator);
				$this->session->set_userdata("ddlapi",$ddlapi);
				$this->session->set_userdata("ddluser",$ddluser);
				$this->session->set_userdata("ddlreroot",$ddlreroot);
				$this->session->set_userdata("ddldb",$ddldb);
				$this->pageview();
									
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$todaydate = $this->common->getMySqlDate();
					$this->session->set_userdata("FromDate",$todaydate);
					$this->session->set_userdata("ToDate",$todaydate);
					$this->session->set_userdata("ddlstatus","ALL");
					$this->session->set_userdata("txtNumId","");
					$this->session->set_userdata("ddloperator","ALL");
					$this->session->set_userdata("ddlapi","ALL");
					$this->session->set_userdata("ddlreroot","ALL");
					$this->session->set_userdata("ddldb","LIVE");
					$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	private function resolveFailureToSuccess($recharge_id,$recUser)
	{
		$rslt = $this->db->query("select * from tblrecharge where recharge_id = '$recharge_id' and user_id = '$recUser'");
		if($rslt->num_rows() == 1)
		{
			$amount = $rslt->row(0)->amount;
			$company_id = $rslt->row(0)->company_id;
			$mobile_no = $rslt->row(0)->mobile_no;
			$this->load->model("tblcompany_methods");
			$company_name = $this->tblcompany_methods->getCompany_name($company_id);
			$company_name = "";
			$commission_amount = $rslt->row(0)->commission_amount;
			$debit_amount = $amount - $commission_amount;
			$transaction_type = "RechargeSolved";
			$Description = "Resolved Recharge : Recharge_id = ".$recharge_id." : ".$company_name." | ".$mobile_no." | ".$amount;
			$this->Insert_model->tblewallet_Recharge_DrEntry($recUser,$recharge_id,$transaction_type,$debit_amount,$Description);
			
		}
	}
	private function resolveSuccessToFailure($recharge_id,$recUser)
	{
		$rslt = $this->db->query("select * from tblewallet where recharge_id = '$recharge_id' and user_id = '$recUser'");
		if($rslt->num_rows() == 1)
		{
			$this->load->model("Tblcompany_methods");
			$debit_amount = $rslt->row(0)->debit_amount;
			$transaction_type = "Recharge_Refund";
			$cr_amount = $debit_amount;
			$Description = "Refund : ".$rslt->row(0)->description;
			$this->Insert_model->tblewallet_Recharge_CrEntry($recUser,$recharge_id,$transaction_type,$cr_amount,$Description);
			
		}
	}
	public function dataexport()
	{
	   
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "session expired"; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$db = trim($_GET["db"]);
			
			$data = array();
			
			if($db == "ARCHIVE")
			{
				$str_query = "select 
		        a.debited,
		        a.reverted,
		        a.edit_date,
        		a.ewallet_id,
        		a.recharge_id,
        		a.mobile_no,
        		a.state_id,
        		a.amount,
        		a.recharge_status,
        		a.transaction_id,
        		a.operator_id,
        		a.amount,
        		a.user_id,
        		a.ExecuteBy,
        		a.AdminComm,
				a.commission_amount,
        		a.add_date,
        		a.update_time,
        		a.operator_id,
        		a.recharge_by,
        		a.lapubalance,
        		c.company_name,
        		b.businessname,b.username,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				state.state_name,
				state.code as statecode
        		from jantrech_archive.tblrecharge a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblusers parent on b.parentid = parent.user_id
				left join tblcompany c on a.company_id = c.company_id 
				left join tblstate state on a.state_id = state.state_id
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to));
			}
			else
			{
				$str_query = "select 
		        a.debited,
		        a.reverted,
		        a.edit_date,
        		a.ewallet_id,
        		a.recharge_id,
        		a.mobile_no,
        		a.state_id,
        		a.amount,
        		a.recharge_status,
        		a.transaction_id,
        		a.operator_id,
        		a.amount,
        		a.user_id,
        		a.ExecuteBy,
        		a.AdminComm,
				a.commission_amount,
				a.flat_commission,
				a.DComm,
				a.MdComm,
        		a.add_date,
        		a.update_time,
        		a.operator_id,
        		a.recharge_by,
        		a.lapubalance,
        		c.company_name,
        		b.businessname,b.username,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				state.state_name,
				state.code as statecode
        		from tblrecharge a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblusers parent on b.parentid = parent.user_id
				left join tblcompany c on a.company_id = c.company_id 
				left join tblstate state on a.state_id = state.state_id
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to));
			}
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"debited" => $rw->debited, 
									"reverted" => $rw->reverted, 
									"edit_date" => $rw->edit_date, 
									"recharge_id" => $rw->recharge_id, 
									"ewallet_id" => $rw->ewallet_id, 
									"transaction_id" =>$rw->transaction_id, 
									"operator_id" =>$rw->operator_id, 
									"add_date" =>$rw->add_date, 
									"update_time" =>$rw->update_time, 
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"company_name" => $rw->company_name, 
									"mobile_no" =>$rw->mobile_no, 
									"Amount" =>$rw->amount, 
									"Execute By" =>$rw->ExecuteBy, 
									"Recharge By" =>$rw->recharge_by, 
									"Recharge Status" =>$rw->recharge_status, 
									"Flat.Comm" =>$rw->flat_commission,
									"Ret.Comm" =>$rw->commission_amount,
									"Dist.Comm" =>$rw->DComm,
									"Md.Comm" =>$rw->MdComm,
									"ParentName" =>$rw->parent_businessname, 
									"ParentUserId" =>$rw->parent_username, 
									"state_name" =>$rw->state_name, 
								);
					
					
					
					array_push( $data,$temparray);
					$i++;
	}
	function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
    $fileName = "recharge_list From ".$from." To  ".$to.".xls";
    
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
		else
		{
			echo "parameter missing";exit;
		}
	}
	
	
	public function ExecuteAPI($url)
	{	
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
	public function logentry($data)
	{
		$filename = "urlrespnec.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}	
	private function gettablerows($from,$to,$api,$operator,$status,$numid,$start,$perpage,$user_id,$ddlreroot,$ddldb)
	{
	    
		if($ddldb == "ARCHIVE")
		{
			return $this->db->query("
		select
				a.transaction_id,
				a.updated_by,
				a.user_id, 	
				a.roffer,
                a.state_id,
				a.edit_date,
				a.update_time,
				a.retry,
				a.recharge_id,
				a.company_id,
				a.balance,
				a.mobile_no,
				a.amount,
				a.recharge_by,
				a.ExecuteBy,
				a.ewallet_id,
				a.user_id,
				b.company_name,
				b.mcode,
				a.AdminComm,
				a.commission_amount,
				a.add_date,
				a.update_time,
				a.operator_id,
				a.recharge_status,
				a.MdComm,
				a.MdId,
				a.DId,
				a.DComm,
				a.lapubalance,
				a.host_id,
				c.businessname,
				c.username,
				state.state_name,
				state.code as statecode,
				p.businessname as parent_name
							from jantrech_archive.tblrecharge a
							left join tblcompany b on a.company_id = b.company_id
							left join tblusers c on a.user_id = c.user_id
							left join tblusers p  on c.parentid = p.user_id
							left join tblstate state on a.state_id = state.state_id

							where 
							
							if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
							(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
							(if(? >= 1,c.username =?,true) or if(? = 'ALL',true,c.username = ?)) and
							(if(? != '',a.ExecuteBy = ?,true) or if(? = 'ALL',true,a.ExecuteBy = ?)) and
							(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
							(if(? = 'ALL',true,a.retry = ?)) and
							(if(? != '',Date(a.add_date) >= ?,true)) and
							(if(? != '',Date(a.add_date) <= ?,true))

							 order by a.recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$api,$api,$api,$api,$status,$status,$status,$status,$ddlreroot,$ddlreroot,$from,$from,$to,$to,intval($start),intval($perpage)));
		}
		else
		{
		   
			return $this->db->query("
		select
				a.transaction_id,
				a.updated_by,
				a.roffer,
				a.user_id, 	
                a.state_id,
				a.edit_date,
				a.update_time,
				a.retry,
				a.recharge_id,
				a.company_id,
				a.balance,
				a.mobile_no,
				a.amount,
				a.recharge_by,
				a.ExecuteBy,
				a.ewallet_id,
				a.user_id,
				b.company_name,
				b.mcode,
				a.AdminComm,
				a.commission_amount,
				a.add_date,
				a.update_time,
				a.operator_id,
				a.recharge_status,
				a.MdComm,
				a.MdId,
				a.DId,
				a.DComm,
				a.flat_commission,
				a.lapubalance,
				a.host_id,
				c.businessname,
				c.username,
				state.circleName as state_name,
				state.circleName as statecode,
				p.businessname as parent_name
							from tblrecharge a
							left join tblcompany b on a.company_id = b.company_id
							left join tblusers c on a.user_id = c.user_id
							left join tblusers p  on c.parentid = p.user_id
							left join freecharge_circlemaster state on a.state_id = state.circleMasterId

							where 
							
							if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
							(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
							(if(? != '',c.username =?,true) or if(? = 'ALL',true,c.username = ?)) and
							(if(? != '',a.ExecuteBy = ?,true) or if(? = 'ALL',true,a.ExecuteBy = ?)) and
							(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
							(if(? = 'ALL',true,a.retry = ?)) and
							(if(? != '',Date(a.add_date) >= ?,true)) and
							(if(? != '',Date(a.add_date) <= ?,true))

							 order by a.recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$api,$api,$api,$api,$status,$status,$status,$status,$ddlreroot,$ddlreroot,$from,$from,$to,$to,intval($start),intval($perpage)));
		}
		
	}
	private function gettablerowscount($from,$to,$api,$operator,$status,$numid,$start,$perpage,$user_id)
	{
		
		$rsltrowcount=  $this->db->query("
				select 
				count(recharge_id) as total from tblrecharge
				where Date(add_date) >= ? and Date(add_date) <= ?
				",array($from,$from));
		return $rsltrowcount->row(0)->total;
		
	}
	
	public function dorefund()
	{
	    if(isset($_POST["recharge_id"]))
	    {
	        $recharge_id = intval(trim($this->input->post("recharge_id")));
	        if($recharge_id > 0)
	        {
	            $recharge_info = $this->db->query("
                    		select 
                    		
                    		a.order_id,
                    		a.recharge_by,
                    		a.user_id, 
                    		a.add_date,
                    		a.ExecuteBy,
                    		a.recharge_status,
                    		a.company_id,
                    		a.mobile_no,
                    		a.amount,
                    		a.commission_amount,
                    		a.DComPer,
							a.DComm,
							a.MdComPer,
							a.MdComm,
                    		a.user_id,
                    		b.company_name,
                    		c.mobile_no as sendermobile,
                    		d.call_back_url as respurl 
                    		from tblrecharge a
                    		left join tblusers_info d on a.user_id = d.user_id
                    		left join tblcompany b on a.company_id = b.company_id
                    		left join tblusers c on a.user_id = c.user_id 
                    		where 
                    		a.recharge_id = ?",array($recharge_id));
	            if($recharge_info->num_rows() == 1)
	            {
	                $status = "Failure";
	                $operator_id = "N/A";
	                $company_id = $recharge_info->row(0)->company_id;
	                $user_id = $recharge_info->row(0)->user_id;
	                $lapubalance = "";
	                $lapunumber = "";
	                $date = $this->common->getDate();
	                $ip = $this->common->getRealIpAddr();
	                $recharge_by = $recharge_info->row(0)->recharge_by;
	                $callback = true;
	                $respurl = $recharge_info->row(0)->respurl;
	                $uniqueid = $recharge_info->row(0)->order_id;
	                
	              
	                $this->load->model("Update_methods");
	                $this->Update_methods->refundOfAcountReportEntry($recharge_id,$status,$operator_id,$company_id,$user_id,$lapubalance,$lapunumber,$recharge_info,$date,$ip,$recharge_by,$callback,$respurl,$uniqueid,true);
	                $resparray = array(
	                                "message"=>"Refund Done Successfully"  ,
	                                "status"=>0
	                               );
	                echo json_encode($resparray);exit;
	                
	            }
	            else
	            {
	                $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	                echo json_encode($resparray);exit;
	            }
	        }
	        else
	        {
	            $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	           echo json_encode($resparray);exit;
	        } 
	    }
	    else
	    {
	        $resparray = array(
	                                "message"=>"Some Parameters Missing"  ,
	                                "status"=>1
	                               );
	       echo json_encode($resparray);exit;
	    }
	}
	public function dosuccess()
	{
	   
	    if(isset($_POST["recharge_id"]) and isset($_POST["operator_id"]))
	    {
	        $recharge_id = intval(trim($this->input->post("recharge_id")));
	        $operator_id = trim($this->input->post("operator_id"));
	        
	        if($recharge_id > 0)
	        {
	            $recharge_info = $this->db->query("
                    		select 
                    		
                    		a.order_id,
                    		a.recharge_by,
                    		a.user_id, 
                    		a.add_date,
                    		a.ExecuteBy,
                    		a.recharge_status,
                    		a.company_id,
                    		a.mobile_no,
                    		a.amount,
                    		a.commission_amount,
                    		a.user_id,
                    		b.company_name,
                    		c.mobile_no as sendermobile,
                    		d.call_back_url as respurl 
                    		from tblrecharge a
                    		left join tblusers_info d on a.user_id = d.user_id
                    		left join tblcompany b on a.company_id = b.company_id
                    		left join tblusers c on a.user_id = c.user_id 
                    		where 
                    		a.recharge_id = ?",array($recharge_id));
	            if($recharge_info->num_rows() == 1)
	            {
	                $status = "Success";
	                
	                $company_id = $recharge_info->row(0)->company_id;
	                $user_id = $recharge_info->row(0)->user_id;
	                $lapubalance = "";
	                $lapunumber = "";
	                $date = $this->common->getDate();
	                $ip = $this->common->getRealIpAddr();
	                $recharge_by = $recharge_info->row(0)->recharge_by;
	                $callback = true;
	                $respurl = $recharge_info->row(0)->respurl;
	                $uniqueid = $recharge_info->row(0)->order_id;
	                
	              
	                
	                
	                $this->load->model("Rollback_model");
	                $resp =  $this->Rollback_model->recharge_Rollback_rollback($recharge_id,$operator_id,$status);
	                echo $resp;exit;
	                
	            }
	            else
	            {
	                $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	                echo json_encode($resparray);exit;
	            }
	        }
	        else
	        {
	            $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	           echo json_encode($resparray);exit;
	        } 
	    }
	    else
	    {
	        $resparray = array(
	                                "message"=>"Some Parameters Missing"  ,
	                                "status"=>1
	                               );
	       echo json_encode($resparray);exit;
	    }
	}
	
	public function checkstatus()
	{
	    if(isset($_POST["recharge_id"]))
	    {
	        $recharge_id = intval(trim($this->input->post("recharge_id")));
	        if($recharge_id > 0)
	        {
	            $recharge_info = $this->db->query("
                    		select 
                    		
                    		a.order_id,
                    		a.recharge_by,
                    		a.user_id, 
                    		a.add_date,
                    		a.ExecuteBy,
                    		a.recharge_status,
                    		a.company_id,
                    		a.mobile_no,
                    		a.amount,
                    		a.commission_amount,
                    		a.user_id,
                    		b.company_name,
                    		c.mobile_no as sendermobile,
                    		d.call_back_url as respurl 
                    		from tblrecharge a
                    		left join tblusers_info d on a.user_id = d.user_id
                    		left join tblcompany b on a.company_id = b.company_id
                    		left join tblusers c on a.user_id = c.user_id 
                    		where 
                    		a.recharge_id = ?",array($recharge_id));
	            if($recharge_info->num_rows() == 1)
	            {
	                $company_id = $recharge_info->row(0)->company_id;
	                $Mobile = $recharge_info->row(0)->mobile_no;
	                $Amount = $recharge_info->row(0)->amount;
	                
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//	                S T A T U S    A P I   C O D E   S T A R T S   H E R E    
//	                
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	                
	                
	              
			$apiinfo = $this->db->query("select * from api_configuration where api_name = ?",array($recharge_info->row(0)->ExecuteBy));
			if($apiinfo->num_rows() == 1)
			{
			        $api_id = $apiinfo->row(0)->Id;
        	        $api_name = $apiinfo->row(0)->api_name;
        	        $api_type = $apiinfo->row(0)->api_type;
        	        $is_active = $apiinfo->row(0)->is_active;
        	        $enable_recharge = $apiinfo->row(0)->enable_recharge;
        	        $enable_balance_check = $apiinfo->row(0)->enable_balance_check;
        	        $enable_status_check = $apiinfo->row(0)->enable_status_check;
        	        $hostname = $apiinfo->row(0)->hostname;
        	        $param1 = $apiinfo->row(0)->param1;
        	        $param2 = $apiinfo->row(0)->param2;
        	        $param3 = $apiinfo->row(0)->param3;
        	        $param4 = $apiinfo->row(0)->param4;
        	        $param5 = $apiinfo->row(0)->param5;
        	        $param6 = $apiinfo->row(0)->param6;
        	        $param7 = $apiinfo->row(0)->param7;
        	        
        	        $header_key1 = $apiinfo->row(0)->header_key1;
        	        $header_key2 = $apiinfo->row(0)->header_key1;
        	        $header_key3 = $apiinfo->row(0)->header_key1;
        	        $header_key4 = $apiinfo->row(0)->header_key1;
        	        $header_key5 = $apiinfo->row(0)->header_key1;
        	        $header_value1 = $apiinfo->row(0)->header_value1;
        	        $header_value2 = $apiinfo->row(0)->header_value2;
        	        $header_value3 = $apiinfo->row(0)->header_value3;
        	        $header_value4 = $apiinfo->row(0)->header_value4;
        	        $header_value5 = $apiinfo->row(0)->header_value5;
        	        
        	        $balance_check_api_method = $apiinfo->row(0)->balance_check_api_method;
        	        $balance_ceck_api = $apiinfo->row(0)->balance_ceck_api;
        	        $status_check_api_method = $apiinfo->row(0)->status_check_api_method;
        	        $status_check_api = $apiinfo->row(0)->status_check_api;
        	        $validation_api_method = $apiinfo->row(0)->validation_api_method;
        	        $validation_api = $apiinfo->row(0)->validation_api;
        	        $transaction_api_method = $apiinfo->row(0)->transaction_api_method;
        	        $api_prepaid = $apiinfo->row(0)->api_prepaid;
        	        $api_dth = $apiinfo->row(0)->api_dth;
        	        $api_postpaid = $apiinfo->row(0)->api_postpaid;
        	        
        	        $api_electricity = $apiinfo->row(0)->api_electricity;
        	        $api_gas = $apiinfo->row(0)->api_gas;
        	        $api_insurance = $apiinfo->row(0)->api_insurance;
        	        $dunamic_callback_url = $apiinfo->row(0)->dunamic_callback_url;
        	        $response_parser = $apiinfo->row(0)->response_parser;
        	        
        	        
        	        $recharge_response_type = $apiinfo->row(0)->recharge_response_type;
        	        $response_separator = $apiinfo->row(0)->response_separator;
        	        
        	        $recharge_response_status_field = $apiinfo->row(0)->recharge_response_status_field;
        	        $recharge_response_opid_field = $apiinfo->row(0)->recharge_response_opid_field;
        	        $recharge_response_apirefid_field = $apiinfo->row(0)->recharge_response_apirefid_field;
        	        
        	        $recharge_response_balance_field = $apiinfo->row(0)->recharge_response_balance_field;
        	        $recharge_response_remark_field = $apiinfo->row(0)->recharge_response_remark_field;
        	        $recharge_response_stat_field = $apiinfo->row(0)->recharge_response_stat_field;
        	        
        	        $recharge_response_fos_field = $apiinfo->row(0)->recharge_response_fos_field;
        	        $recharge_response_otf_field = $apiinfo->row(0)->recharge_response_otf_field;
        	        
        	         $recharge_response_lapunumber_field = $apiinfo->row(0)->recharge_response_lapunumber_field;
        	         $recharge_response_message_field = $apiinfo->row(0)->recharge_response_message_field;
        	         $pendingOnEmptyTxnId = $apiinfo->row(0)->pendingOnEmptyTxnId;
        	         $RecRespSuccessKey = $apiinfo->row(0)->RecRespSuccessKey;
        	         $RecRespPendingKey = $apiinfo->row(0)->RecRespPendingKey;
        	         $RecRespFailureKey = $apiinfo->row(0)->RecRespFailureKey;
        	          
        	         ///////////////////////////////////////////
        	         ////////////////////////////////////////
        	         ///////////////////////
        	         ///////////////////////////////////////////
        	         $operatorcode_rslt = $this->db->query("
                        	    select 
                        	    a.company_id,
                        	    a.company_name,
                        	    a.mcode,
                        	    a.service_id,
                        	    b.service_name,
                        	    g.commission,
                        	    g.commission_type,
                        	    g.commission_slab,
                        	    g.OpParam1,
                        	    g.OpParam2,
                        	    g.OpParam3,
                        	    g.OpParam4,
                        	    g.OpParam5
                        	    
                        	    from tblcompany a 
                        	    left join tblservice b on a.service_id = b.service_id 
                        	    left join tbloperatorcodes g on g.api_id = ? and a.company_id = g.company_id
                        	    where a.company_id = ?
                        	    order by service_id",array($api_id,$company_id));
                        	    $OpParam1 = '';
                        	    $OpParam2 = '';
                        	    $OpParam3 = '';
                        	    $OpParam4 = '';
                        	    $OpParam5 = '';
                    if($operatorcode_rslt->num_rows() == 1)
                    {
                        $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
                        $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
                        $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
                        $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
                        $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
                    }
                    $url = $hostname;
        	        if($status_check_api_method == "GET")
        	        {
        	            
        	           
        	            $status_check_api  = str_replace("@param1",$param1, $status_check_api);
        	            $status_check_api  = str_replace("@param2",$param2, $status_check_api);
        	            $status_check_api  = str_replace("@param3",$param3, $status_check_api);
        	            $status_check_api  = str_replace("@param4",$param4, $status_check_api);
        	            $status_check_api  = str_replace("@param5",$param5, $status_check_api);
        	            $status_check_api  = str_replace("@param6",$param6, $status_check_api);
        	            $status_check_api  = str_replace("@param7",$param7, $status_check_api);
        	            
        	            $url = $hostname.$status_check_api;
        	           
        	            
        	            $url  = str_replace("@mn",$Mobile, $url);
        	            $url  = str_replace("@amt",$Amount, $url);
        	            $url  = str_replace("@opparam1",$OpParam1, $url);
        	            $url  = str_replace("@opparam2",$OpParam2, $url);
        	            $url  = str_replace("@opparam3",$OpParam3, $url);
        	            $url  = str_replace("@opparam4",$OpParam4, $url);
        	            $url  = str_replace("@opparam5",$OpParam5, $url);
        	            $url  = str_replace("@reqid",$recharge_id, $url);
        	           // echo $url;exit;
        	            $response = $this->common->callurl(trim($url),$recharge_id);  
        	            //echo $response;
        	           // echo "<br>";
        	        }
        	       
        	        if($status_check_api_method == "POST")
        	        {
        	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
        	            $status_check_api  = str_replace("@param1",$param1, $status_check_api);
        	            $status_check_api  = str_replace("@param2",$param2, $status_check_api);
        	            $status_check_api  = str_replace("@param3",$param3, $status_check_api);
        	            $status_check_api  = str_replace("@param4",$param4, $status_check_api);
        	            $status_check_api  = str_replace("@param5",$param5, $status_check_api);
        	            $status_check_api  = str_replace("@param6",$param6, $status_check_api);
        	            $status_check_api  = str_replace("@param7",$param7, $status_check_api);
        	            
        	            $url = $hostname.$status_check_api;
        	           
        	            
        	            $url  = str_replace("@mn",$Mobile, $url);
        	            $url  = str_replace("@amt",$Amount, $url);
        	            $url  = str_replace("@opparam1",$OpParam1, $url);
        	            $url  = str_replace("@opparam2",$OpParam2, $url);
        	            $url  = str_replace("@opparam3",$OpParam3, $url);
        	            $url  = str_replace("@opparam4",$OpParam4, $url);
        	            $url  = str_replace("@opparam5",$OpParam5, $url);
        	            $url  = str_replace("@reqid",$recharge_id, $url);
        	            
        	            
        	            $postdata = explode("?",$url)[1];
        	            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
        	        }
        	        
        	        $status_api_configuration = $this->db->query("select * from status_api_configuration where api_id = ?",array($api_id));
        	        if($status_api_configuration->num_rows() == 1)
        	        {
        	            $api_id = trim($status_api_configuration->row(0)->api_id);
                        $response_type = trim($status_api_configuration->row(0)->response_type);
                        $status_field = trim($status_api_configuration->row(0)->status_field);
                        $opid_field = trim($status_api_configuration->row(0)->opid_field);
                        $state_field = trim($status_api_configuration->row(0)->state_field);
                        $fos_field = trim($status_api_configuration->row(0)->fos_field);	
                        $otf_field = trim($status_api_configuration->row(0)->otf_field);
                        $lapunumber_field = trim($status_api_configuration->row(0)->lapunumber_field);
                        $message_field = trim($status_api_configuration->row(0)->message_field);
                        $success_key = trim($status_api_configuration->row(0)->success_key);
                        $pending_key = trim($status_api_configuration->row(0)->pending_key);
                        $failure_key = trim($status_api_configuration->row(0)->failure_key);
                        $refund_key = trim($status_api_configuration->row(0)->refund_key);
                        $notfound_key = trim($status_api_configuration->row(0)->notfound_key);
                        $str_separator = trim($status_api_configuration->row(0)->str_separator);
                       
                        if(strtoupper($response_type) == "XML")
                        {
                            $obj = (array)simplexml_load_string( $response);
                           
                           
                            $status_field = str_replace("<","",$status_field);
                            $status_field = str_replace(">","",$status_field);
                            
                          
                            
                            $opid_field = str_replace("<","",$opid_field);
                            $opid_field = str_replace(">","",$opid_field);
                            
                            $statusvalue = $obj[$status_field];
                            
                            $operator_id = json_encode($obj[$opid_field]);
                            $operator_id = str_replace('"','', $operator_id);
                            
                            
                            $lapubalance = "";
                            
                            $success_key_array = explode(",",$success_key);
                            $failure_key_array = explode(",",$failure_key);
                            $pending_key_array = explode(",",$pending_key);
                            $refund_key_array = explode(",",$refund_key);
                            
                           
                           
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Success With Operator Id ".$operator_id ,
	                                "status"=>0,
	                                "statuscode"=>"Success",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
            					
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Failure" ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else if (in_array($statusvalue, $refund_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Refund" ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else  if (in_array($statusvalue, $pending_key_array)) 
                            {
                                $status = 'Pending';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge In Pending Process ",
	                                "status"=>0,
	                                "statuscode"=>"Pending",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                               
                            }
                        } 
                        else if(strtoupper($response_type) == "JSON")
                        {
                            $obj = (array)json_decode( $response);
                            $statusvalue = $obj[$status_field];
                            
                            $operator_id = json_encode($obj[$opid_field]);
                            $operator_id = str_replace('"','', $operator_id);
                            
                            
                            $lapubalance = "";
                            
                            $success_key_array = explode(",",$success_key);
                            $failure_key_array = explode(",",$failure_key);
                            $pending_key_array = explode(",",$pending_key);
                            $refund_key_array = explode(",",$refund_key);
                            
                           
                           
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Success With Operator Id ".$operator_id ,
	                                "status"=>0,
	                                "statuscode"=>"Success",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
            					
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Failure" ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else if (in_array($statusvalue, $refund_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Refund" ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else  if (in_array($statusvalue, $pending_key_array)) 
                            {
                                $status = 'Pending';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge In Pending Process ",
	                                "status"=>0,
	                                "statuscode"=>"Pending",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                               
                            }
                        }
                        else if(strtoupper($response_type) == "CSV")
                        {
                            $obj = explode($str_separator, $response);
                            $statusvalue = $obj[$status_field];
                            
                            $operator_id = json_encode($obj[$opid_field]);
                            $operator_id = str_replace('"','', $operator_id);
                            
                            
                            $lapubalance = "";
                            
                            $success_key_array = explode(",",$success_key);
                            $failure_key_array = explode(",",$failure_key);
                            $pending_key_array = explode(",",$pending_key);
                            $refund_key_array = explode(",",$refund_key);
                            
                           
                           
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Success With Operator Id ".$operator_id ,
	                                "status"=>0,
	                                "statuscode"=>"Success",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
            					
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Failure" ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else if (in_array($statusvalue, $refund_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge Refund" ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else  if (in_array($statusvalue, $pending_key_array)) 
                            {
                                $status = 'Pending';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge In Pending Process ",
	                                "status"=>0,
	                                "statuscode"=>"Pending",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                               
                            }
                        }  
                        else
                        {
                            $resparray = array(
	                                "message"=>"Respone Type Not Configured"  ,
	                                "status"=>1
	                               );
    	                    echo json_encode($resparray);exit;
                        }
        	        }
        	        else
        	        {
        	            $resparray = array(
	                                "message"=>"Status Api Not Configured"  ,
	                                "status"=>1
	                               );
	                    echo json_encode($resparray);exit;
        	        }
        	      
			}
			else
			{
			    $resparray = array(
	                                "message"=>"Api Not Found"  ,
	                                "status"=>1
	                               );
	            echo json_encode($resparray);exit;
			}
            
            
///////////////////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////////////////////////                 
	                
	                
	                
	                
	                
	            }
	            else
	            {
	                $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	                echo json_encode($resparray);exit;
	            }
	        }
	        else
	        {
	            $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	           echo json_encode($resparray);exit;
	        } 
	    }
	    else
	    {
	        $resparray = array(
	                                "message"=>"Some Parameters Missing"  ,
	                                "status"=>1
	                               );
	       echo json_encode($resparray);exit;
	    }
	}
	
	public function resendtoanotherapi()
	{
	    // error_reporting(-1);
	    // ini_set('display_errors',1);
	    // $this->db->db_debug = TRUE;



	    if(isset($_POST["recharge_id"]) and isset($_POST["api_id"]))
	    {
	        $recharge_id = intval(trim($this->input->post("recharge_id")));
	        $resend_api_id = intval(trim($this->input->post("api_id")));
	        if($recharge_id > 0)
	        {
	            $recharge_info = $this->db->query("
                    		select 
                    		
                    		a.order_id,
                    		a.recharge_by,
                    		a.user_id, 
                    		a.add_date,
                    		a.ExecuteBy,
                    		a.recharge_status,
                    		a.company_id,
                    		a.mobile_no,
                    		a.amount,
                    		a.commission_amount,
                    		a.user_id,
                    		b.company_name,
                    		c.mobile_no as sendermobile,
                    		d.call_back_url as respurl 
                    		from tblrecharge a
                    		left join tblusers_info d on a.user_id = d.user_id
                    		left join tblcompany b on a.company_id = b.company_id
                    		left join tblusers c on a.user_id = c.user_id 
                    		where 
                    		a.recharge_id = ? and (a.recharge_status = 'Pending' or a.recharge_status = 'Success')",array($recharge_id));
	            if($recharge_info->num_rows() == 1)
	            {
	                $company_id = $recharge_info->row(0)->company_id;
	                $Mobile = $recharge_info->row(0)->mobile_no;
	                $Amount = $recharge_info->row(0)->amount;
	                $recharge_status = $recharge_info->row(0)->recharge_status;
	                $user_id = $recharge_info->row(0)->user_id;
	                $recharge_datetime = $recharge_info->row(0)->add_date;


	                if($recharge_status == "Success")
	                {
	                	$chkstop_success_recharge_rerootRslt = $this->db->query("select value from admininfo where param = 'stop_success_recharge_reroot' and host_id = 1");
	                	if($chkstop_success_recharge_rerootRslt->row(0)->value =="yes")
	                	{
	                		$resparray = array(
	                                "message"=>"Success Recharge Reroot Is Blocked  " ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>"",
	                                            "Response"=>"Success Recharge Reroot Is Blocked  " 
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
	                	}
	                }

	                
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//	                S T A T U S    A P I   C O D E   S T A R T S   H E R E    
//	                
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	                
	                
	              
			$apiinfo = $this->db->query("select * from api_configuration where Id = ?",array($resend_api_id));
			if($apiinfo->num_rows() == 1)
			{
			        $api_id = $apiinfo->row(0)->Id;
        	        $api_name = $apiinfo->row(0)->api_name;
        	        $api_type = $apiinfo->row(0)->api_type;
        	        $is_active = $apiinfo->row(0)->is_active;
        	        $enable_recharge = $apiinfo->row(0)->enable_recharge;
        	        $enable_balance_check = $apiinfo->row(0)->enable_balance_check;
        	        $enable_status_check = $apiinfo->row(0)->enable_status_check;
        	        $hostname = $apiinfo->row(0)->hostname;
        	        $param1 = $apiinfo->row(0)->param1;
        	        $param2 = $apiinfo->row(0)->param2;
        	        $param3 = $apiinfo->row(0)->param3;
        	        $param4 = $apiinfo->row(0)->param4;
        	        $param5 = $apiinfo->row(0)->param5;
        	        $param6 = $apiinfo->row(0)->param6;
        	        $param7 = $apiinfo->row(0)->param7;
        	        
        	        $header_key1 = $apiinfo->row(0)->header_key1;
        	        $header_key2 = $apiinfo->row(0)->header_key1;
        	        $header_key3 = $apiinfo->row(0)->header_key1;
        	        $header_key4 = $apiinfo->row(0)->header_key1;
        	        $header_key5 = $apiinfo->row(0)->header_key1;
        	        $header_value1 = $apiinfo->row(0)->header_value1;
        	        $header_value2 = $apiinfo->row(0)->header_value2;
        	        $header_value3 = $apiinfo->row(0)->header_value3;
        	        $header_value4 = $apiinfo->row(0)->header_value4;
        	        $header_value5 = $apiinfo->row(0)->header_value5;
        	        
        	        $balance_check_api_method = $apiinfo->row(0)->balance_check_api_method;
        	        $balance_ceck_api = $apiinfo->row(0)->balance_ceck_api;
        	        $status_check_api_method = $apiinfo->row(0)->status_check_api_method;
        	        $status_check_api = $apiinfo->row(0)->status_check_api;
        	        $validation_api_method = $apiinfo->row(0)->validation_api_method;
        	        $validation_api = $apiinfo->row(0)->validation_api;
        	        $transaction_api_method = $apiinfo->row(0)->transaction_api_method;
        	        $api_prepaid = $apiinfo->row(0)->api_prepaid;
        	        $api_dth = $apiinfo->row(0)->api_dth;
        	        $api_postpaid = $apiinfo->row(0)->api_postpaid;
        	        
        	        $api_electricity = $apiinfo->row(0)->api_electricity;
        	        $api_gas = $apiinfo->row(0)->api_gas;
        	        $api_insurance = $apiinfo->row(0)->api_insurance;
        	        $dunamic_callback_url = $apiinfo->row(0)->dunamic_callback_url;
        	        $response_parser = $apiinfo->row(0)->response_parser;
        	        
        	        
        	        $recharge_response_type = $apiinfo->row(0)->recharge_response_type;
        	        $response_separator = $apiinfo->row(0)->response_separator;
        	        
        	        $recharge_response_status_field = $apiinfo->row(0)->recharge_response_status_field;
        	        $recharge_response_opid_field = $apiinfo->row(0)->recharge_response_opid_field;
        	        $recharge_response_apirefid_field = $apiinfo->row(0)->recharge_response_apirefid_field;
        	        
        	        $recharge_response_balance_field = $apiinfo->row(0)->recharge_response_balance_field;
        	        $recharge_response_remark_field = $apiinfo->row(0)->recharge_response_remark_field;
        	        $recharge_response_stat_field = $apiinfo->row(0)->recharge_response_stat_field;
        	        
        	        $recharge_response_fos_field = $apiinfo->row(0)->recharge_response_fos_field;
        	        $recharge_response_otf_field = $apiinfo->row(0)->recharge_response_otf_field;
        	        
        	         $recharge_response_lapunumber_field = $apiinfo->row(0)->recharge_response_lapunumber_field;
        	         $recharge_response_message_field = $apiinfo->row(0)->recharge_response_message_field;
        	         $pendingOnEmptyTxnId = $apiinfo->row(0)->pendingOnEmptyTxnId;
        	         $RecRespSuccessKey = $apiinfo->row(0)->RecRespSuccessKey;
        	         $RecRespPendingKey = $apiinfo->row(0)->RecRespPendingKey;
        	         $RecRespFailureKey = $apiinfo->row(0)->RecRespFailureKey;
        	          
        	         ///////////////////////////////////////////
        	         ////////////////////////////////////////
        	         ///////////////////////
        	         ///////////////////////////////////////////
        	         $operatorcode_rslt = $this->db->query("
                        	    select 
                        	    a.company_id,
                        	    a.company_name,
                        	    a.mcode,
                        	    a.service_id,
                        	    b.service_name,
                        	    g.commission,
                        	    g.commission_type,
                        	    g.commission_slab,
                        	    g.OpParam1,
                        	    g.OpParam2,
                        	    g.OpParam3,
                        	    g.OpParam4,
                        	    g.OpParam5
                        	    
                        	    from tblcompany a 
                        	    left join tblservice b on a.service_id = b.service_id 
                        	    left join tbloperatorcodes g on g.api_id = ? and a.company_id = g.company_id
                        	    where a.company_id = ?
                        	    order by service_id",array($api_id,$company_id));
                        	    $OpParam1 = '';
                        	    $OpParam2 = '';
                        	    $OpParam3 = '';
                        	    $OpParam4 = '';
                        	    $OpParam5 = '';
                    if($operatorcode_rslt->num_rows() == 1)
                    {
                        $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
                        $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
                        $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
                        $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
                        $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
                    }
                    $url = $hostname;
	        
	                //check recharge exist in tblpendingrecharges
	                $checkpending = $this->db->query("select recharge_id from tblpendingrechares where recharge_id = ?",array($recharge_id));
	                if($checkpending->num_rows() == 1)
	                {
	                    $this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->Id,$recharge_id));    
	                }
	                else
	                {
	                    $this->db->query("insert into tblpendingrechares
	                                    (recharge_id,company_id,api_id,mobile_no,amount,status,user_id,add_date,ishold,state_id)
	                                    values(?,?,?,?,?,?,?,?,?,?)
	                    ",array($recharge_id,$company_id,$api_id,$Mobile,$Amount,"Pending",$user_id,$recharge_datetime,'no',0));
	                }
	                
					
					$this->db->query("update tblrecharge set recharge_status = 'Pending',ExecuteBy = ?,retry = 'yes' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
	                $do_api_call = false;
	                
        	        if($transaction_api_method == "GET")
        	        {
        	            $do_api_call = true;
        	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
        	            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
        	            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
        	            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
        	            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
        	            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
        	            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
        	            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);
        	            
        	            $url = $hostname.$api_prepaid;
        	            $url  = str_replace("@mn",$Mobile, $url);
        	            $url  = str_replace("@amt",$Amount, $url);
        	            $url  = str_replace("@opparam1",$OpParam1, $url);
        	            $url  = str_replace("@opparam2",$OpParam2, $url);
        	            $url  = str_replace("@opparam3",$OpParam3, $url);
        	            $url  = str_replace("@opparam4",$OpParam4, $url);
        	            $url  = str_replace("@opparam5",$OpParam5, $url);
        	            $url  = str_replace("@reqid",$recharge_id, $url);
        	            $response = $this->common->callurl(trim($url),$recharge_id);  
        	        }
        	        if($transaction_api_method == "POST")
        	        {
        	            $do_api_call = true;
        	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
        	            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
        	            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
        	            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
        	            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
        	            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
        	            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
        	            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);
        	            
        	            $url = $hostname.$api_prepaid;
        	            $url  = str_replace("@mn",$Mobile, $url);
        	            $url  = str_replace("@amt",$Amount, $url);
        	            $url  = str_replace("@opparam1",$OpParam1, $url);
        	            $url  = str_replace("@opparam2",$OpParam2, $url);
        	            $url  = str_replace("@opparam3",$OpParam3, $url);
        	            $url  = str_replace("@opparam4",$OpParam4, $url);
        	            $url  = str_replace("@opparam5",$OpParam5, $url);
        	            $url  = str_replace("@reqid",$recharge_id, $url);
        	            
        	            
        	            $postdata = explode("?",$url)[1];
        	            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
        	        }
        	        
        	        if($do_api_call == true)
        	        {
        	            if($recharge_response_type == "XML")
                        {
                            $obj = (array)simplexml_load_string( $response);
                           
                            $recharge_response_status_field = str_replace("<","",$recharge_response_status_field);
                            $recharge_response_status_field = str_replace(">","",$recharge_response_status_field);
                            
                            // echo $recharge_response_status_field;
                            // echo "<br><br>";
                            // print_r($obj);exit;
                            
                            $recharge_response_opid_field = str_replace("<","",$recharge_response_opid_field);
                            $recharge_response_opid_field = str_replace(">","",$recharge_response_opid_field);
                            
                            $statusvalue = $obj[$recharge_response_status_field];
                            
                            $operator_id = json_encode($obj[$recharge_response_opid_field]);
                            $lapubalance = "";
                            
                            $success_key_array = explode(",",$RecRespSuccessKey);
                            $failure_key_array = explode(",",$RecRespFailureKey);
                            $pending_key_array = explode(",",$RecRespPendingKey);
                            
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
            				    $resparray = array(
	                                "message"=>"Recharge Success With Operator Id ".$operator_id ,
	                                "status"=>0,
	                                "statuscode"=>"Success",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = 'Failure';
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
            				    $resparray = array(
	                                "message"=>"Recharge Failed " ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else  if (in_array($statusvalue, $pending_key_array)) 
                            {
                                $status = 'Pending';
                                $operator_id = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge In Pending Process " ,
	                                "status"=>0,
	                                "statuscode"=>"Pending",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                        }
                        else if($recharge_response_type == "JSON")
                        {
                            $obj = (array)json_decode($response);
                           
                            $statusvalue = $obj[$recharge_response_status_field];
                            $operator_id = json_encode($obj[$recharge_response_opid_field]);
                            $lapubalance = "";
                            
                            $success_key_array = explode(",",$RecRespSuccessKey);
                            $failure_key_array = explode(",",$RecRespFailureKey);
                            $pending_key_array = explode(",",$RecRespPendingKey);
                            
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
            				    $resparray = array(
	                                "message"=>"Recharge Success With Operator Id ".$operator_id ,
	                                "status"=>0,
	                                "statuscode"=>"Success",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = 'Failure';
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
            				    $resparray = array(
	                                "message"=>"Recharge Failed " ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else  if (in_array($statusvalue, $pending_key_array)) 
                            {
                                $status = 'Pending';
                                $operator_id = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge In Pending Process " ,
	                                "status"=>0,
	                                "statuscode"=>"Pending",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                        }
                        else if($recharge_response_type == "CSV")
                        {
                            $obj = explode($response_separator,$response);
                           
                            $statusvalue = $obj[$recharge_response_status_field];
                            
                            $operator_id = json_encode($obj[$recharge_response_opid_field]);
                            $lapubalance = "";
                            
                            $success_key_array = explode(",",$RecRespSuccessKey);
                            $failure_key_array = explode(",",$RecRespFailureKey);
                            $pending_key_array = explode(",",$RecRespPendingKey);
                            
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
            				    $resparray = array(
	                                "message"=>"Recharge Success With Operator Id ".$operator_id ,
	                                "status"=>0,
	                                "statuscode"=>"Success",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = 'Failure';
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
            				    $resparray = array(
	                                "message"=>"Recharge Failed " ,
	                                "status"=>0,
	                                "statuscode"=>"Failure",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                            else  if (in_array($statusvalue, $pending_key_array)) 
                            {
                                $status = 'Pending';
                                $operator_id = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                $resparray = array(
	                                "message"=>"Recharge In Pending Process " ,
	                                "status"=>0,
	                                "statuscode"=>"Pending",
	                                "data"=>array
	                                        (
	                                            "url"=>$url,
	                                            "Response"=>$response
	                                        )
	                               );
            	                echo json_encode($resparray);exit;
                            }
                        }
        	        }
        	        else
        	        {
        	            $resparray = array(
	                                "message"=>"No Api Call Done"  ,
	                                "status"=>1
	                               );
	                    echo json_encode($resparray);exit;
        	        }
                   
        	      
			}
			else
			{
			    $resparray = array(
	                                "message"=>"Api Not Found"  ,
	                                "status"=>1
	                               );
	            echo json_encode($resparray);exit;
			}
            
            
///////////////////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////////////////////////                 
	                
	                
	                
	                
	                
	            }
	            else
	            {
	                $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	                echo json_encode($resparray);exit;
	            }
	        }
	        else
	        {
	            $resparray = array(
	                                "message"=>"Invalid Recharge Id"  ,
	                                "status"=>1
	                               );
	           echo json_encode($resparray);exit;
	        } 
	    }
	    else
	    {
	        $resparray = array(
	                                "message"=>"Some Parameters Missing"  ,
	                                "status"=>1
	                               );
	       echo json_encode($resparray);exit;
	    }
	}
	
	public function filter()
	{
	   
	    if(isset($_GET["date"]) and isset($_GET["status"]))
	    {
	        $date = trim($this->input->get("date"));
	        if($date == "today")
	        {
	            $status = trim($this->input->get("status"));
    	        $word = "";
        		$this->session->set_userdata("FromDate",$this->common->getMySqlDate());
        		$this->session->set_userdata("ToDate",$this->common->getMySqlDate());
        		$this->session->set_userdata("ddlstatus",$status);
        		
        		$this->session->set_userdata("ddlstatus",$status);
        		$this->session->set_userdata("txtNumId","");
        		$this->session->set_userdata("ddloperator","ALL");
        		$this->session->set_userdata("ddlapi","ALL");
        		$this->session->set_userdata("ddluser","ALL");
        		$this->session->set_userdata("ddlreroot","no");
        		$this->session->set_userdata("ddldb","LIVE");
        		$this->pageview();
	        }   
	    }
	}
	
}