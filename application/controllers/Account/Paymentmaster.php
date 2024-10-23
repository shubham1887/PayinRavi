<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paymentmaster extends CI_Controller {
	public function index()
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if(isset($_GET["apikey"]) and isset($_GET["date"]))
		{
			//84712451862593066122
			//1001012345 admin
		    //9924357609 shreeji enterprise
			$apikey = trim($_GET["apikey"]);
			$date = trim($_GET["date"]);
			$username = trim($_GET["username"]);
			if($apikey == "89629056192963652575")
			{
			
				$recorddate = 
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');
				$date = date_format(date_create($date),'Y-m-d');		
				$data = array();
			        if($date >= "2016-06-17")
			        {
			            	$str_query = "select 
						
    					
    						
    						a.update_time,
    						a.recharge_id,
    						a.ewallet_id,
    						a.transaction_id,
    						a.add_date,
    						b.businessname,
    						b.username,
    						c.company_name,
    						c.company_id,
    						b.parentid,
    						a.mobile_no,
    						a.amount,
    						a.commission_amount,
    						a.ExecuteBy,
    						a.recharge_by,
    						a.recharge_status
    						from tblrecharge a
    						left join tblcompany c on a.company_id = c.company_id
    						left join tblusers b on a.user_id = b.user_id
    						where 
    						Date(a.add_date) =? order by a.recharge_id
    						";
    					$rslt = $this->db->query($str_query,array($username,$date));
    					echo json_encode($rslt->result());exit;
			        }
			        
					
				
					
				
	
			}		
		}
		else
		{
			echo "parameter missing";exit;
		}
		
		
	}
	
}
