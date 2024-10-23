<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mt_commission_slab extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'adminlogin'); 
		}				
		else 		
		{
		
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				$group_id = $this->Common_methods->decrypt($this->input->post("hidgroupid",TRUE));
				$txtAmountFrom = $this->input->post("txtAmountFrom",TRUE);
				$txtAmountTo = $this->input->post("txtAmountTo",TRUE);
				$txnCharge = $this->input->post("txnCharge",TRUE);				
				$ddldudtype = $this->input->post("ddldudtype",TRUE);	
				$txtccf = $this->input->post("txtccf",TRUE);	
				$txtcashback= $this->input->post("txtcashback",TRUE);	
				$txttds = $this->input->post("txttds",TRUE);	
				
				$checkgroup = $this->db->query("select * from  mt3_group where Id = ?",array($group_id));
				if($checkgroup->num_rows() == 1)
				{
					$rsltresult = $this->db->query("select * from mt_commission_slabs where range_from = ? and range_to = ? and group_id = ?",array($txtAmountFrom,$txtAmountTo,$group_id ));
					if($rsltresult->num_rows() == 0)
					{
						$this->db->query("insert into mt_commission_slabs(group_id,range_from,range_to,charge_amount,add_date,ipaddress,charge_type,ccf,cashback,tds) values(?,?,?,?,?,?,?,?,?,?)",
						array($group_id,$txtAmountFrom,$txtAmountTo,$txnCharge ,$this->common->getDate(),$this->common->getRealIpAddr(),$ddldudtype,$txtccf,$txtcashback,$txttds));
					}
					redirect(base_url()."_Admin/mt_commission_slab?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
				}
				
				
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{
			    
			    $slab_id = $this->input->post("hidSlabId",TRUE);
				$txtAmountFrom = $this->input->post("txtAmountFrom",TRUE);
				$txtAmountTo = $this->input->post("txtAmountTo",TRUE);
				$txnCharge = $this->input->post("txnCharge",TRUE);				
				$ddldudtype = $this->input->post("ddldudtype",TRUE);
				$txtccf = $this->input->post("txtccf",TRUE);
				$ddlccftype = $this->input->post("ddlccftype",TRUE);
				$txttds = $this->input->post("txttds",TRUE);
				$ddltdstype = $this->input->post("ddltdstype",TRUE);
				$txtcashback = $this->input->post("txtcashback",TRUE);
				$ddlcashbacktype = $this->input->post("ddlcashbacktype",TRUE);
				
				$checkgroup = $this->db->query("select * from  mt_commission_slabs where Id = ?",array($slab_id));
				if($checkgroup->num_rows() == 1)
				{
				    $this->db->query("
				            update 
				                mt_commission_slabs set range_from=?,range_to=?,charge_type=?,
				                charge_amount=?,edit_date=?,ccf=?,cashback=?,tds=?,ccf_type=?,
				                cashback_type=?,tds_type=? where Id = ?",
				                array($txtAmountFrom,$txtAmountTo,$ddldudtype,$txnCharge,$this->common->getDate(),
				                $txtccf,$txtcashback ,$txttds,
				                $ddlccftype,$ddlcashbacktype,$ddltdstype,
				                $slab_id
				                ));
					redirect(base_url()."_Admin/mt_commission_slab?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
				}
				
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{	
				$Id = $this->input->post("hidValue",TRUE);
				$this->db->query("delete from mt_commission_slabs where Id = ?",array($Id));	
				redirect(base_url()."_Admin/mt_commission_slab?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
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
						$this->load->view('_Admin/mt_margin_slabs_view',$this->view_data);		
					}
					else
					{redirect(base_url().'adminlogin');}																					
				}
				else
				{
					redirect(base_url()."_Admin/dmr_margin_slab?crypt=".$this->Common_methods->encrypt("MyData"));
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