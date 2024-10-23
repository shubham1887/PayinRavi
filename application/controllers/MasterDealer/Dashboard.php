<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 

class Dashboard extends CI_Controller 

{

        

    private $msg='';

	function __construct()

    {

        parent:: __construct();

        $this->is_logged_in();

        $this->clear_cache();

    }

	function is_logged_in() 

    {

	 	if ($this->session->userdata('MdUserType') != "MasterDealer") 

		{ 

			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 

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

    		    		

				

			

				$this->view_data["message"]  = "";	

				$this->view_data["message"]  = ""; 

				$this->load->view("MasterDealer/Dashboard_view",$this->view_data);

			

			

		}

		public function getTodaysHourSale()

		{

			$user_id = $this->session->userdata("MdId");

			$hours = '';

			$total = 0;

			$totalcount = 0;

			$totalcharge = 0;

			$dbrslt = $this->db->query("SELECT count(Id) as totalcount,Sum(Amount) as sale,Sum(Charge_Amount) as totalcharge,add_date FROM `mt3_transfer` where Date(add_date) = ? and status = 'SUCCESS' and user_id = ? group by hour(add_date)  order by Id",array($this->common->getMySqlDate(),$user_id));

			foreach($dbrslt->result() as $rw)

			{

				$hours .=$rw->sale.",";

				$total +=floatval($rw->sale);

				$totalcount +=floatval($rw->totalcount);

				$totalcharge += floatval($rw->totalcharge);

			}

			$reaparray = array(

				"hourlysale"=>$hours,

				"totalsale"=>$total,

				"totalcount"=>$totalcount,

				"totalcharge"=>round($totalcharge,2),

			);

			echo json_encode($reaparray);exit;

		}

		public function getSummary()

		{

			$user_id = $this->session->userdata("MdId");

			$hours = '';

			$totalsuccess = 0;

			$totalpending = 0;

			$totalfailure = 0;

			$dbrslt = $this->db->query("SELECT count(Id) as totalcount,Sum(Amount) as sale,Status,Sum(Charge_Amount) as totalcharge,add_date FROM `mt3_transfer` where Date(add_date) = ?  and user_id = ? group by Status  order by Id",array($this->common->getMySqlDate(),$user_id));

			foreach($dbrslt->result() as $rw)

			{

				if($rw->Status == "SUCCESS")

				{

					$totalsuccess += floatval($rw->sale);

				}	

				if($rw->Status == "FAILURE")

				{

					$totalfailure += floatval($rw->sale);

				}

				if($rw->Status == "PENDING")

				{

					$totalpending += floatval($rw->sale);

				}

			}

			$reaparray = array(

				"SUCCESS"=>$totalsuccess,

				"PENDING"=>$totalpending,

				"FAILURE"=>$totalfailure,

				"BALANCE"=>$this->Common_methods->getAgentBalance($user_id)

			);

			echo json_encode($reaparray);exit;

		}

		

		

		public function getLastTransactions()

		{

			$resp = '<table class="table table-responsive mg-b-0 tx-12" style="color:#000000">

                <thead>

                  <tr class="tx-10">

                    <th class="pd-y-5">Id</th>

					<th class="pd-y-5">OrderId</th>

					<th class="pd-y-5">Remitter</th>

                    <th class="pd-y-5">Account</th>

					<th class="pd-y-5">IFSC</th>

                    <th class="pd-y-5">Amount</th>

					<th class="pd-y-5">DebitAmount</th>

					<th class="pd-y-5">CreditAmount</th>

                    <th class="pd-y-5">Status</th>

                    <th class="pd-y-5">Date</th>

                  </tr>

                </thead>

                <tbody>';

			$user_id = $this->session->userdata("MdId");

			$rsltreport = $this->db->query("SELECT a.Id,a.order_id,a.add_date,a.edit_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,

a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,

a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,

a.RESP_statuscode,a.RESP_opr_id,a.RESP_status,a.RESP_name





FROM `mt3_transfer` a

 where Date(a.add_date) = ? and a.user_id = ? order by Id desc limit 10",array($this->common->getMySqlDate(),$user_id));

			foreach($rsltreport->result() as $rw)

			{

			

				if($rw->Status == "SUCCESS")

				{

					$sclass = "success";

				}

				if($rw->Status == "FAILURE")

				{

					$sclass = "danger";

				}

				if($rw->Status == "PENDING")

				{

					$sclass = "primary";

				}

				$resp.= '<tr>

                    <td class="pd-l-20">

                      '.$rw->Id.'

                    </td>

					<td class="pd-l-20">

                      '.$rw->order_id.'

                    </td>

					<td class="pd-l-20">

                      '.$rw->RemiterMobile.'

                    </td>

                    <td>

                      <span class="tx-inverse tx-14 tx-medium d-block">'.$rw->RESP_name.'</span>

                      <span class="tx-invers tx-11 tx-medium d-block">Acc: '.$rw->AccountNumber.'</span>

                      <span class=" tx-invers tx-11 tx-medium d-block">TRANSID: '.$rw->RESP_opr_id.'</span>

                    </td>

					<td class="tx-12">

						'.$rw->IFSC.'

                    </td>

                    <td class="tx-12">

						'.$rw->Amount.'

                    </td>

					<td class="tx-12">

						'.$rw->debit_amount.'

                    </td>

					<td class="tx-12">

						'.$rw->credit_amount.'

                    </td>

                    <td class="tx-12">

                      <span class="square-8 bg-'.$sclass.' mg-r-5 rounded-circle"></span>'.$rw->Status.'

                    </td>

                    <td>'.$rw->add_date.'</td>

                  </tr>';	

			}

			$resp.= '</table>';

			echo $resp;exit;

		}

		

		

		public function getBalance()

		{

			echo $this->Common_methods->getAgentBalance($this->session->userdata("MdId"))."#".$this->Ew2->getAgentBalance($this->session->userdata("MdId"));

		}

	}