<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetBillAmount extends CI_Controller {
	public function logentry($data)
	{
	/*	$filename = "temp.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');*/
	}
	public function index()
	{
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
	    /*
	    {"ddlcity":"Ahmedabad","customer_mobile":"8238232303","mcode":"TPE","username":"9287398237","option2":"","pwd":"12345","option1":"","serviceno":"500185702"}
	    */
		$this->logentry(json_encode($this->input->get()));
		$this->logentry(json_encode($this->input->post()));
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])   && isset($_GET['mcode']) && isset($_GET['serviceno']) && isset($_GET['customer_mobile']) && isset($_GET['option1']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
			//	$txnpwd = $_GET['txnpwd'];
				$mcode = $_GET['mcode'];
				$serviceno =  $_GET['serviceno'];
				$customer_mobile = $_GET['customer_mobile'];
				$option1 = $_GET['option1'];
			    	
			 	if($mcode == "TPE")
			 	{
			 	    
			 	    
                   if(isset($_GET['option1']))
                   {
                        $option1 = $_GET['option1'];    
                        if($option1 == "Ahmedabad")
                        {
                            $mcode = "TYE";
                        }
                         if($option1 == "Surat")
                        {
                            $mcode = "TWE";
                        }
                   }	    
			 	}
			 	if($mcode == "WBSEDCL")
			 	{
			 	    $mcode = "WWE";
			 	}
			 	
			 	//echo $mcode;exit;
               $host_id =1;
				$user_info = $this->db->query("select * from tblusers where username = ?  and password = ? ",array($username,$pwd));

				if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "Distributor" or $user_info->row(0)->usertype_name == "MasterDealer")
				{
					
					$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));
					if($company_info->num_rows() == 1)
					{
						if($mcode == "UGE" or $mcode == "PGE" or $mcode == "DGE" or $mcode == "MGE" or $mcode == "ADG"  or $mcode == "SGG" or $mcode == "GJG"  or $mcode == "TYE" or $mcode == "TWE")
					   {
					       if($mcode == "UGE"){$spkey = "UGVCL"; }
					       if($mcode == "PGE"){$spkey = "PGVCL"; }
					       if($mcode == "DGE"){$spkey = "DGVCL"; }
					       if($mcode == "MGE"){$spkey = "MGVCL"; }
					       if($mcode == "ADG"){$spkey = "ADGL"; }
					       if($mcode == "TYE"){$spkey = "TORRENTAHME"; }
                           if($mcode == "TWE"){$spkey = "TORRENTSURAT"; }
                           if($mcode == "SGG"){$spkey = "SBGL"; }
                           if($mcode == "GJG"){$spkey = "GJGL"; }

                           
					       
					     
					       if($mcode == "ADG" or $mcode == "SGG"  or $mcode == "GJG")
					       {
								$url = 'https://www.mplan.in/api/Gas.php?apikey=dee2d840e2f42fc6c89f183abb257df3&offer=roffer&operator='.$spkey.'&tel='.$serviceno;
					       }
					       else
					       {
					       		$url = 'https://www.mplan.in/api/electricinfo.php?apikey=dee2d840e2f42fc6c89f183abb257df3&offer=roffer&operator='.$spkey.'&tel='.$serviceno;	
					       }
					       
					      //echo $url."<br>";
					      // $this->logentry2($url);
                    	   $buffer = $this->common->callurl($url);
                    		$json_obj = json_decode($buffer);
                    	//print_r($buffer);exit;
                    		
                    		/*
                    		{"tel":"12972041127","operator":"DGVCL",
                    		"records":[{"CustomerName":"NILESHBHAI JASWANTBHAI ADESARA ","Billamount":"1,631.49","Billdate":"24\/01\/2020","Duedate":null}],
                    		"status":1}
                    		*/
                    	   // $this->logentry2($buffer);
                    		if(isset($json_obj->records))
                    		{
                    		    $records = $json_obj->records;

                    		   

                    		   if(is_array($records))
                    		   {
                    		    //echo "asdfdsf";exit;   
                    		       $resparr = array();
                    		       $resparr["status"] = "0";
                    		       $resparr["message"] = "Transaction Successful";
                    		       $resparr_data = array();
                    		       $record = $records[0];
                    		      // print_r($record);exit;
                    		       if(isset($record->CustomerName))
                    		       {
                    		           $customername = $record->CustomerName;
                    		         //  print_r($record);exit;
                    		       //   echo $record->Billamount;exit;

                                       if(isset($record->Billamount))
                                       {
                                       	//Billamount
                                        $Billamount = str_replace(",","",$record->Billamount); 
                                       }
                                       else
                                       {
                                        $Billamount = str_replace(",","",$record->BillAmount);
                                       }
                    		           
                    		           $Billdate = $record->Billdate;
                    		           $Duedate  = $record->Duedate;
                    		           $resparr["particulars"] = array(
                    		                "dueamount"=>$Billamount,
                                	        "duedate"=>"",
                                	        "customername"=>$customername,
                                	        "billnumber"=>"",
                                	        "billdate"=>$Billdate,
                                	        "billperiod"=>"NA",
                                	        "billdetails"=>[],
                                	        "customerparamsdetails"=>"",
                                	        "additionaldetails"=>"",
                                	        "reference_id"=>0
                    		               );
                    		               //$this->logentry2(json_encode($resparr));
                    		               echo json_encode($resparr);exit;
                    		       }
                    		       else
                    		       {
                    		           $resparr = array();
                        		       $resparr["statuscode"] = "ERR";
                        		       $resparr["status"] = "Please Enter Amount Manually";
                        		     //   $this->logentry2(json_encode($resparr));
                        		       echo json_encode($resparr);exit;
                    		       }
                    		   }
                    		   else
                    		   {
                    		   		
                    		       
                    		       $resparr = array();
                    		       $resparr["status"] = "0";
                    		       $resparr["message"] = "Transaction Successful";
                    		       $resparr_data = array();
                    		      
                    		     // print_r($records);exit;
                    		       if(isset($records->CustomerName))
                    		       {
                    		           $customername = $records->CustomerName;
                    		          
                    		           if(isset($records->Billamount))
                                       {
                                        $Billamount = str_replace(",","",$records->Billamount); 
                                       }
                                       else
                                       {
                                        $Billamount = str_replace(",","",$records->BillAmount);
                                       }
                    		            $Billamount = str_replace("₹","", $Billamount);
                    		            $Billamount = str_replace(" ","", $Billamount);
 
                    		           //echo $Billamount;exit;
                    		           $Billdate = "";
                    		           $Duedate  = $records->Duedate;
                    		           $resparr["particulars"] = array(
                    		                "dueamount"=>$Billamount,
                                	        "duedate"=>"",
                                	        "customername"=>$customername,
                                	        "billnumber"=>"",
                                	        "billdate"=>$Billdate,
                                	        "billperiod"=>"NA",
                                	        "billdetails"=>[],
                                	        "customerparamsdetails"=>"",
                                	        "additionaldetails"=>"",
                                	        "reference_id"=>0
                    		               );
                    		               //$this->logentry2(json_encode($resparr));
                    		               echo json_encode($resparr);exit;
                    		       }
                    		       else
                    		       {
                    		           $resparr = array();
                        		       $resparr["statuscode"] = "ERR";
                        		       $resparr["status"] = "Please Enter Amount Manually";
                        		     //   $this->logentry2(json_encode($resparr));
                        		       echo json_encode($resparr);exit;
                    		       }
                    		   
                    		   }
                    		}
					   }
					   else if($mcode == "BLL" or $mcode == "ALL")
					   {
					       if($mcode == "BLL")
					       	{
					       		$spkey = "BsnlLL"; 
					       	}
					      
					      
					       $url = 'https://www.mplan.in/api/Bsnl.php?apikey=dee2d840e2f42fc6c89f183abb257df3&offer=roffer&tel='.$serviceno.'&operator='.$spkey.'&stdcode='.$option1;
					     
					       $buffer = $this->common->callurl($url);
                    		$json_obj = json_decode($buffer);
                    	//print_r($buffer);exit;
                    		
                    		/*
                    		{"tel":"12972041127","operator":"DGVCL",
                    		"records":[{"CustomerName":"NILESHBHAI JASWANTBHAI ADESARA ","Billamount":"1,631.49","Billdate":"24\/01\/2020","Duedate":null}],
                    		"status":1}
                    		*/
                    	   // $this->logentry2($buffer);
                    		if(isset($json_obj->records))
                    		{
                    		    $records = $json_obj->records;

                    		   

                    		   if(is_array($records))
                    		   {
                    		       
                    		       $resparr = array();
                    		       $resparr["status"] = "0";
                    		       $resparr["message"] = "Transaction Successful";
                    		       $resparr_data = array();
                    		       $record = $records[0];
                    		      // print_r($record);exit;
                    		       if(isset($record->customerName))
                    		       {
                    		           $customername = $record->customerName;
                    		           $Billamount = str_replace(",","",$record->dueAmount);
                    		           $Billdate = "";
                    		           $Duedate  = $record->dueDate;
                    		           $resparr["particulars"] = array(
                    		                "dueamount"=>$Billamount,
                                	        "duedate"=>$Duedate,
                                	        "customername"=>$customername,
                                	        "billnumber"=>"",
                                	        "billdate"=>$Billdate,
                                	        "billperiod"=>"NA",
                                	        "billdetails"=>[],
                                	        "customerparamsdetails"=>"",
                                	        "additionaldetails"=>"",
                                	        "reference_id"=>0
                    		               );
                    		               //$this->logentry2(json_encode($resparr));
                    		               echo json_encode($resparr);exit;
                    		       }
                    		       else
                    		       {
                    		           $resparr = array();
                        		       $resparr["statuscode"] = "ERR";
                        		       $resparr["status"] = "Please Enter Amount Manually";
                        		     //   $this->logentry2(json_encode($resparr));
                        		       echo json_encode($resparr);exit;
                    		       }
                    		   }
                    		   else
                    		   {
                    		   		
                    		       
                    		       $resparr = array();
                    		       $resparr["status"] = "0";
                    		       $resparr["message"] = "Transaction Successful";
                    		       $resparr_data = array();
                    		      
                    		     // print_r($records);exit;
                    		       if(isset($records->CustomerName))
                    		       {
                    		           $customername = $records->CustomerName;
                    		          
                    		           $Billamount = str_replace(",","",$records->BillAmount);
                    		            $Billamount = str_replace("₹","", $Billamount);
                    		            $Billamount = str_replace(" ","", $Billamount);
 
                    		           //echo $Billamount;exit;
                    		           $Billdate = "";
                    		           $Duedate  = $records->Duedate;
                    		           $resparr["particulars"] = array(
                    		                "dueamount"=>intval($Billamount),
                                	        "duedate"=>"",
                                	        "customername"=>$customername,
                                	        "billnumber"=>"",
                                	        "billdate"=>$Billdate,
                                	        "billperiod"=>"NA",
                                	        "billdetails"=>[],
                                	        "customerparamsdetails"=>"",
                                	        "additionaldetails"=>"",
                                	        "reference_id"=>0
                    		               );
                    		               //$this->logentry2(json_encode($resparr));
                    		               echo json_encode($resparr);exit;
                    		       }
                    		       else
                    		       {
                    		           $resparr = array();
                        		       $resparr["statuscode"] = "ERR";
                        		       $resparr["status"] = "Please Enter Amount Manually";
                        		     //   $this->logentry2(json_encode($resparr));
                        		       echo json_encode($resparr);exit;
                    		       }
                    		   
                    		   }
                    		}
					   }

                       else if($mcode == "AMC" )
                       {
                           if($mcode == "AMC")
                            {
                                $spkey = "AMCW"; 
                            }
                          
                          
                          
                           $url = 'https://www.mplan.in/api/Water.php?apikey=dee2d840e2f42fc6c89f183abb257df3&offer=roffer&tel='.$serviceno.'&operator='.$spkey;
                         
                           $buffer = $this->common->callurl($url);
                            $json_obj = json_decode($buffer);
                       
                            
                            /*
                            {"tel":"12972041127","operator":"DGVCL",
                            "records":[{"CustomerName":"NILESHBHAI JASWANTBHAI ADESARA ","Billamount":"1,631.49","Billdate":"24\/01\/2020","Duedate":null}],
                            "status":1}
                            */
                           // $this->logentry2($buffer);
                            if(isset($json_obj->records))
                            {
                                $records = $json_obj->records;

                               

                               if(is_array($records))
                               {
                                   
                                   $resparr = array();
                                   $resparr["status"] = "0";
                                   $resparr["message"] = "Transaction Successful";
                                   $resparr_data = array();
                                   $record = $records[0];
                                  // print_r($record);exit;
                                   if(isset($record->customerName))
                                   {
                                       $customername = $record->customerName;
                                       $Billamount = str_replace(",","",$record->dueAmount);
                                       $Billdate = "";
                                       $Duedate  = $record->dueDate;
                                       $resparr["particulars"] = array(
                                            "dueamount"=>$Billamount,
                                            "duedate"=>$Duedate,
                                            "customername"=>$customername,
                                            "billnumber"=>"",
                                            "billdate"=>$Billdate,
                                            "billperiod"=>"NA",
                                            "billdetails"=>[],
                                            "customerparamsdetails"=>"",
                                            "additionaldetails"=>"",
                                            "reference_id"=>0
                                           );
                                           //$this->logentry2(json_encode($resparr));
                                           echo json_encode($resparr);exit;
                                   }
                                   else
                                   {
                                       $resparr = array();
                                       $resparr["statuscode"] = "ERR";
                                       $resparr["status"] = "Please Enter Amount Manually";
                                     //   $this->logentry2(json_encode($resparr));
                                       echo json_encode($resparr);exit;
                                   }
                               }
                               else
                               {
                                    
                                   
                                   $resparr = array();
                                   $resparr["status"] = "0";
                                   $resparr["message"] = "Transaction Successful";
                                   $resparr_data = array();
                                  
                                 // print_r($records);exit;
                                   if(isset($records->CustomerName))
                                   {
                                       $customername = $records->CustomerName;
                                      
                                       $Billamount = str_replace(",","",$records->BillAmount);
                                        $Billamount = str_replace("₹","", $Billamount);
                                        $Billamount = str_replace(" ","", $Billamount);
 
                                       //echo $Billamount;exit;
                                       $Billdate = "";
                                       $Duedate  = $records->Duedate;
                                       $resparr["particulars"] = array(
                                            "dueamount"=>intval($Billamount),
                                            "duedate"=>"",
                                            "customername"=>$customername,
                                            "billnumber"=>"",
                                            "billdate"=>$Billdate,
                                            "billperiod"=>"NA",
                                            "billdetails"=>[],
                                            "customerparamsdetails"=>"",
                                            "additionaldetails"=>"",
                                            "reference_id"=>0
                                           );
                                           //$this->logentry2(json_encode($resparr));
                                           echo json_encode($resparr);exit;
                                   }
                                   else
                                   {
                                       $resparr = array();
                                       $resparr["statuscode"] = "ERR";
                                       $resparr["status"] = "Please Enter Amount Manually";
                                     //   $this->logentry2(json_encode($resparr));
                                       echo json_encode($resparr);exit;
                                   }
                               
                               }
                            }
                       }


                       else if($mcode == "LIC" or $mcode == "ABSLI" or $mcode == "IFLI" or $mcode == "PMLI" or $mcode == "PRLI")
                       {
                           if($mcode == "LIC")
                            {
                                $spkey = "LICOF"; 
                            }
                            if($mcode == "ABSLI")
                            {
                                $spkey = "ABSL"; 
                            }
                            if($mcode == "IFLI")
                            {
                                $spkey = "IFLI"; 
                            }
                            if($mcode == "PMLI")
                            {
                                $spkey = "PNBM"; 
                            }
                            if($mcode == "PRLI")
                            {
                                $spkey = "PRLI"; 
                            }
                          
                           $url = 'https://www.mplan.in/api/insurance.php?apikey=dee2d840e2f42fc6c89f183abb257df3&offer=roffer&tel='.$serviceno.'&mob='.$customer_mobile.'&operator='.$spkey;
                          
                          
                         
                           $buffer = $this->common->callurl($url);
                            $json_obj = json_decode($buffer);
                        //print_r($buffer);exit;
                            
                            /*
                            {"tel":"12972041127","operator":"DGVCL",
                            "records":[{"CustomerName":"NILESHBHAI JASWANTBHAI ADESARA ","Billamount":"1,631.49","Billdate":"24\/01\/2020","Duedate":null}],
                            "status":1}
                            */
                           // $this->logentry2($buffer);
                            if(isset($json_obj->records))
                            {
                                $records = $json_obj->records;

                               

                               if(is_array($records))
                               {
                                   
                                   $resparr = array();
                                   $resparr["status"] = "0";
                                   $resparr["message"] = "Transaction Successful";
                                   $resparr_data = array();
                                   $record = $records[0];
                                  // print_r($record);exit;
                                   if(isset($record->CustomerName))
                                   {
                                       $customername = $record->CustomerName;
                                       $Billamount = str_replace(",","",$record->Netamount);
                                       $Billdate = "";
                                       $Duedate  = $record->Duedatefromto;
                                       $resparr["particulars"] = array(
                                            "dueamount"=>$Billamount,
                                            "duedate"=>$Duedate,
                                            "customername"=>$customername,
                                            "billnumber"=>"",
                                            "billdate"=>$Billdate,
                                            "billperiod"=>"NA",
                                            "billdetails"=>[],
                                            "customerparamsdetails"=>"",
                                            "additionaldetails"=>"",
                                            "reference_id"=>0
                                           );
                                           //$this->logentry2(json_encode($resparr));
                                           echo json_encode($resparr);exit;
                                   }
                                   else
                                   {
                                       $resparr = array();
                                       $resparr["statuscode"] = "ERR";
                                       $resparr["status"] = "Please Enter Amount Manually";
                                     //   $this->logentry2(json_encode($resparr));
                                       echo json_encode($resparr);exit;
                                   }
                               }
                               else
                               {
                                    
                                   
                                   $resparr = array();
                                   $resparr["status"] = "0";
                                   $resparr["message"] = "Transaction Successful";
                                   $resparr_data = array();
                                  
                                 // print_r($records);exit;
                                   if(isset($records->CustomerName))
                                   {
                                       $customername = $records->CustomerName;
                                      
                                       $Billamount = str_replace(",","",$records->BillAmount);
                                        $Billamount = str_replace("₹","", $Billamount);
                                        $Billamount = str_replace(" ","", $Billamount);
 
                                       //echo $Billamount;exit;
                                       $Billdate = "";
                                       $Duedate  = $records->Duedate;
                                       $resparr["particulars"] = array(
                                            "dueamount"=>intval($Billamount),
                                            "duedate"=>"",
                                            "customername"=>$customername,
                                            "billnumber"=>"",
                                            "billdate"=>$Billdate,
                                            "billperiod"=>"NA",
                                            "billdetails"=>[],
                                            "customerparamsdetails"=>"",
                                            "additionaldetails"=>"",
                                            "reference_id"=>0
                                           );
                                           //$this->logentry2(json_encode($resparr));
                                           echo json_encode($resparr);exit;
                                   }
                                   else
                                   {
                                       $resparr = array();
                                       $resparr["statuscode"] = "ERR";
                                       $resparr["status"] = "Please Enter Amount Manually";
                                     //   $this->logentry2(json_encode($resparr));
                                       echo json_encode($resparr);exit;
                                   }
                               
                               }
                            }
                       }
						else
						{
							$this->load->model("Mastermoney");
					   		$response = $this->Mastermoney->fetchbill($user_info,$mcode,$company_info->row(0)->company_id,$serviceno,$customer_mobile,$option1);
    					
							echo $response;exit;
						}
					}
					else
					{
						$resp_arr = array(
									"message"=>"Operator Configuration Missing",
									"status"=>1,
									"statuscode"=>"CONF",
								);
						$json_resp =  json_encode($resp_arr);
					}
				}	
				else
				{
					$resp_arr = array(
									"message"=>"Unauthorised Access",
									"status"=>1,
									"statuscode"=>"AUTH",
								);
						$json_resp =  json_encode($resp_arr);
				}
			
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['pwd'])   && isset($_POST['mcode']) && isset($_POST['serviceno']) && isset($_POST['customer_mobile']) && isset($_POST['option1']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				
				$mcode = $_POST['mcode'];
				$serviceno =  $_POST['serviceno'];
				$customer_mobile = $_POST['customer_mobile'];
				$option1 = $_POST['option1'];
			    if($mcode == "TPE")
			 	{
			 	    
			 	    
                   if(isset($_POST['ddlcity']))
                   {
                        $option1 = $_POST['ddlcity'];    
                        if($option1 == "Ahmedabad")
                        {
                            $mcode = "TYE";
                        }
                         if($option1 == "Surat")
                        {
                            $mcode = "TWE";
                        }
                   }	    
			 	}
			 	
			 	
			 
				$user_info = $this->db->query("select * from tblusers where  username = ? and password = ?",array($username,$pwd));
			
				if($user_info->row(0)->usertype_name == "Agent")
				{
					
					$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));
					if($company_info->num_rows() == 1)
					{
					    
						$this->load->model("Instapay");
						$response = $this->Instapay->recharge_transaction_validate2($user_info,$mcode,$company_info->row(0)->company_id,"",$serviceno,$customer_mobile,$option1);
						//recharge_transaction_validate2($user_info,$mcode,0,0,$serviceno,$customer_mobile,$option1);
						$this->logentry(json_encode($response));
						echo $response;exit;
					}
					else
					{
						$resp_arr = array(
									"message"=>"Operator Configuration Missing",
									"status"=>1,
									"statuscode"=>"CONF",
								);
						$json_resp =  json_encode($resp_arr);
					}
				}	
				else
				{
					$resp_arr = array(
									"message"=>"Unauthorised Access",
									"status"=>"1",
									"statuscode"=>"ERR",
								);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
				}
			
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		
		
		
	}	
	public function getCompanyIdByProvider($operatorcode)
	{
		$rslt = $this->db->query("select company_id from tblcompany where mcode = ?",array($operatorcode));
		if($rslt->num_rows() >= 1)
		{
			return $rslt->row(0)->company_id;
		}
		else
		{
			return false;
		}
	}
	function check_login($username,$password)
	{
		$str_query = "select user_id,status from tblusers where username=? and password=?";
		$result = $this->db->query($str_query,array($username,$password));		
		if($result->num_rows() == 1)
		{
			
			if($result->row(0)->status == '1')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}		
	}
}