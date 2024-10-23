<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rechargecommission_cron extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function getpreviousdate()
	{
		$date = $this->common->getMySqlDate();
		$date1 = str_replace('-', '/', $date);
		$preciusday = date('Y-m-d',strtotime($date1 . "-1 days"));
		return date_format(date_create($preciusday),'Y-m-d');
	}
	public function checkduplicate($user_id,$transaction_date)
    {
    	$add_date = $this->common_>getDate();
    	$ip =$this->common->getRealIpAddr();
    	$rslt = $this->db->query("insert into recharge_commission_preventduplication (user_id,transaction_date,ipaddress,add_date) values(?,?,?,?)",
    	array($user_id,$transaction_date,$ip,$add_date));
    	  if($rslt == "" or $rslt == NULL)
    	  {
    	  	return false;
    	  }
    	  else
    	  {
    	  	return true;
    	  }
    }
	public function index()  
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 



        // $this->getpreviousdate();
        
        $str = '<table border=1 style="border-collapse: collapse">';
            $str .= '<tr>';
                $str .= '<td>Name</td>';
                $str .= '<td>UserName</td>';
                $str .= '<td>Transaction Date</td>';
                $str .= '<td>TotalSuccess</td>';
                $str .= '<td>Total Commission</td>';
                
            $str .= '</tr>';
            
            
            
        $transaction_date = $this->getpreviousdate();
        
		$strrslt = $this->db->query("
		            SELECT 
		                
		                Sum(a.amount) as totalAmount,
		                Sum(a.DComm) as totalDCommAmount,
		                c.businessname,
		                c.username,
		                c.usertype_name,
		                c.user_id as parentid
		                FROM `tblrecharge` a 
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers c on b.parentid = c.user_id
                        where 
                        Date(a.add_date) = ? and 
                        a.recharge_status = 'Success'
                        group by c.user_id
                        order by a.recharge_id  desc",array($transaction_date));
               
        foreach($strrslt->result() as $rw)
        {
            $parentid = $rw->parentid;
            $totalAmount = $rw->totalAmount;
            $username = $rw->username;
            $businessname = $rw->businessname;
            $dist_commission = $rw->totalDCommAmount;;
            
            if($this->checkduplicate($parentid,$transaction_date) == false)
           // if(false)
    		{
    			
    		}
    		else
    		{
    		    
    		    
    		     $str .= '<tr>';
                    $str .= '<td>'.$businessname.'</td>';
                    $str .= '<td>'.$username.'</td>';
                    $str .= '<td>'.$transaction_date.'</td>';
                    $str .= '<td>'.$totalAmount.'</td>';
                    $str .= '<td>'.$dist_commission.'</td>';
                    
                $str .= '</tr>';
    		    $rsltinsert = $this->db->query("insert into recharge_distcommission(add_date,ipaddress,user_id,transaction_date,TotalSuccess,totalcommission,commission_type,commission_given,ewallet_id) 
    		    values(?,?,?,?,?,?,?,?,?)",
    		    array($this->common->getDate(),$this->common->getRealIpAddr(),$parentid,$transaction_date, $totalAmount,$dist_commission,"RECHARGE","no",""));
    		    if($rsltinsert == true)
    		    {
    		        $insert_id = $this->db->insert_id();
    		        $cr_user_id = $parentid;
        		    $dr_user_id = 1;
        		    $amount = $dist_commission;
        		    $remark = "Recharge Commission";
        		    $description = "Recharge Incentive Date : ".$transaction_date ." Total Recharge :  ".$totalAmount;
        		    $payment_type = "CASH";
    		        $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
    		    }
    		    
    		}
    		
        }
        $str .= '</table>';
    		echo $str;exit;
	}	

}