<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupcommission_uploadfile extends CI_Controller {
	
	
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
    public function test()
    {
        	ini_set('memory_limit', '-1');
        	$storagename = "UserImages/CommissionStructure_Revised.xls";
        		ini_set('excelutils/max_execution_time', 0);
						require_once 'excelutils/excel_reader2.php';
						require_once 'excelutils/db.php';
						//file_get_contents("http://payreflection.com/setplan/deleterecords?circle_id=1");
						$data = new Spreadsheet_Excel_Reader($storagename);
						
						//echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
						
						$html="<table border='1'>";
						$account_number = false;
						$TransactionDate_found = false; 
						$ChequeNumber_found = false;
						$Withdrawal_found = false;
						$Deposit_found = false;
						$Balance_found = false;
						$Narration_found = false;
						$rflagdata = "";
						$dataar = array();
						for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
						{	
							if(count($data->sheets[$i][cells])>0) // checking sheet not empty
							{
								//echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
								for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
								{ 
									$html.="<tr>";
									
									for($k=1;$k<=20;$k++) // This loop is created to get data in a table format.
									{
										$html.="<td>";
										$celdata = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][$k], 'UTF-8', 'UTF-8'));
										
										$html.=$celdata;
										$html.="</td>";
									}
									
									
									$data->sheets[$i][cells][$j][1];
									
									
								
									
									
									$Id = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][1], 'UTF-8', 'UTF-8'));
									$RefTable = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][2], 'UTF-8', 'UTF-8'));
									
									$group_id = $RefID = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][3], 'UTF-8', 'UTF-8'));
									
									
									$ProductID = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][4], 'UTF-8', 'UTF-8'));
									$company_id = $OperatorID = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][5], 'UTF-8', 'UTF-8'));
									$CommissionType = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][6], 'UTF-8', 'UTF-8'));
									$CommissionPercent = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][7], 'UTF-8', 'UTF-8'));
									$CommissionValue = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][8], 'UTF-8', 'UTF-8'));
									
									
									$IsVisible = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][9], 'UTF-8', 'UTF-8'));
									$CreatedAt = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][10], 'UTF-8', 'UTF-8'));
									$CreatedBy = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][11], 'UTF-8', 'UTF-8'));
									$ModifiedAt = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][12], 'UTF-8', 'UTF-8'));
									$ModifiedBy = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][13], 'UTF-8', 'UTF-8'));
									$MinCommission = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][14], 'UTF-8', 'UTF-8'));
									$MaxCommission = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][15], 'UTF-8', 'UTF-8'));
									
									$temparray = array(
									
									"Id"=>$Id,
									"group_id"=>$group_id,
									"company_id"=>$company_id,
									"CommissionType"=>$CommissionType,
									"CommissionPercent"=>$CommissionPercent,
									"CommissionValue"=>$CommissionValue,
									"MinCommission"=>$MinCommission,
									"MaxCommission"=>$MaxCommission,
									
									);
									array_push($dataar,$temparray);
									
									if($RefTable == "Entity")
									{
										if($CommissionType == "Percent")
										{
											$CommissionType = "PER";
											$commission = $CommissionPercent;
										}
										if($CommissionType == "Flat")
										{
											$CommissionType = "AMOUNT";
											$commission = $CommissionValue;
										}
										exit;
										
											$this->db->query("insert into tbluser_commission(Id,user_id,company_id,commission,commission_amount,commission_type,min_com_limit,max_com_limit,add_date,ipaddress) 
											values(?,?,?,?,?,?,?,?,?,?) ",array($Id,$group_id,$company_id,$commission,$CommissionValue,$CommissionType,$MinCommission,$MaxCommission,$this->common->getDate(),$this->common->getRealIpAddr()));
										
										
									}
									
									
									
									$html.="</tr>";
								}
							}
							
						}
    }
	public function index() 
	{
		
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 

		 	if(isset($_POST["btnSubmit"])) 
			{
				ini_set('memory_limit', '-1');
				if(isset($_FILES["file"])) 
				{
					if ($_FILES["file"]["error"] > 0) 
					{
						echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
					}
					else 
					{
						if (file_exists($_FILES["file"]["name"])) 
						{
							unlink($_FILES["file"]["name"]);
						}
						if (!file_exists("UserImages/".$this->common->getDate())) 
						{
							mkdir("UserImages/".$this->common->getDate());
						}
						$storagename = "UserImages/".$this->common->getDate()."/royalsbi.xls";
						move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
						$uploadedStatus = 1;
						
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

						ini_set('excelutils/max_execution_time', 0);
						require_once 'excelutils/excel_reader2.php';
						require_once 'excelutils/db.php';
						//file_get_contents("http://payreflection.com/setplan/deleterecords?circle_id=1");
						$data = new Spreadsheet_Excel_Reader($storagename);
						
						//echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";
						
						$html="<table border='1'>";
						$account_number = false;
						$TransactionDate_found = false; 
						$ChequeNumber_found = false;
						$Withdrawal_found = false;
						$Deposit_found = false;
						$Balance_found = false;
						$Narration_found = false;
						$rflagdata = "";
						$dataar = array();
						for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
						{	
							if(count($data->sheets[$i][cells])>0) // checking sheet not empty
							{
								//echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
								for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
								{ 
									$html.="<tr>";
									
									for($k=1;$k<=20;$k++) // This loop is created to get data in a table format.
									{
										$html.="<td>";
										$celdata = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][$k], 'UTF-8', 'UTF-8'));
										
										$html.=$celdata;
										$html.="</td>";
									}
									
									
									$data->sheets[$i][cells][$j][1];
									
									
								
									
									
									$Id = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][1], 'UTF-8', 'UTF-8'));
									$RefTable = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][2], 'UTF-8', 'UTF-8'));
									
									$group_id = $RefID = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][3], 'UTF-8', 'UTF-8'));
									
									
									$ProductID = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][4], 'UTF-8', 'UTF-8'));
									$company_id = $OperatorID = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][5], 'UTF-8', 'UTF-8'));
									$CommissionType = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][6], 'UTF-8', 'UTF-8'));
									$CommissionPercent = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][7], 'UTF-8', 'UTF-8'));
									$CommissionValue = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][8], 'UTF-8', 'UTF-8'));
									
									
									$IsVisible = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][9], 'UTF-8', 'UTF-8'));
									$CreatedAt = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][10], 'UTF-8', 'UTF-8'));
									$CreatedBy = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][11], 'UTF-8', 'UTF-8'));
									$ModifiedAt = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][12], 'UTF-8', 'UTF-8'));
									$ModifiedBy = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][13], 'UTF-8', 'UTF-8'));
									$MinCommission = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][14], 'UTF-8', 'UTF-8'));
									$MaxCommission = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][15], 'UTF-8', 'UTF-8'));
									
									$temparray = array(
									
									"Id"=>$Id,
									"group_id"=>$group_id,
									"company_id"=>$company_id,
									"CommissionType"=>$CommissionType,
									"CommissionPercent"=>$CommissionPercent,
									"CommissionValue"=>$CommissionValue,
									"MinCommission"=>$MinCommission,
									"MaxCommission"=>$MaxCommission,
									
									);
									array_push($dataar,$temparray);
									
									if($RefTable == "Group")
									{
										if($CommissionType == "Percent")
										{
											$CommissionType = "PER";
											$commission = $CommissionPercent;
										}
										if($CommissionType == "Flat")
										{
											$CommissionType = "AMOUNT";
											$commission = $CommissionValue;
										}
										
											$this->db->query("insert into tblgroupapi(Id,group_id,company_id,commission,CommissionAmount,commission_type,min_com_limit,max_com_limit,add_date,ipaddress) values(?,?,?,?,?,?,?,?,?,?) ",array($Id,$group_id,$company_id,$commission,$CommissionValue,$CommissionType,$MinCommission,$MaxCommission,$this->common->getDate(),$this->common->getRealIpAddr()));
										
										
									}
									
									
									
									$html.="</tr>";
								}
							}
							
						}
						
						$html.="</table>";
						print_r($dataar);exit;
						
						
						//echo $account_number."<hr>";
						//echo $html;
					//	echo "<br />Data Inserted in dababase";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						
						
						
						
						
						
						
						
						
					}
				} 
				$this->view_data['msg'] = "Logo Uploaded";
				$this->view_data["data"] = $html;
				//print_r($dataar);exit;
				$this->view_data["dataarray"] =base64_encode(json_encode($dataar));
				$this->load->view('_Admin/groupcommission_uploadfile_view',$this->view_data);		
			}
			else if($this->input->post("hidaction") == "INSERTDATA")
			{
				$datas = base64_decode($this->input->post("hiddata"));
				$json_arr = json_decode($datas);
				
				foreach($json_arr as $r)
				{
			
					$TxnDate = $r->TxnDate;
					//echo $TxnDate;exit;
					$VaslueDate = $r->VaslueDate;
					$Description = $r->Description;
					$Cheque_no = $r->Cheque_no;
					$BranchCode = $r->BranchCode;
					$Debit = $r->Debit;
					$Credit = $r->Credit;
					$Balance = $r->Balance;
					
					if($Balance != "Balance")
					{
						$accountinfo = $this->db->query("select * from tblbankdetail where Id = 2");
						if($accountinfo->num_rows() == 1)
						{
							$bank_account_id = $accountinfo->row(0)->Id;
							$bank_id = $accountinfo->row(0)->bank_id;
							
							$bankledgerinfo = $this->db->query("select * from tblBankLedger where transaction_date = ? and Withdrawal = ? and Deposit = ? and Balance = ? and Narration = ? and bank_id = ? and bank_account_id = ?",array($TxnDate,$Debit,$Credit,$Balance,$Description,$bank_id,$bank_account_id));
							if($bankledgerinfo->num_rows() == 0)
							{
								$this->db->query("insert into tblBankLedger(user_id,hostname,add_date,ipaddress,transaction_date,Withdrawal,Deposit,Balance,Narration,Details,bank_id,bank_account_id,branchcode,BankRefNo,sValueDate) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array(1,"account.quickapp.in",$this->common->getDate(),$this->common->getRealIpAddr(),$TxnDate,$Debit,$Credit,$Balance,$Description,$Cheque_no,$bank_id,$bank_account_id,$BranchCode,$Cheque_no,$VaslueDate));
							
							}
						}
					}
					
				}
				redirect(base_url()."_Admin/groupcommission_uploadfile");
			}
			else
			{
					$this->view_data['msg'] = "";
					$this->load->view('_Admin/groupcommission_uploadfile_view',$this->view_data);																							
			}
		 
	}	
	
}