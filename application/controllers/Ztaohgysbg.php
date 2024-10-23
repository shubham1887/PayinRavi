<?php
class Ztaohgysbg extends  CI_Controller 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getlastresponselog()
	{
		if(isset($_GET["id"]))
		{
			$recharge_id = trim($_GET["id"]);
			$loginfo = $this->db->query("select a.response,b.recharge_status,b.ExecuteBy from tblreqresp a  left join tblrecharge b on a.recharge_id = b.recharge_id where a.recharge_id = ? order by a.Id desc limit 1",array($recharge_id));    
			if($loginfo->num_rows() == 1)
			{
				echo $recharge_id."^-^".$loginfo->row(0)->response."^-^".$loginfo->row(0)->recharge_status."^-^".$loginfo->row(0)->ExecuteBy;
			}
					
		}
	}
	private function logentry($data)
	{
		$filename = "test.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $this->common->getDate()."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
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
	public function index()
	{
	  if(isset($_GET["id"]))
	  {
	      $recharge_id = $_GET["id"];
	      
          $rechargeInfo = $this->db->query("select 
        		
                		a.recharge_id,
                		a.mobile_no,
        				a.company_id,
                		a.amount,
                		a.recharge_status,
                		a.user_id,
                		a.ExecuteBy,
                		a.add_date,
                		c.company_name,
                		code.code
                		from tblrecharge a 
                		
        				left join tblcompany c on a.company_id = c.company_id
        				left join tblapi api on a.ExecuteBy = api.api_name
        				left join tbloperatorcodes code on a.company_id = code.company_id and api.api_id = code.api_id
        				where a.recharge_id = ? and recharge_status = 'Pending'
        				order by a.recharge_id",array($recharge_id));
        		if($rechargeInfo->num_rows() ==0)
        		{
        			echo "No-Action";exit;
        		}
        		else
        		{
        		    $code =   $rechargeInfo->row(0)->code;
        			$recdt = $rechargeInfo->row(0)->add_date;
        			$recdatetime =date_format(date_create($recdt),'Y-m-d H:i:s');
        			$cdate =date_format(date_create($this->common->getDate()),'Y-m-d H:i:s');
        			$this->load->model("Update_methods");
        			$diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
        		
        			if($diff < 2)
        			{
        				echo "Click After 2 Minute";exit;
        			}
        			else
        			{
        			    
        			    $rsltremoveduplicate = $this->db->query("SELECT * FROM `remove_queue_duplication` where recharge_id = ?",array($recharge_id));
        			    if($rsltremoveduplicate->num_rows() == 1)
        			    {
        			        $remocdeuplicate_datetime = $rsltremoveduplicate->row(0)->add_date;
        			        
                			$remup_recdatetime =date_format(date_create($remocdeuplicate_datetime),'Y-m-d H:i:s');
                			$cdate =date_format(date_create($this->common->getDate()),'Y-m-d H:i:s');
                			
                			$diff2 = $this->Update_methods->gethoursbetweentwodates($remup_recdatetime,$cdate);
                			if($diff2 < 2)
                			{
                				echo "Click After 2 Minute";exit;
                			}
                			else
                			{
                			    $oldStatus = $rechargeInfo->row(0)->recharge_status;
                				$recUser =  $rechargeInfo->row(0)->user_id;
                				$company_id = $rechargeInfo->row(0)->company_id; 
                
                				$api_name = $rechargeInfo->row(0)->ExecuteBy; 
                				
                				$StatusCheckApiInfo = $this->db->query("select * from apistatuscheck_settings where api_id = (select api_id from tblapi where api_name = ?)",array($api_name));
                				if($StatusCheckApiInfo->num_rows() == 1)
                				{
                				    $status_url = $StatusCheckApiInfo->row(0)->status_url;
                    				$parameters = $StatusCheckApiInfo->row(0)->parameters;
                    			    $parameters = str_replace("[REFID]",$recharge_id,$parameters);
                    			    $parameters = str_replace("[CODE]",$code,$parameters);
                    			    $parameters = str_replace(" ","%20",$parameters);
                    			    $parameters = str_replace("&amp;","&",$parameters);
            						$parameters = str_replace(";","",$parameters);
            				        $resp = $this->common->callurl($status_url."?".$parameters);
                    		        
                    		        if($api_name == "KRISHNA")
                    		        {
                    		           // echo $status_url."?".$parameters;exit;
                    		            //Success,9316407537,49,15598478,12416293,13480023,Recharge Success
                    		            $strresparr = explode(",",$resp);
                    		            if(isset($strresparr[0]) and isset($strresparr[5]) and isset($strresparr[3]))
                    		            {
                    		                $recharge_id = trim($strresparr[5]);
                    		                $status = trim($strresparr[0]);
                    		                $operator_id = trim($strresparr[3]);
                    		                if($status == "Success")
                    		                {
                    		                    	$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Success",true);
                    								echo $status.",".$operator_id;exit;
                    		                }
                    		                else if($status == "Failure")
                    		                {
                    		                    	$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Failure",true);
                    								echo $status.",".$operator_id;exit;
                    		                }
                    		            }
                    		        }
                    		        else
                    		        {
                    		            $rsltmessagesettings = $this->db->query("select * from message_setting where api_id = ?",array($StatusCheckApiInfo->row(0)->api_id));
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
                    						$resp  = str_replace('xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/"',"",$resp);
                    						//print htmlentities($resp);
                    						//echo "<br>";
                                            //print htmlentities($status_word."    ".$operator_id_start);
                                            //echo "<br>";
                                            //echo "<br>";
                                            //var_dump($status_word);
                                            //var_dump(preg_match("/".$status_word."/",$resp));
                    						if (preg_match("/".$status_word."/",$resp) == 1 and preg_match("/".$operator_id_start."/",$resp) == 1)
                    						{
                    
                    							$mobile_no = $this->get_string_between($resp, $num_start, $num_end);
                    							$operator_id = $this->get_string_between($resp, $operator_id_start, $operator_id_end);
                                                    
                                                //echo     $mobile_no;exit;
                                                    
                    							$operator_id = str_replace("\n","",$operator_id);
                    							$mobile_no = str_replace("\n","",$mobile_no);
                                               
                    							$this->load->model("Update_methods");
                    							if($status == "Success" or $status == "Failure")
                    							{
                    								if($status == "Failure")
                    								{
                    									$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true);
                    									echo $status.",".$operator_id;exit;
                    								}
                    								else
                    								{
                    									$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true);
                    									echo $status.",".$operator_id;exit;
                    								}	
                    							}
                    							else
                    							{
                    							    	echo "Pending";exit;
                    							}
                    						}
                    						else
                    						{
                    						    
                    						}
                    
                    					}   
                    		        }
            		
                					
                				    echo print htmlentities($resp);exit;
                    			}
                    			else
                    			{
                    			    echo "No Api Call";exit;
                    			}
                			}
                		
        			        
        			    }
        			    
        				else
        				{
        				    echo "RECHARGE HOLD";
        				}
        				
        				
        				
        			
        				
        			}
        		}
	  }
	  
	}
	

}