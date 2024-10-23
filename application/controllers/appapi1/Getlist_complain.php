<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getlist_complain extends CI_Controller {
	
	
	
	
	public function index() 
	{
	
		if(isset($_GET["number"]))
		{
			$number = trim($_GET["number"]);
			$rslt = $this->db->query("select company_name,imageurl,tblrecharge.recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.mobile_no = ? order by recharge_id desc limit 100",array($number));
		}
		else
		{
			$rslt = $this->db->query("select tblcomplain.complain_id,tblcomplain.recharge_id,message,complain_status,complain_date,complainsolve_date,response_message from tblcomplain  order by  tblcomplain.complain_id desc limit 100");
		}
		echo '<?xml version="1.0" encoding="utf-8"?><rss>';
		
		foreach($rslt->result() as $row)
		{
		$rsltrec = $this->db->query("select tblrecharge.recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.operator_id,tblrecharge.recharge_status,tblrecharge.add_date,company_name,imageurl from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.recharge_id = ?",array($row->recharge_id));
		if($rsltrec->num_rows() == 1)
		{
			echo '
<item>
<id>'.$row->recharge_id.'</id>
<complain_id>'.$row->complain_id.'</complain_id>
<complain_message>'.$row->message.'</complain_message>
<complain_status>'.$row->complain_status.'</complain_status>
<complain_date>'.$row->complain_date.'</complain_date>
<complainsolve_date>'.$row->complainsolve_date.'</complainsolve_date>
<Response_message>'.$row->response_message.'</Response_message>
<operator>'.$rsltrec->row(0)->company_name.'</operator>
<mobile>'.$rsltrec->row(0)->mobile_no.' </mobile>
<amount>'.$rsltrec->row(0)->amount.' </amount>
<status>'.$rsltrec->row(0)->recharge_status.' </status>
<operator_id>'.$rsltrec->row(0)->operator_id.' </operator_id>
<recDate>'.$rsltrec->row(0)->add_date.'</recDate>
<link>http://www.royalbusinessonline.in/images/Company_logo/'.$rsltrec->row(0)->imageurl.'</link>
</item>
';	
		}
		
		}
		echo '</rss>';
		

	}
	
}