<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_inbox2 extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
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
        //error_reporting(E_ALL);
        //ini_set('display_errors',1);
        //$this->db->db_debug = TRUE;
    }
	public function index()  
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
            error_reporting(E_ALL);
            ini_set('display_errors',1);
            $this->db->db_debug = TRUE;

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Search")
			{
				
				$from = $this->input->post("txtFrom",TRUE);
				$to = $this->input->post("txtTo",TRUE);
				$txtUserId = $this->input->post("txtUserId",TRUE);
				$txtParentUserId = $this->input->post("txtParentUserId",TRUE);
				

				
				$this->view_data['data'] = $this->db->query("
				select 
				a.*,
				b.host_id,b.user_id,b.username,b.usertype_name,b.businessname,
				p.businessname as parent_name,p.username as parent_username
				FROM `smsinbox2` a 
				left join tblusers b on a.mobile_no = b.mobile_no 
				left join tblusers p on b.parentid = p.user_id
				where 
				Date(a.add_date) >= ? and
				Date(a.add_date) <= ? and
				if(? != '',a.mobile_no = ?,true) and
				if(? != '',p.mobile_no = ?,true) and
				a.mobile_no > 0
				order by a.add_date ",array($from,$to,$txtUserId,$txtUserId,$txtParentUserId,$txtParentUserId));
				$this->view_data['message'] =$this->msg;
				
				$this->view_data['from_date']  = $from;
				$this->view_data['to_date']  = $to;
				$this->view_data['txtUserId']  = $txtUserId;
				$this->view_data['txtParentUserId']  = $txtParentUserId;
				$this->view_data['ddlbalnacetype']  = "ALL";
				$this->load->view('SuperDealer/sms_inbox2_view',$this->view_data);	
			}					
			
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
				{
				
				$from = $to  = $this->common->getMySqlDate();

				
				$this->view_data['data'] = $this->db->query("
				select 
				a.*,
				b.host_id,b.user_id,b.username,b.usertype_name,b.businessname,
				p.businessname as parent_name,p.username as parent_username
				FROM `smsinbox2` a 
				left join tblusers b on a.mobile_no = b.mobile_no 
				left join tblusers p on b.parentid = p.user_id
				where 
				Date(a.add_date) >= ? and
				Date(a.add_date) <= ? and
				a.mobile_no > 0
				order by a.add_date ",array($from,$to));
				$this->view_data['message'] =$this->msg;
				
				$this->view_data['from_date']  = $from;
				$this->view_data['to_date']  = $to;
				$this->view_data['txtUserId']  = "";
				$this->view_data['txtParentUserId']  = "";
				$this->view_data['ddlbalnacetype']  = "ALL";
				$this->load->view('SuperDealer/sms_inbox2_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	
	public function dataexport()
	{
	   
	
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$UserId = trim($_GET["UserId"]);
			$ParentUserId = trim($_GET["ParentUserId"]);
			
			$data = array();
			
			
				
		$rslt = $this->db->query("
				select 
				a.*,
				b.host_id,b.user_id,b.username,b.usertype_name,b.businessname,
				p.businessname as parent_name,p.username as parent_username
				FROM `smsinbox2` a 
				left join tblusers b on a.mobile_no = b.mobile_no 
				left join tblusers p on b.parentid = p.user_id
				where 
				Date(a.add_date) >= ? and
				Date(a.add_date) <= ? and
				if(? != '',a.mobile_no = ?,true) and
				if(? != '',p.mobile_no = ?,true) and
				a.mobile_no > 0
				order by a.add_date ",array($from,$to,$UserId,$UserId,$ParentUserId,$ParentUserId));
			
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"Mobile" => $rw->mobile_no, 
									"businessname" => $rw->businessname, 
									"usertype_name" => $rw->usertype_name, 
									"parent_name" => $rw->parent_name, 
									"parent_mobile" => $rw->parent_username, 
									"add_date" =>$rw->add_date, 
									"amount" =>$rw->amount, 
									"SenderId" =>$rw->sender_id, 
									"HostName" =>$this->Common_methods->getHostName($rw->host_id), 
									"Message" =>$rw->message, 
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
    $fileName = "Sms Filter From ".$from." To  ".$to.".xls";
    
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