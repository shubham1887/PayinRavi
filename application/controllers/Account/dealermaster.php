<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dealermaster extends CI_Controller {
	public function index()
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if(isset($_GET["apikey"]) and isset($_GET["reqtype"]))
		{
		    
		    //1001012345 admin
		    //9924357609 shreeji enterprise
		    //http://www.mypaymall.in/Account/Dealermaster?apikey=89629056192963652575&reqtype=DEALERMASTER
			//84712451862593066122
			$apikey = trim($_GET["apikey"]);
			$reqtype = trim($_GET["reqtype"]);
			if($apikey == "89629056192963652575")
			{
				if($reqtype == "DEALERMASTER")
				{
				    error_reporting(-1);
				    ini_set('display_errors',1);
				    $this->db->db_debug = TRUE;
					$rsltuserinfo = $this->db->query("select 
											a.user_id,
											a.username,
											a.businessname,
											a.mobile_no,
											a.emailid,
											a.state_id,
											a.city_id,
											a.postal_address,
											a.pan_no
											from tblusers a 
											
											where 
											a.usertype_name = 'Distributor' or a.usertype_name = 'APIUSER' or a.usertype_name = 'MasterDealer' or  a.usertype_name = 'Agent'");
							echo json_encode($rsltuserinfo->result());exit;
						
											
				}
				else if($reqtype == "PRODUCTMASTER")
				{
					$productinfo = $this->db->query("select 
											a.company_id,
											a.company_name,
											a.model
											from tblcompany a order by a.company_name");
							echo json_encode($productinfo->result());exit;
						
											
				}
				else if($reqtype == "APIMASTER")
				{
					$apiinfo = $this->db->query("select 
											a.api_id,
											a.api_name
											from tblapi a order by a.api_name");
							echo json_encode($apiinfo->result());exit;
						
											
				}
				else if($reqtype == "DEALERMASTEROPENINGBALANCE")
				{
					if(isset($_GET["UserId"]))
					{
						$UserId = trim($_GET["UserId"]);
					
						$rsltuserinfo = $this->db->query("select balance from pankajtr_archivedb.tblewallet where Date(add_date) = '2017-04-01' and user_id = (select user_id from tblusers where username = ?) order by user_id desc limit 1",array(intval($UserId)));
						if($rsltuserinfo->num_rows() == 1)
						{
									echo $rsltuserinfo->row(0)->balance;
						}
						else
						{
						   
						        	    echo "0";
						   	
						}
					}
					else
					{
						echo "Parameter Missing";exit;
					}
					
					
						
											
				}
			}		
		}
		
		
	}
	
}
