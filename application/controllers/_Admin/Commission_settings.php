<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commission_settings extends CI_Controller {
    
    
    private $msg='';
    function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
    function is_logged_in() 
    {

       if($this->session->userdata('aloggedin') != TRUE) 
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
        $this->load->model("Commission");   
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;
                
    }
    public function pageview()
    { 
        $rslt = $this->db->query("select company_id,company_name from tblcompany");
        $this->view_data['result_company'] = $rslt;
        $this->view_data['message'] =$this->msg;
        $this->load->view('_Admin/groupapi_view',$this->view_data);     
    }
    
    

    public function index() 
    {
        
        if(isset($_GET["act"]) and isset($_GET["id"]))
        {
            $group_id = intval(trim($_GET["id"]));
            $group_info = $this->db->query("select * from tblgroup where Id = ?",array($group_id));
            $data_array = array();
            $service_array = array();
            $operator_rslt = $this->db->query("
            select 
            a.company_id,
            a.company_name,
            a.mcode,
            a.service_id,
            b.service_name,
            IFNULL(g.commission_per,0.00) as commission_per,
            IFNULL(g.CommissionAmount,0.00) as CommissionAmount,
            IFNULL(g.Charge_per,0.00) as Charge_per,
            IFNULL(g.Charge_amount,0.00) as Charge_amount,

            g.commission_type,
            g.commission_slab
            from tblcompany a 
            left join tblservice b on a.service_id = b.service_id 
            left join tblgroupapi g on g.group_id = ? and a.company_id = g.company_id
            
            order by service_id,a.company_name",array($group_id));
            foreach($operator_rslt->result() as $rw)
            {
                if(!isset($data_array[$rw->service_name]))
                {
                     $data_array[$rw->service_name] = array();
                }
               
                array_push( $service_array,$rw->service_name);
                array_push( $data_array[$rw->service_name],$rw);
               // $data_array[$rw->service_name][$rw->company_id] = $rw;
            }
            $service_array = array_unique($service_array);
            
            //print_r($data_array);exit;
            $this->view_data["data"]  = $data_array;
             $this->view_data["group_info"]  = $group_info;
            $this->view_data["group_id"]  = $group_id;
             $this->view_data["service_array"]  = $service_array;
            $this->load->view("_Admin/commission_settings_view",$this->view_data);  
        }
        else if(isset($_POST["btnsearch"]))
        {
           $ddlgroup = intval($this->input->post("ddlgroup"));
           if($ddlgroup > 0)
           {
                $data_array = array();
                $service_array = array();
                $operator_rslt = $this->db->query("select a.company_id,a.company_name,a.mcode,a.service_id,b.service_name from tblcompany a left join tblservice b on a.service_id = b.service_id order by service_id");
                foreach($operator_rslt->result() as $rw)
                {
                    if(!isset($data_array[$rw->service_name]))
                    {
                         $data_array[$rw->service_name] = array();
                    }
                   
                    array_push( $service_array,$rw->service_name);
                    array_push( $data_array[$rw->service_name],$rw);
                   // $data_array[$rw->service_name][$rw->company_id] = $rw;
                }
                $service_array = array_unique($service_array);
                
                //print_r($data_array);exit;
                $this->view_data["data"]  = $data_array;
                 $this->view_data["service_array"]  = $service_array;
                $this->load->view("_Admin/commission_settings_view",$this->view_data);  
           }
           else
           {
                $data_array = array();
                $service_array = array();
                $operator_rslt = $this->db->query("select a.company_id,a.company_name,a.mcode,a.service_id,b.service_name from tblcompany a left join tblservice b on a.service_id = b.service_id order by service_id");
                foreach($operator_rslt->result() as $rw)
                {
                    if(!isset($data_array[$rw->service_name]))
                    {
                         $data_array[$rw->service_name] = array();
                    }
                   
                    array_push( $service_array,$rw->service_name);
                    array_push( $data_array[$rw->service_name],$rw);
                   // $data_array[$rw->service_name][$rw->company_id] = $rw;
                }
                $service_array = array_unique($service_array);
                
                //print_r($data_array);exit;
                $this->view_data["data"]  = $data_array;
                 $this->view_data["service_array"]  = $service_array;
                $this->load->view("_Admin/commission_settings_view",$this->view_data);  
           }
           
        }
        else
        {
            $data_array = array();
            $service_array = array();
            $operator_rslt = $this->db->query("
            select 
            a.company_id,
            a.company_name,
            a.mcode,
            a.service_id,
            b.service_name,
            g.commission_per,
            g.commission_type,
            g.commission_slab
            from tblcompany a 
            left join tblservice b on a.service_id = b.service_id 
            left join tblgroupapi g on g.Id = ? and a.company_id = g.company_id
            order by service_id",array());
            foreach($operator_rslt->result() as $rw)
            {
                if(!isset($data_array[$rw->service_name]))
                {
                     $data_array[$rw->service_name] = array();
                }
               
                array_push( $service_array,$rw->service_name);
                array_push( $data_array[$rw->service_name],$rw);
               // $data_array[$rw->service_name][$rw->company_id] = $rw;
            }
            $service_array = array_unique($service_array);
            
            //print_r($data_array);exit;
            $this->view_data["data"]  = $data_array;
             $this->view_data["service_array"]  = $service_array;
            $this->load->view("_Admin/commission_settings_view",$this->view_data);  
        }
       
    }
    function ChangeCommission()
    {
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;

        $objarray = $_POST["params"];
        $group_id =  intval($_POST["group_id"]);
        $groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($group_id));
        if($groupinfo->num_rows() == 1)
        {
            $company_rslt = $this->db->query("select company_id,company_name from tblcompany order by company_name");
            foreach($company_rslt->result() as $rwcomp)
            {
                $company_id = $rwcomp->company_id;
                if(isset($objarray[$rwcomp->company_id]))
                {
                    $paramrslt = $objarray[$rwcomp->company_id];
                   if( preg_match('/@/',$paramrslt) == 1)
                   {
                       $param_arr = explode("@",$paramrslt);
                       if(count($param_arr) == 6)
                       {
                          $commission =  floatval($param_arr[0]);
                          $commission_type =  $param_arr[1];
                          $commission_slab =  intval($param_arr[2]);

                          $CommAmt =  floatval($param_arr[3]);
                          $ChargePer =  floatval($param_arr[4]);
                          $ChargeAmt =  floatval($param_arr[5]);

                          $rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
                        if($rslt->num_rows() > 0)
                        {
                            $insertgroupapi = $this->db->query("update tblgroupapi set commission_per=?,CommissionAmount=?,Charge_per=?,Charge_amount=?,commission_type=?,commission_slab = ? where group_id = ? and company_id = ?",array($commission,$CommAmt,$ChargePer,$ChargeAmt,$commission_type, $commission_slab,$group_id,$company_id));
                        }
                        else
                        {
                            $this->db->query("delete from tblgroupapi  where group_id = $group_id and company_id = $company_id");
                            $this->db->query("insert into tblgroupapi(company_id,commission_per,CommissionAmount,Charge_per,Charge_amount,commission_type,commission_slab,group_id,add_date,ipaddress) values(?,?,?,?,?,?,?,?,?,?)",array($company_id,$commission,$CommAmt,$ChargePer,$ChargeAmt,$commission_type, $commission_slab,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
                        }   
                          
                       }
                   }
                }
            }
        }
        
        echo "Commission Set Successfully";exit;
    }
    public function changecommissionodl()
    {
        $comm = $_GET["com"];
        $mincom = $_GET["mincom"];
        $maxcom = $_GET["maxcom"];
        $comtype = $_GET["comtype"];
        $group_id = $_GET["groupid"];
        $company_id = $_GET["company_id"];
        $rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
        if($rslt->num_rows() > 0)
        {
            
            $insertgroupapi = $this->db->query("update tblgroupapi set commission_per=?,min_com_limit = ?,max_com_limit = ?,commission_type=? where group_id = ? and company_id = ?",array($comm,$mincom,$maxcom,$comtype,$group_id,$company_id));
            
            echo true;
        }
        else
        {
            $this->db->query("delete from tblgroupapi  where group_id = $group_id and company_id = $company_id");
            $this->db->query("insert into tblgroupapi(company_id,commission_per,min_com_limit,max_com_limit,commission_type,group_id,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($company_id,$comm,$mincom,$maxcom,$comtype,$group_id,$this->common->getDate(),$this->common->getRealIpAddr()));
            echo true;
        }
        
    }
    public function changeapi()
    {
        $company_id = $_GET["company_id"];
        $api_id = $_GET["api_id"];
        $group_id = $_GET["group_id"];
        $rslt = $this->db->query("select * from tblgroupapi where group_id = $group_id and company_id = $company_id");
        if($rslt->num_rows() > 0)
        {
            $str_qry ="update tblgroupapi set api_id=? where group_id = $group_id and company_id = ?";
            $insertgroupapi = $this->db->query($str_qry,array($api_id,$company_id));
            echo true;
        }
        
    }
    private function changeusercommission($group_id,$commission,$company_id)
    {
    
            
            $rsltusers = $this->db->query("select user_id from tblusers where scheme_id = ?",array($group_id));
            foreach($rsltusers->result() as $user)
            {
                $check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($user->user_id, $company_id));
                if($check_rslt->num_rows()  == 1)
                {
                
                    $rslt = $this->db->query("update tbluser_commission set commission = ? where Id = ?",array($commission,$check_rslt->row(0)->Id));
                }
                else
                {
                    $this->db->query("delete from tbluser_commission where user_id = ? and company_id = ?",array($user->user_id, $company_id));
                    $add_date = $this->common->getDate();
                    $str_qry = "insert into tbluser_commission(user_id,company_id,commission,add_date) values( ? , ?, ? , ?)";
                    $rslt_in = $this->db->query($str_qry,array($user->user_id,$company_id,$commission,$add_date));
                }   
            }   
        }

    public function getAepsSlabList()
    {

            $str = '<table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount Range</th>
                                        <th>Commission</th>
                                        <th>Max Commission</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';



        if(isset($_POST["group_id"]))
        {
            $i=1;
            $group_id = intval($this->input->post("group_id"));
            $rslt = $this->db->query("SELECT Id,group_id,range_from,range_to,commission,commission_type,max_commission,type FROM `aeps_slab` where group_id = ?",array($group_id));
            foreach($rslt->result() as $rw)
            {
                $comm_type = '%';
                $commission_type = $rw->commission_type;
                if($commission_type == "AMOUNT")
                {
                    $comm_type = '';
                }
                $aeps_type = "";
                if($rw->type == "W")
                {
                    $aeps_type = "Cash Withdrawal";
                }
                if($rw->type == "B")
                {
                    $aeps_type = "Balance Inquiry";
                }
                if($rw->type == "S")
                {
                    $aeps_type = "Mini Statement";
                }


                $str.='<tr>';
                    $str .='<td>'.$i.'</td>';
                     $str .='<td><span id="amountrange_'.$rw->Id.'">'.$rw->range_from.' - '.$rw->range_to.'</span></td>';
                     $str .='<td><span id="commission_'.$rw->Id.'">'.$rw->commission.' '.$comm_type.'</span></td>';
                     $str .='<td><span id="max_commission_'.$rw->Id.'">'.$rw->max_commission.'</span></td>';
                     $str .='<td><span id="aeps_type_'.$rw->Id.'">'.$aeps_type.'</span></td>';
                     $str .='<td>
                                 <a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="AepsSlabDeleteConfirmation('.$rw->Id.')">Delete</a>
                            </td>';
                    
                $str.='</tr>';   
            $i++;
            }
            $str.='<tr></tbody>
                            </table>';

            echo $str;exit;
        }
    }
    public function deleteAepsSlab()
    {
        if(isset($_POST["Id"]))
        {
            $Id = intval($this->input->post("Id"));
            $this->db->query("delete from aeps_slab where Id  = ?",array($Id));
            echo "ok";exit;
        }
    }
    public function AddAepsSlab()
    {

            ini_set('display_errors',1);
            error_reporting(-1);
            $this->db->db_debug = TRUE;
        if(isset($_POST["group_id"]) and isset($_POST["amount_from"]) and isset($_POST["amount_to"]) and isset($_POST["aeps_commission"])  and isset($_POST["maxcommission"]))
        {
            $group_id = intval($this->input->post("group_id"));
            $amount_from = intval($this->input->post("amount_from"));
            $amount_to = intval($this->input->post("amount_to"));
            $aeps_commission = floatval($this->input->post("aeps_commission"));
            $commission_type = $this->input->post("commission_type");
            $maxcommission = intval($this->input->post("maxcommission"));
            $aeps_type = $this->input->post("aeps_type");
            
            $this->db->query("insert into aeps_slab(group_id,range_from,range_to,commission_type,commission,max_commission,add_date,ipaddress,type) values(?,?,?,?,?,?,?,?,?)",array($group_id,$amount_from,$amount_to,$commission_type,$aeps_commission,$maxcommission,$this->common->getDate(),$this->common->getRealIpAddr(),$aeps_type));
            echo "OK";exit;
        }
    }






    public function getPayoutSlabList()
    {

            $str = '<table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount Range</th>
                                        <th>Imps Charge</th>
                                        <th>Neft Charge</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';



        if(isset($_POST["group_id"]))
        {
            $i=1;
            $group_id = intval($this->input->post("group_id"));
            $rslt = $this->db->query("SELECT Id,group_id,range_from,range_to,charge_value,neft_charge_value,charge_type FROM `payout_slab` where group_id = ?",array($group_id));
            foreach($rslt->result() as $rw)
            {
                $chrg_type = '%';
                $charge_type = $rw->charge_type;
                if($charge_type == "AMOUNT")
                {
                    $chrg_type = '';
                }
                $str.='<tr>';
                    $str .='<td>'.$i.'</td>';
                     $str .='<td><span id="amountrange_'.$rw->Id.'">'.$rw->range_from.' - '.$rw->range_to.'</span></td>';
                     $str .='<td><span id="payoutcharge_'.$rw->Id.'">'.$rw->charge_value.' '.$chrg_type.'</span></td>';
                     $str .='<td><span id="payoutchargeneft_'.$rw->Id.'">'.$rw->neft_charge_value.' '.$chrg_type.'</span></td>';
                     $str .='<td>
                                 <a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="PayoutSlabDeleteConfirmation('.$rw->Id.')">Delete</a>
                            </td>';
                $str.='</tr>';   
            $i++;
            }
            $str.='<tr></tbody>
                            </table>';

            echo $str;exit;
        }
    }
    public function deletePayoutSlab()
    {
        if(isset($_POST["Id"]))
        {
            $Id = intval($this->input->post("Id"));
            $this->db->query("delete from payout_slab where Id  = ?",array($Id));
            echo "ok";exit;
        }
    }
    public function AddPayoutSlab()
    {

            ini_set('display_errors',1);
            error_reporting(-1);
            $this->db->db_debug = TRUE;
        if(isset($_POST["group_id"]) and isset($_POST["amount_from"]) and isset($_POST["amount_to"]) and isset($_POST["payout_charge"])  and isset($_POST["payout_neftcharge"]))
        {
            $group_id = intval($this->input->post("group_id"));
            $amount_from = intval($this->input->post("amount_from"));
            $amount_to = intval($this->input->post("amount_to"));
            $payout_charge = floatval($this->input->post("payout_charge"));
            $charge_type = $this->input->post("charge_type");
            $payout_neftcharge = intval($this->input->post("payout_neftcharge"));
            
            $this->db->query("insert into payout_slab(group_id,range_from,range_to,charge_type,charge_value,neft_charge_value,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",array($group_id,$amount_from,$amount_to,$charge_type,$payout_charge,$payout_neftcharge,$this->common->getDate(),$this->common->getRealIpAddr()));
            echo "OK";exit;
        }
    }



















    public function getPGSlabList()
    {

            $str = '<table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PG Group</th>
                                        <th>Charge</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';



        if(isset($_POST["group_id"]))
        {
            $i=1;
            $group_id = intval($this->input->post("group_id"));
            $rslt = $this->db->query("SELECT Id,payment_group,charge,charge_type,group_id FROM `pg_charge` where group_id = ?",array($group_id));
            foreach($rslt->result() as $rw)
            {
                $chrg_type = '%';
                $charge_type = $rw->charge_type;
                if($charge_type == "AMOUNT")
                {
                    $chrg_type = '';
                }
                $str.='<tr>';
                    $str .='<td>'.$i.'</td>';
                     $str .='<td><span id="pg_group_'.$rw->Id.'">'.$rw->payment_group.'</span></td>';
                     $str .='<td><span id="payoutcharge_'.$rw->Id.'">'.$rw->charge.' '.$chrg_type.'</span></td>';
                     $str .='<td>
                                 <a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="PGSlabDeleteConfirmation('.$rw->Id.')">Delete</a>
                            </td>';
                $str.='</tr>';   
            $i++;
            }
            $str.='<tr></tbody>
                            </table>';

            echo $str;exit;
        }
    }
    public function deletePGSlab()
    {
        if(isset($_POST["Id"]))
        {
            $Id = intval($this->input->post("Id"));
            $this->db->query("delete from pg_charge where Id  = ?",array($Id));
            echo "ok";exit;
        }
    }
    public function AddPGSlab()
    {

            ini_set('display_errors',1);
            error_reporting(-1);
            $this->db->db_debug = TRUE;
        if(isset($_POST["group_id"]) and isset($_POST["pg_group"]) and isset($_POST["pg_charge"]) and isset($_POST["charge_type"]))
        {
            $group_id = intval($this->input->post("group_id"));
            $pg_group = $this->input->post("pg_group");
           
            $pg_charge = floatval($this->input->post("pg_charge"));
            $charge_type = $this->input->post("charge_type");
           
            
            $this->db->query("insert into pg_charge(group_id,payment_group,charge,charge_type,add_date,ipaddress) values(?,?,?,?,?,?)",array($group_id,$pg_group,$pg_charge,$charge_type,$this->common->getDate(),$this->common->getRealIpAddr()));
            echo "OK";exit;
        }
    }









    public function getINDONEPALSlabList()
    {

            $str = '<table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount Range</th>
                                        <th>Commission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';



        if(isset($_POST["group_id"]))
        {
            $i=1;
            $group_id = intval($this->input->post("group_id"));
            $rslt = $this->db->query("SELECT Id,group_id,range_from,range_to,charge_value,charge_type FROM `indonepal_slab` where group_id = ?",array($group_id));
            foreach($rslt->result() as $rw)
            {
                $chrg_type = '%';
                $charge_type = $rw->charge_type;
                if($charge_type == "AMOUNT")
                {
                    $chrg_type = '';
                }
                $str.='<tr>';
                    $str .='<td>'.$i.'</td>';
                     $str .='<td><span id="amountrange_'.$rw->Id.'">'.$rw->range_from.' - '.$rw->range_to.'</span></td>';
                     $str .='<td><span id="INDONEPALcharge_'.$rw->Id.'">'.$rw->charge_value.' '.$chrg_type.'</span></td>';
                     
                     $str .='<td>
                                 <a href="javascript:void(0)" class="btn btn-danger btn-sm" onClick="INDONEPALSlabDeleteConfirmation('.$rw->Id.')">Delete</a>
                            </td>';
                $str.='</tr>';   
            $i++;
            }
            $str.='<tr></tbody>
                            </table>';

            echo $str;exit;
        }
    }
    public function deleteINDONEPALSlab()
    {
        if(isset($_POST["Id"]))
        {
            $Id = intval($this->input->post("Id"));
            $this->db->query("delete from indonepal_slab where Id  = ?",array($Id));
            echo "ok";exit;
        }
    }
    public function AddINDONEPALSlab()
    {
        if(isset($_POST["group_id"]) and isset($_POST["amount_from"]) and isset($_POST["amount_to"]) and isset($_POST["commission"])  )
        {
            $group_id = intval($this->input->post("group_id"));
            $amount_from = intval($this->input->post("amount_from"));
            $amount_to = intval($this->input->post("amount_to"));
            $commission = floatval($this->input->post("commission"));
            $commission_type = $this->input->post("commission_type");
          
            $this->db->query("insert into indonepal_slab(group_id,range_from,range_to,charge_type,charge_value,add_date,ipaddress) values(?,?,?,?,?,?,?)",array($group_id,$amount_from,$amount_to,$commission_type,$commission,$this->common->getDate(),$this->common->getRealIpAddr()));
            echo "OK";exit;
        }
    }









    
    
}