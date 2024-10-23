<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrcommission_cron extends CI_Controller {
	
	
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
    	$rslt = $this->db->query("insert into mt3_dmrcommission_preventduplication (user_id,transaction_date,ipaddress,add_date) values(?,?,?,?)",
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
                $str .= '<td>TDS</td>';
                $str .= '<td>Description</td>';
                
            $str .= '</tr>';
            
            
            
        $transaction_date = $this->getpreviousdate();
        
        
		$strrslt = $this->db->query("
		            SELECT 
		                a.Id,
		                a.RemiterMobile,
		                a.AccountNumber,
		                a.IFSC,
		                Sum(a.Amount) as totalAmount,
		                a.dist_charge_amount,
		                a.Status,
		                c.businessname,
		                c.username,
		                c.usertype_name,
		                c.dmr_group,
		                info.tds,
		                c.user_id as parentid
		                FROM `mt3_transfer` a 
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers c on b.parentid = c.user_id
                        left join tblusers_info info on c.user_id = info.user_id
                        where 
                        Date(a.add_date) = ? and 
                        a.Status = 'SUCCESS' and a.API!='EKO_INDONEPAL'
                        group by c.user_id
                        order by a.Id  desc",array($transaction_date));
               
        foreach($strrslt->result() as $rw)
        {
            $parentid = $rw->parentid;
            $totalAmount = $rw->totalAmount;
            $username = $rw->username;
            $businessname = $rw->businessname;
            $dmr_group = $rw->dmr_group;
            $tds_per = $rw->tds;
            $tds_per  = 5;
            
            
            $rsltgroupcommission = $this->db->query("select * from mt3_group where Id = ?",array($dmr_group));
            if($rsltgroupcommission->num_rows() == 1)
            {
                $dist_charge_type = $rsltgroupcommission->row(0)->dist_charge_type;
                $dist_charge_value = $rsltgroupcommission->row(0)->dist_charge_value;
                if($dist_charge_type == "PER")
                {
                        $dist_commission = (($totalAmount * $dist_charge_value)/100);
                        $tds_amount = (($dist_commission * $tds_per) / 100);
                        $net_dist_commission = $dist_commission - $tds_amount;
                        if($this->checkduplicate($parentid,$transaction_date) == false)
                		{
                			
                		}
                		else
                		{
                		    $description = "DMR Comm. Date : ".$transaction_date .", ( ".$totalAmount." * $dist_charge_value  / 100 )  TDS : ".$tds_amount;
                		    
                		     $str .= '<tr>';
                                $str .= '<td>'.$businessname.'</td>';
                                $str .= '<td>'.$username.'</td>';
                                $str .= '<td>'.$transaction_date.'</td>';
                                $str .= '<td>'.$totalAmount.'</td>';
                                $str .= '<td>'.$net_dist_commission.'</td>';
                                $str .= '<td>'.$tds_amount.'</td>';
                                $str .= '<td>'.$description.'</td>';
                                
                            $str .= '</tr>';
                		    $rsltinsert = $this->db->query("insert into dmr3_distcommission(add_date,ipaddress,user_id,transaction_date,TotalSuccess,totalcommission,tds,commission_type,commission_given,ewallet_id) 
                		    values(?,?,?,?,?,?,?,?,?,?)",
                		    array($this->common->getDate(),$this->common->getRealIpAddr(),$parentid,$transaction_date, $totalAmount,$net_dist_commission,$tds_amount,"DMR","no",""));
                		    if($rsltinsert == true)
                		    {
                		        $insert_id = $this->db->insert_id();
                		        $cr_user_id = $parentid;
                    		    $dr_user_id = 1;
                    		    $amount = $net_dist_commission;
                    		    $remark = "DMR Commission";
                    		    $description = "DMRComm.Date:".$transaction_date .",(".$totalAmount." * ".$dist_charge_value." /100) TDS:".$tds_amount;
                    		    $payment_type = "CASH";
                		        $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
                		        //update date 2019-01-22
                		        $this->db->query("update mt3_transfer set dcom_given = 'yes' where DId = ? and Status = 'SUCCESS' and Date(add_date) = ? ",array($cr_user_id,$transaction_date));
                		    }
                		   
                		}
                }
            }
            
            
           
    		
        }
        $str .= '</table>';
    		echo $str;exit;
	}	
}