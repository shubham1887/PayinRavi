<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_bene extends CI_Controller {
	
	
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }


    

	public function index() 
	{
		
			

				error_reporting(-1);
				ini_set('display_errors',1);
				ini_set('memory_limit',-1);
				ini_set('max_execution_time', '300');

				require_once "phpexcel/Classes/PHPExcel.php";


				
						$this->db->db_debug = TRUE;
						$storagename = "uploads/tejasbhai_bene.xlsx";
				
						
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$tmpfname = $storagename;
						$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
						$excelObj = $excelReader->load($tmpfname);
						$worksheet = $excelObj->getSheet(0);
						$lastRow = $worksheet->getHighestRow();
						



						//echo  "<table>";

						// echo  '<tr>
						// 					<th>Sender</th>
						// 					<th>BeneName</th>
						// 					<th>AccNo</th>
						// 					<th>IFSC</th>
						// 					<th>AccType</th>
						// 					<th>status</th>
						// 					<th>isDeleted</th>
						// 					<th>isValidated</th>
						// 					<th>PaytmBeneId</th>
						// 				</tr>';

						for ($row = 1; $row <= $lastRow; $row++) 
						{

							$CompanyName = "";
							$ServiceNo = "";
							$Amount = "";
							$OperatorId = "";
							
							$BeneName = $this->checknull($worksheet->getCell('C'.$row)->getValue());
							$SenderMobile = $this->checknull($worksheet->getCell('D'.$row)->getValue());

							$AccountNumber = $this->checknull($worksheet->getCell('E'.$row)->getValue());
							$IFSC = $this->checknull($worksheet->getCell('F'.$row)->getValue());
							$AccType = $this->checknull($worksheet->getCell('G'.$row)->getValue());
							$BankName = $this->checknull($worksheet->getCell('H'.$row)->getValue());
							$Status = $this->checknull($worksheet->getCell('K'.$row)->getValue());
							$Deleted = $this->checknull($worksheet->getCell('L'.$row)->getValue());
							$isValidate = $this->checknull($worksheet->getCell('M'.$row)->getValue());
							$paytm_bene_id = $this->checknull($worksheet->getCell('O'.$row)->getValue());
							
							
							$this->db->query("insert into delete_me_bene(SenderMobile,BeneName,AccountNumber,IFSC,AccType,BankName,Status,Deleted,isValidate,paytm_bene_id) values(?,?,?,?,?,?,?,?,?,?)",array($SenderMobile,$BeneName,$AccountNumber,$IFSC,$AccType,$BankName,$Status,$Deleted,$isValidate,$paytm_bene_id));



							// $table_str .= '<tr>';
							// $table_str .= '<td>'.$SenderMobile.'</td>';
							// $table_str .= '<td>'.$BeneName.'</td>';
							// $table_str .= '<td>'.$AccountNumber.'</td>';
							// $table_str .= '<td>'.$IFSC.'</td>';
							// $table_str .= '<td>'.$BankName.'</td>';
							// $table_str .= '<td>'.$Status.'</td>';
							// $table_str .= '<tr>';

							 
						}
						//$table_str.= "</table>";	
			echo "END";exit;		
				
			//	echo $table_str;exit;
		 
	}
	private function checknull($value)
	{
		if($value == NULL)
		{
			return "";
		}
		else
		{
			return $value;
		}
	}	
	
}