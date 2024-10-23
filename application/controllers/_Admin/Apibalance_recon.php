<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Apibalance_recon extends CI_Controller {
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
		if($this->input->post("txtDate") and $this->input->post("ddlapi"))
		{
	
			$txtDate = $this->input->post("txtDate");
			$ddlapi = $this->input->post("ddlapi");
			$txtOpening = $this->input->post("txtOpening");
			$txtPurchase = $this->input->post("txtPurchase");
			$txtPurchaseRet = $this->input->post("txtPurchaseRet");
			$txtTotalrec = $this->input->post("txtTotalrec");
			$txtTotalComm = $this->input->post("txtTotalComm");
			
			$txtClossing = $this->input->post("txtClossing");
			$txtCalcClossing = $this->input->post("txtCalcClossing");
			$txtDiff = $this->input->post("txtDiff");
			$txtremark = $this->input->post("txtremark");
			
			
			$this->db->query("insert into tblapirecon(Date,api_id,add_date,edit_date,ipaddress,opening,purchase,revert_purchase,recharge_total,commission_received,closing,calc_closing,difference,remark) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?) ",array($txtDate ,$ddlapi,$this->common->getDate(),$this->common->getDate(),$this->common->getRealIpAddr(),$txtOpening,$txtPurchase,$txtPurchaseRet,$txtTotalrec,$txtTotalComm,$txtClossing,$txtCalcClossing,$txtDiff,$txtremark));
			$this->view_data["message"] = "";
			$this->load->view("_Admin/apibalance_recon_view",$this->view_data);
		}
		else 		
		{
			$this->view_data["message"] = "";
			$this->load->view("_Admin/apibalance_recon_view",$this->view_data);
		} 

	}
	public function getvalues()
	{
		if(isset($_GET["date"]) and isset($_GET["imid"]))
		{
			$date = trim($_GET["date"]);
			$imid = trim($_GET["imid"]);
			$opening = 0;
			$closing = 0;
			$totalrecharge = 0;
			$totalcommission = 0;
			$rsltopening = $this->db->query("select * from tblapiclosingbalance where Date(add_date) = ?",array($date));
			if($rsltopening->num_rows() == 1)
			{
				if($imid == 1)
				{
					$opening =  $rsltopening->row(0)->jupiter;
				}
				if($imid == 2)
				{
					$opening =  $rsltopening->row(0)->ss;
				}
				if($imid == 4)
				{
					$opening =  $rsltopening->row(0)->in7;
				}
				if($imid == 5)
				{
					$opening =  $rsltopening->row(0)->arena;
				}
				else if($imid == 6)
				{
					$opening =  $rsltopening->row(0)->cyber;
				}
				else if($imid == 7)
				{
					$opening =  $rsltopening->row(0)->ru;
				}
			}
			$rsltclosing = $this->db->query("select * from tblapiclosingbalance where Date(add_date) > ? order by Id limit 1",array($date));
			if($rsltclosing->num_rows() == 1)
			{
				if($imid == 1)
				{
					$closing =  $rsltclosing->row(0)->jupiter;
				}
				if($imid == 2)
				{
					$closing =  $rsltclosing->row(0)->ss;
				}
				if($imid == 4)
				{
					$closing =  $rsltclosing->row(0)->in7;
				}
				if($imid == 5)
				{
					$closing =  $rsltclosing->row(0)->arena;
				}
				else if($imid == 6)
				{
					$closing =  $rsltclosing->row(0)->cyber;
				}
				else if($imid == 7)
				{
					$closing =  $rsltclosing->row(0)->ru;
				}
				$rslt_recharge = $this->db->query("select Sum(a.amount) as total,Sum(totalcommamt) as totalcommission from tblrecharge a left join tblapi b on a.ExecuteBy = b.api_name where a.recharge_status = 'Success' and b.api_id = ? and Date(a.add_date) = ?",array($imid,$date));
				if($rslt_recharge->num_rows() == 1)
				{
					$totalrecharge = $rslt_recharge->row(0)->total;
					$totalcommission = $rslt_recharge->row(0)->totalcommission;
				}
				echo $opening."#".$totalrecharge."#".$totalcommission."#".$closing;
				
			}
			
		}
		
	}	
}