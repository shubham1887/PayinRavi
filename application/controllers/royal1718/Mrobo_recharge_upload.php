<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mrobo_recharge_upload extends CI_Controller {
	
	
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }


    public function test()
    {
    	error_reporting(-1);
		ini_set('display_errors',1);

		require_once "phpexcel/Classes/PHPExcel.php";

		$tmpfname = "uploads/20210123mrobo.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
		
		echo "<table>";
		for ($row = 1; $row <= $lastRow; $row++) 
		{
			 echo "<tr><td>";
			 echo $worksheet->getCell('A'.$row)->getValue();
			 echo "</td><td>";
			 echo $worksheet->getCell('B'.$row)->getValue();
			 echo "</td><tr>";
		}
		echo "</table>";	
    }

	public function index() 
	{
		
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 

		 	if(isset($_POST["btnSubmit"])) 
			{

				error_reporting(-1);
				ini_set('display_errors',1);

				require_once "phpexcel/Classes/PHPExcel.php";


				//print_r($this->input->post());exit;
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
						if (!file_exists("uploads/".$this->common->getMySqlDate())) 
						{
							mkdir("uploads/".$this->common->getMySqlDate());
						}

						$storagename = "uploads/".$_FILES["file"]["name"];
						move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
						$uploadedStatus = 1;
						
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$tmpfname = $storagename;

						//$tmpfname = "uploads/20210123mrobo.xlsx";
						$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
						$excelObj = $excelReader->load($tmpfname);
						$worksheet = $excelObj->getSheet(0);
						$lastRow = $worksheet->getHighestRow();
						



						$table_str =  "<table>";
						for ($row = 1; $row <= $lastRow; $row++) 
						{

							$id = $worksheet->getCell('A'.$row)->getValue();
							$mobile_no = $worksheet->getCell('B'.$row)->getValue();
							$amount = $worksheet->getCell('C'.$row)->getValue();
							$balance = $worksheet->getCell('D'.$row)->getValue();
							$order_id = $worksheet->getCell('E'.$row)->getValue();
							$tnx_id = $worksheet->getCell('F'.$row)->getValue();
							$roffer = $worksheet->getCell('G'.$row)->getValue();
							$status = $worksheet->getCell('H'.$row)->getValue();
							$recharge_date = $worksheet->getCell('I'.$row)->getValue();
							$createdAt = $worksheet->getCell('J'.$row)->getValue();
							$updatedAt = $worksheet->getCell('K'.$row)->getValue();
							$Lapu = $worksheet->getCell('L'.$row)->getValue();
							$company_name = $worksheet->getCell('M'.$row)->getValue();



							$recharge_date = \PHPExcel_Style_NumberFormat::toFormattedString($recharge_date, 'YYYY-MM-DD');
							$createdAt = \PHPExcel_Style_NumberFormat::toFormattedString($createdAt, 'YYYY-MM-DD HH:MM:SS');
							$updatedAt = \PHPExcel_Style_NumberFormat::toFormattedString($updatedAt, 'YYYY-MM-DD HH:MM:SS');
							//echo $recharge_date."<br>";
							//echo "Formated : ". date_format(date_create($recharge_date),'Y-m-d H:i:s')."<br>";exit;


							if($tnx_id == NULL)
							{
								$tnx_id = "";
							}

							$this->db->query("insert into lapu_recharge_history(

								Id,mrobo_id,mobile_no,amount,balnace,order_id,txn_id,roffer,status,recharge_date,createdAt,updatedAt,lapu_no,company_name
						)	values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)
						",array($id,$id,$mobile_no,$amount,$balance,$order_id ,$tnx_id,$roffer,$status,$recharge_date,$createdAt,$updatedAt,$Lapu,$company_name));
							


							 $table_str.= '<tr>';
							 $table_str.= '<td>';

							 $table_str.= $id;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $mobile_no;
							 $table_str.= '</td>';



							 $table_str.= '<td>';
							 $table_str.= $amount;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $balance;
							 $table_str.= '</td>';


							 $table_str.= '<td>';
							 $table_str.= $tnx_id;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $roffer;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $status;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $recharge_date;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $createdAt;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $updatedAt;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $Lapu;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $company_name;
							 $table_str.= '</td>';

							 $table_str.= '<tr>';
						}
						$table_str.= "</table>";	
					}
				} 
				$this->view_data['msg'] = "Logo Uploaded";
				$this->view_data["data"] = $table_str;
				//print_r($dataar);exit;
				$dataar = array();
				$this->view_data["dataarray"] =base64_encode(json_encode($dataar));
				$this->load->view('royal1718/Mrobo_recharge_upload_view',$this->view_data);		
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
				redirect(base_url()."Admin/sbiuploadfile");
			}
			else
			{
					$this->view_data['msg'] = "";
					$this->load->view('royal1718/Mrobo_recharge_upload_view',$this->view_data);																							
			}
		 
	}	
	
}