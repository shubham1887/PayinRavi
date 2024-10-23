<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SbiUpload extends CI_Controller {
	
	
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

							$TxnDate = $worksheet->getCell('A'.$row)->getValue();
							$ValueDate = $worksheet->getCell('B'.$row)->getValue();
							$Description = $worksheet->getCell('C'.$row)->getValue();
							$RefNoChqNo = $worksheet->getCell('D'.$row)->getValue();
							$BranchCode = $worksheet->getCell('E'.$row)->getValue();
							$Debit = $worksheet->getCell('F'.$row)->getValue();
							$Credit = $worksheet->getCell('G'.$row)->getValue();
							$Balance = $worksheet->getCell('H'.$row)->getValue();
							



							$TxnDate = \PHPExcel_Style_NumberFormat::toFormattedString($TxnDate, 'YYYY-MM-DD');
							$ValueDate = \PHPExcel_Style_NumberFormat::toFormattedString($ValueDate, 'YYYY-MM-DD HH:MM:SS');
							


							
							$BankName = "ROYAL_SBI";
							$this->db->query("insert into RoyalBank(

								BankName,TxnDate,ValueDate,Description,RefNoChqNo,BranchCode,Debit,Credit,Balance)	values(?,?,?,?,?,?,?,?,?)
						",array($BankName,$TxnDate,$ValueDate,$Description,$RefNoChqNo,$BranchCode,$Debit,$Credit,$Balance));
							


							 $table_str.= '<tr>';
							 $table_str.= '<td>';

							 $table_str.= $BankName;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $TxnDate;
							 $table_str.= '</td>';



							 $table_str.= '<td>';
							 $table_str.= $ValueDate;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $Description;
							 $table_str.= '</td>';


							 $table_str.= '<td>';
							 $table_str.= $RefNoChqNo;
							 $table_str.= '</td>';



							 $table_str.= '<td>';
							 $table_str.= $BranchCode;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $Debit;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $Credit;
							 $table_str.= '</td>';

							 $table_str.= '<td>';
							 $table_str.= $Balance;
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
				$this->load->view('royal1718/SbiUpload_view',$this->view_data);		
			}
			
			else
			{
					$this->view_data['msg'] = "";
					$this->load->view('royal1718/SbiUpload_view',$this->view_data);																							
			}
		 
	}	
	
}