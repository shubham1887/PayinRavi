<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_history extends CI_Controller { 
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ApiUserType') != "APIUSER") 
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
	public function commonfunction()
	{ 	
		if ($this->session->userdata('ApiLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		
		$word = "";
		$fromdate = $this->session->userdata("from");
		$todate = $this->session->userdata("to");
		
		$txtNumId = $this->session->userdata("txtNumId");
		$ddlstatus = $this->session->userdata("ddlstatus");
		$ddloperator = $this->session->userdata("ddloperator");
		$ddldb = $this->session->userdata("ddldb");
		$user = $this->session->userdata("ApiId");
		
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
	
		/*$countarr = $this->db->query("select count(recharge_id) as total from tblrecharge where recharge_date >='$fromdate' and recharge_date <= '$todate' and tblrecharge.user_id  = ? order by tblrecharge.recharge_id desc",array($this->session->userdata("ApiId")));*/
		$total_rows = $this->gettablerowscount($fromdate,$todate,$ddloperator,$ddlstatus,$txtNumId,$user,$ddldb);
		//echo $total_rows;exit;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."API/recharge_history/commonfunction";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['numrows'] = $total_rows; 
		$this->view_data['fromdate'] =$fromdate; 
		$this->view_data['todate'] =$todate; 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
        $this->db->reconnect();
		
		if($ddldb == "ARCHIVE")
		{
			
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM rodalapi_archive.tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and a.user_id = ?
										 group by a.recharge_status ",array($fromdate,$todate,$user));
			
		}
		else
		{
			$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ?  and a.user_id = ?
										 group by a.recharge_status ",array($fromdate,$todate,$user));
		}
		
		$totalsuccess = 0;
		$totalfailure = 0;
		$totalpending = 0;
		$totalcommission = 0;
			
		if($rslt_sf->num_rows() > 0)
		{
			foreach($rslt_sf->result() as $row)
			{
				if($row->recharge_status == "Success")
				{
					$totalsuccess = $row->total;	
				
				}
				if($row->recharge_status == "Failure")
				{
					$totalfailure = $row->total;	
				}
				if($row->recharge_status == "Pending")
				{
					$totalpending = $row->total;	
				}
			}
	
		}
	
		
		$this->view_data['totalRecahrge'] =$totalsuccess;
		$this->view_data['totalpRecahrge'] =$totalpending;
		$this->view_data['totalfRecahrge'] =$totalfailure;
		
		
		$this->view_data['txtNumId'] =$txtNumId; 
		$this->view_data['from'] =$fromdate;
		$this->view_data['to'] =$todate;
		$this->view_data['user'] =$user;
		$this->view_data['ddlstatus'] =$ddlstatus; 
		$this->view_data['ddloperator'] =$ddloperator;
		$this->view_data['ddldb'] =$ddldb; 
		$this->view_data['result_recharge'] = $this->gettablerows($fromdate,$todate,$ddloperator,$ddlstatus,$txtNumId,$start_row,$per_page,$user,$ddldb);
		//$this->view_data['result_all'] = 
		$this->view_data['message'] =$this->msg;
		$this->load->view('API/recharge_history_view',$this->view_data);			
	
	}	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		else if($this->input->post('btnSearch'))
		{
		
			$fromdate = $this->input->post('txtFrom',true);
			$todate = $this->input->post('txtTo',true);
			$txtNumId = $this->input->post('txtNumId',true);
			$ddlstatus = $this->input->post('ddlstatus',true);
			$ddloperator = $this->input->post('ddloperator',true);
			$ddldb = $this->input->post('ddldb',true);
			$this->session->set_userdata("from",$fromdate);
			$this->session->set_userdata("to",$todate);
			$this->session->set_userdata("txtNumId",$txtNumId);
			$this->session->set_userdata("ddlstatus",$ddlstatus);
			$this->session->set_userdata("ddloperator",$ddloperator);
			$this->session->set_userdata("ddldb",$ddldb);
			$this->commonfunction();					
		}
		else if($this->input->post('hidrecid') and $this->input->post('hidmsg'))
		{

				$hidrecid = $this->input->post('hidrecid',true);
				$hidmsg = $this->input->post('hidmsg',true);
				$user_id = $this->session->userdata('ApiId');	
				$recharge_info = $this->db->query("select * from tblrecharge where recharge_id = ? and recharge_status = 'Pending'",array($hidrecid));
				if($recharge_info->num_rows() == 1)
				{
					$this->commonfunction();
				}
				else
				{
					$recinfo = $this->db->query("select * from tblcomplain where complain_status = 'Pending' and recharge_id = ?",array($hidrecid));
					if($recinfo->num_rows() > 0)
					{
						$this->commonfunction();
					}
					else
					{
						$date = $this->common->getDate();		
						$str_query = "insert into tblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id) values(?,?,?,?,?,?)";
						$this->db->query($str_query,array($user_id,$date,"Pending",$hidmsg,"Recharge",$hidrecid));
						$this->commonfunction();
						
					}
				}
				
		
	} 
		else 
		{ 						
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER')
				{		
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->session->set_userdata("ddlstatus","ALL");
					$this->session->set_userdata("txtNumId","");
					$this->session->set_userdata("ddloperator","ALL");
					$this->session->set_userdata("ddldb","LIVE");
					$this->commonfunction();	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	public function dataexport()
	{
	   
		if ($this->session->userdata('ApiLoggedIn') != TRUE) 
		{ 
			echo false; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$db = trim($_GET["db"]);
			$user_id = $this->session->userdata("ApiId");
			$data = array();
			
			if($db == "ARCHIVE")
			{
				$str_query = "select 
		
        		a.ewallet_id,
        		a.recharge_id,
        		a.mobile_no,
        		a.amount,
        		a.order_id,
        		a.recharge_status,
        		a.transaction_id,
        		a.amount,
        		a.user_id,
				a.commission_amount,
        		a.add_date,
        		a.operator_id,
        		a.recharge_by,
				a.update_time,
        		c.company_name,
        		b.businessname,b.username 
        		from rodalapi_archive.tblrecharge a 
				left join tblusers b on a.user_id = b.user_id 
				left join tblcompany c on a.company_id = c.company_id 
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to,$user_id));	
			}
			
			else
			{
			$str_query = "select 
		
        		a.ewallet_id,
        		a.recharge_id,
        		a.mobile_no,
        		a.amount,
        		a.order_id,
        		a.recharge_status,
        		a.transaction_id,
        		a.amount,
        		a.user_id,
				a.commission_amount,
        		a.add_date,
        		a.operator_id,
        		a.recharge_by,
				a.update_time,
        		c.company_name,
        		b.businessname,b.username 
        		from tblrecharge a 
				left join tblusers b on a.user_id = b.user_id 
				left join tblcompany c on a.company_id = c.company_id 
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and
				 a.user_id = ?
				order by recharge_id";
				$rslt = $this->db->query($str_query,array($from,$to,$user_id));
				
			}
			
				

		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"recharge_id" => $rw->recharge_id, 
									"client_id" => $rw->order_id, 
									"operator_id" =>$rw->operator_id, 
									"add_date" =>$rw->add_date, 
									"update_time" =>$rw->update_time, 
									"businessname" =>$rw->businessname, 
									"company_name" => $rw->company_name, 
									"mobile_no" =>$rw->mobile_no, 
									"Amount" =>$rw->amount, 
									"Recharge By" =>$rw->recharge_by, 
									"Recharge Status" =>$rw->recharge_status, 
									"Commission" =>$rw->commission_amount, 
									
									
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
    $fileName = "recharge_list From ".$from." To  ".$to.".xls";
    
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
	
	
	private function gettablerows($from,$to,$operator,$status,$numid,$start,$perpage,$user_id,$ddldb)
	{
		if($ddldb == "LIVE")
		{
		return $this->db->query("select
	a.transaction_id,
	a.updated_by,
	a.user_id, 	
	
	a.recharge_id,
	a.order_id,
	a.company_id,
	a.mobile_no,
	a.amount,
	a.recharge_by,
	a.commission_amount,
	a.add_date,
	a.update_time,
	a.operator_id,
	a.recharge_status,
	b.company_name,
	c.parentid,
	c.businessname,
	c.username 
	from tblrecharge a
	left join tblcompany b on a.company_id = b.company_id
	left join tblusers c on a.user_id = c.user_id
				
				where 
			
				if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
				(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
				(if(? >= 1,a.user_id =?,true) or if(? = 'ALL',true,a.user_id = ?)) and
				(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
				(if(? != '',Date(a.add_date) >= ?,true)) and
				(if(? != '',Date(a.add_date) <= ?,true)) and 
				a.user_id = ?
				
				 order by a.recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id,intval($start),intval($perpage)));
		}
		
		if($ddldb == "ARCHIVE")
		{
		
		return $this->db->query("select
	a.transaction_id,
	a.updated_by,
	a.user_id, 	
	
	a.recharge_id,
	a.order_id,
	a.company_id,
	a.mobile_no,
	a.amount,
	a.recharge_by,
	a.commission_amount,
	a.add_date,
	a.update_time,
	a.operator_id,
	a.recharge_status,
	b.company_name,
	c.parentid,
	c.businessname,
	c.username 
	from rodalapi_archive.tblrecharge a
	left join tblcompany b on a.company_id = b.company_id
	left join tblusers c on a.user_id = c.user_id
				
				where 
			
				if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
				(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
				(if(? >= 1,a.user_id =?,true) or if(? = 'ALL',true,a.user_id = ?)) and
				(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
				(if(? != '',Date(a.add_date) >= ?,true)) and
				(if(? != '',Date(a.add_date) <= ?,true)) and 
				a.user_id = ?
				
				 order by a.recharge_id desc limit ?,?",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id,intval($start),intval($perpage)));
		
		}
		
		
	}
	private function gettablerowscount($from,$to,$operator,$status,$numid,$user_id,$ddldb)
	{
		if($ddldb == "LIVE")
		{
			$rsltdata =  $this->db->query("select
	count(a.recharge_id) as total
	from tblrecharge a
				
				where 
			
				if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
				(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
				(if(? >= 1,a.user_id =?,true) or if(? = 'ALL',true,a.user_id = ?)) and
				(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
				(if(? != '',Date(a.add_date) >= ?,true)) and
				(if(? != '',Date(a.add_date) <= ?,true)) and 
				a.user_id = ?
				
				 order by a.recharge_id",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id));
				 return $rsltdata->row(0)->total;
		}
		
		if($ddldb == "ARCHIVE")
		{
			$rsltdata =   $this->db->query("select
	count(a.recharge_id) as total
	from rodalapi_archive.tblrecharge a
				
				where 
			
				if(? != '',(a.mobile_no = ? or a.recharge_id = ?),true) and 
				(if(? >= 1,a.company_id =?,true) or if(? = 'ALL',true,a.company_id = ?)) and
				(if(? >= 1,a.user_id =?,true) or if(? = 'ALL',true,a.user_id = ?)) and
				(if(? != '',a.recharge_status = ?,true) or if(? = 'ALL',true,a.recharge_status = ?)) and
				(if(? != '',Date(a.add_date) >= ?,true)) and
				(if(? != '',Date(a.add_date) <= ?,true)) and 
				a.user_id = ?
				
				 order by a.recharge_id",array($numid,$numid,$numid,$operator,$operator,$operator,$operator,$user_id,$user_id,$user_id,$user_id,$status,$status,$status,$status,$from,$from,$to,$to,$user_id));
				  return $rsltdata->row(0)->total;
		}
	}
	

}