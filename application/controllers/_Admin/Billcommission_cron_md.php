<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billcommission_cron_md extends CI_Controller {
	
	
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
    	$rslt = $this->db->query("insert into bill_commission_preventduplication (user_id,transaction_date,ipaddress,add_date) values(?,?,?,?)",
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
                $str .= '<td>Total Bill Amount</td>';
                $str .= '<td>Commission</td>';
                $str .= '<td>Total TDS</td>';
                
            $str .= '</tr>';
            
            
        $transaction_date = $this->getpreviousdate();
       // $transaction_date = '2019-03-21';
        $rsltuser = $this->db->query("
        SELECT 
        Sum(a.bill_amount) as total, 
        Sum(a.md_commission) as commission,
        b.businessname,
        b.user_id,
        b.username,
        b.usertype_name,
        
        FROM `tblbills` a 
        left join tblusers b on a.user_id = b.MdId 
        
        where 
        Date(a.add_date) = ? and
        a.status = 'Success'  and
        a.bill_amount < 100000 
        group by m.user_id order by a.Id",array($transaction_date));
    	foreach($rsltuser->result() as $rw)
    	{
    	    
    	    $cr_user_id = $rw->user_id;
		    $dr_user_id = 1;
		    
		    
		    
	        $commamount = $rw->commission;
	        $description = "Bill Comm ".$commamount." On ",$rw->total."";
		    
		    
		    $tds = 0;
		    $commamount_aftertds = round($commamount - $tds,2);
		    $remark = "BILL PAYMENT COMM.";
		    
		    $payment_type = "CASH";
		    if($this->checkduplicate($cr_user_id,$transaction_date) == false)
		   // if(false)
    		{
    			
    		}
    		else
    		{
    		    $rsltinsert = $this->db->query("insert into bill_distcommission(add_date,ipaddress,user_id,transaction_date,TotalSuccess,totalcommission,tds,commission_type,commission_given,ewallet_id) 
                		    values(?,?,?,?,?,?,?,?,?,?)",
                		    array($this->common->getDate(),$this->common->getRealIpAddr(),$cr_user_id,$transaction_date, $rw->total,$commamount_aftertds,$tds,"BILL","no",""));
    		    if($rsltinsert == true)
    		    //if(true)
    		    {
    		        //$insert_id = $this->db->insert_id();
    		        
        		    $amount = $commamount_aftertds;
        		    $remark = "BILL Payment Commission";
        		     
        		     
        		    
        		    $payment_type = "CASH";
    		        $this->Ew2->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
    		    }
    		}
		    
		    
	        //$this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
    	    $str .= '<tr>';
                $str .= '<td>'.$rw->businessname.'</td>';
                $str .= '<td>'.$rw->username.'</td>';
                 $str .= '<td>'.$rw->total.'</td>';
                $str .= '<td>'.$commamount_aftertds.'</td>';
                $str .= '<td>'.$tds.'</td>';
                $str .= '<td>'.$description.'</td>';
                
                
            $str .= '</tr>';
    	}
		$str .= '</table>';
		echo $str;exit;
	}	

}