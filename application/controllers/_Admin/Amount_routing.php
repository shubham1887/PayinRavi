<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Operator_settings extends CI_Controller {
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$this->load->model('Company_model');
		$this->view_data['result_company'] =  $this->Company_model->get_company();
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/operator_settings_view',$this->view_data);		
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
			if($this->input->post("btnSubmit") == "Submit")
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
					$companyName = $this->input->post("txtCompName",TRUE);
					$serviceName = $this->input->post("ddlSerName",TRUE);					
					$Long_Code_Format = $this->input->post("txtLong_Code_Format",TRUE);
					$Provider = $this->input->post("txtProvider",TRUE);
					$PProvider = $this->input->post("txtPProvider",TRUE);
					$productName = $this->input->post("txtProductName",TRUE);
					$CProvider = $this->input->post("txtCProvider",TRUE);
					$Long_Code_No = $this->input->post("txtLong_Code_No",TRUE);					
					$this->load->model('Company_model');					
					if($this->Company_model->add($companyName,$serviceName,$Provider,$PProvider,$CProvider,$Long_Code_Format,$Long_Code_No,$file_Logo,$productName) == true)
					{
						$this->msg ="Company Name Add Successfully.";
						$this->pageview();							
					}
					else
					{
						
					}					
			}
			else if($this->input->post("btnSubmit") == "Update")
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
					$companyID = $this->input->post("hidID",TRUE);
					$companyName = $this->input->post("txtCompName",TRUE);
					$serviceName = $this->input->post("ddlSerName",TRUE);
					$Provider = $this->input->post("txtProvider",TRUE);
					$PProvider = $this->input->post("txtPProvider",TRUE);
					$CProvider = $this->input->post("txtCProvider",TRUE);
					$productName = $this->input->post("txtProductName",TRUE);
					$Long_Code_Format = $this->input->post("txtLong_Code_Format",TRUE);
					$Long_Code_No = $this->input->post("txtLong_Code_No",TRUE);					
					$this->load->model('Company_model');
					if($this->Company_model->update($companyID,$companyName,$serviceName,$Provider,$PProvider,$CProvider,$Long_Code_Format,$Long_Code_No,$file_Logo,$productName) == true)
					{
						$this->msg ="Company Name Update Successfully.";
						$this->pageview();							
					}
					else
					{
						
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
				$str_query = "update tblcompany set api_id = (select api_id from tblapi where tblapi.api_name = '$api_name') where company_id = '$company_id'";
				$rslt = $this->db->query($str_query);
				$this->msg ="API Change Successfully.";
				$this->pageview();
				
			}
			else if($this->input->post("changeapi") == "change2")
			{
				$api_name = $this->input->post("api_name");
				$company_id = $this->input->post("company_id");
				$str_query = "update tblcompany set api_id2 = (select api_id from tblapi where tblapi.api_name = '$api_name') where company_id = '$company_id'";
				$rslt = $this->db->query($str_query);
				$this->msg ="API Change Successfully.";
				$this->pageview();
				
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$this->load->model('Company_model');
					$this->view_data['result_company'] =  $this->db->query("
					select 
						a.company_id,
						a.m2m_code,
						a.company_name,
						a.amounts,
						a.amounts_api,
						a.amounts_for_apiuser,
						a.amounts_for_apiuser_api,
						rapi.api_name as retailer_api_name,
						aapi.api_name as apiuser_api_name
						from tblcompany a
						left join tblapi rapi on a.amounts_api = rapi.api_id
						left join tblapi aapi on a.amounts_for_apiuser_api = aapi.api_id
						
					
					");
					$this->view_data['message'] =$this->msg;
					$this->load->view('_Admin/operator_settings_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																												
			}
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
		
		if($field == "retailer_txtAmounts")
		{
			$this->db->query("update tblcompany set amounts = ? where company_id = ?",array($val,$company_id));
		}
		if($field == "apiuser_txtAmounts")
		{
			$this->db->query("update tblcompany set amounts_for_apiuser = ? where company_id = ?",array($val,$company_id));
		}
		
		if($field == "AmountRange")
		{
			$this->db->query("update tblcompany set AmountRange = ? where company_id = ?",array($val,$company_id));
		}
		if($field == "amounts_api")
		{
			$this->db->query("update tblcompany set amounts_api = (select api_id from tblapi where api_name = ?) where company_id = ?",array($val,$company_id));
		}
		if($field == "amounts_for_apiuser_api")
		{
			$this->db->query("update tblcompany set amounts_for_apiuser_api = (select api_id from tblapi where api_name = ?) where company_id = ?",array($val,$company_id));
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
					if(isset($_POST["chk".$riw->company_id]))
					{
						$company_id =  $this->input->post("chk".$riw->company_id);
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
}