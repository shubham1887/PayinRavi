<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set_commission extends CI_Controller {
function __construct()
    {
        parent:: __construct();
		$this->clear_cache();
        $this->is_logged_in();
       
    }
	function is_logged_in() 
    {

       if($this->session->userdata('DistLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
    }
    function clear_cache()
    {
       $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
	   $this->output->set_header("Pragma: no-cache"); 
    }
function getCommission()
{

		
		$id = $_GET["id"]; 
		$userinfo = $this->Userinfo_methods->getUserInfo($id);
		if($userinfo->num_rows() == 1)
		{
			$parent_id = $userinfo->row(0)->parentid;
			$user_type = $userinfo->row(0)->usertype_name;
			if($parent_id == $this->session->userdata("DistId"))
			{
				$rsltcompany = $this->db->query("select * from tblcompany");
				$str ='<div>Commission Structure of '.$userinfo->row(0)->businessname.'</div><input type="hidden" id="uid" name="uid" value="'.$id.'"><table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="width:700px;">
				<tr>  
				<th>Sr No.</th>
				<th>Network</th>
				<th>My Commission</th>
				<th>Client Commission (%)</th>
				<th></th>
				</tr>
				';
				$i=1;
				foreach($rsltcompany->result() as $row)
				{
					$rslt  = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($id,$row->company_id));
					$adm_com_rslt  = $this->db->query("select * from tblcompany where company_id = ?",array($row->company_id));
				if($i % 2 == 0)
				{
					$str .='<tr class="row1">';
				}
				else
				{
					$str .='<tr class="row2">';
				}
					$str.='
			
					<td >'.$i.'</td>
					<td >'.$row->company_name.'</td>
					
					<td >'.$this->Userinfo_methods->getCommissionInfo($row->company_id,$this->session->userdata("DistId")).'</td>
					<td >';
					
					if($rslt->num_rows() > 0)
					{
							$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value="'.$rslt->row(0)->commission.'"/>';
					}
					else
					{
						$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value=""/>';
					}
					
					$str.='</td>
					<td ><input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->company_id.',\''.$user_type.'\')"/></td>
					</tr>
					';
					$i++;
				}
				$str.='</table>';
				echo $str;
			}
			else
			{
				echo "Error::Invalid User";exit;
			}
			
		}
		else
		{
			echo "Error::Invalid User";exit;
		}
		
		
}

function getretailer()
{
	$id = $_GET["id"];
	$rsltdealer = $this->db->query("select * from tblusers where parentid = ? and usertype_name = 'Distributor'",array($this->session->userdata("DistId")));
	echo "<option>Select</option>";
	foreach($rsltdealer->result() as $row)
	{
		
		echo "<option value='".$row->user_id."'>".$row->businessname."[".$row->username."]</option>";
	}

}
	
	
	
	public function index() 
	{
		
			if(isset($_GET["company_id"]) and isset($_GET["com"]) and isset($_GET["id"]))
			{
				
					$id = $_GET["id"];
					$com = $_GET["com"];
					$company_id = $_GET["company_id"];
					$userinfo = $this->Userinfo_methods->getUserInfo($id);
					if($userinfo->num_rows() != 1)
					{
						echo "Error::Invalid User";exit;
					}
					$parent_id = $userinfo->row(0)->parentid;
					$usertype_name = $userinfo->row(0)->usertype_name;
					if($parent_id == $this->session->userdata("DistId") and $usertype_name == "Agent")
					{
						$parentcomm = $this->Userinfo_methods->getCommissionInfo($company_id,$parent_id);
						if($parentcomm >= $com and $com >= 0)
						{
							$check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($id, $company_id));
							if($check_rslt->num_rows()  == 1)
							{
								
								$rslt = $this->db->query("update tbluser_commission set commission = ? where Id = ?",array($com,$check_rslt->row(0)->Id));
							}
							else
							{
							
								$add_date = $this->common->getDate();
								$str_qry = "insert into tbluser_commission(user_id,company_id,commission,add_date) values( ? , ?, ? , ?)";
								$rslt_in = $this->db->query($str_qry,array($id,$company_id,$com,$add_date));
							}
						}
						else
						{
							echo "Error::Invalid Commission";exit;
						}
						
					}
					
	
	
			exit;
			}
		else 
		{ 
			$data['message']='';				
			if($this->input->post("hidflag") == "Set")
			{
				$com_id = $this->input->post("hidid",TRUE);
				$com_per = $this->input->post("hidcom",TRUE);
				
			}
			else
			{
				$data=array(
				"message"=>"",
				);
				$this->load->view("Distributor/set_commission_view",$data);																				
			}
		} 
	}	
}