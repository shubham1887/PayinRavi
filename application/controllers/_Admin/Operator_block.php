<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operator_block extends CI_Controller {
	
	
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
			$this->view_data["message"] = "";
			$this->load->view("_Admin/operator_block_view",$this->view_data);
		} 
	}	
	public function getUser()
	{
		$type = $_GET["type"];
		$rslt = $this->db->query("select user_id,businessname,username from tblusers where usertype_name = ?",array($type));
		echo "<option value='0'>Select</option>";
		foreach($rslt->result() as $row)
		{
			echo "<option value='".$row->user_id."'>".$row->businessname."[".$row->username."]</option>";
		}
	}
	public function getOperator()
	{
		$user_id = $_GET["user_id"];
		$rsltuser = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		if($rsltuser->num_rows() == 1)
		{
			$html ='<table style="width:100%;font-size:14px" cellpadding="3" cellspacing="0" border="0"><tr><td>';
		
			$rsltoperators = $this->db->query("select * from tblcompany where service_id = 1");
			$html .= '<table style="width:100%;font-size:14px" cellpadding="3" cellspacing="0" border="0">';
			$i = 0;
			foreach($rsltoperators->result() as $row)
			{
			if($i % 2 ==0)
			{
			$class = "row1";
			}else{$class = "row2";}
				$html .='<tr class="'.$class.'">';
				$html .='<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >'.$row->company_name.'</td>';
				$rsltbtouser = $this->db->query("select * from tblavalioptr where company_id = ? and user_id = ?",array($row->company_id,$user_id));
				if($rsltbtouser->num_rows() > 0)
				{
					$html .='<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34"><a href="javascript:void(0)" onClick="unblockuser('.$user_id.','.$row->company_id.')">BLOCKED</a></td>';
				}
				else
				{
					$html .='<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34"><a href="javascript:void(0)" onClick="blockuser('.$user_id.','.$row->company_id.')">OPEN</a></td>';
				}
				
				$html .='</tr>';
				$i++;
			}
			$html.='</table>';
			$html .='</td>';
			$html .='<td valign="top">';
			$rsltoperators = $this->db->query("select * from tblcompany where service_id = 2");
			$html .= '<table style="width:100%;font-size:14px" cellpadding="3" cellspacing="0" border="0">';
			$j=0;
			foreach($rsltoperators->result() as $row)
			{
				if($j % 2 ==0)
				{
				$class = "row1";
				}else{$class = "row2";}
				$html .='<tr class="'.$class.'">';
				$html .='<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">'.$row->company_name.'</td>';
				$rsltbtouser = $this->db->query("select * from tblavalioptr where company_id = ? and user_id = ?",array($row->company_id,$user_id));
				if($rsltbtouser->num_rows() > 0)
				{
					$html .='<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34"><a href="javascript:void(0)" onClick="unblockuser('.$user_id.','.$row->company_id.')">BLOCKED</a></td>';
				}
				else
				{
					$html .='<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34"><a href="javascript:void(0)" onClick="blockuser('.$user_id.','.$row->company_id.')">OPEN</a></td>';
				}
				
				$html .='</tr>';
				$j++;
			}
			$html.='</table>';
			
			$html .='</td></tr></table>';
			
			echo $html;
		}
	}
	public function unblockuser()
	{
		$user_id = $_GET["user_id"];
		$company_id = $_GET["company_id"];
		$this->db->query("delete from tblavalioptr where user_id = ? and company_id = ?",array($user_id,$company_id));
		echo "true";
	}
	public function blockuser()
	{
		$user_id = $_GET["user_id"];
		$company_id = $_GET["company_id"];
		$this->db->query("delete from tblavalioptr where user_id = ? and company_id = ?",array($user_id,$company_id));
		$this->db->query("insert into tblavalioptr(user_id,company_id) values(?,?)",array($user_id,$company_id));
		
		echo "true";
	}
}