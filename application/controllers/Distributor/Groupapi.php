<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupapi extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('DistUserType') != "Distributor") 
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
    }
	public function pageview()
	{ 
		$rslt = $this->db->query("select company_id,company_name from tblcompany");
		$this->view_data['result_company'] = $rslt;
		$this->view_data['message'] =$this->msg;
		$this->load->view('Distributor/groupapi_view',$this->view_data);		
	}
	
	
	public function getresult()
	{
	    $user_id = $this->session->userdata("DistId");
	    $str_company_id = "";
		$group_id = intval($_GET["groupid"]);
		//$userinfo = $this->Userinfo_methods->getUserInfo($group_id);
		$group_info = $this->db->query("select * from tblgroup where Id = ? and user_id = ?",array($group_id,$user_id));
		if($group_info->num_rows() == 1)
		{
		    $str = '<div>Commission Structure of '.$group_info->row(0)->group_name.'</div><input type="hidden" id="uid" name="uid" value="'.$group_id.'">
		<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
				<tr>  
    				<th>Sr No.</th>
    				<th>Network</th>
    				<th>Client Commission %</th>
    				<th>Commission Type</th>
    				<th></th>
				</tr>';
    	$i = 0;
		$result_company = $this->db->query("select * from tblcompany where service_id = 1 or service_id = 2 order by service_id,company_name");
		foreach($result_company->result() as $row) 	
		{
		    $str_company_id.=$row->company_id.",";
			$rslt  = $this->db->query("select * from tblgroupapi where group_id = ? and company_id = ?",array($group_id,$row->company_id));
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
				<td >'.$row->company_name.'</td>';
				
				
				
				
				if($rslt->num_rows() > 0)
				{
						$str.= '<td >';
						$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value="'.$rslt->row(0)->commission.'"/>';
						$str.= '</td>';
						
						$str.= '<td>';
						if($rslt->row(0)->commission_type == "PER")
						{
							$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
							<option value="PER">Percentage</option>
							<option value="AMOUNT">Amount</option>';
							$str.= '</select>';
						}
						else
						{
							$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
							<option value="AMOUNT">Amount</option>
							<option value="PER">Percentage</option>';
							$str.= '</select>';
						}
						$str.= '</td>';
				}
				else
				{
					$str.= '<td >';
					$str.= '<input style="width:150px;" class="form-control" type="text" width="30" id="txtComm'.$row->company_id.'" name="txtComm'.$row->company_id.'" value=""/>';
					$str.= '</td>';
				
					$str.= '<td>';
						
					$str.= '<select id="ddlcommission_type'.$row->company_id.'" name="ddlcommission_type'.$row->company_id.'" class="form-control" >
					<option value="PER">Percentage</option>
					<option value="AMOUNT">Amount</option>';
					$str.= '</select>';
						
						$str.= '</td>';
					
				}
				$str.='
				<td ><input class="btn btn-primary" type="button" id="btnsubmit" name="btnsubmit" value="Submit" onclick="changecommission('.$row->company_id.',\''.$group_id.'\')"/></td>
				</tr>
				';
				$i++;
			
	} 
	
	
	$str.='<tr>
<td></td>

<td colspan=3 align="center">
    <input type="button" id="btnAll" class="btn btn-success btn-lg" value="Submit All" onClick="changeall()">
    <input type="hidden" id="hidcompany_ids" value="'.$str_company_id.'">
</td>
</tr>';
	
   $str.='</table>';
			echo $str;
		}
		
	}
	public function index() 
	{
					$this->pageview();		
	}
	function ChangeCommission()
	{
	
		
		$comm = trim($_GET["com"]);
		$mincom = trim($_GET["mincom"]);
		$maxcom = trim($_GET["maxcom"]);
		$comtype = $_GET["comtype"];
		$group_id = $_GET["groupid"];
		$company_id = intval($_GET["company_id"]);
		
		

		$user_id = $this->session->userdata("DistId");
		
		$groupinfo = $this->db->query("select * from tblgroup where Id = ? and user_id = ?",array($group_id,$user_id));
		if($groupinfo->num_rows() == 1)
		{
		    
		    $md_info = $this->db->query("select scheme_id from tblusers where user_id = ? and usertype_name = 'Distributor'",array($user_id));
		    if($md_info->num_rows() == 1)
		    {
		        $md_scheme_id = $md_info->row(0)->scheme_id;
		        $md_commission_info = $this->db->query("select commission,commission_type from tblgroupapi where group_id = ? and company_id = ?",array($md_scheme_id,$company_id));
		        if($md_commission_info->num_rows() == 1)
		        {
		            $md_commission = $md_commission_info->row(0)->commission;
		            $md_commission_type = $md_commission_info->row(0)->commission_type;
		           
		            if($comm >= 0 and $comm <= 5)
    				{
    					if($comtype == "PER" or $comtype == "AMOUNT")
    					{
    						if($comm <= $md_commission and $comtype == $md_commission_type)
    						{
    							$rslt = $this->db->query("select * from tblgroupapi where group_id = ? and company_id = ?",array($group_id,$company_id));
    							if($rslt->num_rows() > 0)
    							{
    
    								$insertgroupapi = $this->db->query("update tblgroupapi set commission=?,commission_type=? where group_id = ? and company_id = ?",array($comm,$comtype,$group_id,$company_id));
    
    								echo "OK";exit;
    							}
    							else
    							{
    								$this->db->query("delete from tblgroupapi  where group_id = ? and company_id = ?",array($group_id,$company_id));
    								$this->db->query("insert into tblgroupapi(company_id,commission,commission_type,group_id,add_date,ipaddress) values(?,?,?,?,?,?)",array($company_id,$comm,$comtype,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
    								echo "OK";exit;
    							}	
    
    
    						}
    						else
    						{
    							echo "Invalid Commission";exit;
    						}
    					}
    					else
    					{
    						echo "Invalid Commission Type";exit;
    					}
    
    
    				}
    				else
    				{
    					echo "Commission Not In Range";exit;
    				}
		        }
		        else
		        {
		            echo "Commission Not set";exit;
		        }
		        
		    }
		    else
		    {
		        echo "User Not Found";exit;
		    }
		}
		else
		{
		    echo "Invalid Group";exit;
		}




		


	}

}