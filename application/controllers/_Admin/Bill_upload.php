<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_upload extends CI_Controller {
	
	
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
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;
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

						$this->db->db_debug = TRUE;

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

							$CompanyName = "";
							$ServiceNo = "";
							$Amount = "";
							$OperatorId = "";
							
							$CompanyName = $this->checknull($worksheet->getCell('A'.$row)->getValue());
							$ServiceNo = $this->checknull($worksheet->getCell('B'.$row)->getValue());
							
							$Amount = $this->checknull($worksheet->getCell('C'.$row)->getValue());
							$OperatorId = $this->checknull($worksheet->getCell('D'.$row)->getValue());
								
							$bil_info = $this->db->query("SELECT * FROM tblbills where status = 'Pending'  and service_no = ? and bill_amount = ?",array(trim($ServiceNo),trim($Amount)));
							//print_r($bil_info->num_rows());exit;
							if($bil_info->num_rows() == 1)
							{
								$this->db->query("update tblbills set status = 'Success' ,opr_id = ? where Id = ?",array($OperatorId,$bil_info->row(0)->Id));
								//$this->distcommission($bil_info->row(0)->Id);	
							}
							else
							{
								$table_str.= '<tr>';
								 $table_str.= '<td>';

								 $table_str.= $CompanyName;
								 $table_str.= '</td>';

								 $table_str.= '<td>';
								 $table_str.= $ServiceNo;
								 $table_str.= '</td>';



								 $table_str.= '<td>';
								 $table_str.= $Amount;
								 $table_str.= '</td>';

								 $table_str.= '<td>';
								 $table_str.= $OperatorId;
								 $table_str.= '</td>';



								
								 $table_str.= '<tr>';
							}

							 
						}
						$table_str.= "</table>";	
					}
				} 
				$this->view_data['msg'] = "Logo Uploaded";
				$this->view_data["data"] = $table_str;
				//print_r($dataar);exit;
				$dataar = array();
				$this->view_data["dataarray"] =base64_encode(json_encode($dataar));
				$this->load->view('_Admin/Bill_upload_view',$this->view_data);		
				}
			
			else
			{
					$this->view_data['msg'] = "";
					$this->load->view('_Admin/Bill_upload_view',$this->view_data);																							
			}
		 
	}
	private function distcommission($bill_id)
	{
	    //4381 allpayfast commission to superdealer
	   $rsltuser = $this->db->query("
        SELECT 
        a.bill_amount as total, 
        a.add_date,
        a.company_id,
        p.businessname,
        p.user_id,
        p.username,
        p.usertype_name,
        b.host_id
        FROM `tblbills` a 
        left join tblusers b on a.user_id = b.user_id 
        left join tblusers p on  b.parentid = p.user_id 
        where 
        b.usertype_name = 'Agent' and
        a.Id = ? and
        a.status = 'Success'  and
        a.bill_amount < 100000
        order by a.Id",array($bill_id));
    	if($rsltuser->num_rows() == 1)
    	{
    	    $cr_user_id = $rsltuser->row(0)->user_id;
    	    $host_id = $rsltuser->row(0)->host_id;
    	    $transaction_date = $rsltuser->row(0)->add_date;
    	    $company_id = $rsltuser->row(0)->company_id;
    	    $user_id = $rsltuser->row(0)->user_id;

    	    $md_id = 0;
    	    $sd_id = 0;

    	    $dist_info = $this->db->query("select user_id,parentid,scheme_id from tblusers where user_id = ?",array($user_id));
    	    if($dist_info->num_rows() == 1)
    	    {
    	    	$md_id = $dist_info->row(0)->parentid;
    	    	$md_info = $this->db->query("select user_id,parentid,scheme_id from tblusers where user_id = ?",array($md_id));
    	    	if($md_info->num_rows() == 1)
    	    	{
    	    		$sd_id = $md_info->row(0)->parentid;
    	    	}
    	    }

    	    ////default commission values
    	    $DComm = 0.20;
    	    $MdComm = 0.00;
    	    $SdComm = 0.00;


    	    $company_info = $this->db->query("select service_id from tblcompany where company_id = ?",array($company_id));
			if($company_info->num_rows() == 1)
			{
				$service_id = $company_info->row(0)->service_id;
				$userinfo = $this->db->query("select user_id,scheme_id from tblusers where user_id = ?",array($user_id));
				if($userinfo->num_rows() == 1)
				{
					$scheme_id = $userinfo->row(0)->scheme_id;
					$commission_info = $this->db->query("select SdComm,MdComm,DComm,RComm from tblutilitycommission where group_id = ? and service_id = ?",array($scheme_id,$service_id));
					if($commission_info->num_rows() == 1)
					{
						$SdComm = $commission_info->row(0)->SdComm;
						$MdComm = $commission_info->row(0)->MdComm;
						$DComm = $commission_info->row(0)->DComm;
						$RComm = $commission_info->row(0)->RComm;
					}

				}
			}







    	    if($host_id == 4381)
    	    {
    	        $cr_user_id = $rsltuser->row(0)->host_id;
    	    }
    	    
    	    ///////////
    	    ///// DIST COMMISSION
    	    ///////////////////////////////////////////
		    $dr_user_id = 1;
		    $commamount = (($rsltuser->row(0)->total * $DComm) / 100);
		    $tds = 0;
		    $commamount_aftertds = round($commamount - $tds,2);
		    $remark = "BILL PAYMENT COMM.";
		    $description = "Bill Payment Comm.:(".$rsltuser->row(0)->total." * ".$DComm." ) / 100,";
		    $payment_type = "CASH";
		    
    		
		    $rsltinsert = $this->db->query("insert into bill_distcommission(add_date,ipaddress,user_id,transaction_date,TotalSuccess,totalcommission,tds,commission_type,commission_given,ewallet_id) 
            		    values(?,?,?,?,?,?,?,?,?,?)",
            		    array($this->common->getDate(),$this->common->getRealIpAddr(),$cr_user_id,$transaction_date, $rsltuser->row(0)->total,$commamount_aftertds,$tds,"BILL","no",""));
		    if($rsltinsert == true)
		    {
		        $amount = $commamount_aftertds;
    		    $remark = "BILL Payment Commission";
    		    $description = "BillComm.Date:".$transaction_date .",(".$rsltuser->row(0)->total." * ".$DComm." /100)";
    		    $payment_type = "CASH";



    		    if($cr_user_id == 15 or $cr_user_id == 29 or $cr_user_id == 2408 or $cr_user_id == 19885)
    		    {

    		    }
    		    else
    		    {
    		    	//$this->Ew2->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
    		    }
		        
		    }



		    ///////////
    	    ///// MD COMMISSION
    	    ///////////////////////////////////////////



		    $dr_user_id = 1;
		    $commamount = (($rsltuser->row(0)->total * $MdComm) / 100);
		    $tds = 0;
		    $commamount_aftertds = round($commamount - $tds,2);
		    $remark = "BILL PAYMENT COMM.";
		    $description = "Bill Payment Comm.:(".$rsltuser->row(0)->total." * ".$MdComm." ) / 100,";
		    $payment_type = "CASH";
		    
    		
		    $rsltinsert = $this->db->query("insert into bill_distcommission(add_date,ipaddress,user_id,transaction_date,TotalSuccess,totalcommission,tds,commission_type,commission_given,ewallet_id) 
            		    values(?,?,?,?,?,?,?,?,?,?)",
            		    array($this->common->getDate(),$this->common->getRealIpAddr(),$md_id,$transaction_date, $rsltuser->row(0)->total,$commamount_aftertds,$tds,"BILL","no",""));
		    if($rsltinsert == true)
		    {
		        $amount = $commamount_aftertds;
    		    $remark = "BILL Payment Commission";
    		    $description = "BillComm.Date:".$transaction_date .",(".$rsltuser->row(0)->total." * ".$MdComm." /100)";
    		    $payment_type = "CASH";


    		    if($md_id == 15 or $md_id == 29 or $md_id == 2408 or $md_id == 19885)
    		    {

    		    }
    		    else
    		    {
    		    	$this->Ew2->tblewallet_Payment_CrDrEntry($md_id,$dr_user_id,$amount,$remark,$description,$payment_type);	
    		    }

		        
		    }
		    ///////////
    	    ///// SD COMMISSION
    	    ///////////////////////////////////////////
		    $dr_user_id = 1;
		    $commamount = (($rsltuser->row(0)->total * $SdComm) / 100);
		    $tds = 0;
		    $commamount_aftertds = round($commamount - $tds,2);
		    $remark = "BILL PAYMENT COMM.";
		    $description = "Bill Payment Comm.:(".$rsltuser->row(0)->total." * ".$SdComm." ) / 100,";
		    $payment_type = "CASH";
		    
    		
		    $rsltinsert = $this->db->query("insert into bill_distcommission(add_date,ipaddress,user_id,transaction_date,TotalSuccess,totalcommission,tds,commission_type,commission_given,ewallet_id) 
            		    values(?,?,?,?,?,?,?,?,?,?)",
            		    array($this->common->getDate(),$this->common->getRealIpAddr(),$sd_id,$transaction_date, $rsltuser->row(0)->total,$commamount_aftertds,$tds,"BILL","no",""));
		    if($rsltinsert == true)
		    {
		        $amount = $commamount_aftertds;
    		    $remark = "BILL Payment Commission";
    		    $description = "BillComm.Date:".$transaction_date .",(".$rsltuser->row(0)->total." * ".$SdComm." /100)";
    		    $payment_type = "CASH";



    		    if($sd_id == 15 or $sd_id == 29 or $sd_id == 2408 or $sd_id == 19885)
    		    {

    		    }
    		    else
    		    {
    		    	$this->Ew2->tblewallet_Payment_CrDrEntry($sd_id,$dr_user_id,$amount,$remark,$description,$payment_type);	
    		    }
		        
		    }
    	}
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