<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils extends CI_Controller {
	
	
	
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
	private function checkpendinglimit()
	{
		$rslt = $this->db->query("select a.api_id,a.totalpending,b.api_name,c.company_name from operatorpendinglimit a 
		left join tblapi b on a.api_id = b.api_id 
		left join tblcompany c on a.company_id = c.company_id
		where a.totalpending >= a.pendinglimit and a.totalpending > 0 and a.pendinglimit > 0 and a.status = 1 and a.api_id > 0");
		foreach($rslt->result() as $rw)
		{
			$msg = $rw->api_name." (".$rw->company_name." ) : ".$rw->totalpending;
			$rsltcheck = $this->db->query("select count(Id) as total from tblnotification where message = ? and is_unread = 'yes'",array($msg));
			if($rsltcheck->row(0)->total == 0)
			{
			//$this->db->query("insert into tblnotification(title,message,messagefor,add_date,ipaddress) values(?,?,?,?,?)",array("PENDING LIMIT",$msg,"Admin",$this->common->getDate(),$this->common->getRealIpAddr()));
			}
			
		}
	}
	
	public function getNotifications()
	{
	
		$this->checkpendinglimit();
	
		if(isset($_GET["notification_for"]))
		{
			$rsltnotifications = $this->db->query("select * from tblnotification where is_unread = 'yes' and messagefor = 'Admin' order by Id desc");
		
			$resp = '';
			foreach($rsltnotifications->result() as $rwnotification)
			{
			    $host_id = $rwnotification->host_id;
			    $host_name = $this->Common_methods->getHostName($host_id);
				$resp.= '
				<a href="#" onClick="updatenotificationasread('.$rwnotification->Id.')">
					<div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
					<div class="mail-contnet">
						<span style="color:#000000;font-size:12px;">'.$rwnotification->title.'</span> <h6 class="">'.$rwnotification->message.'</h6><h5>'.$host_name.'</h5><span class="time">'.$rwnotification->add_date.'</span> </div>
				</a>';
			}
			echo '<input type="hidden" id="hidnotificationcount" value="'.$rsltnotifications->num_rows().'">'.$resp;exit;
		}
	}
	
	public function getNotificationMarkAsRead()
	{
		if(isset($_GET["notification_id"]))	
		{
			$notification_id = $_GET["notification_id"];
			
			$this->db->query("update tblnotification set is_unread = 'no',read_date = ? where Id = ?",array($this->common->getDate(),$notification_id));
			echo "Notification Marked Ad Read Successfully";exit;
		}
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
		} 
	}	
}