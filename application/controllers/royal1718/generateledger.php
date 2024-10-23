<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generateledger extends CI_Controller {
	
	
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
	public function index() 
	{
		
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 

		 	
				
				
					
					
						
						$storagename = "ravikant/ravikant_ledger_sahjanand.xls";
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
									
									
									
								//	$srno = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][1], 'UTF-8', 'UTF-8'));
								//	$bankname = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][2], 'UTF-8', 'UTF-8'));
								//	$bankcode =str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][3], 'UTF-8', 'UTF-8'));
									
								//	$field4 = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][4], 'UTF-8', 'UTF-8'));
									
								//	$field5 = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][5], 'UTF-8', 'UTF-8'));
								//	$ifsc = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][6], 'UTF-8', 'UTF-8'));
								//	$bankid = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][7], 'UTF-8', 'UTF-8'));
								
									
								/*	$temparray = array(
									
									"sr"=>$srno,
									"bankname"=>$bankname,
									"bankcode"=>$bankcode,
									"field4"=>$field4,
									"field5"=>$field5,
									"ifsc"=>$ifsc,
									"bankid"=>$bankid,
									
									
									);
									*/
									
									
									
									
									$payment_id = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][1], 'UTF-8', 'UTF-8'));
								    $datetime =mb_convert_encoding($data->sheets[$i][cells][$j][2], 'UTF-8', 'UTF-8');
								    
								    
								    $datetime = str_replace("/","-",$datetime);
								    $datetime1 = explode("-",$datetime);
								    $datetime = $datetime1[2]."-".$datetime1[1]."-".$datetime1[0];
								    
									$description = str_replace("?","",mb_convert_encoding($data->sheets[$i][cells][$j][4], 'UTF-8', 'UTF-8'));
								    $credit_amount = str_replace(",","",mb_convert_encoding($data->sheets[$i][cells][$j][6], 'UTF-8', 'UTF-8'));
									$particulars = "RECHARGE- TOP UP";
									
									//credit entry of payment
									$this->db->query("insert into templedger_ravikant(add_date,payment_id,Description,Credit,particulars) values(?,?,?,?,?)",array($datetime,$payment_id,$description,$credit_amount,$particulars));
									
									//debit entry of cash
									$particularsPcash = $description;
									$this->db->query("insert into templedger_ravikant(add_date,payment_id,Description,Debit,particulars) values(?,?,?,?,?)",array($datetime,$payment_id,$description,$credit_amount,$particularsPcash));
									
									$temparray = array(
									
									"payment_id"=>$payment_id,
									"datetime"=>$datetime,
									"credit_amount"=>str_replace(",","",$credit_amount),
									"Desc"=>$description	
									);
									//$Balance = mb_convert_encoding($Balance, 'UTF-8', 'UTF-8');
									//floatval(str_replace(",","",$Debit));
									array_push( $dataar,$temparray);
									
									
									if(true)
									{
										
										
										
										//echo "Balance : ".floatval(str_replace(",","",str_replace("?","",$Balance)))."<br>";
									
										//echo  "<hr>";
									
									
										
									}
									
									$html.="</tr>";
								}
							}
							
						}
						
						
					echo json_encode($dataar);exit;
				//		$html.="</table>";
						
						
						
						//echo $account_number."<hr>";
						//echo $html;
					//	echo "<br />Data Inserted in dababase";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						
						
						
						
						
						
						
						
						
					
				
				echo $html;exit;
				
			
		 
	}	
	
}