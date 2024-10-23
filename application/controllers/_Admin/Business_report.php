<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_report extends CI_Controller {
	
	
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

			if($this->input->post('btnSearch') == "Search")
			{
				//print_r($this->input->post());exit;
				error_reporting(-1);
				ini_set('display_errors',1);
				$this->db->db_debug = TRUE;
				$from = $this->input->post("txtFrom");
				$to = $this->input->post("txtTo");
				$ddlusertype = $this->input->post("ddlusertype");
				
				$rslt = $this->db->query("select * from tblusers 
				where  
				if(?='Agent',usertype_name = 'Agent',true) and 
				if(?='Distributor',usertype_name = 'Distributor',true) and
				if(?='MasterDealer',usertype_name = 'MasterDealer',true) and
				if(?='APIUSER',usertype_name = 'APIUSER',true)
				",array($ddlusertype,$ddlusertype,$ddlusertype,$ddlusertype));
			

				//print_r($rslt->result());exit;

			
				$rechargearray = array();
				if($ddlusertype == "Agent" or $ddlusertype == "APIUSER")
				{
					$rechargereport = $this->db->query("
					SELECT a.user_id, 
							Sum(a.amount) as toatlrecharge,
							Sum(a.commission_amount) as totalcommission 
							FROM tblrecharge a

							where a.recharge_status = 'Success' 
							and Date(a.add_date) >= ? and Date(a.add_date) <= ? 
							group by a.user_id ",array($from,$to));
							//print_r($rechargereport->result());exit;
				}
				else if($ddlusertype == "Distributor")
				{
					$rechargereport = $this->db->query("
					SELECT a.DId as user_id, 
							Sum(a.amount) as toatlrecharge,
							Sum(a.DComm) as totalcommission
							FROM tblrecharge a

							where a.recharge_status = 'Success' and 
							Date(a.add_date) >= ? and Date(a.add_date) <= ? 
							group by a.DId",array($from,$to));
				}
				else if($ddlusertype == "MasterDealer")
				{
					$rechargereport = $this->db->query("
					SELECT a.MdId as user_id, 
							Sum(a.amount) as toatlrecharge,
							Sum(a.MdComm) as totalcommission
							FROM tblrecharge a

							where a.recharge_status = 'Success' and 
							Date(a.add_date) >= ? and 
							Date(a.add_date) <= ? group by a.MdId",array($from,$to));
				}
				
				
				foreach($rechargereport->result() as $row)
				{
					$rechargearray[$row->user_id]["totalrecharge"] = $row->toatlrecharge;
					$rechargearray[$row->user_id]["totalcommission"] = $row->totalcommission;
				}

				

				$this->view_data["result_recharge"] = $rslt;
				$this->view_data["from"] = $from;
				$this->view_data["to"] = $to;
				$this->view_data["rechargearray"] = $rechargearray;
				$this->view_data["ddlusertype"] = $ddlusertype;
				$this->load->view('_Admin/business_report_view',$this->view_data);		
			}					
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$date = $this->common->getMySqlDate();
		
					$this->view_data["from"] = $date;
					$this->view_data["to"] = $date;
					$this->view_data["usertype"] = "ALL";
					$this->view_data["username"] = "";
					$this->view_data["result_recharge"] = false;
					$this->load->view('_Admin/business_report_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function dataexporttwo()
	{
	   
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "session expired"; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			
			$data = array();
			
			
				$rechargereport = $this->db->query("
				SELECT a.user_id, 
						Sum(a.amount) as toatlrecharge,
						Sum(a.commission_amount) as totalcommission,
						b.businessname,
						b.username,
						b.usertype_name
						FROM tblrecharge a
						left join tblusers b on a.user_id = b.user_id

						where a.recharge_status = 'Success' 
						and Date(a.add_date) >= ? and Date(a.add_date) <= ? 
						group by a.user_id ",array($from,$to));
			
				
		$i = 0;
		foreach($rechargereport->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"businessname" => $rw->businessname, 
									"username" => $rw->username, 
									"usertype_name" =>$rw->usertype_name, 
									"toatlrecharge" =>$rw->toatlrecharge, 
									"totalcommission" =>$rw->totalcommission, 
								);
					
					
					
					array_push( $data,$temparray);
					$i++;
	}
	function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
    $fileName = "business Report From ".$from." To  ".$to.".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    foreach($data as $row) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($row, 'filterData');
        echo implode("\t", array_values($row)) . "\n";
    }
    
    exit;				
		}
		else
		{
			echo "parameter missing";exit;
		}
	}
}