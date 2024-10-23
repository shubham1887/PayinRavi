<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserDetailUpload extends CI_Controller {
	
	
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


							
							$Id = $this->removenull($worksheet->getCell('A'.$row)->getValue());
							$UserID = $this->removenull($worksheet->getCell('B'.$row)->getValue());
							$PANCard = $this->removenull($worksheet->getCell('C'.$row)->getValue());
							$AdharNo = $this->removenull($worksheet->getCell('D'.$row)->getValue());
							$Address = $this->removenull($worksheet->getCell('E'.$row)->getValue());
							$FirmAddress = $this->removenull($worksheet->getCell('F'.$row)->getValue());
							$PinCode = $this->removenull($worksheet->getCell('G'.$row)->getValue());
							$StateName = $this->removenull($worksheet->getCell('H'.$row)->getValue());
							$CityName = $this->removenull($worksheet->getCell('I'.$row)->getValue());
							$BankName = $this->removenull($worksheet->getCell('J'.$row)->getValue());
							$AccountNo = $this->removenull($worksheet->getCell('K'.$row)->getValue());
							$IFSCCode = $this->removenull($worksheet->getCell('L'.$row)->getValue());
							$BranchName = $this->removenull($worksheet->getCell('M'.$row)->getValue());

							$Document1 = $this->removenull($worksheet->getCell('N'.$row)->getValue());
							$Document2 = $this->removenull($worksheet->getCell('O'.$row)->getValue());
							$Document3 = $this->removenull($worksheet->getCell('P'.$row)->getValue());
							$AddDate = $this->removenull($worksheet->getCell('Q'.$row)->getValue());
							$Status = $this->removenull($worksheet->getCell('R'.$row)->getValue());
							$ResponsePage = $this->removenull($worksheet->getCell('S'.$row)->getValue());
							$ResponsePage1 = $this->removenull($worksheet->getCell('T'.$row)->getValue());
							$GeoLocation = $this->removenull($worksheet->getCell('U'.$row)->getValue());
							$VerifyData = $this->removenull($worksheet->getCell('V'.$row)->getValue());
							$VerifyDate = $this->removenull($worksheet->getCell('W'.$row)->getValue());
							$IMEINo = $this->removenull($worksheet->getCell('X'.$row)->getValue());
							$IsAcceptTerm = $this->removenull($worksheet->getCell('Y'.$row)->getValue());
							$AllowPattern = $this->removenull($worksheet->getCell('Z'.$row)->getValue());
							$Outlet = $this->removenull($worksheet->getCell('AA'.$row)->getValue());
							$PanStatus = $this->removenull($worksheet->getCell('AB'.$row)->getValue());


							$KYCReqDate = $this->removenull($worksheet->getCell('AC'.$row)->getValue());
							$KYCApprovedDate = $this->removenull($worksheet->getCell('AD'.$row)->getValue());
							$Document4 = $this->removenull($worksheet->getCell('AE'.$row)->getValue());
							$AgentID = $this->removenull($worksheet->getCell('AF'.$row)->getValue());
							$DailyDeductAmount = $this->removenull($worksheet->getCell('AG'.$row)->getValue());
							$DailyDeductDate = $this->removenull($worksheet->getCell('AH'.$row)->getValue());
							$WeeklyDeductAmount = $this->removenull($worksheet->getCell('AI'.$row)->getValue());
							$WeeklyDeductDate = $this->removenull($worksheet->getCell('AJ'.$row)->getValue());
							$MonthlyDeductAmount = $this->removenull($worksheet->getCell('AK'.$row)->getValue());
							$MonthlyDeductDate = $this->removenull($worksheet->getCell('AL'.$row)->getValue());
							$QuarterlyDeductAmount = $this->removenull($worksheet->getCell('AM'.$row)->getValue());
							$QuarterlyDeductDate = $this->removenull($worksheet->getCell('AN'.$row)->getValue());
							$SemiAnnuallyDeductAmount = $this->removenull($worksheet->getCell('AO'.$row)->getValue());
							$SemiAnnuallyDeductDate = $this->removenull($worksheet->getCell('AP'.$row)->getValue());
							$AnnuallyDeductAmount = $this->removenull($worksheet->getCell('AQ'.$row)->getValue());
							$AnnuallyDeductDate = $this->removenull($worksheet->getCell('AR'.$row)->getValue());
							$KYCRemarks = $this->removenull($worksheet->getCell('AS'.$row)->getValue());



							$AddDate = \PHPExcel_Style_NumberFormat::toFormattedString($AddDate, 'YYYY-MM-DD');
							

							if($Id > 0)
							{
								$this->db->query("insert into tempuser_detail(Id, UserID, PANCard, AdharNo, Address, FirmAddress, PinCode, StateName, CityName, BankName, AccountNo, IFSCCode, BranchName, Document1, Document2, Document3, AddDate, Status, ResponsePage, ResponsePage1, GeoLocation, VerifyData, VerifyDate, IMEINo, IsAcceptTerm, AllowPattern, Outlet, PanStatus, KYCReqDate, KYCApprovedDate, Document4, AgentID, DailyDeductAmount, DailyDeductDate, WeeklyDeductAmount, WeeklyDeductDate, MonthlyDeductAmount, MonthlyDeductDate, QuarterlyDeductAmount, QuarterlyDeductDate, SemiAnnuallyDeductAmount, SemiAnnuallyDeductDate, AnnuallyDeductAmount, AnnuallyDeductDate, KYCRemarks) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($Id,$UserID,$PANCard,$AdharNo,$Address,$FirmAddress,$PinCode,$StateName,$CityName,$BankName,$AccountNo,$IFSCCode,$BranchName,$Document1,$Document2,$Document3,$AddDate,$Status,$ResponsePage,$ResponsePage1,$GeoLocation,$VerifyData,$VerifyDate,$IMEINo,$IsAcceptTerm,$AllowPattern,$Outlet,$PanStatus,$KYCReqDate,$KYCApprovedDate,$Document4,$AgentID,$DailyDeductAmount,$DailyDeductDate,$WeeklyDeductAmount,$WeeklyDeductDate,$MonthlyDeductAmount,$MonthlyDeductDate,$QuarterlyDeductAmount,$QuarterlyDeductDate,$SemiAnnuallyDeductAmount,$SemiAnnuallyDeductDate,$AnnuallyDeductAmount,$AnnuallyDeductDate,$KYCRemarks));
	
							}


							


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
				$this->load->view('royal1718/UserDetailUpload_view',$this->view_data);		
			}
			
			else
			{
					$this->view_data['msg'] = "";
					$this->load->view('royal1718/UserDetailUpload_view',$this->view_data);																							
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

			$rslt = $this->db->query("select Id, UserID, PANCard, AdharNo, Address, FirmAddress, PinCode, StateName, CityName, BankName, AccountNo, IFSCCode, BranchName, Document1, Document2, Document3, AddDate, Status, ResponsePage, ResponsePage1, GeoLocation, VerifyData, VerifyDate, IMEINo, IsAcceptTerm, AllowPattern, Outlet, PanStatus, KYCReqDate, KYCApprovedDate, Document4, AgentID, DailyDeductAmount, DailyDeductDate, WeeklyDeductAmount, WeeklyDeductDate, MonthlyDeductAmount, MonthlyDeductDate, QuarterlyDeductAmount, QuarterlyDeductDate, SemiAnnuallyDeductAmount, SemiAnnuallyDeductDate, AnnuallyDeductAmount, AnnuallyDeductDate, KYCRemarks, new_user_id FROM tempuser_detail order by Id");
			//echo $rslt->num_rows();exit;
			foreach($rslt->result() as $rw)
			{


				$Id = $rw->Id;
				$UserID = $rw->UserID;
				$PANCard = $rw->PANCard;
				$AdharNo = $rw->AdharNo;
				$Address = $rw->Address;
				$FirmAddress = $rw->FirmAddress;
				$PinCode = $rw->PinCode;
				$StateName = $rw->StateName;
				$CityName = $rw->CityName;
				$BankName = $rw->BankName;
				$AccountNo = $rw->AccountNo;
				$IFSCCode = $rw->IFSCCode;
				$BranchName = $rw->BranchName;
				$Document1 = $rw->Document1;
				$Document2 = $rw->Document2;
				$Document3 = $rw->Document3;
				$AddDate = $rw->AddDate;
				$Status = $rw->Status;
				$ResponsePage = $rw->ResponsePage;
				$ResponsePage1 = $rw->ResponsePage1;
				$GeoLocation = $rw->GeoLocation;
				$VerifyData = $rw->VerifyData;
				$VerifyDate = $rw->VerifyDate;
				$IMEINo = $rw->IMEINo;
				$IsAcceptTerm = $rw->IsAcceptTerm;
				$AllowPattern = $rw->AllowPattern;
				$Outlet = $rw->Outlet;
				$PanStatus = $rw->PanStatus;
				$KYCReqDate = $rw->KYCReqDate;
				$KYCApprovedDate = $rw->KYCApprovedDate;
				$Document4 = $rw->Document4;
				$AgentID = $rw->AgentID;
				
				$KYCRemarks = $rw->KYCRemarks;
				$new_user_id = $rw->new_user_id;





				  if($this->checkmobileexist($new_user_id))
				  {
						$user_id = $new_user_id;
						$add_date = $AddDate;
						$ipaddress = $this->common->getRealIpAddr();
						$postal_address = $Address;
						$pincode = $PinCode;
						$aadhar_number = $AdharNo;
						$pan_no = $PANCard;
						$gst_no = "";
						$call_back_url = $ResponsePage;
						$contact_person = "";
						$landline = "";
						$emailid = "";
						$client_ip = "";
						$client_ip2 = "";
						$client_ip3 = "";
						$client_ip4 = "";
						$client_ip5 = "";
						$notify_mobile_no = "";
						$notify_imei = $IMEINo;
						$notify_key = "";
						$birthdate = "";
						$deactive_date = "";
						$tds = "";
						$autoaccounting = "";
						$profile_pic_path = "";
						

				  	$str_query = "insert into tblusers_info(user_id, add_date, ipaddress, postal_address, FirmAddress, pincode, aadhar_number, pan_no, gst_no, call_back_url, contact_person, landline, emailid, client_ip, client_ip2, client_ip3, client_ip4, client_ip5, notify_mobile_no, notify_imei, notify_key, birthdate, deactive_date, tds, autoaccounting, profile_pic_path, StateName, CityName, BankName, AccountNo, IFSCCode, BranchName, Document1, Document2, Document3, Document4, Status, GeoLocation, Outlet, KYCReqDate, KYCApprovedDate, AgentID, KYCRemarks) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$rlst = $this->db->query($str_query,array($user_id,$add_date,$ipaddress,$postal_address,$FirmAddress,$pincode,$aadhar_number,$pan_no,$gst_no,$call_back_url,$contact_person,$landline,$emailid,$client_ip,$client_ip2,$client_ip3,$client_ip4,$client_ip5,$notify_mobile_no,$notify_imei,$notify_key,$birthdate,$deactive_date,$tds,$autoaccounting,$profile_pic_path,$StateName,$CityName,$BankName,$AccountNo,$IFSCCode,$BranchName,$Document1,$Document2,$Document3,$Document4,$Status,$GeoLocation,$Outlet,$KYCReqDate,$KYCApprovedDate,$AgentID,$KYCRemarks));		
					$reg_id = $this->db->insert_id();
					if($reg_id > 1)
					{
						
					}
				  }
			}

		}
		public function checkmobileexist($user_id)
		{
			$rsltcheck = $this->db->query("select user_id from tblusers_info where user_id = ?",array($user_id));
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