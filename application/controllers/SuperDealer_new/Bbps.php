<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bbps extends CI_Controller {

  function __construct()
  {
      parent:: __construct();
      $this->is_logged_in();
      $this->clear_cache();
  }
  function is_logged_in() 
  {
    if ($this->session->userdata('SdUserType') != "SuperDealer") 
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
       error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
  }
  public function Categories()
  {
    header("Content-Type: application/json; charset=utf-8");

    $data_array = array();
    $rsltservices = $this->db->query("select * from tblservice where is_bbps = 'yes'");
    foreach($rsltservices->result() as $rw)
    {
      $temparray = array(
          "Categoryid"=>$rw->service_id,
          "Categoryname"=>$rw->service_name,
          "ImageUrl"=>"water-drop.svg",
      );
      array_push($data_array,$temparray);
    }
    $resp_array["ResponseStatus"] = "1";
    $resp_array["Status"] = "Success";
    $resp_array["Remarks"] = "Category List";
    $resp_array["ErrorCode"] = "";
    $resp_array["Data"] = $data_array;
    echo json_encode($resp_array);exit;

   
  }
  public function Validatebillingdetails()
  {
    /*
    {"billercode":"226","customerNo":"8238232303","billnumber":"100385854","billeraccount":null,"billercycle":""}
    */
    $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("SdId")));
    header("Content-Type: application/json; charset=utf-8");
    $user_id = $userinfo->row(0)->user_id;
    $response = file_get_contents('php://input');
    $json_obj = json_decode($response);
    if(isset($json_obj->billercode) and isset($json_obj->customerNo) and isset($json_obj->billnumber)  )
    {

      $billercode =  trim((string)$json_obj->billercode);
      $customerNo =  trim((string)$json_obj->customerNo);
      $billnumber =  trim((string)$json_obj->billnumber);
      $billeraccount =  trim((string)$json_obj->billeraccount);

      $company_info = $this->db->query("select * from tblcompany where company_id = ?",array($billercode));
      if($company_info->num_rows() == 1)
      {
          $mcode = $company_info->row(0)->mcode;
          /*
{"tel":"9920426565","operator":"Vodafone","records":{"status":0,"desc":"We are facing issues fetching your bill. This could be due to no bill due or other biller issues. Please try again later"},"status":1}

*/
          if($company_info->row(0)->service_id == 3)
          {
              if($company_info->row(0)->company_id == 44)
              {
                  $mcode = "Airtel";
              }
              if($company_info->row(0)->company_id == 45 or $company_info->row(0)->company_id == 49)
              {
                  $mcode = "Vodafone";
              }
              $url = 'https://www.mplan.in/api/Bsnl.php?apikey=ecc8fea337674a0d600ff07c88515042&offer=roffer&tel='.$billnumber.'&operator='.$mcode;

              if($company_info->row(0)->company_id == 46)
              {
                  $mcode = "Bsnlpost";
                  $url = 'https://www.mplan.in/api/Bsnl.php?apikey=ecc8fea337674a0d600ff07c88515042&offer=roffer&tel='.$billnumber.'&operator=Bsnlpost'.$mcode;
              }
              $response = $this->common->callurl($url);
              $json_obj = json_decode($response);


              $dueamount = "";
              $duedate = "";
              $customername = "";
              $billnumber = "";
              $billperiod = "";


              if(isset($json_obj->records))
              {
                $records = $json_obj->records;
                if(isset($records->dueamount))
                {
                  $dueamount = $records->dueamount;
                  $duedate = $records->duedate;
                  $customername = $records->customername;
                  $billnumber = $records->billnumber;
                  $billperiod = $records->billperiod;  
                  $StatusCode = 1;
                  $Message = "SUCCESS";
                }
                else
                {
                  $Message = $records->desc;
                  $StatusCode = 0;
                }
                
              }
              $data_array = array(
                  "dueamount"=> $dueamount,
                  "duedate"=> $duedate,
                  "billdate"=> "",
                  "customername"=> $customername,
                  "reference_id"=> "0",
                  "billnumber"=> $billnumber,
                );

                $resp_array["StatusCode"] = $StatusCode;
                $resp_array["Message"] = $Message;
                $resp_array["Data"] = $data_array;
                echo json_encode($resp_array);exit;
          }
          else
          {
              $this->load->model("Mastermoney");
              $resp = $this->Mastermoney->fetchbill($userinfo,$mcode,$billercode,$billnumber,$customerNo,$billeraccount);
              $json_obj = json_decode($resp);
              if(isset($json_obj->statuscode) and isset($json_obj->status) and isset($json_obj->message))
              {
                $statuscode = $json_obj->statuscode;
                $status = $json_obj->status;
                $message = $json_obj->message;

                $StatusCode = 0;
                $Message = $message;

                $dueamount = "";
                $duedate = "";
                $customername = "";
                $billnumber = "";
                $billperiod = "";
                if($statuscode == "TXN")
                {
                  $StatusCode = 1;
                }


                if(isset($json_obj->particulars))
                {
                  $particulars = $json_obj->particulars;
                  $dueamount = $particulars->dueamount;
                  $duedate = $particulars->duedate;
                  $customername = $particulars->customername;
                  $billnumber = $particulars->billnumber;
                  $billperiod = $particulars->billperiod;
                  
                }



                $data_array = array(
                  "dueamount"=> $dueamount,
                  "duedate"=> $duedate,
                  "billdate"=> "",
                  "customername"=> $customername,
                  "reference_id"=> "0",
                  "billnumber"=> $billnumber,
                );

                $resp_array["StatusCode"] = $StatusCode;
                $resp_array["Message"] = $Message;
                $resp_array["Data"] = $data_array;
                echo json_encode($resp_array);exit;

              }
              echo $resp;exit;
          }
      }
      
      
    }
  }

  public function Dotransactions()
  {
    error_reporting(-1);
    ini_set('display_errors',1);
    $this->db->db_debug = TRUE;
    /*
    {"billercode":"135","billnumber":"210001334997","Amount":"866","custmobileno":"8238232303","billeraccount":null,"billercycle":"","payment":"Cash","duedate":"07 Mar 2021","billdate":"","consumername":"Mrs. DIPALI DILIP NALAWADE","billnumbers":"","referenceNo":"0","tPin":"1234"}
    */
    $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("SdId")));
    header("Content-Type: application/json; charset=utf-8");
    $user_id = $userinfo->row(0)->user_id;
    $response = file_get_contents('php://input');
    $json_obj = json_decode($response);
    if(isset($json_obj->billercode) and isset($json_obj->Amount) and isset($json_obj->custmobileno)  )
    {

      $billercode =  trim((string)$json_obj->billercode);
      $billnumber =  trim((string)$json_obj->billnumber);

      $Amount =  trim((string)$json_obj->Amount);
      $custmobileno =  trim((string)$json_obj->custmobileno);

      $billeraccount =  trim((string)$json_obj->billeraccount);
      $billercycle =  trim((string)$json_obj->billercycle);
      $duedate =  trim((string)$json_obj->duedate);

      $billdate =  trim((string)$json_obj->billdate);
      $consumername =  trim((string)$json_obj->consumername);
      $billnumbers =  trim((string)$json_obj->billnumbers);
      $tPin =  trim((string)$json_obj->tPin);
      $option1 = "";
      if($billercode == 119)
      {
        $option1 = $billeraccount;
      }


      $company_info = $this->db->query("select * from tblcompany where company_id = ?",array($billercode));
      if($company_info->num_rows() == 1)
      {
          $mcode = $company_info->row(0)->mcode;
          $remark = "BillPayment";
          $ref_id = 0;
          $particulars = false;
          $option2="";
          $option3="";
          $done_by = "WEB";
          $this->load->model("Mastermoney");
          $resp = $this->Mastermoney->recharge_transaction2($userinfo,$mcode,$billercode,$Amount,$billnumber,$custmobileno,$remark,$option1,$ref_id,$particulars,$option2,$option3,$done_by);
          echo $resp;exit;
          
      }
      
      
    }
      
  }

  public function SubCategories()
  {
     $data_array = array();
     header("Content-Type: application/json; charset=utf-8");
     $category_id = trim($this->input->get("category"));

      $rsltcompany = $this->db->query("
        select 
        company_id as Billerid,
        company_name as Billername,
        mcode as Billercode,
        mcode as BillercodeCCA, 
        'water-drop.svg' as Imageurl,
        'true' as Validateallow,
        true as Partialallow,
        service_id as CategoryId
        from tblcompany where service_id = ?",array($category_id));
      foreach($rsltcompany->result() as $rw)
      {
        $Validateallow = true;
        if($category_id == 3)
        {
          $Validateallow = true;
        }

        $temparray = array(
          "Billerid"=>$rw->Billerid,
          "Billername"=>$rw->Billername,
          "Billercode"=>$rw->Billercode,
          "BillercodeCCA"=>$rw->BillercodeCCA,
          "Imageurl"=>$rw->Imageurl,
          "Validateallow"=>$Validateallow,
          "Partialallow"=>false,
          "CategoryId"=>$rw->CategoryId,

        );
        array_push($data_array,$temparray);
      }
      
      $resp_array["ResponseStatus"] = "1";
      $resp_array["Status"] = "Success";
      $resp_array["Remarks"] = "Category List";
      $resp_array["ErrorCode"] = "";
      $resp_array["Data"] = $data_array;
      echo json_encode($resp_array);exit;

  }

  public function GetBillerparams()
  {
      header("Content-Type: application/json; charset=utf-8");
      if(isset($_GET["billerid"]))
      {
        $billerid = trim($this->input->get("billerid"));  
          $company_info = $this->db->query("select mobile_number_min_length,mobile_number_max_length,company_id,mcode,mobile_number_label,amount_label from tblcompany where company_id = ?",array($billerid));
          if($company_info->num_rows() == 1)
          {
              $mobile_number_min_length = intval($company_info->row(0)->mobile_number_min_length);
              $mobile_number_max_length = intval($company_info->row(0)->mobile_number_max_length);


              $resp_array["ResponseStatus"] = "1";
              $resp_array["Status"] = "Success";
              $resp_array["Remarks"] = "Biller Param Details";
              $resp_array["ErrorCode"] = "";


              $data_array = array();

              $temp_array = array(
                "Name"=>"CA Number",
                "MinLenght"=>$mobile_number_min_length,
                "MaxLength"=>$mobile_number_max_length,
                "FieldType"=>"NUMERIC",
                "Ismandatory"=>true,
                "Pattern"=>""
              );

              array_push($data_array,$temp_array);
              if($billerid  == 119)
              {
                $temp_array = array(
                "Name"=>"Sub Division Code",
                "MinLenght"=>0,
                "MaxLength"=>30,
                "FieldType"=>"NUMERIC",
                "Ismandatory"=>true,
                "Pattern"=>""
              );

              array_push($data_array,$temp_array);
              }



              $resp_array["Data"] = $data_array;
              echo json_encode($resp_array);exit;


              $resp = '{"ResponseStatus":"1","Status":"Success","Remarks":"Biller Param Details","ErrorCode":"","Data":[{"Name":"CA Number","MinLenght":'.$mobile_number_min_length.',"MaxLength":'.$mobile_number_max_length.',"FieldType":"NUMERIC","Ismandatory":true,"Pattern":""}]}';
              echo $resp;exit;
          }
      }
      
  }


	public function index()
	{	
		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
		
		 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('SdUserType');			
			if(trim($user) == 'MasterDealer')
			{
				if(isset($_POST["hidencrdata"]) and isset($_POST["txtNumber"]))
				{
					//9999999991
					//360880
					
					$hidencrdata = $this->Common_methods->decrypt($this->input->post("hidencrdata"));
				
					if($hidencrdata == $this->session->userdata("session_id"))
					{
						$txtNumber = trim($this->input->post("txtNumber",TRUE));
						$user_id = $this->session->userdata("SdId");
						
						
					//	$otherdb = $this->load->database('otherdb', TRUE);
						
						$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no from tblusers where user_id = ?",array($user_id));
						if($userinfo->num_rows() == 1)
						{
							$status = $userinfo->row(0)->status;
							$user_id = $userinfo->row(0)->user_id;
							$business_name = $userinfo->row(0)->businessname;
							$username = $userinfo->row(0)->username;
							$mobile_no = $userinfo->row(0)->mobile_no;
							$usertype_name = $userinfo->row(0)->usertype_name;
							if($status == '1')
							{
								if(ctype_digit($txtNumber))
								{
									
									    $rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
        							    if($rsltcommon->num_rows() == 1)
        							    {
        							        $is_service = $rsltcommon->row(0)->value;
        							    	if($is_service == "DOWN")
        							    	{
        							    	    $resp_arr = array(
                    								"message"=>"Service Temporarily Down",
                    								"status"=>1,
                    								"statuscode"=>"ERR",
                    								);
                        						$this->session->set_flashdata("MESSAGEBOXTYPE","FAILURE");
                        						$this->session->set_flashdata("MESSAGEBOX","Service Temporarily Down");
												$this->view_data["MESSAGEBOX"] = "Service Temporarily Down";
												redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
        							    	}
        							    }
									    
									    
									      
									        $this->load->model("Mastermoney");
    										$jsonresp =  $this->Mastermoney->remitter_details($txtNumber,$userinfo);
    									    $jsonobj = json_decode($jsonresp);
    									
    										if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
    										{
    											$message = trim((string)$jsonobj->message);
    											$status = trim((string)$jsonobj->status);
    											$statuscode = trim((string)$jsonobj->statuscode);
    										//	echo $statuscode;exit;
    											if($status == "1" and  ($statuscode == "RNF" or $statuscode == "323"))
    											{
    											    
    											    $this->session->set_flashdata("f_sendermobile",$txtNumber);
    												redirect(base_url()."Retailer/dmrmm_sender_registration?crypt1=".$this->Common_methods->encrypt($txtNumber)."&crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
    											}
    											else if($status == "0" and $statuscode == "TXN")
    											{
    													
    														$this->session->set_userdata("SenderMobile",$txtNumber);
    														$this->session->set_userdata("MT_USER_ID",$user_id);
    														$this->session->set_userdata("MT_LOGGED_IN",TRUE);
    														redirect(base_url()."Retailer/dmrmm_dashboard?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
    											}
    										}
									    
								}
								else
								{
									$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
									$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Internal Server Error. Please Try Later...");
									redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
								}
							}
							else
							{
								$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
								$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Your Account Deactivated By Admin");
								redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
							}
						
						}
						else
						{
							$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
							$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Session Expired. Please try Login Again");
							redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
						}
					}
					else
					{
							$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
							$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Request");
							redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
					}
				}	
				else
				{		
						$this->view_data['message'] ="";
						$this->load->view('SuperDealer_new/Bbps_view',$this->view_data);
				}
			} 
		}
	}
}	