<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getcompany extends CI_Controller {
	
	
	
	
	public function index() 
	{
		
		$rslt = $this->db->query("select company_name,company_id,imageurl,mcode,service_id from tblcompany order by listing_priority");
		foreach($rslt->result() as $row)
		{
		echo $row->company_id.'#'.$row->company_name.'#'.$row->mcode.">".$row->service_id.'#'.$row->imageurl.'@@';
		}
		

	}
	
}