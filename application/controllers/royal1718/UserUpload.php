<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserUpload extends CI_Controller {
	
	
	private $msg='';
	
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		// if ($this->session->userdata('ausertype') != "Admin") 
		// { 
		// 	redirect(base_url().'login'); 
		// }
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

				//require_once "phpexcel/Classes/PHPExcel.php";


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


							
							$Id = $this->removenull($worksheet->getCell('A'.$row)->getValue());
							$parent_id = $this->removenull($worksheet->getCell('B'.$row)->getValue());
							$UniqueCode = $this->removenull($worksheet->getCell('C'.$row)->getValue());
							$NextNo = $this->removenull($worksheet->getCell('D'.$row)->getValue());
							$username = $this->removenull($worksheet->getCell('E'.$row)->getValue());
							$password = $this->removenull($worksheet->getCell('F'.$row)->getValue());
							$tpin = $this->removenull($worksheet->getCell('G'.$row)->getValue());
							$usertype = $this->removenull($worksheet->getCell('H'.$row)->getValue());
							$add_date = $this->removenull($worksheet->getCell('I'.$row)->getValue());
							$edit_date = $this->removenull($worksheet->getCell('J'.$row)->getValue());
							$status = $this->removenull($worksheet->getCell('K'.$row)->getValue());
							$FirstName = $this->removenull($worksheet->getCell('L'.$row)->getValue());
							$MiddleName = $this->removenull($worksheet->getCell('M'.$row)->getValue());

							$LastName = $this->removenull($worksheet->getCell('N'.$row)->getValue());
							$MobileNo = $this->removenull($worksheet->getCell('O'.$row)->getValue());
							$EmailId = $this->removenull($worksheet->getCell('P'.$row)->getValue());
							$SchemeId = $this->removenull($worksheet->getCell('Q'.$row)->getValue());
							$FirmName = $this->removenull($worksheet->getCell('R'.$row)->getValue());
							$Ip = $this->removenull($worksheet->getCell('S'.$row)->getValue());
							$KycStatus = $this->removenull($worksheet->getCell('T'.$row)->getValue());
							$CapAmt = $this->removenull($worksheet->getCell('U'.$row)->getValue());
							$Balance = $this->removenull($worksheet->getCell('V'.$row)->getValue());
							$WhiteLabel = $this->removenull($worksheet->getCell('W'.$row)->getValue());
							$DeviceId = $this->removenull($worksheet->getCell('X'.$row)->getValue());
							$IsBlock = $this->removenull($worksheet->getCell('Y'.$row)->getValue());
							$AEPSLimit = $this->removenull($worksheet->getCell('Z'.$row)->getValue());
							$AEPSBalance = $this->removenull($worksheet->getCell('AA'.$row)->getValue());
							$SalesManager = $this->removenull($worksheet->getCell('AB'.$row)->getValue());



							$add_date = \PHPExcel_Style_NumberFormat::toFormattedString($add_date, 'YYYY-MM-DD');
							

							if($tnx_id == NULL)
							{
								$tnx_id = "";
							}




							$this->db->query("insert into tempuser(Id, parent_id, UniqueCode, NextNo, username, password, tpin, usertype, add_date, edit_date, status, FirstName, MiddleName, LastName, MobileNo, EmailId, SchemeId, FirmName, Ip, KycStatus, CapAmt, Balance, WhiteLabel, DeviceId, IsBlock, AEPSLimit, AEPSBalance, SalesManager) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($Id, $parent_id, $UniqueCode, $NextNo, $username, $password, $tpin, $usertype, $add_date, $edit_date, $status, $FirstName, $MiddleName, $LastName, $MobileNo, $EmailId, $SchemeId, $FirmName, $Ip, $KycStatus, $CapAmt, $Balance, $WhiteLabel, $DeviceId, $IsBlock, $AEPSLimit, $AEPSBalance, $SalesManager));



						/*	 $table_str.= '<tr>';
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
							 */
						}
						$table_str.= "</table>";	
					}
				} 
				$this->view_data['msg'] = "Logo Uploaded";
				$this->view_data["data"] = $table_str;
				//print_r($dataar);exit;
				$dataar = array();
				$this->view_data["dataarray"] =base64_encode(json_encode($dataar));
				$this->load->view('royal1718/UserUpload_view',$this->view_data);		
			}
			
			else
			{
					$this->view_data['msg'] = "";
					$this->load->view('royal1718/UserUpload_view',$this->view_data);																							
			}
		 
	}	
	public function removenull($variable)
	{
			if($variable == NULL or $variable == "")
			{
				$variable = "NA";
			}
			return $variable;
	}



		public function dataInsertion()
		{

			$rslt = $this->db->query("select user_id,Id, parent_id, UniqueCode, NextNo, username, password, tpin, usertype, add_date, edit_date, status, FirstName, MiddleName, LastName, MobileNo, EmailId, SchemeId, FirmName, Ip, KycStatus, CapAmt, Balance, WhiteLabel, DeviceId, IsBlock, AEPSLimit, AEPSBalance, SalesManager from tempuser where usertype = 'FRC'");
			//echo $rslt->num_rows();exit;
			foreach($rslt->result() as $rw)
			{
				  $newParentId = $rw->user_id;
				  $Id= $rw->Id;
				  $parent_id= $rw->parent_id;
				  $UniqueCode= $rw->UniqueCode;
				  $NextNo= $rw->NextNo;
				  $username= $rw->username;
				  $password= $rw->password;
				  $tpin= $rw->tpin;
				  $usertype= $rw->usertype;
				  $add_date= $rw->add_date;
				  $edit_date= $rw->edit_date;
				  $status= $rw->status;
				  $FirstName= $rw->FirstName;
				  $MiddleName= $rw->MiddleName;
				  $LastName= $rw->LastName;
				  $MobileNo= $rw->MobileNo;
				  $EmailId= $rw->EmailId;
				  $SchemeId= $rw->SchemeId;
				  $FirmName= $rw->FirmName;
				  $Ip = $rw->Ip;
				  $KycStatus= $rw->KycStatus;
				  $CapAmt= $rw->CapAmt;
				  $Balance= $rw->Balance;
				  $WhiteLabel= $rw->WhiteLabel;
				  $DeviceId= $rw->DeviceId;
				  $IsBlock= $rw->IsBlock;
				  $AEPSLimit= $rw->AEPSLimit;
				  $AEPSBalance= $rw->AEPSBalance;
				  $SalesManager = $rw->SalesManager;
				  $usertype_name = "Agent";


				  if($this->checkmobileexist($MobileNo))
				  {
				  	$distributer_name = $FirstName." ".$LastName;
				  	$state_id = $city_id = 0;
				  	$mobile_no = $MobileNo;
				  	$add_date = $add_date;
				  	$ipaddress = $Ip;
				  	$status = $status;
				  	$scheme_id = $SchemeId;
				  	$username = $MobileNo;
				  	$password = substr($MobileNo,4,10);

				  	$fos_id = 0;
				  	$host_id = $WhiteLabel;



				  	$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,fos_id,host_id,FirstName,MiddleName,LastName) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$rlst = $this->db->query($str_query,array($newParentId,$distributer_name,
					$state_id,$city_id,$mobile_no,$usertype_name,
					$add_date,$ipaddress,$status,$scheme_id,$username,$password,$password,$fos_id,$host_id,$FirstName,$MiddleName,$LastName));		
					$reg_id = $this->db->insert_id();
					if($reg_id > 1)
					{
						$this->db->query("update tempuser set user_id = ? where Id = ?",array($reg_id,$Id));
						//return $reg_id;
					}
				  }
			}

		}
		public function checkmobileexist($mobile_no)
		{
			$rsltcheck = $this->db->query("select user_id from tblusers where mobile_no = ?",array($mobile_no));
			if($rsltcheck->num_rows() == 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

	
}