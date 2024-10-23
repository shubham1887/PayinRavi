<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logoupload extends CI_Controller {
	
	
	private $msg='';
	
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if($this->session->userdata('Adminusertype') != "ADMIN") 
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
    }
	public function index() 
	{
		
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 

		 	if(isset($_POST["btnSubmit"])) 
			{
				
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
						$storagename = "UserImages/".$this->common->getDate()."/boi.xls";
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
									
									
									$TxnDate =trim($data->sheets[$i][cells][$j][2]);
									//var_dump($data->sheets[$i][cells][$j][2]);
									//echo "<hr>";
									
									
									
									$countcheck = explode("/",$TxnDate);
									
									
									
									$TxnDate = date_format(date_create($TxnDate),'Y-m-d');
									$Descrip =$data->sheets[$i][cells][$j][3];
									$RefNo = $data->sheets[$i][cells][$j][4];
									$INR = $data->sheets[$i][cells][$j][5];
									$Debit = $data->sheets[$i][cells][$j][6];
									$Credit = $data->sheets[$i][cells][$j][7];
									$Balance = $data->sheets[$i][cells][$j][8];
						
									
									
									$In_sr = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][1], 'UTF-8', 'UTF-8'));
									$In_Date = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][2], 'UTF-8', 'UTF-8'));
									$In_Desc = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][3], 'UTF-8', 'UTF-8'));
									$In_Cheque = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][4], 'UTF-8', 'UTF-8'));
									$In_Currency = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][5], 'UTF-8', 'UTF-8'));
									$In_Debit = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][6], 'UTF-8', 'UTF-8'));
									$In_Credit = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][7], 'UTF-8', 'UTF-8'));
									$In_Balance = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][8], 'UTF-8', 'UTF-8'));
									
									$temparray = array(
									
									"SrNo"=>$In_sr,
									"Date"=>$In_Date,
									"Description"=>$In_Desc,
									"Cheque_no"=>$In_Cheque,
									"Currency"=>$In_Currency,
									"Debit"=>str_replace(",","",$In_Debit),
									"Credit"=>str_replace(",","",$In_Credit),
									"Balance"=>str_replace(",","",$In_Balance)
									
									);
									
									
									array_push( $dataar,$temparray);
									
									
									if(true)
									{
										
										
										
										
									//	echo "<hr>";
										//echo "TxnDaTE : ".$TxnDate."  <br>";
										//echo "Descrip : ".$Descrip."<br>";
										
										$Descrip = mb_convert_encoding($Descrip, 'UTF-8', 'UTF-8');
										
										
										//echo "RefNo : ".$RefNo."<br>";
										//echo "CRDR : ".$INR."<br>";
										
										//echo "Debit : ".floatval(str_replace(",","",$Debit))."<br>";
										//
										//echo "Credit : ".floatval(str_replace(",","",$Credit))."<br>";
										$Balance = mb_convert_encoding($Balance, 'UTF-8', 'UTF-8');
										
										//echo "Balance : ".floatval(str_replace(",","",str_replace("?","",$Balance)))."<br>";
									
										//echo  "<hr>";
									
										if(date_create($TxnDate) and $INR != "Currency")
										{
											
											$ex_TransactionDate = $TxnDate;
											$ex_ValueDate = $TxnDate;
											$ex_Descrip = $Descrip;
											$ex_RefNo = $RefNo;
											$ex_BranchCode = $INR;
											
											$ex_Debit = floatval(str_replace(",","",$Debit));
											$ex_Credit = floatval(str_replace(",","",$Credit));
											$ex_Balance = floatval(str_replace(",","",$Balance));
											
											
											$ex_RefNo = "";
											
											
											
													$accountinfo = $this->db->query("select * from tblbankdetail where Id = 3");
													
													if($accountinfo->num_rows() == 1)
													{
														$bank_account_id = $accountinfo->row(0)->Id;
														$bank_id = $accountinfo->row(0)->bank_id;
														
														$bankledgerinfo = $this->db->query("select * from tblBankLedger where transaction_date = ? and Withdrawal = ? and Deposit = ? and Balance = ? and Narration = ? and bank_id = ? and bank_account_id = ?",array($ex_TransactionDate,$ex_Debit,$ex_Credit,$ex_Balance,$ex_Descrip,$bank_id,$bank_account_id));
														if($bankledgerinfo->num_rows() == 0)
														{
															//$this->db->query("insert into tblBankLedger(user_id,hostname,add_date,ipaddress,transaction_date,Withdrawal,Deposit,Balance,Narration,bank_id,bank_account_id,branchcode,BankRefNo,sValueDate) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array(1,"account.quickapp.in",$this->common->getDate(),$this->common->getRealIpAddr(),$ex_TransactionDate,$ex_Debit,$ex_Credit,$ex_Balance,$ex_Descrip,$bank_id,$bank_account_id,$ex_BranchCode,$ex_RefNo,$ex_ValueDate));
														//	echo "end";
														}
													}
											
										}
										
									}
									/*[Id],[ParentId],[CustName],[Username],[Mobile],[Password],[Email],[Company],[City],[PostalCode],[Address],[Status],[AddDate],[EditDate],[UserType],[StateId],[SchemeId],[Firstime],[ThemeColor],[ResponseURL] ,[APIPassword]*/
									$code = $data->sheets[$i][cells][$j][1];
									$Station_name = $data->sheets[$i][cells][$j][2];
									
									$add_date = "2017-09-17";//$this->common->getDate();
									$ipaddress = "1.1.1.1";//$this->common->getRealIpAddr();
									
									//echo "<hr>";
									//$url = 'http://payreflection.com/setplan?operator_name='.urlencode($operator_name).'&circle='.urlencode($circle).'&plan_type='.urlencode($plan_type).'&amount='.urlencode($amount).'&validity='.urlencode($validity).'&talktime='.urlencode($talktime).'&tags='.urlencode($tags).'&Benefits='.urlencode($Benefits);
						//echo $url;exit;
									//echo file_get_contents($url);
								//	$query = "insert into master_stations(staion_name,station_code,add_date,edit_date,ipaddress) values('".$Station_name."','".$code."','".$add_date."','".$add_date."','".$ipaddress."')";
									
								//	mysqli_query($connection,$query);
									$html.="</tr>";
								}
							}
							
						}
						
						$html.="</table>";
						
						
						
						//echo $account_number."<hr>";
						//echo $html;
					//	echo "<br />Data Inserted in dababase";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						
						
						
						
						
						
						
						
						
					}
				} 
				$this->view_data['msg'] = "Logo Uploaded";
				$this->view_data["data"] = $html;
				
				$this->view_data["dataarray"] =base64_encode(json_encode($dataar));
				$this->load->view('Admin/logoupload_view',$this->view_data);		
			}
			else if($this->input->post("hidaction") == "INSERTDATA")
			{
				$datas = base64_decode($this->input->post("hiddata"));
				$json_arr = json_decode($datas);
				foreach($json_arr as $r)
				{
					$SrNo = $r->SrNo;
					$Date = $r->Date;
					$Description = $r->Description;
					$Cheque_no = $r->Cheque_no;
					$Currency = $r->Currency;
					$Debit = $r->Debit;
					$Credit = $r->Credit;
					$Balance = $r->Balance;
					if($SrNo != "Srl No.")
					{
						$accountinfo = $this->db->query("select * from tblbankdetail where Id = 3");
						if($accountinfo->num_rows() == 1)
						{
							$bank_account_id = $accountinfo->row(0)->Id;
							$bank_id = $accountinfo->row(0)->bank_id;
							$txnDate = date_format(date_create($Date),'Y-m-d');
							// echo $txnDate;exit;
 							$bankledgerinfo = $this->db->query("select * from tblBankLedger where transaction_date = ? and Withdrawal = ? and Deposit = ? and Balance = ? and Narration = ? and bank_id = ? and bank_account_id = ?",array($txnDate,$Debit,$Credit,$Balance,$Description,$bank_id,$bank_account_id));
							if($bankledgerinfo->num_rows() == 0)
							{
								$ex_BranchCode = $Cheque_no;
								$ex_RefNo = $Currency;
								$ex_ValueDate = $txnDate;
								$this->db->query("insert into tblBankLedger(user_id,hostname,add_date,ipaddress,transaction_date,Withdrawal,Deposit,Balance,Narration,bank_id,bank_account_id,branchcode,BankRefNo,sValueDate) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array(1,"account.quickapp.in",$this->common->getDate(),$this->common->getRealIpAddr(),$txnDate,$Debit,$Credit,$Balance,$Description,$bank_id,$bank_account_id,$ex_BranchCode,$ex_RefNo,$ex_ValueDate));
							//	echo "end";
							
							}
						}
					}
					
				}
				redirect(base_url()."Admin/logoupload");
			}
			else
			{
					$this->view_data['msg'] = "";
					$this->load->view('Admin/logoupload_view',$this->view_data);																							
			}
		 
	}	
	
}