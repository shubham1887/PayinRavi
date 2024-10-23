<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aeps_commission_slab extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'adminlogin'); 
		}				
		else 		
		{
			//	print_r($this->input->post());exit;
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				//print_r($this->input->post());exit;
				$group_id = $this->Common_methods->decrypt($this->input->post("hidgroupid",TRUE));
				$AmountFrom = $this->input->post("txtAmountFrom",TRUE);
				$AmountTo = $this->input->post("txtAmountTo",TRUE);
				$commission_type = $this->input->post("ddldudtype",TRUE);				
				$Commission = $this->input->post("txtCommission",TRUE);	
				$MaxCommission = $this->input->post("txtMaxCommission",TRUE);	
				
				
				$checkgroup = $this->db->query("select * from  aeps_group where Id = ?",array($group_id));
				if($checkgroup->num_rows() == 1)
				{
					$rsltresult = $this->db->query("select * from aeps_slab where range_from = ? and range_to = ? and group_id = ?",array($AmountFrom,$AmountTo,$group_id ));
					if($rsltresult->num_rows() == 0)
					{
						$this->db->query("insert into aeps_slab(group_id,range_from,range_to,commission_type,commission,max_commission,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",
						array($group_id,$AmountFrom,$AmountTo,$commission_type,$Commission,$MaxCommission ,$this->common->getDate(),$this->common->getRealIpAddr()));
					}
					redirect(base_url()."_Admin/Aeps_group?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
				}
				
				
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{
				//print_r($this->input->post());exit;
			    
			    $slab_id = $this->input->post("hidSlabId",TRUE);
				


				$group_id = $this->Common_methods->decrypt($this->input->post("hidgroupid",TRUE));
				$AmountFrom = $this->input->post("txtAmountFrom",TRUE);
				$AmountTo = $this->input->post("txtAmountTo",TRUE);
				$commission_type = $this->input->post("ddldudtype",TRUE);				
				$Commission = $this->input->post("txtCommission",TRUE);	
				$MaxCommission = $this->input->post("txtMaxCommission",TRUE);	
				
				$checkgroup = $this->db->query("select * from  aeps_slab where Id = ?",array($slab_id));
				if($checkgroup->num_rows() == 1)
				{
				    $this->db->query("
				            update 
				                aeps_slab set range_from=?,range_to=?,commission_type=?,
				                commission=?,max_commission=? where Id = ?",
				                array($AmountFrom,$AmountTo,$commission_type,$Commission,$MaxCommission,
				                $slab_id
				                ));
					redirect(base_url()."_Admin/Aeps_group?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
				}
				
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{	
				$Id = $this->input->post("hidValue",TRUE);
				$this->db->query("delete from aeps_slab where Id = ?",array($Id));	
				redirect(base_url()."_Admin/Aeps_group?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
			}
			else
			{
				if(isset($_GET["crypt1"]) and isset($_GET["crypt2"]))
				{
					$user=$this->session->userdata('ausertype');
					if(trim($user) == 'Admin')
					{
						$this->view_data['result_slabs'] = $this->db->query("select a.*,b.Name from mt_commission_slabs a left join mt3_group b on a.group_id = b.Id where a.group_id = ? order by a.range_from",array($this->Common_methods->decrypt($this->input->get("crypt2"))));
						$this->view_data['message'] =$this->msg;
						$this->load->view('_Admin/Aeps_margin_slab_view',$this->view_data);		
					}
					else
					{redirect(base_url().'adminlogin');}																					
				}
				else
				{
					redirect(base_url()."_Admin/Aeps_margin_slabs_view?crypt=".$this->Common_methods->encrypt("MyData"));
				}
					
			}
		
		} 
	}
	private function Ledger_getReport($user_id,$from_date,$to_date)
	{
		$rslt = $this->db->query("select 
		a.user_id,a.Id,a.username,a.transaction_type,a.credit_amount,a.debit_amount,a.balance,a.add_date,a.remark,a.description,
		b.businessname as payment_to,
		c.businessname as payment_from
		from mt_ewallet a
		left join tblusers b on a.cr_user_id = b.user_id
		left join tblusers c on a.dr_user_id = c.user_id
		
		 where a.user_id = ? and Date(a.add_date) >= ? and Date(a.add_date) <= ?",array($user_id,$from_date,$to_date));
		return $rslt;
	}		
	
	
}