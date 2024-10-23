<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set_commission extends CI_Controller {
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {

        if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
    }
	private function getCommissionInfo($company_id,$user_id,$scheme_id)
	{
		$str_query = "select * from  tbluser_commission where company_id = ? and user_id = ?";
		$rslt = $this->db->query($str_query,array($company_id,$user_id));
		if($rslt->num_rows() == 1)
		{
			if($rslt->row(0)->commission > 0 )
			{
				$resparr = array(
					"Commission_Type"=>$rslt->row(0)->commission_type,
					"Commission_Per"=>$rslt->row(0)->commission,
					"TYPE"=>"ENTITY",
					);
					return $resparr;	
			}
			else
			{
				$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
				$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
				if($rslt->num_rows() == 1)
				{
					$resparr = array(
							"Commission_Type"=>$rslt->row(0)->commission_type,
							"Commission_Per"=>$rslt->row(0)->commission,
							"TYPE"=>"GROUP",
							);
					return $resparr;

				}
				else
				{
					$resparr = array(
							"Commission_Type"=>"PER",
							"Commission_Per"=>0.00,
							"TYPE"=>"GROUP",
							);
							return $resparr;
				}
			}
		}
		else
		{
			$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
			$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
			if($rslt->num_rows() == 1)
			{
				$resparr = array(
						"Commission_Type"=>$rslt->row(0)->commission_type,
						"Commission_Per"=>$rslt->row(0)->commission,
						"TYPE"=>"GROUP",
						);
				return $resparr;

			}
			else
			{
				$resparr = array(
						"Commission_Type"=>"PER",
						"Commission_Per"=>0.00,
						"TYPE"=>"GROUP",
						);
						return $resparr;
			}
		}






	}	
	private function getCommissionRange($company_id,$user_id,$scheme_id)
	{	
		
		$str_query = "select * from  tbluser_commission where company_id = ? and user_id = ?";
		$rslt = $this->db->query($str_query,array($company_id,$user_id));
		if($rslt->num_rows() == 1)
		{
			if($rslt->row(0)->min_com_limit > 0 or $rslt->row(0)->max_com_limit > 0 )
			{
				$resparr = array(
					"min_com_limit"=>$rslt->row(0)->min_com_limit,
					"max_com_limit"=>$rslt->row(0)->max_com_limit,
					);
					return $resparr;	
			}
			else
			{
				$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
				$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
				if($rslt->num_rows() == 1)
				{
					$resparr = array(
							"min_com_limit"=>$rslt->row(0)->min_com_limit,
							"max_com_limit"=>$rslt->row(0)->max_com_limit,
							);
					return $resparr;

				}
				else
				{
					$resparr = array(
							"min_com_limit"=>"0",
							"max_com_limit"=>"0",
							);
					return $resparr;
				}
			}
		}
		else
		{
			$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
			$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
			if($rslt->num_rows() == 1)
			{
				$resparr = array(
						"min_com_limit"=>$rslt->row(0)->min_com_limit,
						"max_com_limit"=>$rslt->row(0)->max_com_limit,
						);
				return $resparr;

			}
			else
			{
				$resparr = array(
							"min_com_limit"=>"0",
							"max_com_limit"=>"0",
							);
				return $resparr;
			}
		}	
	}	
	function getCommission()
	{
			$str = '';
			$company_id = $_GET["company_id"];
			$company_info = $this->db->query("select company_name,company_id from tblcompany where company_id = ?",array($company_id));
			if($company_info->num_rows() == 1)
			{
				
				
				
				$dist_commissioninfo = $this->Insert_model->getCommissionInfo($company_id,$this->session->userdata("MdId"),$this->session->userdata("MdSchemeId"));
				
				
				
				$userinfo = $this->db->query("
					select 
						a.user_id,
						a.businessname,
						a.username,
						a.parentid,
						a.fos_id,
						a.scheme_id,
						
						b.businessname as fos_name,
						b.username as fos_username,
						b.scheme_id as fos_scheme_id,
						p.businessname as dist_name,
						p.username as dist_username,
						p.scheme_id as dist_scheme_id
						
						from tblusers a
						left join tblusers b on a.fos_id = b.user_id
						left join tblusers p on a.parentid = p.user_id
						
						where a.parentid = ? and a.usertype_name = 'Distributor'
				",array($this->session->userdata("MdId")));
				
				
				$str .='<input type="hidden" id="uid" name="uid" value="'.$company_id.'">
					<table class="table table-striped table-bordered table-hover" >

					<tr>  
					<th>SB</th>
					<th>My Comm</th>
					<th>Comm Left</th>
					<th>Distributor</th>
					<th>Distributor Range</th>
					<th>Distributor Comm</th>
					<th>Action</th>
					</tr>';
				$i = 1;
				foreach($userinfo->result() as $rwuser)
				{
					
					
					$fos_commissioninfo = $this->Insert_model->getCommissionInfo($company_id,$rwuser->fos_id,$rwuser->fos_scheme_id);
					$fos_commissionrange = $this->Insert_model->getCommissionRange($company_id,$rwuser->fos_id,$rwuser->fos_scheme_id);
					
					$agent_commissioninfo = $this->Insert_model->getCommissionInfo($company_id,$rwuser->user_id,$rwuser->scheme_id);
					$agent_commissionrange = $this->Insert_model->getCommissionRange($company_id,$rwuser->user_id,$rwuser->scheme_id);
					
					$commission_left = $dist_commissioninfo["Commission_Per"] - $agent_commissioninfo["Commission_Per"];
					
					$str .='<tr>';
						$str .='<td>'.$i.'</td>';
						$str .='<td>'.$dist_commissioninfo["Commission_Per"].'</td>';
						$str .='<td>'.$commission_left.'</td>';
						$str .='<td>'.$rwuser->businessname.'</td>';
						$str .='<td>'.$agent_commissionrange["min_com_limit"].' - '.$agent_commissionrange["max_com_limit"].'</td>';
					
						$str .='<td>
						<input type="text" class="form-control"  id="txtAgentComm'.$rwuser->user_id.'" value="'.$agent_commissioninfo["Commission_Per"].'"></td>';
						$str .='<td>
						<input type="button" class="btn btn-success btn-mini" id="btnsubmit'.$rwuser->user_id.'" value="Save" onClick="changecommission('.$rwuser->user_id.')"></td>';
						
					$str .='</tr>';
					
					$i++;
				}
				$str .= '</table>';
				echo $str;exit;
				
			}
		
	}
	
	
	
	function ChangeCommission()
	{
		$company_id = $_GET["company_id"];
		$com = floatval(trim($_GET["com"]));
		$user_id = trim($_GET["user_id"]);
		
		
		$userinfo = $this->db->query("select * from tblusers where user_id = ? and parentid = ?",array($user_id,$this->session->userdata("MdId")));
		if($userinfo->num_rows() == 1)
		{
			
				if($userinfo->row(0)->usertype_name == "Distributor")
				{
					$parentinfo = $this->db->query("select * from tblusers where user_id = ?",array($userinfo->row(0)->parentid));
					$this->load->model("Do_recharge_model");
					$parent_commission_info = $this->Do_recharge_model->getCommissionInfo($company_id,$parentinfo,0);
					$parent_commission_type =$parent_commission_info["Commission_Type"];
					$parent_commission_per =$parent_commission_info["Commission_Per"];

					$commission_range = $this->Do_recharge_model->getCommissionRange($company_id,$userinfo);
					$min_com_limit =$commission_range["min_com_limit"];
					$max_com_limit =$commission_range["max_com_limit"];
					
					
					if($com <= $parent_commission_per)
					{
						if($com <= $max_com_limit and $com >= $min_com_limit)
						{
							$comtype = $parent_commission_type;
							$check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($user_id, $company_id));
							if($check_rslt->num_rows()  >= 1)
							{
								$rslt = $this->db->query("update tbluser_commission set commission = ?,commission_type = ? where Id = ?",array($com,$comtype,$check_rslt->row(0)->Id));
								echo "OK";
							}
							else
							{
								$add_date = $this->common->getDate();
								$str_qry = "insert into tbluser_commission(user_id,company_id,commission,commission_type,min_com_limit,max_com_limit,add_date) values(?,?,?,?,?,?,?)";
								$rslt_in = $this->db->query($str_qry,array($user_id,$company_id,$com,$comtype,0,0,$add_date));
								echo "OK";
							}

							
						}
						else
						{
							echo "Commission Not In Range";exit;
						}

					}
					else
					{
						echo "Commission Should Not Greater Than Parent Commission";exit;
					}
				}
			
		}
		
	}
	
	
	
	
	
	
	
	
	
	public function index() 
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 

		$data['message']='';				
		if($this->input->post("hidflag") == "Set")
		{
			$com_id = $this->input->post("hidid",TRUE);
			$com_per = $this->input->post("hidcom",TRUE);

		}
		else if($this->input->post("btnSubmit") == "Update")
		{				
			$commissionID = $this->input->post("hidID",TRUE);
			$Company_id = $this->input->post("ddlCompanyName",TRUE);
			//$Proirity = $this->input->post("ddlPriority",TRUE);
			$Proirity =1;
			$RCommission = $this->input->post("txtRoyalComm",TRUE);	
			$PCommission = $this->input->post("txtPayworldComm",TRUE);	
			$CCommission = $this->input->post("txtCyberComm",TRUE);				
			$Scheme = $this->input->post("ddlScheme",TRUE);								
			$this->load->model('Commission_model');				
			if($this->Commission_model->update($commissionID,$Company_id,$Proirity,$RCommission,$PCommission,$CCommission,$Scheme) == true)
			{
				$this->msg ="Commission Update Successfully.";
				$this->pageview();
			}
			else
			{

			}
		}
		else if( $this->input->post("hidValue") && $this->input->post("action") ) 
		{

			$commissionID = $this->input->post("hidValue",TRUE);
			$this->load->model('Commission_model');
			if($this->Commission_model->delete($commissionID) == true)
			{
				$this->msg ="Commission Delete Successfully.";
				$this->pageview();
			}
			else
			{

			}				
		}
		else
		{
			$data=array("message"=>"",);
			$this->load->view("MasterDealer/set_commission_view",$data);																				
		}

	}	
}