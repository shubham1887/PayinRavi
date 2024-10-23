<?php
class Old_business_report extends  CI_Controller 
{   
    function _construct()
    {
          // Call the Model constructor
          parent::_construct();
    }
    
    public function index()
    {
        
            error_reporting(-1);
            ini_set('display_errors',1);
            $this->db->db_debug = TRUE;
            $data = array();
            
            $from = "2021-01-01";
            $to = "2021-01-31";
            ini_set('memory_limit', '-1');
                    
                    $rsltuses = $this->db->query("SELECT b.businessname,b.username,b.usertype_name,Sum(a.amount) as amount,Sum(a.commission_amount) as commission_amount FROM `tblrecharge` a left join tblusers b on a.user_id = b.user_id
where  a.recharge_status = 'Success' and Date(a.add_date) BETWEEN ? and ?
group by a.user_id order by b.businessname",array($from,$to));
    
                    
                    $i = 1;
                    foreach($rsltuses->result() as $usr_row)
                    {
                        
                        
                        $bname = $usr_row->businessname;
                        $uname = $usr_row->username;
                        $usertype = $usr_row->usertype_name;
                        if($usertype == "Agent" or $usertype == "Distributor" or $usertype == "MasterDealer")
                        {
                            $Qty = $usr_row->amount;
                            $commission_amount = (($Qty * 3.6)/100);
                            $Amount = $Qty  - $commission_amount;
                        }
                        else
                        {
                            $Qty = $usr_row->amount;
                            $commission_amount = $usr_row->commission_amount;
                            $Amount = $Qty  - $commission_amount;   
                        }

                        
                        
                       
                        
                        
                        $temparray = array(
                            "Sr"=>$i,
                            "DateRange"=>$from."<---->".$to,
                            "AgentName"=>$bname,
                            "UserId"=>$uname,
                            "UserType"=>$usertype,
                            "Qty"=>$Qty,
                            "Discount"=>$commission_amount,
                            "Amount"=>$Amount,
                            "GstStatus"=>"NotRegistered"
                            );
                        
                        
                        array_push( $data,$temparray);  
                        $i++;
                    }
                    
                    
                    
                //echo json_encode($data);exit;
                    
                    function filterData(&$str)
                    {
                        $str = preg_replace("/\t/", "\\t", $str);
                        $str = preg_replace("/\r?\n/", "\\n", $str);
                        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
                    }
                    
                    
                    
                    
                    
                    // file name for download
                    $fileName = "Distributor Invoice From ".$from." To  ".$to.".xls";
                    
                    // headers for download
                    header("Content-Disposition: attachment; filename=\"$fileName\"");
                    header("Content-Type: application/vnd.ms-excel");
                    
                    $flag = false;
                    foreach($data as $row) 
                    {
                        if(!$flag) 
                        {
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
    
}