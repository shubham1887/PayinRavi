<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BillFetchResponseSetting extends CI_Controller {
	
	
	
	private $msg='';
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
				$ddlapi = trim($this->input->post("ddlapi",TRUE));
				$txtCustomerNameStart = trim($this->input->post("txtCustomerNameStart",TRUE));
				$txtCustomerNameEnd = trim($this->input->post("txtCustomerNameEnd",TRUE));
				$txtBillAmountStart = trim($this->input->post("txtBillAmountStart",TRUE));
				$txtBillAmountEnd = trim($this->input->post("txtBillAmountEnd",TRUE));
				$txtDueDateStart = trim($this->input->post("txtDueDateStart",TRUE));
				$txtDueDateEnd = trim($this->input->post("txtDueDateEnd",TRUE));	
				
					$this->db->query("insert into bill_fetch_parsing
					(api_id,customerNameStart,customerNameEnd,BillAmountStart,BillAmountEnd,DueDateStart,DueDateEnd) 
					values(?,?,?,?,?,?,?)",
					array($ddlapi,$txtCustomerNameStart,$txtCustomerNameEnd,$txtBillAmountStart,$txtBillAmountEnd,$txtDueDateStart,$txtDueDateEnd));
				
				redirect(base_url()."_Admin/BillFetchResponseSetting?crypt=".$this->Common_methods->encrypt("MyData"));
						
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{		
				$Id = $this->input->post("hidID",TRUE);
				$ddlapi = trim($this->input->post("ddlapi",TRUE));
				$txtCustomerNameStart = trim($this->input->post("txtCustomerNameStart",TRUE));
				$txtCustomerNameEnd = trim($this->input->post("txtCustomerNameEnd",TRUE));
				$txtBillAmountStart = trim($this->input->post("txtBillAmountStart",TRUE));
				$txtBillAmountEnd = trim($this->input->post("txtBillAmountEnd",TRUE));
				$txtDueDateStart = trim($this->input->post("txtDueDateStart",TRUE));
				$txtDueDateEnd = trim($this->input->post("txtDueDateEnd",TRUE));
				
				
				$rslt = $this->db->query("select * from bill_fetch_parsing where Id = ?",array($Id));
				if($rslt->num_rows() == 1)
				{
					$this->db->query("update bill_fetch_parsing set 
					api_id = ?,customerNameStart = ?,customerNameEnd = ?,BillAmountStart = ?,
					BillAmountEnd = ?,DueDateStart = ?,DueDateEnd= ?
					where Id = ?",
					array($ddlapi,$txtCustomerNameStart,$txtCustomerNameEnd,$txtBillAmountStart,$txtBillAmountEnd,$txtDueDateStart,$txtDueDateEnd,$Id));
					
				}
				
				redirect(base_url()."_Admin/BillFetchResponseSetting?crypt=".$this->Common_methods->encrypt("MyData"));			
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$Id = $this->input->post("hidValue",TRUE);
				$action = $this->input->post("action",TRUE);
				if($action == "delete")			
				{
					$rslt = $this->db->query("select * from bill_fetch_parsing where Id = ?",array($Id));
					if($rslt->num_rows() == 1)
					{
						$this->db->query("delete from  bill_fetch_parsing  where Id = ?",array($Id));
						
					}
				}
				redirect(base_url()."_Admin/BillFetchResponseSetting?crypt=".$this->Common_methods->encrypt("MyData"));		
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{

					$this->view_data["message"] = "";
					$this->view_data["data"] = $this->db->query("
						select 
						b.api_name,
						a.Id,a.api_id,a.customerNameStart,a.customerNameEnd,
						a.BillAmountStart,a.BillAmountEnd,a.DueDateStart,
						a.DueDateEnd 
						from bill_fetch_parsing a 
						left join api_configuration b on a.api_id = b.Id 
						order by b.api_name");

					$this->load->view("_Admin/BillFetchResponseSetting_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}