<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_recharge_pending2 extends CI_Controller {
	
	
	private $msg=''; 
	private $message=''; 
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }
	private function manual_resend_checkduplicate($recharge_id)
	{
		$rslt = $this->db->query("insert into locking_manualresend (recharge_id,add_date,ipaddress) values(?,?,?)",array($recharge_id,$this->common->getDate(),$this->common->getRealIpAddr()));
		  if($rslt == "" or $rslt == NULL)
		  {
			return false;
		  }
		  else
		  {
			return true;
		  }
	}
	private function recharge_url_hit_checkduplicate($recharge_id,$API)
	{
		
		$rslt = $this->db->query("insert into remove_queue_duplication (recharge_id,add_date,ipaddress,API) values(?,?,?,?)",array($recharge_id,$this->common->getDate(),$this->common->getRealIpAddr(),$API));
		  if($rslt == "" or $rslt == NULL)
		  {
			return false;
		  }
		  else
		  {
			return true;
		  }
	}
	private function get_string_between($string, $start, $end)
 { 
	$string = ' ' . $string;
	
	if(strlen($start) > 0 )
	{
		$ini = strpos($string, $start);    
	}
	else
	{
		$ini = 0;
	}
	if ($ini == 0) return '';
	$ini += strlen($start);
	
	
	
	
	if($end == "")
	{
		$len = strlen($string);
	}
	else
	{
		$len = strpos($string, $end, $ini) - $ini;    
	}
	
	return substr($string, $ini, $len);
}
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}	
		$ddlapi = trim($this->session->userdata("ddlapi"));
		$ddloperator = trim($this->session->userdata("ddloperator"));
		$txtNumber = trim($this->session->userdata("txtNumber"));

		
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		
		
		$rslttotal = $this->db->query("select sum(amount) as total ,count(recharge_id) as totalcount from tblpendingrechares");
		$totalpendin = $rslttotal->row(0)->total;
		$totalpendincount = $rslttotal->row(0)->totalcount;
		
		$this->view_data["total"] = $totalpendin;
		$this->view_data["totalcount"] = $totalpendincount;
		
		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/list_recharge_pending2/pageview";
		$config['total_rows'] = $totalpendincount;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		
		
		
		
		
		$this->view_data['pagination'] = $this->pagination->create_links();
		
	
		
			$this->view_data['result_recharge'] = $this->db->query("select 
		
        		a.recharge_id,
        		a.mobile_no,
        		a.amount,
        		a.status as recharge_status,
        		a.user_id,
        		api.api_name as ExecuteBy,
        		a.add_date,
        		c.company_name,
				c.mcode,
        		b.businessname as name,
        		b.username,
				(select '') as response
        		from tblpendingrechares a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblcompany c on a.company_id = c.company_id 
			    left join api_configuration api on a.api_id = api.Id
				
				where 
				if(? > 0,a.api_id = ?,true) and
				if(? > 0,a.company_id = ?,true) and
				if(? != '',a.mobile_no = ?,true) 
				order by a.recharge_id limit ?,? ",array($ddlapi,$ddlapi,$ddloperator,$ddloperator,$txtNumber,$txtNumber,intval($start_row),intval($per_page)));
				
	
		
		$this->view_data['message'] =$this->msg;
		$this->view_data['ddlapi'] =$ddlapi;
		$this->view_data['ddloperator'] =$ddloperator;
		$this->view_data['txtNumber'] =$txtNumber;
		
		
		$this->load->view('_Admin/list_recharge_pending2_view',$this->view_data);	
		return 0;	
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
			if($this->input->post('hidactionall') == "settoall")
			{
				$this->load->model("Update_methods");
				$status = $this->input->post("hidactionallstatus");
				$chkarr = $this->input->post("chkp");
				if(is_array($chkarr))
				{
					
					foreach($chkarr as $r)
					{
						$recharge_id =  $r;
						$operator_id = $this->input->post("txtOpId".$recharge_id);
						$recharge_info = $this->db->query("select * from tblrecharge where recharge_id = ? and (recharge_status = 'Pending' or recharge_status = '')",array($recharge_id));
						if($recharge_info->num_rows() == 1)
						{
							$user_id = $recharge_info->row(0)->user_id;
							$company_id = $recharge_info->row(0)->company_id;
							$Amount = $recharge_info->row(0)->amount;
							$Mobile = $recharge_info->row(0)->mobile_no;
							
							$resend_apiinfo = $this->db->query("select a.*,b.Name as apigroup_name  from tblapi a
							left join tblapiroups b on a.apigroup = b.Id
							 where a.api_name = ?",array($status));
							 if($resend_apiinfo->num_rows() == 1)
							 {
							 	$apigroup_name = $resend_apiinfo->row(0)->apigroup_name;
								if( preg_match('/OTOMAX/',$status) == 1)
								{
								  
									$api_name = $status;
									$recharge_info = $this->db->query("select * from tblrecharge where recharge_id = ? and recharge_status = 'Pending'",array($recharge_id));
									if($recharge_info->num_rows() == 1)
									{
										$Mobile = $recharge_info->row(0)->mobile_no;
										$Amount = $recharge_info->row(0)->amount;
										$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($api_name));
										if($apiinfo->num_rows() == 1)
										{
											$company_info = $this->db->query("select * from tblcompany where company_id = ?",array($recharge_info->row(0)->company_id));
											
											
											
											$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
											$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
													
											$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
											$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'yes' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
											
										
											$response_type = "CSV";
											$order_id = "";
											$Message = "Rechareg Accepted";
											$CODE = "";
											$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($apiinfo->row(0)->api_id,$company_id));
											if($rsltcodeinfo->num_rows() == 1)
											{
												$CODE = $rsltcodeinfo->row(0)->code;
											}
											//103.250.189.232:6968
											$req = $apiinfo->row(0)->static_ip.'?memberid='.$apiinfo->row(0)->username.'&pin='.$apiinfo->row(0)->apitocken.'&password='.$apiinfo->row(0)->password.'&product='.$CODE.'&qty='.$Amount.'&dest='.$Mobile.'&refID='.$recharge_id;
											$this->db->query("insert into tblmiddler(recharge_id,sms,add_date,API) values(?,?,?,?)",array($recharge_id,$req,$this->common->getDate(),$apiinfo->row(0)->api_name));
											
											$this->db->query("insert into tblreqresp(user_id,request,response,add_date,ipaddress,recharge_id,mobile_no,amount,company_id) values(?,?,?,?,?,?,?,?,?)",array($user_id,$req,"",$this->common->getDate(),$this->common->getRealIpAddr(),$recharge_id,$Mobile,$Amount,$company_id));
			
										
										}
									}
									
									
	
	
								}
								
								else if($apigroup_name == "EVAN")
								{
									$field1 = '';
									$field2 = '';
									$api_name = $status;
									$Mobile = $recharge_info->row(0)->mobile_no;
									$Amount = $recharge_info->row(0)->amount;
									$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($api_name));
									if($apiinfo->num_rows() == 1)
									{
									
										$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
										$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
											$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
													
										$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
										$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'yes' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
										
										$response_type = "CSV";
										$order_id = "";
										$Message = "Rechareg Accepted";
	
	
	
										$company_info = $this->db->query("select * from tblcompany where company_id = ?",array($recharge_info->row(0)->company_id));
										
						$CODE = "";
						$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($apiinfo->row(0)->api_id,$company_id));
						if($rsltcodeinfo->num_rows() == 1)
						{
							$CODE = $rsltcodeinfo->row(0)->code;
						}
	
										$field1 = '';
										$field2 = '';
										$req = $apiinfo->row(0)->static_ip."?apiToken=".$apiinfo->row(0)->apitocken."&mn=".$Mobile."&op=".$CODE."&amt=".$Amount."&reqid=".$recharge_id."&field1=$field1&field2=$field2";
										 $this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
										$resp = $this->common->callurl($req);
										$status = $this->get_string_between($resp, "<status>", "</status>");
										$operator_id = $this->get_string_between($resp, "<field1>", "</field1>");
									
										if($status == "" or $status==NULL)
										{
											$status="Pending";
										}
										else if($status == "SUCCESS" )
										{
											$operator_trans_id = $array["field1"];
											$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Success");
											//$this->custom_response($recharge_id,$Mobile,$Amount,"Success",$opid,$recharge_id,$response_type);
										}
										else if($status == "FREQUENT")
										{
											//$this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$recharge_id,$response_type);
										}
	
										else if($status == "PENDING")
										{
											//$this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$recharge_id,$response_type);
										}
										else if($status == "FAILED" or $status == "REFUND")
										{
											$this->Update_methods->updateRechargeStatus($recharge_id,"","Failure");
											$Message = "Recharge Failed";
											//$this->custom_response($recharge_id,$Mobile,$Amount,"Failure",$Message,$recharge_id,$response_type);
										}
									}
									
	
	
								}
								else if($apigroup_name == "ATOM")
								{
									$field1 = '';
									$field2 = '';
									$api_name = $status;
									$Mobile = $recharge_info->row(0)->mobile_no;
									$Amount = $recharge_info->row(0)->amount;
					$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($resend_apiinfo->row(0)->api_name));
					if($apiinfo->num_rows() == 1)
					{
					
						$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
						$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
							$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
									
						$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
						$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'manual' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
						
						$response_type = "CSV";
						$order_id = "";
						$Message = "Rechareg Accepted";



						$company_info = $this->db->query("select * from tblcompany where company_id = ?",array($recharge_info->row(0)->company_id));
						putenv("TZ=Asia/Calcutta");
						date_default_timezone_set('Asia/Calcutta');
						$add_date = $this->common->getDate();

						$adt = urlencode(date_format(date_create($this->common->getDate()),'d/m h:i:s'));
						$req = $apiinfo->row(0)->static_ip.'?uid='.$apiinfo->row(0)->username.'&pwd='.$apiinfo->row(0)->password.'&lapunumber='.$apiinfo->row(0)->params.'&apitoken='.$apiinfo->row(0)->apitocken.'&mn='.$Mobile.'&amt='.$Amount.'&reqid='.$recharge_id;	
						//$url = 'http://atom.clareinfotech.com/ws/vodafone?uid=maharshi.telecom@gmail.com&pwd=dilip2612&apitoken=a44c191d56d945d09385937490a25424&mn='.$Mobile.'&amt='.$Amount.'&reqid='.$recharge_id;
						$mars_response = $this->common->callurl($req);
						$this->loging($recharge_id,"list_recharge_pending2","response".$mars_response);
						$jsonpbj = json_decode($mars_response);
						if(isset($jsonpbj->reqid) and isset($jsonpbj->status))
						{
							$this->loging($recharge_id,"list_recharge_pending2","reqid status key found");
							$reqid = trim((string)$jsonpbj->reqid);
							$status_s = trim((string)$jsonpbj->status);
							$remarkmsg= trim((string)$jsonpbj->remark);
							$opid = trim((string)$jsonpbj->opid);
							$this->loging($recharge_id,"list_recharge_pending2","reqid status key found ".$status_s."   ".$opid);
							if($status_s == "FAILED")
							{
								$this->loging($recharge_id,"list_recharge_pending2","IN FAILED ");
							  $this->Update_methods->updateRechargeStatus($recharge_id,$opid,"Failure",false);
							  $this->loging($recharge_id,"list_recharge_pending2","IN updateRechargeStatus ");
							}
							else if($status_s == "SUCCESS")
							{
								  $this->loging($recharge_id,"list_recharge_pending2","IN SUCCESS ");
								  $this->Update_methods->updateRechargeStatus($recharge_id,$opid,"Success",false);
								  $this->loging($recharge_id,"list_recharge_pending2","IN updateRechargeStatus ");
							}
							else
							{
								$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
							}
						}
						else
						{
							$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
				
						}

						
					}
									
	
	
								}
								else if($apigroup_name == "KRISHNA")
								{
									$field1 = '';
									$field2 = '';
									$api_name = $status;
									$Mobile = $recharge_info->row(0)->mobile_no;
									$Amount = $recharge_info->row(0)->amount;
					$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($resend_apiinfo->row(0)->api_name));
					if($apiinfo->num_rows() == 1)
					{
					
						$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
						$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
							$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
									
						$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
						$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'manual' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
						
						$response_type = "CSV";
						$order_id = "";
						$Message = "Rechareg Accepted";



						$CODE = "";
						$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($apiinfo->row(0)->api_id,$company_id));
						if($rsltcodeinfo->num_rows() == 1)
						{
							$CODE = $rsltcodeinfo->row(0)->code;
						}
						putenv("TZ=Asia/Calcutta");
						date_default_timezone_set('Asia/Calcutta');
						$add_date = $this->common->getDate();
						$adt = urlencode(date_format(date_create($this->common->getDate()),'d/m h:i:s'));
						$req = $apiinfo->row(0)->static_ip."?acc_no=".$apiinfo->row(0)->username."&api_key=".$apiinfo->row(0)->apitocken."&opr_code=".$CODE."&rech_num=".$Mobile."&amount=".$Amount."&client_key=".$recharge_id;
						$this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
						$resp = $this->common->callurl($req);
						$response_array = explode(",",$resp);
						if(count($response_array) >= 7)
						{
							$status = $response_array[0];
							$operator_id = $response_array[6];
							if($status == "success")
							{
								$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Success");
							}
							else if($status == "failure")
							{
								$this->Update_methods->updateRechargeStatus($recharge_id,"","Failure");
							}
							else
							{
								$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
							}
						}

						
					}
									
	
	
								}
								else
								{
									$ApiInfo = $this->db->query("select * from tblapi where api_name = ?",array($status));
									if($ApiInfo->num_rows() == 1)
									{
										if (preg_match('/[CODE]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[MOBILE]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[AMOUNT]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[REFID]/',$ApiInfo->row(0)->params) == 1)  
										{
											$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
											$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
												$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
														
											$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
											$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'yes' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
										
											$CODE = "";
											$rsltcodeinfo = $this->db->query("select * from tbloperatorcodes where api_id = ? and company_id = ?",array($ApiInfo->row(0)->api_id,$company_id));
											if($rsltcodeinfo->num_rows() == 1)
											{
												$CODE = $rsltcodeinfo->row(0)->code;
											}
	
											$Message = "Request Acepted";
											$order_id = $recharge_id;
											$response_type = "CSV";
											$params = str_replace("[MOBILE]",$Mobile,trim($ApiInfo->row(0)->params));
											$params = str_replace("[AMOUNT]",$Amount,$params);
											$params = str_replace("[REFID]",$recharge_id,$params);
											$params = str_replace("[CODE]",$CODE,$params);
	
											$params = str_replace("&amp;","&",$params);
											$params = str_replace(";","",$params);
	
											$req = $ApiInfo->row(0)->static_ip."?".$params;
											$mars_response = $this->common->callurl(trim($req));
											$resp = $mars_response;
	
											$rsltmessagesettings = $this->db->query("select * from message_setting where api_id = ?",array($ApiInfo->row(0)->api_id));
											foreach($rsltmessagesettings->result() as $r)
											{
												$status_word = $r->status_word;
												$num_start = $r->number_start;
												$num_end = $r->number_end;
												$operator_id_start = $r->operator_id_start;
												$operator_id_end = $r->operator_id_end;
												$status = $r->status;
												$api_id = $r->api_id;
												//echo $status_word;exit;
	
												if (preg_match("/".$status_word."/",$resp) == 1)
												{
	
													$mobile_no = $this->get_string_between($resp, $num_start, $num_end);
													$operator_id = $this->get_string_between($resp, $operator_id_start, $operator_id_end);
	
													$operator_id = str_replace("\n","",$operator_id);
													$mobile_no = str_replace("\n","",$mobile_no);
	
													$this->load->model("Update_methods");
													$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);
													//return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,"",$response_type);
	
	
												}
												else
												{
												//	echo "Not Found<br>";
												}
	
											}
	
										}
									}
								}
							 }
							else if($status == "Success" or $status == "Failure")
							{
								$this->db->query("update tblrecharge set retry = 'dont' where recharge_id = ?",array($recharge_id));
								$this->load->model("Update_methods");
								$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);
							}
							
							else
							{
								$recharge_info = $this->Tblrecharge_methods->getRechargeTblEntry($recharge_id);
								$hidid = $this->input->post("hidid",TRUE);
								$oldStatus = $recharge_info->row(0)->recharge_status;
								if($status == "Success" or $status == "Failure")
								{
									$this->db->query("update tblrecharge set retry = 'dont' where recharge_id = ?",array($recharge_id));
									$this->load->model("Update_methods");
									$this->Update_methods->updateRechargeStatus($recharge_id,$hidid,$status);
								}

							}
							
							
							
							
						}
						
					}
				}
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Action Submitted Successfully");
				redirect(base_url()."_Admin/list_recharge_pending2?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			else if($this->input->post('hidaction') == "Set")
			{		
				$this->load->model("Tblrecharge_methods");							
				$status = $this->input->post("hidstatus",TRUE);
				$recharge_id = $this->input->post("hidrechargeid",TRUE);
				$recharge_info = $this->db->query("select * from tblrecharge where recharge_id = ? and (recharge_status = 'Pending' or recharge_status = '')",array($recharge_id));
				if($recharge_info->num_rows() == 1)
				{
					$this->load->model("Update_methods");
					$user_id = $recharge_info->row(0)->user_id;
					$company_id = $recharge_info->row(0)->company_id;
					$Amount = $recharge_info->row(0)->amount;
					$Mobile = $recharge_info->row(0)->mobile_no;
					
					$resend_apiinfo = $this->db->query("select a.*,b.Name as apigroup_name  from tblapi a
					left join tblapiroups b on a.apigroup = b.Id
					 where a.api_name = ?",array($status));
					 if($resend_apiinfo->num_rows() == 1)
					 {
						$apigroup_name = $resend_apiinfo->row(0)->apigroup_name;
						if( preg_match('/OTOMAX/',$status) == 1)
						{
						  
							$api_name = $status;
							if($recharge_info->num_rows() == 1)
							{
								$Mobile = $recharge_info->row(0)->mobile_no;
								$Amount = $recharge_info->row(0)->amount;
								$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($apigroup_name->row(0)->api_name));
								if($apiinfo->num_rows() == 1)
								{
									$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
									$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
											
									$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
									$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'yes' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
									
								
									$response_type = "CSV";
									$order_id = "";
									$Message = "Rechareg Accepted";
									$CODE = "";
									$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($apiinfo->row(0)->api_id,$company_id));
									if($rsltcodeinfo->num_rows() == 1)
									{
										$CODE = $rsltcodeinfo->row(0)->code;
									}
									//103.250.189.232:6968
									$req = $apiinfo->row(0)->static_ip.'?memberid='.$apiinfo->row(0)->username.'&pin='.$apiinfo->row(0)->apitocken.'&password='.$apiinfo->row(0)->password.'&product='.$CODE.'&qty='.$Amount.'&dest='.$Mobile.'&refID='.$recharge_id;
									$this->db->query("insert into tblmiddler(recharge_id,sms,add_date,API) values(?,?,?,?)",array($recharge_id,$req,$this->common->getDate(),$apiinfo->row(0)->api_name));
									
									$this->db->query("insert into tblreqresp(user_id,request,response,add_date,ipaddress,recharge_id,mobile_no,amount,company_id) values(?,?,?,?,?,?,?,?,?)",array($user_id,$req,"",$this->common->getDate(),$this->common->getRealIpAddr(),$recharge_id,$Mobile,$Amount,$company_id));
	
								
								}
							}
							
							


						}
					
						else if($apigroup_name == "EVAN")
						{
							$field1 = '';
							$field2 = '';
							$api_name = $status;
							$Mobile = $recharge_info->row(0)->mobile_no;
							$Amount = $recharge_info->row(0)->amount;
							$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($apigroup_name));
							if($apiinfo->num_rows() == 1)
							{
							
								$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
								$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
									$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
											
								$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
								$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'yes' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
								
								$response_type = "CSV";
								$order_id = "";
								$Message = "Rechareg Accepted";


								
				$CODE = "";
				$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($apiinfo->row(0)->api_id,$company_id));
				if($rsltcodeinfo->num_rows() == 1)
				{
					$CODE = $rsltcodeinfo->row(0)->code;
				}

								$field1 = '';
								$field2 = '';
								$req = $apiinfo->row(0)->static_ip."?apiToken=".$apiinfo->row(0)->apitocken."&mn=".$Mobile."&op=".$CODE."&amt=".$Amount."&reqid=".$recharge_id."&field1=$field1&field2=$field2";
								 $this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
								$resp = $this->common->callurl($req);
								$status = $this->get_string_between($resp, "<status>", "</status>");
								$operator_id = $this->get_string_between($resp, "<field1>", "</field1>");
							
								if($status == "" or $status==NULL)
								{
									$status="Pending";
								}
								else if($status == "SUCCESS" )
								{
									$operator_trans_id = $array["field1"];
									$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Success");
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Success",$opid,$recharge_id,$response_type);
								}
								else if($status == "FREQUENT")
								{
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$recharge_id,$response_type);
								}

								else if($status == "PENDING")
								{
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$recharge_id,$response_type);
								}
								else if($status == "FAILED" or $status == "REFUND")
								{
									$this->Update_methods->updateRechargeStatus($recharge_id,"","Failure");
									$Message = "Recharge Failed";
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Failure",$Message,$recharge_id,$response_type);
								}
							}
							


						}
						else if($apigroup_name == "ATOM")
						{
							$field1 = '';
							$field2 = '';
							$api_name = $status;
							$Mobile = $recharge_info->row(0)->mobile_no;
							$Amount = $recharge_info->row(0)->amount;
			$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($resend_apiinfo->row(0)->api_name));
			if($apiinfo->num_rows() == 1)
			{
			
				$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
				$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
					$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
							
				$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
				$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'manual' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
				
				$response_type = "CSV";
				$order_id = "";
				$Message = "Rechareg Accepted";
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');
				$add_date = $this->common->getDate();

				$adt = urlencode(date_format(date_create($this->common->getDate()),'d/m h:i:s'));
				$req = $apiinfo->row(0)->static_ip.'?uid='.$apiinfo->row(0)->username.'&pwd='.$apiinfo->row(0)->password.'&lapunumber='.$apiinfo->row(0)->params.'&apitoken='.$apiinfo->row(0)->apitocken.'&mn='.$Mobile.'&amt='.$Amount.'&reqid='.$recharge_id;	
				//$url = 'http://atom.clareinfotech.com/ws/vodafone?uid=maharshi.telecom@gmail.com&pwd=dilip2612&apitoken=a44c191d56d945d09385937490a25424&mn='.$Mobile.'&amt='.$Amount.'&reqid='.$recharge_id;
				$mars_response = $this->common->callurl($req);
				$this->loging($recharge_id,"list_recharge_pending2","response".$mars_response);
				$jsonpbj = json_decode($mars_response);
				if(isset($jsonpbj->reqid) and isset($jsonpbj->status))
				{
					$this->loging($recharge_id,"list_recharge_pending2","reqid status key found");
					$reqid = trim((string)$jsonpbj->reqid);
					$status_s = trim((string)$jsonpbj->status);
					$remarkmsg= trim((string)$jsonpbj->remark);
					$opid = trim((string)$jsonpbj->opid);
					$this->loging($recharge_id,"list_recharge_pending2","reqid status key found ".$status_s."   ".$opid);
					if($status_s == "FAILED")
					{
						$this->loging($recharge_id,"list_recharge_pending2","IN FAILED ");
					  $this->Update_methods->updateRechargeStatus($recharge_id,$opid,"Failure",false);
					  $this->loging($recharge_id,"list_recharge_pending2","IN updateRechargeStatus ");
					}
					else if($status_s == "SUCCESS")
					{
						  $this->loging($recharge_id,"list_recharge_pending2","IN SUCCESS ");
						  $this->Update_methods->updateRechargeStatus($recharge_id,$opid,"Success",false);
						  $this->loging($recharge_id,"list_recharge_pending2","IN updateRechargeStatus ");
					}
					else
					{
						$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
					}
				}
				else
				{
					$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
		
				}

				
			}
							


						}
						else if($apigroup_name == "KRISHNA")
						{
							$field1 = '';
							$field2 = '';
							$api_name = $status;
							$Mobile = $recharge_info->row(0)->mobile_no;
							$Amount = $recharge_info->row(0)->amount;
			$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($resend_apiinfo->row(0)->api_name));
			if($apiinfo->num_rows() == 1)
			{
			
				$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
				$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
					$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
							
				$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
				$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'manual' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
				
				$response_type = "CSV";
				$order_id = "";
				$Message = "Rechareg Accepted";



				$CODE = "";
				$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($apiinfo->row(0)->api_id,$company_id));
				if($rsltcodeinfo->num_rows() == 1)
				{
					$CODE = $rsltcodeinfo->row(0)->code;
				}
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');
				$add_date = $this->common->getDate();
				$adt = urlencode(date_format(date_create($this->common->getDate()),'d/m h:i:s'));
				$req = $apiinfo->row(0)->static_ip."?acc_no=".$apiinfo->row(0)->username."&api_key=".$apiinfo->row(0)->apitocken."&opr_code=".$CODE."&rech_num=".$Mobile."&amount=".$Amount."&client_key=".$recharge_id;
				$this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
				$resp = $this->common->callurl($req);
				$response_array = explode(",",$resp);
				if(count($response_array) >= 7)
				{
					$status = $response_array[0];
					$operator_id = $response_array[6];
					if($status == "success")
					{
						$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Success");
					}
					else if($status == "failure")
					{
						$this->Update_methods->updateRechargeStatus($recharge_id,"","Failure");
					}
					else
					{
						$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
					}
				}

				
			}
							


						}
						else
						{
							$ApiInfo = $this->db->query("select * from tblapi where api_name = ?",array($status));
							if($ApiInfo->num_rows() == 1)
							{
								if (preg_match('/[CODE]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[MOBILE]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[AMOUNT]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[REFID]/',$ApiInfo->row(0)->params) == 1)  
								{
									$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($recharge_info->row(0)->company_id,$recharge_info->row(0)->ExecuteBy));
									$this->db->query("update operatorpendinglimit set totalpending = totalpending - 1 where company_id = ? and api_id = (select api_id from tblapi where api_name = ?)",array($company_id,$recharge_info->row(0)->ExecuteBy));
										$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$apiinfo->row(0)->api_id));
												
									$this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($apiinfo->row(0)->api_id,$recharge_id));
									$this->db->query("update tblrecharge set ExecuteBy = ?,retry = 'yes' where recharge_id = ?",array($apiinfo->row(0)->api_name,$recharge_id));
								
									$CODE = "";
									$rsltcodeinfo = $this->db->query("select * from tbloperatorcodes where api_id = ? and company_id = ?",array($ApiInfo->row(0)->api_id,$company_id));
									if($rsltcodeinfo->num_rows() == 1)
									{
										$CODE = $rsltcodeinfo->row(0)->code;
									}

									$Message = "Request Acepted";
									$order_id = $recharge_id;
									$response_type = "CSV";
									$params = str_replace("[MOBILE]",$Mobile,trim($ApiInfo->row(0)->params));
									$params = str_replace("[AMOUNT]",$Amount,$params);
									$params = str_replace("[REFID]",$recharge_id,$params);
									$params = str_replace("[CODE]",$CODE,$params);

									$params = str_replace("&amp;","&",$params);
									$params = str_replace(";","",$params);

									$req = $ApiInfo->row(0)->static_ip."?".$params;
									$mars_response = $this->common->callurl(trim($req));
									$resp = $mars_response;

									$rsltmessagesettings = $this->db->query("select * from message_setting where api_id = ?",array($ApiInfo->row(0)->api_id));
									foreach($rsltmessagesettings->result() as $r)
									{
										$status_word = $r->status_word;
										$num_start = $r->number_start;
										$num_end = $r->number_end;
										$operator_id_start = $r->operator_id_start;
										$operator_id_end = $r->operator_id_end;
										$status = $r->status;
										$api_id = $r->api_id;
										//echo $status_word;exit;

										if (preg_match("/".$status_word."/",$resp) == 1)
										{

											$mobile_no = $this->get_string_between($resp, $num_start, $num_end);
											$operator_id = $this->get_string_between($resp, $operator_id_start, $operator_id_end);

											$operator_id = str_replace("\n","",$operator_id);
											$mobile_no = str_replace("\n","",$mobile_no);

											$this->load->model("Update_methods");
											$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);
											//return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,"",$response_type);


										}
										else
										{
										//	echo "Not Found<br>";
										}

									}

								}
							}
						}
					 }
					else if($status == "Success" or $status == "Failure")
					{
						$this->db->query("update tblrecharge set retry = 'dont' where recharge_id = ?",array($recharge_id));
						$this->load->model("Update_methods");
						$this->Update_methods->updateRechargeStatus($recharge_id,"",$status);
					}
					
					else
					{
						$recharge_info = $this->Tblrecharge_methods->getRechargeTblEntry($recharge_id);
						$hidid = $this->input->post("hidid",TRUE);
						$oldStatus = $recharge_info->row(0)->recharge_status;
						if($status == "Success" or $status == "Failure")
						{
							$this->db->query("update tblrecharge set retry = 'dont' where recharge_id = ?",array($recharge_id));
							$this->load->model("Update_methods");
							$this->Update_methods->updateRechargeStatus($recharge_id,$hidid,$status);
						}
					}
				}
				
				
					redirect(base_url()."_Admin/list_recharge_pending2?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			else if($this->input->post('btnSubmit'))
			{
				$ddlapi = $this->input->post('ddlapi',true);
				$ddloperator = $this->input->post('ddloperator',true);
				$txtNumber = $this->input->post('txtNumber',true);
				$this->session->set_userdata("ddlapi",$ddlapi);
				$this->session->set_userdata("ddloperator",$ddloperator);
				$this->session->set_userdata("txtNumber",$txtNumber);
				$this->pageview();
			}
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->session->set_userdata("ddlapi","ALL");
				$this->session->set_userdata("ddloperator","ALL");
				$this->session->set_userdata("txtNumber","");
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function resolveFailureToSuccess($recharge_id,$recUser)
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
	public function resolveSuccessToFailure($recharge_id,$recUser)
	{
		$this->load->model("Insert_model");
		$this->Insert_model->refundOfAcountReportEntry($recharge_id);
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
		$filename = "responseurls.txt";
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
	public function callurl($url)
{	
	// $username;exit;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	$buffer = curl_exec($ch);	
	curl_close($ch);
	return $buffer;
}
public function callapi($url,$postfields)
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		$buffer = curl_exec($ch);
		curl_close($ch);
		
		return $buffer;
	}
public function refundOfAcountReportEntry($recharge_id)
{
	$rsltrech = $this->db->query("select reverted,debited,recharge_id,transaction_id,ewallet_id from tblrecharge where recharge_id = '$recharge_id'");
	if($rsltrech->num_rows() > 0)
	{
		$ewalletarr = explode(",",$rsltrech->row(0)->ewallet_id);
		if(!isset($ewalletarr[1]))
		{
		return 0;
		}
		$ewallet_id = $ewalletarr[1];	
		$debited = $rsltrech->row(0)->debited;
		if($rsltrech->row(0)->reverted == "no")
		{
			$rslt = $this->db->query("select * from tblewallet where Id = '$ewallet_id'");
			if($rslt->num_rows() == 1)
			{
				$user_id = $rslt->row(0)->user_id;
				$date = $this->common->getDate();
				$this->load->model("Tblcompany_methods");
				$debit_amount = $rslt->row(0)->debit_amount;
				$transaction_type = "Recharge_Refund";
				$cr_amount = $debit_amount;
				$recid = $rslt->row(0)->recharge_id;
				$Description = "Refund : ".$rslt->row(0)->description." | Revert Date = ".$date;
			$ewallet_id = $this->Insert_model->tblewallet_Recharge_CrEntry($user_id,$recid,$transaction_type,$cr_amount,$Description);
				$this->db->query("update tblrecharge set reverted = 'yes',ewallet_id = CONCAT_WS(',',ewallet_id,?),revert_description = ? where recharge_id = ?",array($ewallet_id,$Description,$recid));
			}
		}
	}
	
	
}
public function sendRechargeSMS($company_name,$Mobile,$Amount,$TransactionID,$status,$balance,$senderMobile)
{
	$smsMessage = 'Dear Your Request is Com : '.$company_name->row(0)->company_name.' Number : '.$Mobile.' Amt : '.$Amount.' Tx id : '.$TransactionID.' Status : '.$status.' A/C Bal : '.$balance.' MasterPay.co.in';	
$this->load->model();
$result = $this->ExecuteSMSApi($senderMobile,$smsMessage);
		
}
public function ExecuteSMSApi($mobile_no,$message) 
	{
		 $message = rawurlencode($message);
		$buffer = file_get_contents("http://sms.marutiwala.in/api/sendmsg.php?user=12312pass=2112312&sender=OMYSI&phone=".$mobile_no."&text=".$message."&priority=ndnd&stype=normal");
		$this->addSentMessage($mobile_no,$message,$buffer);	
		return $buffer;   
	}
	public	function addSentMessage($mobile_no,$message,$buffer)
	{
		
		$this->load->library('common');
		$date = $this->common->getDate();
		$date1 = $this->common->getMySqlDate();
		$str_query = "INSERT INTO `tblsentsms`(`toNumber`, `message`, `response`, `add_date`) VALUES (?,?,?,?)";
		$result = $this->db->query($str_query,array($mobile_no,rawurldecode($message),$buffer,$date1));
		
			
	}
	public function custom_response($recharge_id,$mobile_no,$amount,$status,$message,$order_id,$response_type)
	{
		redirect(base_url()."_Admin/list_recharge_pending2?crypt=".$this->Common_methods->encrypt("MyData"));
	}	
	public function gettransactions()
	{
	    $result = $this->db->query("select 
		
        		a.recharge_id,
        		a.mobile_no,
        		a.amount,
        		a.status as recharge_status,
        		a.user_id,
        		api.api_name as ExecuteBy,
        		a.add_date,
        		c.company_name,
        		b.businessname as name,
        		b.username
        		from tblpendingrechares a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblcompany c on a.company_id = c.company_id 
			    left join tblapi api on a.api_id = api.api_id
				
				order by a.recharge_id");
		$resp = '';
		$resp.='
		<table class="table table-responsive table-striped .table-bordered mytable-border" style="font-size:14px;color:#000000;font-weight:normal;font-family:sans-serif">
    <tr>  
	<th></th> 
     <th>SR No.</th> 
     <th>Recharge Id</th>
    <th>Recharge Date</th>
    <th>Name</th>
   <th>Company Name</th>
	<th>Mobile No</th>    
	<th>Amount</th>    
   	<th>API</th>    
    <th>Response</th> 
   	<th>Status</th>    
	<th>Action</th>  
    <th></th>                 
    </tr>
		';
		 $strrecid = '';
	    $k = 1;
		$i = $result_recharge->num_rows();foreach($result_recharge->result() as $result) 	
	    {
	        
	        if($k >50)
	        {
	            break;
	        }
	        $recdt = $result->add_date;
    		$recdatetime =date_format(date_create($recdt),'Y-m-d h:i:s');
    		$cdate =date_format(date_create($this->common->getDate()),'Y-m-d h:i:s');
    	    $this->load->model("Update_methods");
    	    $diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
	    
	    
        	if(isset($result->recharge_id)) 
			{
				$strrecid .=$result->recharge_id."#"; 
			}
        
    	    if($diff > 5) 
    	    {
    	        $resp.='<tr class="error"  style="border-top: 1px solid #000;">';
    	    }
    	    else
    	    {
    	        $resp.=' <tr style="border-top: 1px solid #000;" >';
    	    }
    	    $resp .='
    	    
    	    <td><input type="checkbox" name="chkp[]" id="chkp'.$result->recharge_id.'" value="'.$result->recharge_id.'" class="checkBoxrecharge"></td>';
    	    
             $resp .='<td>'.$i.'</td>';
            $resp .='<td><a href="'.base_url()."recharge_detail/index/".$this->Common_methods->encrypt($result->recharge_id).'" target="_blank">'.$result->recharge_id.'</a></td>';
 $resp .='<td>'.$result->add_date.'</td>';
 $resp .='<td>'.$result->name.'</td>';
  $resp .='<td>'.$result->company_name.'</td>
 <td>'.$result->mobile_no.'</td>
 <td>'.$result->amount.'</td>
 <td>'.$result->ExecuteBy.'</td>';
 
  $resp .='<td><input type="text"  id="txtOpId'.$result->recharge_id.'" name="txtOpId'.$result->recharge_id.'" class="form-control" style="width:80px;"></td>
<td> <span class="orange"><a id="sts'.$result->recharge_id.'" href="javascript:statuschecking("'.$result->recharge_id.'")" >Pending</a></span></td>';

 $resp .='<td>';
  
 $resp .'<select style="width:80px;" class="form-control" id="action_'.$result->recharge_id.'" >
     <option value="Select">Select</option>
     <option value="Pending">Pending</option>
     <option value="Success">Success</option>
     <option value="Failure">Failure</option> ';
    
	 	$apirsl = $this->db->query("select * from tblapi order by api_name");
	 	foreach($apirsl->result() as $rapi)
		{
			$resp .'<option value="'.$rapi->api_name.'">'.$rapi->api_name.'</option>';
		}
	 
 $resp .'</select>';

 $resp .'</td>';
 $resp .'<td>
 <input type="button" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-success" onClick="ActionSubmit(\"'.$result->recharge_id.'\",\"'.$result->mobile_no.'\")">
 </td>';
 $resp .'</tr>';
	    $i++;

		}
		$resp.='</table>';
		echo $resp;
	}
	private function loging($recharge_id,$actionfrom,$remark)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into tbllogs(recharge_id,add_date,ipaddress,actionfrom,remark) values(?,?,?,?,?)",
						array($recharge_id,$add_date,$ipaddress,$actionfrom,$remark));
	}
	public function setoperatorselected()
	{
		if(isset($_GET["company_id"]))
		{
			$session_operator_array = $this->session->userdata("pending_chk_operator");
			if($session_operator_array == false)
			{
				$session_operator_array = array();
			}
			$company_id = trim($_GET["company_id"]);
			$action = trim($_GET["action"]);
			if($action == "SET")
			{
				array_push($session_operator_array,$company_id);
				$session_operator_array = array_unique($session_operator_array);
				$this->session->set_userdata("pending_chk_operator",$session_operator_array);
				print_r($session_operator_array);exit;
			}
			else
			{	
				if (($key = array_search($company_id, $session_operator_array)) !== false) 
				{
					unset($session_operator_array[$key]);
				}
				
				
 				$session_operator_array = array_unique($session_operator_array);
				$this->session->set_userdata("pending_chk_operator",$session_operator_array);
				echo "OK";exit;
			}
			
		}
	}
}