<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getlist_operator extends CI_Controller {
	
	
	
	
	public function index() 
	{
		if(isset($_GET["service_id"]))
		{
			$service_id = trim($_GET["service_id"]);
			$rslt = $this->db->query("select company_name,company_id,imageurl,mcode from tblcompany where service_id = ? order by listing_priority",array($service_id));
		}
		else
		{
			$rslt = $this->db->query("select company_name,company_id,imageurl,mcode from tblcompany order by listing_priority",array($service_id));
		}
		echo '<?xml version="1.0" encoding="utf-8"?><rss>';
		
		foreach($rslt->result() as $row)
		{
		echo '
<item>
<id>'.$row->company_id.'</id>
<operator>'.$row->company_name.'</operator>
<mcode>'.$row->mcode.'</mcode>
<link>http://www.payreflection.com/images/Company_logo/'.$row->imageurl.'</link>
</item>
';
		}
		echo '</rss>';
		

	}
	
}