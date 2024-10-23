<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class GetRecResponse extends CI_Controller {

	public function logentry($data)
	{

		$filename = "resp.txt";
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
    public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	public function index()
	{
	 $response = file_get_contents('php://input');
	 
	$rslt = serialize($this->input->post().'    here:'.$response);
	$rslt1 = serialize($this->input->get());
	
	$resp = json_encode($this->input->get());
	$this->logentry($response);
	
	$this->load->model("Errorlog");
	$insert_id = $this->Errorlog->httplog("Callback Url",$resp);
	
	
	
			
    //$resp = '{"refid":"417008","message":"MANGALAM:YOUR RECHAGRE FAIL AND REFUND trxid:26975218.ID Rs.10 to8768768768 FAIL.  Bal. 99,990 @02:08 R#417008#R"}';		
    			$rsltmessagesettings = $this->db->query("select * from message_setting");
    			foreach($rsltmessagesettings->result() as $r)
    			{
    				$status_word = $r->status_word;
    				$num_start = $r->number_start;
    				$num_end = $r->number_end;
    				$balance_start = $r->balance_start;
					$balance_end = $r->balance_end;
    				$operator_id_start = $r->operator_id_start;
    				$operator_id_end = $r->operator_id_end;
    				$status = $r->status;
    				$api_id = $r->api_id;
    				//echo $status_word;exit;
    				if (preg_match("/".$status_word."/",$resp) == 1)
    				{
    				    $mobile_no = $this->get_string_between($resp, $num_start, $num_end);
    					$operator_id = $this->get_string_between($resp, $operator_id_start, $operator_id_end);
    					$lapubalance = $this->get_string_between($resp, $balance_start, $balance_end);
    					$operator_id = str_replace("\n","",$operator_id);
    					$mobile_no = str_replace("\n","",$mobile_no);
    				//	echo $mobile_no."  ".$operator_id;exit;
    					$rsltrec = $this->db->query("select recharge_id,ExecuteBy from tblrecharge where mobile_no = ? and recharge_status = 'Pending' and Date(add_date) = ?",array(trim($mobile_no),$this->common->getMySqlDate()));
    					//print_r($rsltrec->result());exit;
    					if($rsltrec->num_rows() == 1)
    					{
    					        $apiinfo = $this->db->query("select api_id from tblapi where api_name = ?",array($rsltrec->row(0)->ExecuteBy));
        					    if($apiinfo->num_rows() == 1)
        					    {
        					        if($apiinfo->row(0)->api_id == $api_id)
        					        {
        					            $this->load->model("Update_methods");
            							$this->Update_methods->updateRechargeStatus($rsltrec->row(0)->recharge_id,$operator_id,$status,true,$lapubalance);
            							$this->db->query("update tblreqresp set recharge_id = ? where Id = ?",array($rsltrec->row(0)->recharge_id,$insert_id));
            							echo $status."  ".$operator_id;exit;
        					        }
        					       
        					    }		
    					}	
    				}
    			
    			}
        }
	}