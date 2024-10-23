<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Cronjob_apienable_disable_by_timer extends CI_Controller 
{
    public function index()
	{
		$this->load->model("Api_model");
		$this->load->model("Update_methods");
		$api_info = $this->db->query("SELECT * FROM api_configuration order by Id");
		foreach($api_info->result() as $rw)
		{
			$api_time_from = $rw->api_time_from;
			$api_time_to = $rw->api_time_to;
			$api_id = $rw->Id;
			$api_name = $rw->api_name;
			
			$min_balance_limit = $rw->min_balance_limit;
			$balance = $this->Api_model->getBalance($api_id);
			$this->Update_methods->apibalanceloging($api_name,$balance);

			
			if($api_time_from == "00:00:00" or $api_time_to == "00:00:00")
			{

			}
			else
			{
				$current_time = date_format(date_create($this->common->getDate()),'H:i:s');
				//echo $api_time_from ."        ".$api_time_to."      ".$current_time;
				if($current_time >= $api_time_from  and $current_time <= $api_time_to)
				{
						
						$this->db->query("update api_configuration set enable_recharge = 'yes' where Id = ?",array($api_id));
				}
				else
				{
						$this->db->query("update api_configuration set enable_recharge = 'no' where Id = ?",array($api_id));
						
				}

				
				echo "<hr>";
			}

		}
		echo "DONE";exit;
	}
}