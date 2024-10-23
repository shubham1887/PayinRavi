<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hold_processor extends CI_Controller {
	
	
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
where b.multi_threaded = 'no' and a.status = 'Pending'
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
           
                $this->load->model("Update_methods");
                 $resp = '';
                
				$companyrslt = $this->db->query("select company_id,company_name from tblcompany where company_id IN (select company_id from tblpendingrechares group by company_id)");
				foreach($companyrslt->result() as $cmp)
				{
					$rslt = $this->db->query("SELECT a.user_id,a.recharge_id,a.api_id,a.mobile_no,a.amount,a.company_id,a.status,c.api_name,b.multi_threaded FROM `tblpendingrechares` a 
                 left join operatorpendinglimit b on a.api_id = b.api_id and a.company_id = b.company_id
left join tblapi c on a.api_id = c.api_id 
where  a.status = 'Pending' and c.api_name ='HOLD'  and a.company_id = ?
order by a.recharge_id limit 15",array($cmp->company_id));
				//echo $rslt->num_rows();exit;
					foreach($rslt->result() as $rw)
					{
					
						$company_id = $rw->company_id;
						$recharge_id = $rw->recharge_id;
						$api_name = $rw->api_name;
						$Mobile = $rw->mobile_no;
						$Amount = $rw->amount;
						
						
						 $this->loging($recharge_id,"HOLD_PROCESSOR","API SELECTION START");
						$ApiInfo=$this->db->query("select a.*,b.api_name,b.username,b.password,b.static_ip,b.status as apistatus,b.apitocken,b.params from operatorpendinglimit a 
						left join tblapi b on a.api_id = b.api_id where a.company_id = ? and a.pendinglimit > a.totalpending 
						and a.status = 1 order by a.priority  limit 1",array($company_id));
					//	print_r($ApiInfo->num_rows());exit;
						if($ApiInfo->num_rows() == 1)
						{
							 $this->loging($recharge_id,"HOLD_PROCESSOR","APIINFO ROW1 FOUND");
							$mainstate_id = 0;
							if($company_id == 13 or $company_id ==23 or $company_id == 16 or $company_id ==35)
							{
								$this->loging($recharge_id,"HOLD_PROCESSOR","company id 13 or 23 true");
								 $this->loging($recharge_id,"HOLD_PROCESSOR","Series Check Start");
								$operatorswitching = $this->db->query("
									SELECT 
										a.api_id,
										a.code,
										a.amounts,
										a.state_id,
										b.pendinglimit,
										b.totalpending
										FROM statewiseseries a
										join operatorpendinglimit b on a.api_id = b.api_id and a.company_id = b.company_id
									  where  
									  a.company_id = ? and 
									  a.series like '%?%'",array($company_id,intval(substr($Mobile,0,5))));
									if($operatorswitching->num_rows() == 1)
									{
										$this->loging($recharge_id,"HOLD_PROCESSOR","Series Check row 1 found for ".$Mobile);
										$state_id = $operatorswitching->row(0)->state_id;
										$optr_swtching_pendinglimit = $operatorswitching->row(0)->pendinglimit;
										$optr_swtching_totalpending = $operatorswitching->row(0)->totalpending;
										$optr_swtching_api_id = $operatorswitching->row(0)->api_id;
										$optr_swtching_code = $operatorswitching->row(0)->code;
										$seriesamounts = $operatorswitching->row(0)->amounts;
										$seriesamount_array = explode(",",$seriesamounts);
										if(count($seriesamount_array) > 2)
										{
											$this->loging($recharge_id,"HOLD_PROCESSOR","Series Check Amount check ".$Amount);
											if(in_array($Amount,$seriesamount_array))
											{
												 $this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount Found  ".$Amount);
												   $this->loging($recharge_id,"HOLD_PROCESSOR","Pending Limit Check : TotalPending ".$optr_swtching_totalpending."   Pending Limit : ".$optr_swtching_pendinglimit);
												if($optr_swtching_totalpending > $optr_swtching_pendinglimit)
												{
													 $this->loging($recharge_id,"HOLD_PROCESSOR","Series  AmountSet To HOLD  Again");
													$ApiInfo = $this->db->query("select * from tblapi where api_name   = 'HOLD'");
														
												}
												else
												{
													$this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount API select * from tblapi where api_id = ?");
													$optr_swtching_api_info = $this->db->query("select * from tblapi where api_id = ?",array($optr_swtching_api_id));
													if($optr_swtching_api_info->num_rows() == 1)
													{
														 $this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount API select * from tblapi where api_id = ?  Row 1 Found");
														$ApiInfo = $optr_swtching_api_info;
														$mainstate_id = $state_id;
														$code2 = $optr_swtching_code;
														  $this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount API selected ".$ApiInfo ->row(0)->api_name);
													}    
												}
												 
											}   
										}
										else
										{
											if($optr_swtching_totalpending > $optr_swtching_pendinglimit)
											{
													$ApiInfo = $this->db->query("select * from tblapi where api_name   = 'HOLD'");
													
											}
											else
											{
												$optr_swtching_api_info = $this->db->query("select * from tblapi where api_id = ?",array($optr_swtching_api_id));
												if($optr_swtching_api_info->num_rows() == 1)
												{
													
													$ApiInfo = $optr_swtching_api_info;
													$mainstate_id = $state_id;
													$code2 = $optr_swtching_code;
												}
											}   
										}
										
									}
							}
						
						
							if($ApiInfo->row(0)->api_name != "HOLD")
							{
								//$this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
								//$this->db->query("BEGIN;");
								
								$newapi = $ApiInfo->row(0)->api_name;
								$this->db->query("update tblrecharge set ExecuteBy = ?,state_id = ? where recharge_id = ? and ExecuteBy = 'HOLD'",array($newapi,$mainstate_id,$recharge_id));
								$this->db->query("update tblpendingrechares set api_id = ?,state_id = ? where recharge_id = ? and api_id = (select api_id from tblapi where api_name = 'HOLD')",array($ApiInfo->row(0)->api_id,$mainstate_id,$recharge_id));
								$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$ApiInfo->row(0)->api_id));
								
								//$this->db->query("COMMIT;");
							}
							
						}
						else
						{
							
							 $this->loging($recharge_id,"HOLD_PROCESSOR","APIINFO ROW 0 FOUND Else Part Series Check");
							$mainstate_id = 0;
							if($company_id == 13 or $company_id ==23 or $company_id == 16 or $company_id ==35)
							{
								$this->loging($recharge_id,"HOLD_PROCESSOR","company id 13 or 23 true");
								 $this->loging($recharge_id,"HOLD_PROCESSOR","Series Check Start");
								$operatorswitching = $this->db->query("
									SELECT 
										a.api_id,
										a.code,
										a.amounts,
										a.state_id,
										b.pendinglimit,
										b.totalpending
										FROM statewiseseries a
										join operatorpendinglimit b on a.api_id = b.api_id and a.company_id = b.company_id
									  where  
									  a.company_id = ? and 
									  a.series like '%?%'",array($company_id,intval(substr($Mobile,0,5))));
									if($operatorswitching->num_rows() == 1)
									{
										$this->loging($recharge_id,"HOLD_PROCESSOR","Series Check row 1 found for ".$Mobile);
										$state_id = $operatorswitching->row(0)->state_id;
										$optr_swtching_pendinglimit = $operatorswitching->row(0)->pendinglimit;
										$optr_swtching_totalpending = $operatorswitching->row(0)->totalpending;
										$optr_swtching_api_id = $operatorswitching->row(0)->api_id;
										$optr_swtching_code = $operatorswitching->row(0)->code;
										$seriesamounts = $operatorswitching->row(0)->amounts;
										$seriesamount_array = explode(",",$seriesamounts);
										if(count($seriesamount_array) > 2)
										{
											$this->loging($recharge_id,"HOLD_PROCESSOR","Series Check Amount check ".$Amount);
											if(in_array($Amount,$seriesamount_array))
											{
												 $this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount Found  ".$Amount);
												 $this->loging($recharge_id,"HOLD_PROCESSOR","Pending Limit Check : TotalPending ".$optr_swtching_totalpending."   Pending Limit : ".$optr_swtching_pendinglimit);
												if($optr_swtching_totalpending > $optr_swtching_pendinglimit)
												{
													 $this->loging($recharge_id,"HOLD_PROCESSOR","Series  AmountSet To HOLD  Again");
													$ApiInfo = $this->db->query("select * from tblapi where api_name   = 'HOLD'");
														
												}
												else
												{
													$this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount API select * from tblapi where api_id = ?");
													$optr_swtching_api_info = $this->db->query("select * from tblapi where api_id = ?",array($optr_swtching_api_id));
													if($optr_swtching_api_info->num_rows() == 1)
													{
														 $this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount API select * from tblapi where api_id = ?  Row 1 Found");
														$ApiInfo = $optr_swtching_api_info;
														$mainstate_id = $state_id;
														$code2 = $optr_swtching_code;
														  $this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount API selected ".$ApiInfo ->row(0)->api_name);
													}
													else
													{
														$this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount Set To HOLD  Again Amount NOt Found");
														$ApiInfo = $this->db->query("select * from tblapi where api_name   = 'HOLD'");
													}
												}
												 
											}   
											else
											{
												 $this->loging($recharge_id,"HOLD_PROCESSOR","Series  Amount Set To HOLD  Again Amount NOt Found");
												 $ApiInfo = $this->db->query("select * from tblapi where api_name   = 'HOLD'");
											}
										}
										else
										{
											if($optr_swtching_totalpending > $optr_swtching_pendinglimit)
											{
													$ApiInfo = $this->db->query("select * from tblapi where api_name   = 'HOLD'");
													
											}
											else
											{
												$optr_swtching_api_info = $this->db->query("select * from tblapi where api_id = ?",array($optr_swtching_api_id));
												if($optr_swtching_api_info->num_rows() == 1)
												{
													
													$ApiInfo = $optr_swtching_api_info;
													$mainstate_id = $state_id;
													$code2 = $optr_swtching_code;
												}
											}   
										}
										if($ApiInfo->row(0)->api_name != "HOLD")
										{
											//$this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
											//$this->db->query("BEGIN;");
											
											$newapi = $ApiInfo->row(0)->api_name;
											$this->db->query("update tblrecharge set ExecuteBy = ?,state_id = ? where recharge_id = ? and ExecuteBy = 'HOLD'",array($newapi,$mainstate_id,$recharge_id));
											$this->db->query("update tblpendingrechares set api_id = ?,state_id = ? where recharge_id = ? and api_id = (select api_id from tblapi where api_name = 'HOLD')",array($ApiInfo->row(0)->api_id,$mainstate_id,$recharge_id));
											$this->db->query("update operatorpendinglimit set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$ApiInfo->row(0)->api_id));
											
											//$this->db->query("COMMIT;");
										}
										
									}
							}
						
						
						
							
						
						}
						if($ApiInfo->num_rows() == 1)
						{
						    echo $company_id."  api :".$api_name."  rec id : ".$recharge_id ." New APi : ".$ApiInfo->row(0)->api_name;    
						}
						else
						{
						    echo "No Api Found";
						}
						
						echo "<br>";
					
							
						  
					
					}	
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
	private function loging($recharge_id,$actionfrom,$remark)
	{
		/*$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into tbllogs(recharge_id,add_date,ipaddress,actionfrom,remark) values(?,?,?,?,?)",
						array($recharge_id,$add_date,$ipaddress,$actionfrom,$remark));
						*/
	}
}