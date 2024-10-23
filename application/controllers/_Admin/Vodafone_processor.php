<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vodafone_processor extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function get_string_between($string, $start, $end)
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
		
		if ($ini == 0) {return '';}
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
    public function checkduplicate($recharge_id,$API)
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
    public function gettotalapi()
    {
        $resp = '';
        $rslt = $this->db->query("SELECT a.api_id,a.status,c.api_name,b.multi_threaded FROM `tblpendingrechares` a left join operatorpendinglimit b on a.api_id = b.api_id and a.company_id = b.company_id
left join tblapi c on a.api_id = c.api_id 
where b.multi_threaded = 'no' and a.status = 'Pending' and a.ishold = 'yes'
group by api_name");
        foreach($rslt->result() as $rw)
        {
         $resp.=$rw->api_id.",";   
        }
        echo $resp;exit;
    }
	public function index()  
	{
	  
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache"); 
            $this->db->query("insert into deleteme(datetime) values(?)",array($this->common->getDate()));
            if(isset($_GET["api_id"]))
            {
                $this->load->model("Update_methods");
                 $resp = '';
                $api_id = $_GET["api_id"];
                 $rslt = $this->db->query("SELECT 
				 a.user_id,
				 a.recharge_id,
				 a.api_id,
				 a.mobile_no,
				 a.amount,
				 a.company_id,
				 a.status,
				 c.api_name,
				 c.params,
				 c.static_ip,
				 b.multi_threaded 
				 FROM `tblpendingrechares` a left join operatorpendinglimit b on a.api_id = b.api_id and a.company_id = b.company_id
left join tblapi c on a.api_id = c.api_id 
where b.multi_threaded = 'no' and a.status = 'Pending' and a.ishold = 'yes' and a.api_id = ?
order by a.recharge_id limit 4",array($api_id));
                foreach($rslt->result() as $rw)
                {
                     $resp.=$rw->api_id."  ".$rw->mobile_no."  ,";   
                     $company_id = $rw->company_id;
                     $Mobile = $rw->mobile_no;
                     $Amount = $rw->amount;
                     $recharge_id = $rw->recharge_id;
                     
                    $ApiInfo = $this->db->query("select a.*,b.Name as apigroup_name  from tblapi a
							left join tblapiroups b on a.apigroup = b.Id
							 where a.api_id = ?",array($rw->api_id));
					if($ApiInfo->row(0)->api_name != "HOLD")
					{
					 	if( preg_match('/OTOMAX/',$rw->api_name) == 1)
            		   {
            		       $this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
            		        if($this->checkduplicate($rw->recharge_id,$rw->api_name) == true)
                    	    {
                    	        
                    			putenv("TZ=Asia/Calcutta");
        						date_default_timezone_set('Asia/Calcutta');
        						$add_date = $this->common->getDate();
                                $Mobile = $rw->mobile_no;
                                $Amount = $rw->amount;
                                $user_id = $rw->user_id;
                                $company_id = $rw->company_id;
                                $recharge_id= $rw->recharge_id;
        					    $CODE = "";
								if($code2 == false)
								{
									$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($ApiInfo->row(0)->api_id,$company_id));
									if($rsltcodeinfo->num_rows() == 1)
									{
										$CODE = $rsltcodeinfo->row(0)->code;
									}
								}
								else
								{
									$CODE = $code2;
								}
    							
													//103.250.189.232:6968
$req = $ApiInfo->row(0)->static_ip.'?memberid='.$ApiInfo->row(0)->username.'&pin='.$ApiInfo->row(0)->apitocken.'&password='.$ApiInfo->row(0)->password.'&product='.$CODE.'&qty='.$Amount.'&dest='.$Mobile.'&refID='.$recharge_id;
								$this->db->query("insert into tblmiddler(recharge_id,sms,add_date,API) values(?,?,?,?)",array($recharge_id,$req,$this->common->getDate(),$ApiInfo->row(0)->api_name));
								$this->db->query("insert into tblreqresp(user_id,request,response,add_date,ipaddress,recharge_id,mobile_no,amount,company_id) values(?,?,?,?,?,?,?,?,?)",array($user_id,$req,"",$this->common->getDate(),$this->common->getRealIpAddr(),$recharge_id,$Mobile,$Amount,$company_id));
                                $this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
        						
        
                    		}
            		          
            		   }
					   else if($ApiInfo->row(0)->apigroup_name == "EVAN")
					   {
						   
							if($this->checkduplicate($rw->recharge_id,$rw->api_name) == true)
							{
								
								$CODE = "";
								$rsltcodeinfo = $this->db->query("select code from tbloperatorcodes where api_id = ? and company_id = ?",array($ApiInfo->row(0)->api_id,$company_id));
								if($rsltcodeinfo->num_rows() == 1)
								{
									$CODE = $rsltcodeinfo->row(0)->code;
								}
								$field1 = '';
								$field2 = '';
								$req = $ApiInfo->row(0)->static_ip."?apiToken=".$ApiInfo->row(0)->apitocken."&mn=".$Mobile."&op=".$CODE."&amt=".$Amount."&reqid=".$recharge_id."&field1=$field1&field2=$field2";
								 $this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
								$resp = $this->common->callurl($req,$recharge_id);
								$status = $this->get_string_between($resp, "<status>", "</status>");
								$operator_id = $this->get_string_between($resp, "<field1>", "</field1>");
								
								
								if($status == "" or $status==NULL)
								{
									$status="Pending";
								}
								else if($status == "SUCCESS" )
								{
									$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Success");
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Success",$opid,$recharge_id,$response_type,$rechargeBy);
								}
								else if($status == "FREQUENT")
								{
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$recharge_id,$response_type,$rechargeBy);
								}
	
								else if($status == "PENDING")
								{
									$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$recharge_id,$response_type,$rechargeBy);
								}
								else if($status == "FAILED" or $status == "REFUND")
								{
									$this->Update_methods->updateRechargeStatus($recharge_id,"","Failure");
									$Message = "Recharge Failed";
									//$this->custom_response($recharge_id,$Mobile,$Amount,"Failure",$Message,$recharge_id,$response_type,$rechargeBy);
									
								}
							}
							
							
						}
					   else if($ApiInfo->row(0)->apigroup_name == "ATOM")
					   {
					
                            $this->load->model("Update_methods");
							$response_type = "CSV";
							$order_id = "";
							$Message = "Rechareg Accepted";
							
							
							   
								if($this->checkduplicate($rw->recharge_id,$rw->api_name) == true)
								//if(true)
								{
									putenv("TZ=Asia/Calcutta");
									date_default_timezone_set('Asia/Calcutta');
									$add_date = $this->common->getDate();

									$adt = urlencode(date_format(date_create($this->common->getDate()),'d/m h:i:s'));
									$req = $ApiInfo->row(0)->static_ip.'?uid='.$ApiInfo->row(0)->username.'&pwd='.$ApiInfo->row(0)->password.'&lapunumber='.$ApiInfo->row(0)->params.'&apitoken='.$ApiInfo->row(0)->apitocken.'&mn='.$Mobile.'&amt='.$Amount.'&reqid='.$recharge_id;	
									//$url = 'http://atom.clareinfotech.com/ws/vodafone?uid=maharshi.telecom@gmail.com&pwd=dilip2612&apitoken=a44c191d56d945d09385937490a25424&mn='.$Mobile.'&amt='.$Amount.'&reqid='.$recharge_id;
									$mars_response = $this->common->callurl($req,$recharge_id);
								
									$jsonpbj = json_decode($mars_response);
									if(isset($jsonpbj->reqid) and isset($jsonpbj->status))
									{
									  
										$reqid = trim((string)$jsonpbj->reqid);
										$status_s = trim((string)$jsonpbj->status);
										$remarkmsg= trim((string)$jsonpbj->remark);
										$opid = trim((string)$jsonpbj->opid);
										if($status_s == "FAILED")
										{
										    $this->Update_methods->updateRechargeStatus($recharge_id,"","Failure");
										}
										else if($status_s == "SUCCESS")
										{
										    
											$this->Update_methods->updateRechargeStatus($recharge_id,$opid,"Success");
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
								else
								{
								
								$this->db->query("update tblpendingrechares set status = 'InProcess' where recharge_id = ?",array($recharge_id));
								}
							
						}
						else if($ApiInfo->row(0)->apigroup_name == "KRISHNA")
					   {
						    
                            $this->load->model("Update_methods");
							$response_type = "CSV";
							$order_id = "";
							$Message = "Rechareg Accepted";
							
							
							   
								if($this->checkduplicate($rw->recharge_id,$rw->api_name) == true)
								{
									putenv("TZ=Asia/Calcutta");
									date_default_timezone_set('Asia/Calcutta');
									$add_date = $this->common->getDate();

									$adt = urlencode(date_format(date_create($this->common->getDate()),'d/m h:i:s'));
									$req = $ApiInfo->row(0)->static_ip."?acc_no=".$ApiInfo->row(0)->username."&api_key=".$ApiInfo->row(0)->apitocken."&opr_code=".$CODE."&rech_num=".$Mobile."&amount=".$Amount."&client_key=".$recharge_id;
									$this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
									$resp = $this->common->callurl($req,$recharge_id);
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
					   else
						{
							$this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
							
						  
							 if($this->checkduplicate($rw->recharge_id,$rw->api_name) == true)
							 {
							 
								if (preg_match('/[CODE]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[MOBILE]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[AMOUNT]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[REFID]/',$ApiInfo->row(0)->params) == 1)  
								{
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
									$params = str_replace("[CODE]",urlencode($CODE),$params);
	
									$params = str_replace("&amp;","&",$params);
									$params = str_replace(";","",$params);
	
									$req = $ApiInfo->row(0)->static_ip."?".$params;
									$mars_response = $this->common->callurl(trim($req),$recharge_id);
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
	
											if (preg_match("/".$status_word."/",$resp) == 1 and preg_match("/".$operator_id_start."/",$resp) == 1)
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
									//return $this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$order_id,$response_type);
	
								}
								
								else if (preg_match('/[MOBILE]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[AMOUNT]/',$ApiInfo->row(0)->params) == 1 and preg_match('/[REFID]/',$ApiInfo->row(0)->params) == 1)  
								{
									$Message = "Request Acepted";
									$order_id = $recharge_id;
									$response_type = "CSV";
									$params = str_replace("[MOBILE]",$Mobile,trim($ApiInfo->row(0)->params));
									$params = str_replace("[AMOUNT]",$Amount,$params);
									$params = str_replace("[REFID]",$recharge_id,$params);
									$params = str_replace("&amp;","&",$params);
									$params = str_replace(";","",$params);
	
									$req = $ApiInfo->row(0)->static_ip."?".$params;
									$mars_response = $this->common->callurl(trim($req),$recharge_id);
									//return $this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$Message,$order_id,$response_type);
	
								}
							}
						}
					}
            	}
                
                echo $resp;exit;
            }
            else
            {
                echo "welcome to vodafone processer";exit;    
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
}