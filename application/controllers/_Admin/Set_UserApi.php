<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set_UserApi extends CI_Controller {
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {

       if($this->session->userdata('aloggedin') != TRUE) 
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
	function getCommission()
	{
			if($this->session->userdata("ausertype") != "Admin")
			{
				"UN Authorized Access";exit;
			}
			$id = $_GET["id"];
			$userinfo = $this->Userinfo_methods->getUserInfo($id);
			$usertype = $userinfo->row(0)->usertype_name;


        $apidropdown = '';
        $apiinfo = $this->db->query("select api_id,api_name from tblapi order by api_name");
        foreach($apiinfo->result() as $apirw)
        {
            $apidropdown .= '<option value="'.$apirw->api_id.'">'.$apirw->api_name.'</option>';    
        }


		$str_query = "select * from tblcompany";
		$adm_com_rslt = $this->db->query($str_query);
	$str='<div><h2>Api Setting For '.$userinfo->row(0)->businessname.' ['.$usertype.']</h2></div>';
		$str .='<input type="hidden" id="uid" name="uid" value="'.$id.'">
		<table class="table table-striped table-bordered table-hover" >

		<tr>  
		<th >Sr No.</th>
		<th >Network</th>

		<th style="display:none">Client Commission</th>
		<th  style="display:none">Min Commission</th>
		<th  style="display:none">Max Commission</th>
		<th  style="display:none">Commission Type</th>
		<th  style="display:none">Change Commission Type</th>
		<th>API</th>
		<th>Action</th>
		</tr>
		';
		$i=1;
		foreach($adm_com_rslt->result() as $row)
		{
			
		$agent_commissioninfo = $this->Insert_model->getCommissionInfo($row->company_id,$userinfo->row(0)->user_id,$userinfo->row(0)->scheme_id);
		$agent_commissionrange = $this->Insert_model->getCommissionRange($row->company_id,$userinfo->row(0)->user_id,$userinfo->row(0)->scheme_id);
		
			
		$rslt  = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($id,$row->company_id));

			$str .='<tr class="row2">';

			$str.='

			<td>'.$i.'</td>
			<td >'.$row->company_name.'</td>';


			if($rslt->num_rows() > 0)
			{
				$str.='<td  style="display:none">';
				$str.= '<input type="text" width="30" id="txtComm'.$row->company_id.'"  class="form-control" style="width:150px;" name="txtComm'.$row->company_id.'" value="'.$rslt->row(0)->commission.'"/>';
				$str.='</td>';
				$str.='<td  style="display:none">';
				$str.= '<input readonly type="text" width="30" id="txtMinComm'.$row->company_id.'"  class="form-control" style="width:150px;" name="txtMinComm'.$row->company_id.'" value="'.$agent_commissionrange["min_com_limit"].'"/>';
				$str.='</td>';
				$str.='<td  style="display:none">';
				$str.= '<input readonly type="text" width="30" id="txtMaxComm'.$row->company_id.'"  class="form-control" style="width:150px;" name="txtMaxComm'.$row->company_id.'" value="'.$agent_commissionrange["max_com_limit"].'"/>';
				$str.='</td>';
				$str.='<td  style="display:none">'.$rslt->row(0)->commission_type.'</td>';
			}
			else
			{
				$str.='<td  style="display:none">';
				$str.= '<input type="text" width="30"  class="form-control" style="width:150px;" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value=""/>';
				$str.='</td>';
				$str.='<td  style="display:none">';
				$str.= '<input type="text" width="30"  class="form-control" style="width:150px;" id="txtMinComm'.$row->company_id.'" name="txtMinComm'.$row->company_id.'" value="'.$agent_commissionrange["min_com_limit"].'"/>';
				$str.='</td>';
				$str.='<td  style="display:none">';
				$str.= '<input type="text" width="30"  class="form-control" style="width:150px;" id="txtMaxComm'.$row->company_id.'" name="txtMaxComm'.$row->company_id.'" value="'.$agent_commissionrange["min_com_limit"].'"/>';
				$str.='</td>';
				$str.='<td  style="display:none">PER</td>';
			}



			

			$str.='<td style="display:none">';

						if($rslt->num_rows() > 0)
						{




								$str.= '<select id="ddlcomtype'.$row->company_id.'" name="ddlcomtype'.$row->company_id.'" class="form-control" onChange="changecommtype('.$row->company_id.')">
											<option value="PER">PERCENTAGE</option>
											<option value="AMOUNT">AMOUNT</option>';
								$str.= '</select>';

						}
						else
						{
							$str.= '<select id="ddlcomtype'.$row->company_id.'" name="ddlcomtype'.$row->company_id.'" class="form-control" onChange="changecommtype('.$row->company_id.')">
											<option value="PER">PERCENTAGE</option>
											<option value="AMOUNT">AMOUNT</option>';
								$str.= '</select>';
						}

						$str.='</td>';

                    $str.='<td >';

						if($rslt->num_rows() > 0)
						{




								$str.= '<select id="ddlapi'.$row->company_id.'" name="ddlapi'.$row->company_id.'" class="form-control-sm" >
											<option value=""></option>
											<option value="0">Default</option>';
											$str.= $apidropdown;
								$str.= '</select>';
								$str .='<script language="javascript">document.getElementById("ddlapi'.$row->company_id.'").value = "'.$rslt->row(0)->api_id.'";</script>';

						}
						else
						{
							$str.= '<select id="ddlapi'.$row->company_id.'" name="ddlapi'.$row->company_id.'" class="form-control-sm" >
											<option value=""></option>
											<option value="0">Default</option>';
											$str.= $apidropdown;
								$str.= '</select>';
						}

						$str.='</td>';





			$str.='<td>

			<input type="button" class="btn btn-success" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->company_id.',\''.$usertype.'\')"/></td><td><div id="divprocess" style="display:none">
	<img src="'.base_url().'ajax-loader.gif" style="width:70px;">
	</div>
			</td>
			</tr>
			';
			$i++;
		}
		$str.='</table>';
		echo $str;
	}
	function ChangeCommission()
	{
		if($this->session->userdata("ausertype") != "Admin")
		{
			"UN Authorized Access";exit;
		}
		$id = $_GET["id"];
		$com = trim($_GET["com"]);
		$mincomm = trim($_GET["mincomm"]);
		$maxcomm = trim($_GET["maxcomm"]);
		$comtype = trim($_GET["comtype"]);
		$company_id = $_GET["company_id"];
		$api_id = $_GET["api_id"];
		

		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($id));
		if($userinfo->num_rows() == 1)
		{
			
			if($api_id > 0)
			{
			error_reporting(-1);
			ini_set('display_errors',1);
			$this->db->db_debug = TRUE;
				$check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($id, $company_id));
				
				if($check_rslt->num_rows()  == 1)
				{
					$rslt = $this->db->query("update tbluser_commission set commission = 0,commission_type = 'PER' ,min_com_limit = 0, max_com_limit = 0,api_id = ? where Id = ?"
					,array($api_id,$check_rslt->row(0)->Id));
					echo "OK";exit;
				}
				else
				{
					$add_date = $this->common->getDate();
					$str_qry = "insert into tbluser_commission(user_id,company_id,commission,commission_type,min_com_limit,max_com_limit,add_date,api_id) values(?,?,?,?,?,?,?,?)";
					$rslt_in = $this->db->query($str_qry,array($id,$company_id,0,0,0,$add_date,0,$api_id));
					echo "OK";exit;
				}
			}
		
		}




		


	}
	function getdealer()
	{
		if($this->session->userdata("ausertype") != "Admin")
			{
				"UN Authorized Access";exit;
			}
		$id = $_GET["id"];
		$rsltdealer = $this->db->query("select * from tblusers where parentid = ? and usertype_name = 'Distributor'",array($id));
		echo "<option>Select</option>";
		foreach($rsltdealer->result() as $row)
		{

			echo "<option value='".$row->user_id."'>".$row->businessname."[".$row->username."]</option>";
		}

	}
	function getretailer()
	{
		if($this->session->userdata("ausertype") != "Admin")
			{
				"UN Authorized Access";exit;
			}
		$id = $_GET["id"];
		if($id > 0)
		{
			$rsltdealer = $this->db->query("select * from tblusers where parentid = ? and usertype_name = 'Agent'",array($id));
		}
		else
		{
			$rsltdealer = $this->db->query("select * from tblusers where usertype_name = 'Agent'");
		}
		echo "<option>Select</option>";
		foreach($rsltdealer->result() as $row)
		{

			echo "<option value='".$row->user_id."'>".$row->businessname."[".$row->username."]</option>";
		}

	}
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata("ausertype") != "Admin") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
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
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$data=array(
				"message"=>"",
				);
				$this->load->view("_Admin/set_commission_view",$data);
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}