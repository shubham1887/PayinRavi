<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Company extends CI_Controller {
	
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
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        $this->load->model("Api_model");
    }
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		
		$this->view_data['result_company'] =  $this->db->query("
		
		        SELECT 
		            a.company_id,
		            a.company_name,
		            a.mcode,
		            a.minamt,
		            a.mxamt,
		            a.allowed_retry,
		            a.api_id
		           
                    FROM `tblcompany` a 
                    
				    order by a.service_id,a.company_name
		
		
		");
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/company_view',$this->view_data);		
	}
	
public function setmin()
{
	$company_id = $_GET["id"];
	$value = $_GET["val"];
	echo $company_id."  ".$value;
	$this->db->query("update tblcompany set minamt = ? where company_id = ? ",array($value,$company_id));
	echo $value;
}
public function setautomax_code()
{
	$company_id = $_GET["id"];
	$value = $_GET["val"];
	echo $company_id."  ".$value;
	$this->db->query("update tblcompany set automax_code = ? where company_id = ? ",array($value,$company_id));
	echo $value;
}
public function setautomax_code2()
{
	$company_id = $_GET["id"];
	$value = $_GET["val"];
	echo $company_id."  ".$value;
	$this->db->query("update tblcompany set automax_code2 = ? where company_id = ? ",array($value,$company_id));
	echo $value;
}
public function setmax()
{
	$company_id = $_GET["id"];
	$value = $_GET["val"];
	$this->db->query("update tblcompany set mxamt = ? where company_id = ?",array($value,$company_id));
	echo $value;
}
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
            

			$data['message']='';
			//print_r($this->input->post());exit;
			if($this->input->post("btnSubmit"))
			{ 
					if(!empty($_FILES['file_Logo']['name']))
					{
						$config['upload_path'] = realpath(APPPATH.'../images/Logo/');					
						$config['allowed_types'] = "jpg|jpeg|gif|png|bmp|JPG|JPEG|GIF|PNG|BMP";
						$this->load->library('upload', $config);					
						if(!$this->upload->do_upload('file_Logo'))
						{
							$this->msg ="Error : ".$this->upload->display_errors();
							$this->pageview();
						}
						else
						{
							$myFileData = $this->upload->data();
							$file_Logo = $myFileData["file_name"];
						}
					}				
					else
					{
						$file_Logo = $this->input->post("hidOldPath",TRUE);
					}
					
					$add_date = $edit_date = $this->common->getDate();
					$ipaddress = $this->common->getRealIpAddr();
					$amounts=$amounts_api=$amounts_for_apiuser=$amounts_for_apiuser_api="";
					$AmountRange = $RANGE_API = $isqueue=$sortname = "";
					
					
					$company_name = substr(trim($this->input->post("txtOperatorName")),0,60);
				
					
					$checkoperator_exist = $this->db->query("select company_id from tblcompany where company_name = ?",array($company_name));
					if($checkoperator_exist->num_rows()  >= 1)
					{
					    $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Operator Already Exist. Try Different Name");
                		redirect(base_url()."_Admin/company");
					}
					
					
					
					$mcode = $smscode = substr($this->input->post("txtMcode"),0,60);
					$checkoperatormcode_exist = $this->db->query("select company_id from tblcompany where mcode = ?",array($mcode));
					if($checkoperatormcode_exist->num_rows()  >= 1)
					{
					    $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Operator Already Exist. Try Different Name");
                		redirect(base_url()."_Admin/company");
					}
					
					
                    $is_enabled = $this->input->post("chkis_enabled");
				    if($is_enabled == 'on')
                    {
                        $is_enabled = "yes";
                    }
                    else
                    {
                        $is_enabled = "no";
                    }
                    
                    
                    
                    $is_visible = $this->input->post("chkis_visible");
                    
                    if($is_visible == 'on')
                    {
                        $is_visible = "yes";
                    }
                    else
                    {
                        $is_visible = "no";
                    }
                    
                    $service_id = intval($this->input->post("ddlservice"));
                    $display_order = intval($this->input->post("txtDisplayOrder"));
                    $bill_fetch_enabled = $this->input->post("chkenableFetchBill");
                    if($bill_fetch_enabled == 'on')
                    {
                        $bill_fetch_enabled = "yes";
                    }
                    else
                    {
                        $bill_fetch_enabled = "no";
                    }
                    
                    
                    $is_bbps = $this->input->post("chkis_bbps");
                    if($is_bbps == 'on')
                    {
                        $is_bbps = "yes";
                    }
                    else
                    {
                        $is_bbps = "no";
                    }
                    
                    $api_id = intval($this->input->post("ddlapi1"));
                    $api2_id = intval($this->input->post("ddlapi2"));
                    $validation_api = $this->input->post("ddlvalidationapi");
                    $mobile_number_label = substr($this->input->post("txtMobileNunberlabelTExt"),0,40);
                    $mobile_number_min_length = intval($this->input->post("txtMobileNunberMinLength"));
                    $mobile_number_max_length = intval($this->input->post("txtMobileNunberMaxLength"));
                    $mobile_number_start_width = substr($this->input->post("txtMobileNunberStartWith"),0,10);
                    $mobile_number_end_width = substr($this->input->post("txtMobileNunberEndWith"),0,10);
                    $amount_label = substr($this->input->post("txtAmountLabelText"),0,20);
                    $is_fiexd_amount = $this->input->post("chkis_fixedAmount");
                    if($is_fiexd_amount == 'on')
                    {
                        $is_fiexd_amount = "yes";
                    }
                    else
                    {
                        $is_fiexd_amount = "no";
                    }
                    
                    
                    $fixedAmountvalues = $this->input->post("txtFixedAmountValues");
                    $minamt = intval($this->input->post("txtMinAmount"));
                    $mxamt = $this->input->post("txtMaxAmount");
                    $amount_type = $this->input->post("ddlamt_type");
                    $amount_dropdown_contents = $this->input->post("txtAmtDropdownContent");
                    $blocked_amounts = $this->input->post("txtblocked_amounts");
                    
                    $insert_rslt = $this->db->query("
                    insert into tblcompany
                    (
                        company_name, mcode, smscode, api_id, api2_id, service_id, 
                        add_date, edit_date, ipaddress, amounts, amounts_api, amounts_for_apiuser, 
                        amounts_for_apiuser_api, minamt, mxamt, AmountRange, RANGE_API, isqueue, 
                        sortname, is_visible, is_enabled, display_order, bill_fetch_enabled, is_bbps, 
                        validation_api, mobile_number_label, amount_label, mobile_number_start_width, 
                        mobile_number_end_width, is_fiexd_amount, fixedAmountvalues, amount_type, 
                        amount_dropdown_contents,mobile_number_min_length,mobile_number_max_length,blocked_amounts
                    ) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    array($company_name,$mcode,$smscode,$api_id,$api2_id,$service_id,
                    $add_date,$edit_date,$ipaddress,$amounts,$amounts_api,$amounts_for_apiuser,
                    $amounts_for_apiuser_api,$minamt,$mxamt,$AmountRange,$RANGE_API,$isqueue,
                    $sortname,$is_visible,$is_enabled,$display_order,$bill_fetch_enabled,$is_bbps,
                    $validation_api,$mobile_number_label,$amount_label,$mobile_number_start_width,
                    $mobile_number_end_width,$is_fiexd_amount,$fixedAmountvalues,$amount_type,
                    $amount_dropdown_contents,$mobile_number_min_length,$mobile_number_max_length,$blocked_amounts));
					
					
				if($insert_rslt == true)
				{
				    	$MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
                		$MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Operator Added Successfully");
                		redirect(base_url()."_Admin/company");
				}
				else
				{
				    	$MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Some Error Occured. Please Try Again");
                		redirect(base_url()."_Admin/company");
				}
					
					
							
			}
			else if($this->input->post("btnUPdate") == "Update")
			{					
					if(!empty($_FILES['file_Logo']['name']))
					{
						$config['upload_path'] = realpath(APPPATH.'../images/Logo/');					
						$config['allowed_types'] = "jpg|jpeg|gif|png|bmp|JPG|JPEG|GIF|PNG|BMP";
						$this->load->library('upload', $config);					
						if(!$this->upload->do_upload('file_Logo'))
						{
							$this->msg ="Error : ".$this->upload->display_errors();
							$this->pageview();
						}
						else
						{
							$myFileData = $this->upload->data();
							$file_Logo = $myFileData["file_name"];
						}
					}				
					else
					{
						$file_Logo = $this->input->post("hidOldPath",TRUE);
					}
					
					
					//echo $this->input->post("hidcompany_id");exit;
					
					$company_id = intval($this->Common_methods->decrypt(trim($this->input->post("hidcompany_id"))));
					$checkoperator_exist = $this->db->query("select company_id from tblcompany where company_id = ?",array($company_id));
					if($checkoperator_exist->num_rows()  == 1)
					{
					    $edit_date = $this->common->getDate();
    					$amounts=$amounts_api=$amounts_for_apiuser=$amounts_for_apiuser_api="";
    					$AmountRange = $RANGE_API = $isqueue=$sortname = "";
    					$company_name = substr(trim($this->input->post("txtOperatorName")),0,60);
    				    $mcode = $smscode = substr($this->input->post("txtMcode"),0,60);
    					$checkoperatormcode_exist = $this->db->query("select company_id from tblcompany where mcode = ? and company_id != ?",array($mcode,$company_id));
    					if($checkoperatormcode_exist->num_rows()  == 0)
    					{
    					    $is_enabled = $this->input->post("chkis_enabled");
    					    if($is_enabled == 'on')
                            {
                                $is_enabled = "yes";
                            }
                            else
                            {
                                $is_enabled = "no";
                            }
                            
                            
                            
                            $is_visible = $this->input->post("chkis_visible");
                            
                            if($is_visible == 'on')
                            {
                                $is_visible = "yes";
                            }
                            else
                            {
                                $is_visible = "no";
                            }
                            
                            $service_id = intval($this->input->post("ddlservice"));
                            $display_order = intval($this->input->post("txtDisplayOrder"));
                            $bill_fetch_enabled = $this->input->post("chkenableFetchBill");
                            if($bill_fetch_enabled == 'on')
                            {
                                $bill_fetch_enabled = "yes";
                            }
                            else
                            {
                                $bill_fetch_enabled = "no";
                            }
                            
                            
                            $is_bbps = $this->input->post("chkis_bbps");
                            if($is_bbps == 'on')
                            {
                                $is_bbps = "yes";
                            }
                            else
                            {
                                $is_bbps = "no";
                            }
                            
                            $api_id = intval($this->input->post("ddlapi1"));
                            $api2_id = intval($this->input->post("ddlapi2"));
                            $validation_api = $this->input->post("ddlvalidationapi");
                            $mobile_number_label = substr($this->input->post("txtMobileNunberlabelTExt"),0,40);
                            $mobile_number_min_length = intval($this->input->post("txtMobileNunberMinLength"));
                            $mobile_number_max_length = intval($this->input->post("txtMobileNunberMaxLength"));
                            $mobile_number_start_width = substr($this->input->post("txtMobileNunberStartWith"),0,10);
                            $mobile_number_end_width = substr($this->input->post("txtMobileNunberEndWith"),0,10);
                            $amount_label = substr($this->input->post("txtAmountLabelText"),0,20);
                            $is_fiexd_amount = $this->input->post("chkis_fixedAmount");
                            if($is_fiexd_amount == 'on')
                            {
                                $is_fiexd_amount = "yes";
                            }
                            else
                            {
                                $is_fiexd_amount = "no";
                            }
                            
                            
                            $fixedAmountvalues = $this->input->post("txtFixedAmountValues");
                            $minamt = intval($this->input->post("txtMinAmount"));
                            $mxamt = $this->input->post("txtMaxAmount");
                            $amount_type = $this->input->post("ddlamt_type");
                            $amount_dropdown_contents = $this->input->post("txtAmtDropdownContent");
                            $blocked_amounts = $this->input->post("txtblocked_amounts");
                            
                            $insert_rslt = $this->db->query("
                            update tblcompany
                            set
                                company_name = ?, mcode = ?, smscode = ?, api_id = ?, api2_id = ?, service_id = ?, 
                                 edit_date = ?, amounts = ?, amounts_api = ?, amounts_for_apiuser = ?, 
                                amounts_for_apiuser_api = ?, minamt = ?, mxamt = ?, AmountRange = ?, RANGE_API = ?, isqueue = ?, 
                                sortname = ?, is_visible = ?, is_enabled = ?, display_order = ?, bill_fetch_enabled = ?, is_bbps = ?, 
                                validation_api = ?, mobile_number_label = ?, amount_label = ?, mobile_number_start_width = ?, 
                                mobile_number_end_width = ?, is_fiexd_amount = ?, fixedAmountvalues = ?, amount_type = ?, 
                                amount_dropdown_contents = ?,mobile_number_min_length = ?,mobile_number_max_length = ?,blocked_amounts = ?
                                where company_id = ?",
                            array($company_name,$mcode,$smscode,$api_id,$api2_id,$service_id,
                            $edit_date,$amounts,$amounts_api,$amounts_for_apiuser,
                            $amounts_for_apiuser_api,$minamt,$mxamt,$AmountRange,$RANGE_API,$isqueue,
                            $sortname,$is_visible,$is_enabled,$display_order,$bill_fetch_enabled,$is_bbps,
                            $validation_api,$mobile_number_label,$amount_label,$mobile_number_start_width,
                            $mobile_number_end_width,$is_fiexd_amount,$fixedAmountvalues,$amount_type,
                            $amount_dropdown_contents,$mobile_number_min_length,$mobile_number_max_length,$blocked_amounts,$company_id));
                            if($insert_rslt == true)
            				{
            				    	$MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
                            		$MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Operator Updated Successfully");
                            		redirect(base_url()."_Admin/company");
            				}
            				else
            				{
            				    	$MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                            		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Some Error Occured. Please Try Again");
                            		redirect(base_url()."_Admin/company");
            				}
                            
    					}
    					else
    					{
    					    $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                    		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Dupicate Mobile App Code Found. Please Try Different");
                    		redirect(base_url()."_Admin/company");
    					}   
					}
					else
					{
					    $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Operation Performed");
                		redirect(base_url()."_Admin/company");
					}
					
					
					
																
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{
				
				$companyID = $this->input->post("hidValue",TRUE);
				$this->load->model('Company_model');
				if($this->Company_model->delete($companyID) == true)
				{
							$this->msg ="Company Name Delete Successfully.";
							$this->pageview();							
				}
				else
				{
					
				}				
			}	
			else if($this->input->post("changeapi") == "change")
			{
				
				$api_name = $this->input->post("api_name");
				$company_id = $this->input->post("company_id");
				$str_query = "update tblcompany set api_id = ? where company_id = ?";
				$rslt = $this->db->query($str_query,array($api_name,$company_id));
				
				
				
				
				
				$this->msg ="API Change Successfully.";
				$this->pageview();
				
			}
			else if($this->input->post("changeapi") == "change2")
			{
			
				$api_name = $this->input->post("api_name");
				$company_id = $this->input->post("company_id");
				$str_query = "update tblcompany set api2_id = ? where company_id = ?";
				$rslt = $this->db->query($str_query,array($api_name,$company_id));
				$this->msg ="API Change Successfully.";
				$this->pageview();
				
			}
		
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																												
			}
		} 
	}	
	
    public function editoperator()
    {
        if(isset($_GET["id"]) and isset($_GET["hidaction"]))
        {
            $company_id = $this->Common_methods->decrypt($this->input->get("id"));
            $company_info = $this->db->query("select * from tblcompany where company_id = ?",array($company_id));
            if($company_info->num_rows() == 1)
            {
                //print_r($company_info->result());exit;
                $this->view_data["company_info"] = $company_info;
                $this->load->view("_Admin/company_edit_view",$this->view_data);
            }
            else
            {
                $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
        		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Operation Performed");
        		redirect(base_url()."_Admin/company");
            }
        }
        else
        {
            $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
    		$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Operation Performed");
    		redirect(base_url()."_Admin/company");
        }
    }
	
	
	public function setvalues()
	{
		if($this->session->userdata('ausertype') != 'Admin')
		{
			redirect(base_url().'login');
		}
		$company_id = $this->input->get("Id");
		$field = $this->input->get("field");
		$val = $this->input->get("val");
		
		if($field == "txtAmounts")
		{
			$this->db->query("update tblcompany set amounts = ? where company_id = ?",array($val,$company_id));
		}
		if($field == "AmountRange")
		{
			$this->db->query("update tblcompany set AmountRange = ? where company_id = ?",array($val,$company_id));
		}
		if($field == "RANGE_API")
		{
			$this->db->query("update tblcompany set RANGE_API = (select api_id from tblapi where api_name = ?) where company_id = ?",array($val,$company_id));
		}
		
	}	
	public function changeapiall()
	{
	
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		if(isset($_POST["hidactionallstatus"]) and isset($_POST["hidactiontype"]))
		{
			$hidactionallstatus = trim($this->input->post("hidactionallstatus"));
			$apiinfo = $this->db->query("select * from tblapi where api_name = ?",array($hidactionallstatus));
			if($apiinfo->num_rows() == 1)
			{
				$hidactiontype = trim($this->input->post("hidactiontype"));
				
					$rsltcompany_info = $this->db->query("select company_id,company_name from tblcompany");
					foreach($rsltcompany_info->result() as $riw)
					{
						if(isset($_POST["md_checkbox_".$riw->company_id]))
						{
							$company_id =  $this->input->post("md_checkbox_".$riw->company_id);
							$this->db->query("update tblcompany set api_id = ? where company_id = ?",array($apiinfo->row(0)->api_id,$company_id));
						}
					}
				
				
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","API CHANGED SUCCESSFULLY");
				redirect(base_url()."_Admin/company?idstr=".$this->Common_methods->encrypt("ravikant"));
			}
			else
			{
				redirect(base_url()."_Admin/company?idstr=".$this->Common_methods->encrypt("ravikant"));	
			}
			
			
		}
	}
	
	public function ajaxupdate()
	{
	    //data:{ "company_id":id , "api_id" :api_id,"api2_id":api2_id,"plimit":plimit,"minamt":minamt,"maxamt":maxamt} ,
	    if(isset($_POST["company_id"]) and isset($_POST["api_id"])  and isset($_POST["rerootlimit"]) and isset($_POST["minamt"])  and isset($_POST["maxamt"]))
	    {
	        $company_id = intval(trim($_POST["company_id"]));
	        $api_id = intval(trim($_POST["api_id"]));
	        $rerootlimit = trim($_POST["rerootlimit"]);
	        $minamt = trim($_POST["minamt"]);
	        $maxamt = trim($_POST["maxamt"]);
	        
	        $this->db->query("update tblcompany set minamt = ?,mxamt = ?,allowed_retry = ?,api_id = ? where company_id = ?",array($minamt,$maxamt,$rerootlimit,$api_id,$company_id));
	        echo "OK";exit;
	        
	    }
	    else
	    {
	        echo "ERROR";exit;
	    }
	}
	
	
	
}