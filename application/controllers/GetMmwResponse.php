<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetMmwResponse extends CI_Controller {
	
	
public function logentry($data)
	{
		$filename = "inlogs/mmw.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
    
	}	
	public function index() 
	{
		$getdata = serialize($this->input->get());
		$postdata = serialize($this->input->post());	
		$this->logentry("get : ".$getdata." POST : ".$postdata);

echo "helo";exit;
		if(isset($_GET["UniqueId"]) and isset($_GET["operatorId"]) and isset($_GET["Status"]) and isset($_GET["Amount"]))
		{
			$UniqueId = trim($this->input->get("UniqueId"));
			$operatorId = trim($this->input->get("operatorId"));
			$Status = trim($this->input->get("Status"));
			$Amount = trim($this->input->get("Amount"));
			echo "asdfs";exit;
			$rslt_txninfo = $this->db->query("select Id from mt3_transfer where Id = ? and Status = 'PENDING'",array($UniqueId));
			echo $rslt_txninfo->num_rows();exit;
			if($rslt_txninfo->num_rows() == 1)
			{
				if($Status == "2")
				{
					$data = array(
            					'RESP_statuscode' => "TXN",
            					'RESP_status' => "SUCCESS",
            					'RESP_ipay_id' => "",
            					'RESP_opr_id' =>$operatorId,
            					'message'=>"SUCCESS",
            					'Status'=>'SUCCESS',
            					'edit_date'=>$this->common->getDate()
            		);
            
            		$this->db->where('Id', $UniqueId);
            		$this->db->update('mt3_transfer', $data);
				}
			}
		}
		
	
	}
	
}