<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gst_report extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
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
    }
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
				
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);

				$txtsearch = $this->input->post("txtSearch",TRUE);
				$this->view_data['pagination'] = NULL;
				//echo $from_date;exit;
				$this->view_data['result_mdealer'] = $this->db->query("
					SELECT 
						b.businessname,
						b.usertype_name,
						b.username,
						a.user_id,
						count(Id) as totalcount,
						IFNULL(Sum(a.Amount),0) as Amount,
						IFNULL(Sum(a.Charge_Amount),0) as Charge_Amount,
						IFNULL(Sum(a.ccf),0) as ccf,
						IFNULL(Sum(a.cashback),0) as cashback,
						IFNULL(Sum(a.gst),0) as gst,
						IFNULL(Sum(a.tds),0) as tds 
						FROM `mt3_transfer` a 
						left join tblusers b on a.user_id = b.user_id   

where 
a.Status = 'SUCCESS' and 

Date(a.add_date) BETWEEN ? and ? and
if(? != '',b.mobile_no = ?,true)

group by a.user_id 
order by gst desc",array($from_date,$to_date,$txtsearch,$txtsearch));
				//print_r($this->view_data['result_mdealer']->result());exit;
				$this->view_data['message'] =$this->msg;
				
			
				$this->view_data['txtsearch']  = $txtsearch;
				$this->view_data['from_date']  = $from_date;
				$this->view_data['to_date']  = $to_date;
				$this->load->view('_Admin/gst_report_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$from_date = $this->common->getMySqlDate();
					$to_date = $from_date;
					$txtsearch = "";
					$this->view_data['pagination'] = NULL;
					
					$this->view_data['result_mdealer'] = $this->db->query("
						SELECT 
						b.businessname,
						b.usertype_name,
						b.username,
						a.user_id,
						count(Id) as totalcount,
						IFNULL(Sum(a.Amount),0) as Amount,
						IFNULL(Sum(a.Charge_Amount),0) as Charge_Amount,
						IFNULL(Sum(a.ccf),0) as ccf,
						IFNULL(Sum(a.cashback),0) as cashback,
						IFNULL(Sum(a.gst),0) as gst,
						IFNULL(Sum(a.tds),0) as tds 
						FROM `mt3_transfer` a left join tblusers b on a.user_id = b.user_id   

	where 
	a.Status = 'SUCCESS' and 
	a.Amount > 1 and 
	Date(a.add_date) BETWEEN ? and ?

	group by a.user_id 
	order by gst desc",array($from_date,$to_date));
					$this->view_data['message'] =$this->msg;
					
				
					$this->view_data['from_date']  = $from_date;
					$this->view_data['to_date']  = $to_date;
					$this->view_data['txtsearch']  = $txtsearch;
					$this->load->view('_Admin/gst_report_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function dataexport()
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
			$db = trim($_GET["db"]);
			$data = array();
			
			
			
			    $rslt = $this->db->query("SELECT 
						b.businessname,
						b.usertype_name,
						a.user_id,
						count(Id) as totalcount,
						IFNULL(Sum(a.Amount),0) as Amount,
						IFNULL(Sum(a.Charge_Amount),0) as Charge_Amount,
						IFNULL(Sum(a.ccf),0) as ccf,
						IFNULL(Sum(a.cashback),0) as cashback,
						IFNULL(Sum(a.gst),0) as gst,
						IFNULL(Sum(a.tds),0) as tds 
						FROM `mt3_transfer` a left join tblusers b on a.user_id = b.user_id   

where 
a.Status = 'SUCCESS' and 

Date(a.add_date) BETWEEN ? and ?

group by a.user_id 
order by gst desc",array($from,$to));			
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			$temparray = array(
			
									"Sr" =>  $i, 
									"Agent Name" => $rw->businessname, 
									"From date" =>$from, 
									"TO date" =>$to,
									 
									"Agn type" => $rw->usertype_name, 	
									"totalcount" =>$rw->totalcount,
									"Total Charge Amount" =>$rw->Charge_Amount,
								
									"Amount" =>$rw->Amount, 
									"Total ccf" =>$rw->ccf, 
									"Total cashback" =>$rw->cashback, 
									"Total GST" =>$rw->gst, 
									
				
									"Total TDS" =>$rw->tds, 
									
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
    $fileName = "DMR REPORT From ".$from." To  ".$to.".xls";
    
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