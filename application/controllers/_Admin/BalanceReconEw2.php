<?php
class BalanceReconEw2 extends  CI_Controller 
{   
    function _construct()
    {
          // Call the Model constructor
          parent::_construct();
    }
    
    public function index()
    {
    
    
        if($this->input->post("btnSubmit"))
        {
            error_reporting(-1);
            ini_set('display_errors',1);
            $this->db->db_debug = TRUE;
            
            
            $date = $this->input->post("txtDate");
            ini_set('memory_limit', '-1');
            //$date = $this->common->getpreviousdate();
            
            $from = $date;
            $to = $date;
        
            $data = array();
            $user_array = array();
            $username_array = array();
            $usertype_array = array();
            $businessname_array = array();
            

            $userarray = $this->db->query("select user_id from tblusers where usertype_name != 'Admin' ");

            foreach($userarray->result() as $rwuser)
            {
                $opening_balance_rslt = $this->db->query("select balance from tblewallet2 where user_id = ? and Date(add_date) < ? order by Id desc limit 1",array($rwuser->user_id,$from));
               
                if($opening_balance_rslt->num_rows() == 1)
                {
                    $rsltoptrdistgrpc[$rwuser->user_id]["OPENING"] = $opening_balance_rslt->row(0)->balance;
                }
            }
            
            
            foreach($userarray->result() as $rwuser_clossing)
            {
                $clossing_balance_rslt = $this->db->query("select balance from tblewallet2 where user_id = ? and Date(add_date) <= ? order by Id desc limit 1",array($rwuser_clossing->user_id,$from));
               
                if($clossing_balance_rslt->num_rows() == 1)
                {
                    $rsltoptrdistgrpc[$rwuser_clossing->user_id]["CLOSING"] = $clossing_balance_rslt->row(0)->balance;
                }
            }
            
            
            
            
                $rslt_paymentcrdr = $this->db->query("SELECT 
        Sum(a.credit_amount) as total_credit_payment,
        Sum(a.debit_amount) as total_debit_payment,
        b.businessname,b.username,b.usertype_name,b.user_id FROM `tblewallet2` a 
        left join tblusers b on a.user_id = b.user_id
        where a.transaction_type = 'PAYMENT' and Date(a.add_date) >= ? and Date(a.add_date) <= ?
        group by b.user_id",array($from,$to));
                            foreach($rslt_paymentcrdr->result() as $rw)
                            {
                                $username_array[$rw->user_id] = $rw->username;
                                $businessname_array[$rw->user_id] = $rw->businessname;
                                $usertype_array[$rw->user_id] = $rw->usertype_name;
                                array_push($user_array,$rw->user_id);
                                $rsltoptrdistgrpc[$rw->user_id]["PAYMENT"]["CR"] = $rw->total_credit_payment;
                                $rsltoptrdistgrpc[$rw->user_id]["PAYMENT"]["DR"] = $rw->total_debit_payment;
                            }
            
            $rsltoptrdistgrp =  $this->db->query("select 
                            count(a.recharge_id) as totalcount, 
                            Sum(a.amount) as Total,
                            Sum(a.commission_amount) as Commission,
                            b.username,b.businessname,b.usertype_name,
                            a.user_id
                            
                            from tblrecharge a 
                            left join tblusers b on a.user_id = b.user_id
                            where 
                            Date(a.add_date) >=? and 
                            Date(a.add_date) <=? and 
                            a.recharge_status = 'Success' 
                            group by a.user_id",array($from,$to));
                    
                            $dataarr = array();
                            if($rsltoptrdistgrp != NULL)
                            {
                                if($rsltoptrdistgrp->num_rows() > 0)
                                {
                                    foreach($rsltoptrdistgrp->result() as $rw)
                                    {
                                        
                                        $username_array[$rw->user_id] = $rw->username;
                                        $businessname_array[$rw->user_id] = $rw->businessname;
                                        $usertype_array[$rw->user_id] = $rw->usertype_name;
                                        array_push($user_array,$rw->user_id);
                                        
                                        
                                        $rsltoptrdistgrpc[$rw->user_id]["RECHARGE"]["Total"] = $rw->Total;
                                        $rsltoptrdistgrpc[$rw->user_id]["RECHARGE"]["Commission"] =$rw->Commission;
                                        $rsltoptrdistgrpc[$rw->user_id]["RECHARGE"]["user_id"] = $rw->user_id;
                                        $rsltoptrdistgrpc[$rw->user_id]["RECHARGE"]["businessname"] = $rw->businessname;
                                        $rsltoptrdistgrpc[$rw->user_id]["RECHARGE"]["username"] = $rw->username;
                                    }
                                    
                                }
                            }
                        
                                
                                    
                                    
                    
                        
                        
                       
                    $user_array = array_unique($user_array);
                    //$businessname_array = array_unique($businessname_array);
                    //$username_array = array_unique($username_array);
                    //print_r($businessname_array);exit;
                    
                    
                    $usercount = count($user_array);
                    $banemcount = count($businessname_array);
                    //echo $usercount ."   ".$banemcount;exit;
                    
                    $sr = 1;
                    
                    $rsltuses = $this->db->query("SELECT 
    a.host_id,a.user_id,
    a.businessname,a.username,a.usertype_name,
    dist.businessname as dist_businessname,dist.username as dist_username,dist.usertype_name as dist_usertype_name,
    md.businessname as md_businessname,md.username as md_username,md.usertype_name as md_usertype_name
    FROM `tblusers` a 
    left join tblusers dist on a.parentid = dist.user_id
    left join tblusers md on dist.parentid = md.user_id
    where
    a.usertype_name != 'Admin'");
    
                    
                    
                    foreach($rsltuses->result() as $usr_row)
                    {
                        
                       
                        $usr = $usr_row->user_id;
                        
                        $bname = $usr_row->businessname;
                        $uname = $usr_row->username;
                        $usertype = $usr_row->usertype_name;
                        
                       
                        
                        $dist_bname = $usr_row->dist_businessname;
                        $dist_uname = $usr_row->dist_username;
                        $dist_usertype = $usr_row->dist_usertype_name;
                        
                        $md_bname = $usr_row->md_businessname;
                        $md_uname = $usr_row->md_username;
                        $md_usertype = $usr_row->md_usertype_name;
                        $host_name = $this->Common_methods->getHostName($usr_row->host_id);
                        
                        
                        $temparray = array(
                            "HostName"=>$host_name,
                            "businessname"=>$bname,
                            "username"=>$uname,
                            "usertype"=>$usertype,
                            "Dist.businessname"=>$dist_bname,
                            "Dist.username"=>$dist_uname,
                            "Dist.usertype"=>$dist_usertype,
                            "Md.businessname"=>$md_bname,
                            "Md.username"=>$md_uname,
                            "Md.usertype"=>$md_usertype,
                            );
                        
                        $grossrecharge = 0;
                        $grossrecharge_commission = 0;
                        $grossbill = 0;
                        $grossbill_commission = 0;
                        $grossdmt = 0;
                        $grossdmtcharge = 0;
                        if(isset($rsltoptrdistgrpc[$usr]["RECHARGE"]["Total"]))
                        {
                            $grossrecharge = $rsltoptrdistgrpc[$usr]["RECHARGE"]["Total"];
                            $grossrecharge_commission = $rsltoptrdistgrpc[$usr]["RECHARGE"]["Commission"];
                        }
                        if(isset($rsltoptrdistgrpc[$usr]["BILL"]["Total"]))
                        {
                            $grossbill = $rsltoptrdistgrpc[$usr]["BILL"]["Total"];
                            $grossbill_commission = $rsltoptrdistgrpc[$usr]["BILL"]["Commission"];
                        }
                        if(isset($rsltoptrdistgrpc[$usr]["DMT"]["Total"]))
                        {
                            $grossdmt = $rsltoptrdistgrpc[$usr]["DMT"]["Total"];
                            $grossdmtcharge = $rsltoptrdistgrpc[$usr]["DMT"]["Charge_amount"];
                        }
                        
                        $grosspurchase = 0;
                        $grosstransfer = 0;
                        if(isset($rsltoptrdistgrpc[$usr]["PAYMENT"]["CR"]))
                        {
                            $grosspurchase = $rsltoptrdistgrpc[$usr]["PAYMENT"]["CR"];
                            $grosstransfer = $rsltoptrdistgrpc[$usr]["PAYMENT"]["DR"];
                        }
                        
                        
                        $openingbalance = 0;
                        $clossingbalance = 0;
                        if(isset($rsltoptrdistgrpc[$usr]["OPENING"]))
                        {
                            $openingbalance = $rsltoptrdistgrpc[$usr]["OPENING"];
                        }
                        else
                        {
                            $getopening = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) < ? order by Id desc limit 1",array($usr,$from));
                            if($getopening->num_rows() == 1)
                            {
                                $openingbalance  = $getopening ->row(0)->balance;
                            }
                            else
                            {
                                $openingbalance = 0;
                            }
                        }
                        
                        
                        if(isset($rsltoptrdistgrpc[$usr]["CLOSING"]))
                        {
                            $clossingbalance = $rsltoptrdistgrpc[$usr]["CLOSING"];
                        }
                        
                        
                        
                        $accval_cr =  0;
                        $accval_dr =  0;
                        if(isset($rsltoptrdistgrpc[$usr]["DMTACCVAL"]["CR"]))
                        {
                            $accval_cr = $rsltoptrdistgrpc[$usr]["DMTACCVAL"]["CR"];
                        }
                        if(isset($rsltoptrdistgrpc[$usr]["DMTACCVAL"]["DR"]))
                        {
                            $accval_dr = $rsltoptrdistgrpc[$usr]["DMTACCVAL"]["DR"];
                        }
                        
                        
                        
                        $aeps_total =  0;
                        $aeps_commission =  0;
                        if(isset($rsltoptrdistgrpc[$usr]["AEPS"]["TOTAL"]))
                        {
                            $aeps_total = $rsltoptrdistgrpc[$usr]["AEPS"]["TOTAL"];
                        }
                        if(isset($rsltoptrdistgrpc[$usr]["AEPS"]["COMMISSION"]))
                        {
                            $aeps_commission = $rsltoptrdistgrpc[$usr]["AEPS"]["COMMISSION"];
                        }
                        
                        
                        
                        
                        
                        $temparray["Opening"]  =$openingbalance;
                        $temparray["PaymentPurchase"]  =$grosspurchase;
                        $temparray["PaymentTransfer"]  =$grosstransfer;
                        $temparray["TotalRecharge"]  =$grossrecharge;
                        //$temparray["TotalRechargeCommission +"]  = $grossrecharge_commission;
                        //$temparray["TotalBILL -"]  =$grossbill ;
                        //$temparray["TotalBILLCommission +"]  = $grossbill_commission;
                        
                         
                         $temparray["CLOSSING"]  =$clossingbalance;
                         
                         
                        $closingbalance_by_calculation = ($openingbalance + $grosspurchase  + $grossrecharge_commission) - ($grosstransfer + $grossrecharge );
                        $temparray["CLOSSING_By_CALCULATION"]  = $closingbalance_by_calculation;
                        
                        
                        $temparray["DIFF"]  =round($clossingbalance - $closingbalance_by_calculation);
                      // array_push($temparray,$totalcountarr);
                      // array_push($temparray,$TotalRechargearr);
                      // array_push($temparray,$TotalCommissionarr);
                        array_push( $data,$temparray);  
    
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
        else
        {
            $this->view_data["date"] = $this->common->getMySqlDate();
            $this->load->view("_Admin/BalanceReconEw2_view",$this->view_data);
        }
    
        
            
        
    }
    
}