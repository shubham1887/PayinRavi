<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_integration extends CI_Controller {
    
    
    
    private $msg='';
    function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
        
        $this->load->model("Master");
    }
    function is_logged_in() 
    {
        if ($this->session->userdata('ausertype') != "Admin") 
        { 
            redirect(base_url().'login'); 
        }
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function pageview()
    {
        if ($this->session->userdata('aloggedin') != TRUE) 
        { 
            redirect(base_url().'login'); 
        } 
        
        
        
            $api_id= 0;
        
            $data_array = array();
            $service_array = array();
            $operator_rslt = $this->db->query("
            select 
            a.company_id,
            a.company_name,
            a.mcode,
            a.service_id,
            b.service_name,
            g.comm_per,
            g.commission_type,
            g.commission_slab
            from tblcompany a 
            left join tblservice b on a.service_id = b.service_id 
            left join tbladmincommission g on g.api_id = ? and a.company_id = g.company_id
            order by service_id",array($api_id));
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
        
        
        
        
        
        
        
        
        
        $this->view_data['pagination'] = "";
        $this->view_data['result_api'] = $this->db->query("
        select a.*,b.Name as apigroupname 
        from tblapi a
        left join tblapiroups b on a.apigroup = b.Id
        order by a.api_name,a.status desc");
        $this->view_data['message'] =$this->msg;
        $this->load->view('_Admin/api_integration_view',$this->view_data);      
    }
    
    public function index() 
    {
                $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

        if ($this->session->userdata('aloggedin') != TRUE) 
        { 
            redirect(base_url().'login'); 
        } 
        else 
        { 
         
            $data['message']='';
        
        
            if($this->input->post("btnSubmitAll") == "Submit")
            {       
                
                $txtApiName = substr(trim($this->input->post("txtApiName")),0,20); 
                $checkapi = $this->db->query("select Id from api_configuration where api_name = ?",array($txtApiName));
                if($checkapi->num_rows() == 1)
                {
                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Api Name Already Exist In The System. Please Try Different Name");
                    redirect(base_url()."_Admin/api");
                }
                else
                {
                    $ddlapitype = trim($this->input->post("ddlapitype"));
                    $is_active = 'no'; 
                    $enable_recharge = 'no'; 
                    $enable_balance_check = 'no';
                    if(isset($_POST["chkisapiactive"]))
                    {
                        $is_active = trim($this->input->post("chkisapiactive"));
                    }
                    if(isset($_POST["chkenableRecharge"]))
                    {
                        $enable_recharge = trim($this->input->post("chkenableRecharge"));
                    }
                    if(isset($_POST["chkenableBalanceCheck"]))
                    {
                        $enable_balance_check = trim($this->input->post("chkenableBalanceCheck"));
                    }
                    
                    
                    $txtHostName = trim($this->input->post("txtHostName")); 
                    $txtParam1 = trim($this->input->post("txtParam1")); 
                    $txtParam2 = trim($this->input->post("txtParam2")); 
                    $txtParam3 = trim($this->input->post("txtParam3")); 
                    $txtParam4 = trim($this->input->post("txtParam4")); 
                    $txtParam5 = trim($this->input->post("txtParam5")); 
                    $txtParam6 = trim($this->input->post("txtParam6")); 
                    $txtParam7 = trim($this->input->post("txtParam7")); 
                    
                    
                    $txtHeaderKey1 = trim($this->input->post("txtHeaderKey1")); 
                    $txtHeaderValue1 = trim($this->input->post("txtHeaderValue1")); 
                    $txtHeaderKey2 = trim($this->input->post("txtHeaderKey2")); 
                    $txtHeaderValue2 = trim($this->input->post("txtHeaderValue2")); 
                    $txtHeaderKey3 = trim($this->input->post("txtHeaderKey3")); 
                    $txtHeaderValue3 = trim($this->input->post("txtHeaderValue3")); 
                    $txtHeaderKey4 = trim($this->input->post("txtHeaderKey4")); 
                    $txtHeaderValue4 = trim($this->input->post("txtHeaderValue4")); 
                    $txtHeaderKey5 = trim($this->input->post("txtHeaderKey5")); 
                    $txtHeaderValue5 = trim($this->input->post("txtHeaderValue5")); 
                    
                    $ddlbalcheckapimethod = trim($this->input->post("ddlbalcheckapimethod"));
                    $txtBalnaceCheckApi = trim($this->input->post("txtBalnaceCheckApi")); 
                    $ddlstatuscheckapimethod = trim($this->input->post("ddlstatuscheckapimethod"));
                    $txtStatusCheckApi = trim($this->input->post("txtStatusCheckApi")); 
                    $ddlvalidationcheckapimethod = trim($this->input->post("ddlvalidationcheckapimethod")); 
                    $txtValidationCheckApi = trim($this->input->post("txtValidationCheckApi")); 
                    $ddltransactionapimethod = trim($this->input->post("ddltransactionapimethod"));
                    $txtApiPrepaid = trim($this->input->post("txtApiPrepaid")); 
                    $txtApiDth = trim($this->input->post("txtApiDth")); 
                    $txtApiPostpaid = trim($this->input->post("txtApiPostpaid")); 
                    $txtApiElectricity = trim($this->input->post("txtApiElectricity")); 
                    $txtApiGas = trim($this->input->post("txtApiGas")); 
                    
                    $txtApiInsurance = trim($this->input->post("txtApiInsurance")); 
                    $txtDynamicCallBackUrl = trim($this->input->post("txtDynamicCallBackUrl")); 
                    $ddlparser = trim($this->input->post("ddlparser")); 
                    
                    
                    
                    
                    
                    $ddlBalanceCheckResponseType = trim($this->input->post("ddlBalanceCheckResponseType")); 
                    $txtBalanceCheckRespBalFieldName = trim($this->input->post("txtBalanceCheckRespBalFieldName")); 
                   
                    
                    
                    
                    
                    $ddlrecRespType = trim($this->input->post("ddlrecRespType")); 
                    $txtRecRespSeparatorField = trim($this->input->post("txtRecRespSeparatorField")); 
                    
                    
                    $txtRecRespStatusField = trim($this->input->post("txtRecRespStatusField")); 
                    $txtRecRespOpIdField = trim($this->input->post("txtRecRespOpIdField")); 
                    $txtRecRespApirefidField = trim($this->input->post("txtRecRespApirefidField")); 
                    $txtRecRespBalanceField = trim($this->input->post("txtRecRespBalanceField")); 
                    $txtRecRespRemarkField = trim($this->input->post("txtRecRespRemarkField")); 
                    $txtRecRespStateField = trim($this->input->post("txtRecRespStateField")); 
                    $txtRecRespFosField = trim($this->input->post("txtRecRespFosField")); 
                    $txtRecRespOtfField = trim($this->input->post("txtRecRespOtfField")); 
                    $txtRecRespLapuNumberField = trim($this->input->post("txtRecRespLapuNumberField")); 
                    $txtRecRespMessageField = trim($this->input->post("txtRecRespMessageField")); 
                    $txtRecRespSuccessKey = trim($this->input->post("txtRecRespSuccessKey")); 
                    $txtRecRespPendingKey = trim($this->input->post("txtRecRespPendingKey")); 
                    $txtRecRespFailureKey = trim($this->input->post("txtRecRespFailureKey")); 
                    
                    $pendingOnEmptyTxnId = 'no';
                    if(isset($_POST["chkKeepTxnPendingEmptyOpid"]))
                    {
                        $pendingOnEmptyTxnId = trim($this->input->post("chkKeepTxnPendingEmptyOpid"));
                    }
                    
                    $rsltapiinsert = $this->db->query("insert into api_configuration(
                        api_name, api_type, is_active, enable_recharge, enable_balance_check, hostname, 
                        param1, param2, param3, param4, param5, param6, param7, 
                        header_key1, header_value1, header_key2, header_value2, header_key3, header_value3, header_key4, header_value4, header_key5, header_value5, 
                        balance_check_api_method, balance_ceck_api, status_check_api_method, status_check_api, 
                        validation_api_method, validation_api, transaction_api_method, 
                        api_prepaid, api_dth, api_postpaid, api_electricity, api_gas, api_insurance, 
                        dunamic_callback_url, response_parser, balnace_check_response_type, balnace_check_response_balfieldName, 
                        recharge_response_type,response_separator, recharge_response_status_field, recharge_response_opid_field, recharge_response_apirefid_field, 
                        recharge_response_balance_field, recharge_response_remark_field, recharge_response_stat_field, 
                        recharge_response_fos_field, recharge_response_otf_field, recharge_response_lapunumber_field, recharge_response_message_field, 
                        pendingOnEmptyTxnId, RecRespSuccessKey, RecRespPendingKey, RecRespFailureKey) 
                        values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                        array($txtApiName,$ddlapitype,$is_active, $enable_recharge, $enable_balance_check, $txtHostName,
                        $txtParam1,$txtParam2,$txtParam3,$txtParam4,$txtParam5,$txtParam6,$txtParam7,
                        $txtHeaderKey1,$txtHeaderValue1,$txtHeaderKey2,$txtHeaderValue2,$txtHeaderKey3,$txtHeaderValue3,$txtHeaderKey4,$txtHeaderValue4,$txtHeaderKey5,$txtHeaderValue5,
                        $ddlbalcheckapimethod,$txtBalnaceCheckApi,$ddlstatuscheckapimethod,$txtStatusCheckApi,
                        $ddlvalidationcheckapimethod, $txtValidationCheckApi, $ddltransactionapimethod,
                        $txtApiPrepaid,$txtApiDth,$txtApiPostpaid,$txtApiElectricity,$txtApiGas,$txtApiInsurance,
                        $txtDynamicCallBackUrl,$ddlparser,$ddlBalanceCheckResponseType,$txtBalanceCheckRespBalFieldName,
                        $ddlrecRespType,$txtRecRespSeparatorField,$txtRecRespStatusField,$txtRecRespOpIdField,$txtRecRespApirefidField,
                        $txtRecRespBalanceField,$txtRecRespRemarkField,$txtRecRespStateField,
                        $txtRecRespFosField,$txtRecRespOtfField,$txtRecRespLapuNumberField,$txtRecRespMessageField,
                        $pendingOnEmptyTxnId,$txtRecRespSuccessKey,$txtRecRespPendingKey,$txtRecRespFailureKey
                        ));
                        
                        
                        
                    if($rsltapiinsert == true)
                    {
                        $insert_id = $this->db->insert_id();
                        $ddlStatusCheckRespType  = trim($this->input->post("ddlStatusCheckRespType"));
                        $txtStatusCheckRespStatusField  = trim($this->input->post("txtStatusCheckRespStatusField"));
                        $txtStatusCheckRespOpIdField  = trim($this->input->post("txtStatusCheckRespOpIdField"));
                        $txtStatusCheckRespStateField  = trim($this->input->post("txtStatusCheckRespStateField"));
                        $txtStatusCheckRespFosField  = trim($this->input->post("txtStatusCheckRespFosField"));
                        $txtStatusCheckRespOtfField  = trim($this->input->post("txtStatusCheckRespOtfField"));
                        $txtStatusCheckRespLapuNumberField  = trim($this->input->post("txtStatusCheckRespLapuNumberField"));
                        $txtStatusCheckRespMessageField  = trim($this->input->post("txtStatusCheckRespMessageField"));
                        $txtStatusCheckRespSuccessKey  = trim($this->input->post("txtStatusCheckRespSuccessKey"));
                        $txtStatusCheckRespPendingKey  = trim($this->input->post("txtStatusCheckRespPendingKey"));
                        $txtStatusCheckRespFailureKey  = trim($this->input->post("txtStatusCheckRespFailureKey"));
                        $txtStatusCheckRespRefundKey = trim($this->input->post("txtStatusCheckRespRefundKey"));
                        $txtStatusCheckRespNotFoundKey  = trim($this->input->post("txtStatusCheckRespNotFoundKey"));
                        
                        $txtCallbackReqIdName  = trim($this->input->post("txtCallbackReqIdName"));
                        $txtCallbackApiRefIdName  = trim($this->input->post("txtCallbackApiRefIdName"));
                        $chkcallbackcheckthroughreqid  = trim($this->input->post("chkcallbackcheckthroughreqid"));
                        $txtCallbackstatusName  = trim($this->input->post("txtCallbackstatusName"));
                        $txtCallbackopidName  = trim($this->input->post("txtCallbackopidName"));
                        $txtCallbackSuccessKey  = trim($this->input->post("txtCallbackSuccessKey"));
                        $txtCallbackFailureKey  = trim($this->input->post("txtCallbackFailureKey"));
                        $txtCallbackPendingKey  = trim($this->input->post("txtCallbackPendingKey"));
                        $txtCallbackRefundKey  = trim($this->input->post("txtCallbackRefundKey"));
                        
                        
                        
                        
                        
                        
                        $this->db->query("insert into status_api_configuration
                                        (api_id, response_type, status_field, opid_field, state_field, fos_field, otf_field, lapunumber_field, 
                                        message_field, success_key, pending_key, failure_key, refund_key, notfound_key)
                                        values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                        array($insert_id,$ddlStatusCheckRespType,$txtStatusCheckRespStatusField,$txtStatusCheckRespOpIdField,$txtStatusCheckRespStateField,
                                        $txtStatusCheckRespFosField,$txtStatusCheckRespOtfField,$txtStatusCheckRespLapuNumberField,
                                        $txtStatusCheckRespMessageField,$txtStatusCheckRespSuccessKey,$txtStatusCheckRespPendingKey,$txtStatusCheckRespFailureKey,
                                        $txtStatusCheckRespRefundKey,$txtStatusCheckRespNotFoundKey
                                        ));
                        
                        
                        $this->db->query("insert into callback_settings
                                        (api_id, reqid_name, apirefid_name, check_through_reqid, status_name, opid_name, success_key, pending_key, 
                                        failure_key, refund_key)
                                        values(?,?,?,?,?,?,?,?,?,?)",
                                        array($insert_id,$txtCallbackReqIdName,$chkcallbackcheckthroughreqid,$txtCallbackApiRefIdName,$txtCallbackstatusName,$txtCallbackopidName,
                                        $txtCallbackSuccessKey,$txtCallbackFailureKey,$txtCallbackPendingKey,
                                        $txtCallbackRefundKey
                                        ));
                        
                        // $operatorcode_array = $this->input->post("txtCode");
                        $Comm_array = $this->input->post("txtComm");
                        $CommType_array = $this->input->post("ddlcommtype");
                        $OpParam1_array = $this->input->post("txtOpParam1");
                        $OpParam2_array = $this->input->post("txtOpParam2");
                        $OpParam3_array = $this->input->post("txtOpParam3");
                        $OpParam4_array = $this->input->post("txtOpParam4");
                        $OpParam5_array = $this->input->post("txtOpParam5");
                        
                        
                        $company_rslt = $this->db->query("select company_id,company_name from tblcompany order by company_id");
                        foreach($company_rslt->result() as $rwcomp)
                        {
                            $company_id = intval($rwcomp->company_id);
                            if(isset($operatorcode_array[$company_id]))
                            {
                              
                               $commission = trim($Comm_array[$company_id]);
                               $commission_type = "PER";
                               $commission_slab = 0;
                               if(isset($CommType_array[$company_id]))
                               {
                                    $commission_type = $CommType_array[$company_id];
                               }
                               
                               $OpParam1 = trim($OpParam1_array[$company_id]);
                               $OpParam2 = trim($OpParam2_array[$company_id]);
                               $OpParam3 = trim($OpParam3_array[$company_id]);
                               $OpParam4 = trim($OpParam4_array[$company_id]);
                               $OpParam5 = trim($OpParam5_array[$company_id]);
                               
                               $this->db->query("insert into tbloperatorcodes(company_id,api_id,commission,commission_type,commission_slab,OpParam1,OpParam2,OpParam3,OpParam4,OpParam5) 
                                                    values(?,?,?,?,?,?,?,?,?,?)",
                                                    array($company_id,$insert_id,$commission,$commission_type,$commission_slab,$OpParam1,$OpParam2,$OpParam3,$OpParam4,$OpParam5));
                            }
                        }
                        
                        
                        $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
                        $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Api Added Successfully");
                        redirect(base_url()."_Admin/api");
                        
                        
                        
                    }
                    else
                    {
                        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                        $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Some Error Occured. Please Try Again");
                        redirect(base_url()."_Admin/api");
                    }    
                }               
            }
        
            else if(isset($_GET["id"]) and isset($_GET["frmaction"]) ) 
            {       
                if($_GET["frmaction"] == "EDIT")
                {
                    $encapi_id = trim($this->input->get("id"));
                    $api_id = $this->Common_methods->decrypt($encapi_id);
                    $checkapi = $this->db->query("select * from api_configuration where Id = ?",array($api_id));
                    if($checkapi->num_rows() == 1)
                    {
                        $this->view_data["api_data"] = $checkapi;
                        $this->view_data["statusapi_data"] = false;
                        $status_api = $this->db->query("select * from status_api_configuration where api_id = ?",array($api_id));
                        if($status_api->num_rows() == 1)
                        {
                            $this->view_data["statusapi_data"] = $status_api;
                        }
                       
                        $this->view_data["callback_data"] = false;
                        $callback_api = $this->db->query("select * from callback_settings where api_id = ?",array($api_id));
                        if($callback_api->num_rows() == 1)
                        {
                            $this->view_data["callback_data"] = $callback_api;
                        }
                        
                        
                        
                       
                        $data_array = array();
                        $service_array = array();
                        $operator_rslt = $this->db->query("
                        select 
                        a.company_id,
                        a.company_name,
                        a.mcode,
                        a.service_id,
                        b.service_name,
                        g.commission,
                        g.commission_type,
                        g.commission_slab,
                        g.OpParam1,
                        g.OpParam2,
                        g.OpParam3,
                        g.OpParam4,
                        g.OpParam5
                        
                        from tblcompany a 
                        left join tblservice b on a.service_id = b.service_id 
                        left join tbloperatorcodes g on g.api_id = ? and a.company_id = g.company_id
                        order by service_id",array($api_id));
                        
                      
                        
                        
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
                        
                      
                        $this->view_data["data"]  = $data_array;
                         $this->view_data["service_array"]  = $service_array;
                        
                        
                        
                        
                        $this->load->view("_Admin/api_integration_edit_view",$this->view_data);
                    }
                    else
                    {
                        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                        $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Action");
                        redirect(base_url()."_Admin/api");
                    }
                }
                else
                {
                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Action");
                    redirect(base_url()."_Admin/api");
                }
                
            }
        
            else
            {
                $user=$this->session->userdata('ausertype');
                if(trim($user) == 'Admin')
                {
                $this->pageview();
                }
                else
                {redirect(base_url().'login');}                                                                                 
            }
        } 
    }   
    public function updateallfields()
    {
                
                $api_id = $this->input->post("hidapiid");
            
                $checkapi = $this->db->query("select Id from api_configuration where Id = ? and Id > 3",array($api_id));
                if($checkapi->num_rows() == 0)
                {
                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Api Name Not Exist In The System.");
                    redirect(base_url()."_Admin/api");
                }
                else
                {
                    $txtApiName = trim($this->input->post("txtApiName")); 
                    $ddlapitype = trim($this->input->post("ddlapitype"));
                    $is_active = 'no'; 
                    $enable_recharge = 'no'; 
                    $enable_balance_check = 'no';
                    if(isset($_POST["chkisapiactive"]))
                    {
                        $is_active = trim($this->input->post("chkisapiactive"));
                    }
                    if(isset($_POST["chkenableRecharge"]))
                    {
                        $enable_recharge = trim($this->input->post("chkenableRecharge"));
                    }
                    if(isset($_POST["chkenableBalanceCheck"]))
                    {
                        $enable_balance_check = trim($this->input->post("chkenableBalanceCheck"));
                    }
                    


                    $fromtime =  $this->input->post("txtFromTime");
                    $from_time = date_format(date_create($fromtime),'H:i');


                    $totime =  $this->input->post("txtToTime");
                    $to_time = date_format(date_create($totime),'H:i');

                    $txtMinBalanceLimit = trim($this->input->post("txtMinBalanceLimit")); 
                    $txtHostName = trim($this->input->post("txtHostName")); 
                    
                    $txtParam1 = trim($this->input->post("txtParam1")); 
                    $txtParam2 = trim($this->input->post("txtParam2")); 
                    $txtParam3 = trim($this->input->post("txtParam3")); 
                    $txtParam4 = trim($this->input->post("txtParam4")); 
                    $txtParam5 = trim($this->input->post("txtParam5")); 
                    $txtParam6 = trim($this->input->post("txtParam6")); 
                    $txtParam7 = trim($this->input->post("txtParam7")); 
                    
                    
                    $txtHeaderKey1 = trim($this->input->post("txtHeaderKey1")); 
                    $txtHeaderValue1 = trim($this->input->post("txtHeaderValue1")); 
                    $txtHeaderKey2 = trim($this->input->post("txtHeaderKey2")); 
                    $txtHeaderValue2 = trim($this->input->post("txtHeaderValue2")); 
                    $txtHeaderKey3 = trim($this->input->post("txtHeaderKey3")); 
                    $txtHeaderValue3 = trim($this->input->post("txtHeaderValue3")); 
                    $txtHeaderKey4 = trim($this->input->post("txtHeaderKey4")); 
                    $txtHeaderValue4 = trim($this->input->post("txtHeaderValue4")); 
                    $txtHeaderKey5 = trim($this->input->post("txtHeaderKey5")); 
                    $txtHeaderValue5 = trim($this->input->post("txtHeaderValue5")); 
                    
                    $ddlbalcheckapimethod = trim($this->input->post("ddlbalcheckapimethod"));
                    $txtBalnaceCheckApi = trim($this->input->post("txtBalnaceCheckApi")); 
                    $ddlstatuscheckapimethod = trim($this->input->post("ddlstatuscheckapimethod"));
                    $txtStatusCheckApi = trim($this->input->post("txtStatusCheckApi")); 
                    $ddlvalidationcheckapimethod = trim($this->input->post("ddlvalidationcheckapimethod")); 
                    $txtValidationCheckApi = trim($this->input->post("txtValidationCheckApi")); 
                    $ddltransactionapimethod = trim($this->input->post("ddltransactionapimethod"));
                    $txtApiPrepaid = trim($this->input->post("txtApiPrepaid")); 
                    $txtApiDth = trim($this->input->post("txtApiDth")); 
                    $txtApiPostpaid = trim($this->input->post("txtApiPostpaid")); 
                    $txtApiElectricity = trim($this->input->post("txtApiElectricity")); 
                    $txtApiGas = trim($this->input->post("txtApiGas")); 
                    
                    $txtApiInsurance = trim($this->input->post("txtApiInsurance")); 
                    $txtDynamicCallBackUrl = trim($this->input->post("txtDynamicCallBackUrl")); 
                    $ddlparser = trim($this->input->post("ddlparser")); 
                    $ddlBalanceCheckResponseType = trim($this->input->post("ddlBalanceCheckResponseType")); 
                  
                    $txtBalanceCheckRespBalFieldName = trim($this->input->post("txtBalanceCheckRespBalFieldName")); 
                    $txtbalance_check_start_word = trim($this->input->post("txtbalance_check_start_word")); 
                    $txtbalance_check_end_word = trim($this->input->post("txtbalance_check_end_word")); 
                    
                    
                    
                    
                    
                    
                    $ddlrecRespType = trim($this->input->post("ddlrecRespType")); 
                    $txtRecRespSeparatorField = trim($this->input->post("txtRecRespSeparatorField")); 
                    
                    $txtRecRespStatusField = trim($this->input->post("txtRecRespStatusField")); 
                    $txtRecRespOpIdField = trim($this->input->post("txtRecRespOpIdField")); 
                    $txtRecRespApirefidField = trim($this->input->post("txtRecRespApirefidField")); 
                    $txtRecRespBalanceField = trim($this->input->post("txtRecRespBalanceField")); 
                    $txtRecRespRemarkField = trim($this->input->post("txtRecRespRemarkField")); 
                    $txtRecRespStateField = trim($this->input->post("txtRecRespStateField")); 
                    $txtRecRespFosField = trim($this->input->post("txtRecRespFosField")); 
                    $txtRecRespOtfField = trim($this->input->post("txtRecRespOtfField")); 
                    $txtRecRespLapuNumberField = trim($this->input->post("txtRecRespLapuNumberField")); 
                    $txtRecRespMessageField = trim($this->input->post("txtRecRespMessageField")); 
                    $txtRecRespSuccessKey = trim($this->input->post("txtRecRespSuccessKey")); 
                    $txtRecRespPendingKey = trim($this->input->post("txtRecRespPendingKey")); 
                    $txtRecRespFailureKey = trim($this->input->post("txtRecRespFailureKey")); 
                    $txtRecRespFailureText = trim($this->input->post("txtRecRespFailureText")); 
                    
                    $pendingOnEmptyTxnId = 'no';
                    if(isset($_POST["chkKeepTxnPendingEmptyOpid"]))
                    {
                        $pendingOnEmptyTxnId = trim($this->input->post("chkKeepTxnPendingEmptyOpid"));
                    }
                    
                    $rsltapiinsert = $this->db->query("update api_configuration
                        set
                        api_name = ?, api_type = ?, is_active = ?, enable_recharge = ?, enable_balance_check = ?, hostname = ?, 
                        param1 = ?, param2 = ?, param3 = ?, param4 = ?, param5 = ?, param6 = ?, param7 = ?, 
                        header_key1 = ?, header_value1 = ?, header_key2 = ?, header_value2 = ?, header_key3 = ?, header_value3 = ?, header_key4 = ?, header_value4 = ?, header_key5 = ?, header_value5 = ?, 
                        balance_check_api_method = ?, balance_ceck_api = ?, status_check_api_method = ?, status_check_api = ?, 
                        validation_api_method = ?, validation_api = ?, transaction_api_method = ?, 
                        api_prepaid = ?, api_dth = ?, api_postpaid = ?, api_electricity = ?, api_gas = ?, api_insurance = ?, 
                        dunamic_callback_url = ?, response_parser = ?, balnace_check_response_type = ?, balnace_check_response_balfieldName = ?, balance_check_start_word = ?,balance_check_end_word=?,
                        recharge_response_type = ?,response_separator= ?, recharge_response_status_field = ?, recharge_response_opid_field = ?, recharge_response_apirefid_field = ?, 
                        recharge_response_balance_field = ?, recharge_response_remark_field = ?, recharge_response_stat_field = ?, 
                        recharge_response_fos_field = ?, recharge_response_otf_field = ?, recharge_response_lapunumber_field = ?, recharge_response_message_field = ?, 
                        pendingOnEmptyTxnId = ?, RecRespSuccessKey = ?, RecRespPendingKey = ?, 
                        RecRespFailureKey = ?,
                        RecRespFailureText = ?,
                        api_time_from = ?, api_time_to = ?,min_balance_limit=? where Id = ?",
                        array($txtApiName,$ddlapitype,$is_active, $enable_recharge, $enable_balance_check, $txtHostName,
                        $txtParam1,$txtParam2,$txtParam3,$txtParam4,$txtParam5,$txtParam6,$txtParam7,
                        $txtHeaderKey1,$txtHeaderValue1,$txtHeaderKey2,$txtHeaderValue2,$txtHeaderKey3,$txtHeaderValue3,$txtHeaderKey4,$txtHeaderValue4,$txtHeaderKey5,$txtHeaderValue5,
                        $ddlbalcheckapimethod,$txtBalnaceCheckApi,$ddlstatuscheckapimethod,$txtStatusCheckApi,
                        $ddlvalidationcheckapimethod, $txtValidationCheckApi, $ddltransactionapimethod,
                        $txtApiPrepaid,$txtApiDth,$txtApiPostpaid,$txtApiElectricity,$txtApiGas,$txtApiInsurance,
                        $txtDynamicCallBackUrl,$ddlparser,$ddlBalanceCheckResponseType,$txtBalanceCheckRespBalFieldName,$txtbalance_check_start_word,$txtbalance_check_end_word,
                        $ddlrecRespType,$txtRecRespSeparatorField,$txtRecRespStatusField,$txtRecRespOpIdField,$txtRecRespApirefidField,
                        $txtRecRespBalanceField,$txtRecRespRemarkField,$txtRecRespStateField,
                        $txtRecRespFosField,$txtRecRespOtfField,$txtRecRespLapuNumberField,$txtRecRespMessageField,
                        $pendingOnEmptyTxnId,$txtRecRespSuccessKey,$txtRecRespPendingKey,$txtRecRespFailureKey,$txtRecRespFailureText,
                         $from_time, $to_time,$txtMinBalanceLimit,$api_id
                        ));
                        
                        //$txtbalance_check_start_word,$txtbalance_check_end_word
                    if($rsltapiinsert == true)
                    {
                        
                        $ddlStatusCheckRespType  = trim($this->input->post("ddlStatusCheckRespType"));
                        $txtStatusCheckRespStatusField  = trim($this->input->post("txtStatusCheckRespStatusField"));
                        $txtStatusCheckRespOpIdField  = trim($this->input->post("txtStatusCheckRespOpIdField"));
                        $txtStatusCheckRespStateField  = trim($this->input->post("txtStatusCheckRespStateField"));
                        $txtStatusCheckRespFosField  = trim($this->input->post("txtStatusCheckRespFosField"));
                        $txtStatusCheckRespOtfField  = trim($this->input->post("txtStatusCheckRespOtfField"));
                        $txtStatusCheckRespLapuNumberField  = trim($this->input->post("txtStatusCheckRespLapuNumberField"));
                        $txtStatusCheckRespMessageField  = trim($this->input->post("txtStatusCheckRespMessageField"));
                        $txtStatusCheckRespSuccessKey  = trim($this->input->post("txtStatusCheckRespSuccessKey"));
                        $txtStatusCheckRespPendingKey  = trim($this->input->post("txtStatusCheckRespPendingKey"));
                        $txtStatusCheckRespFailureKey  = trim($this->input->post("txtStatusCheckRespFailureKey"));
                        $txtStatusCheckRespRefundKey = trim($this->input->post("txtStatusCheckRespRefundKey"));
                        $txtStatusCheckRespNotFoundKey  = trim($this->input->post("txtStatusCheckRespNotFoundKey"));
                        $txtStatusCheckRespSeparator  = (string)trim($this->input->post("txtStatusCheckRespSeparator"));

                        



                        $txtCallbackReqIdName  = trim($this->input->post("txtCallbackReqIdName"));
                        $txtCallbackApiRefIdName  = trim($this->input->post("txtCallbackApiRefIdName"));
                        $chkcallbackcheckthroughreqid  = trim($this->input->post("chkcallbackcheckthroughreqid"));
                        $txtCallbackstatusName  = trim($this->input->post("txtCallbackstatusName"));
                        $txtCallbackopidName  = trim($this->input->post("txtCallbackopidName"));
                        $txtCallbackSuccessKey  = trim($this->input->post("txtCallbackSuccessKey"));
                        $txtCallbackFailureKey  = trim($this->input->post("txtCallbackFailureKey"));
                        $txtCallbackPendingKey  = trim($this->input->post("txtCallbackPendingKey"));
                        $txtCallbackRefundKey  = trim($this->input->post("txtCallbackRefundKey"));
                        $txtCallbackResponse_type  = trim($this->input->post("ddlcallback_response_type"));
                        
                        
                        
                        
                        
                        
                        $this->db->query("update status_api_configuration
                                        set response_type = ?, status_field = ?, opid_field = ?, state_field = ?, fos_field = ?, otf_field = ?, lapunumber_field = ?, 
                                        message_field = ?, success_key = ?, pending_key = ?, failure_key = ?, refund_key = ?, notfound_key = ?,str_separator = ? where api_id = ? ",
                                        array($ddlStatusCheckRespType,$txtStatusCheckRespStatusField,$txtStatusCheckRespOpIdField,$txtStatusCheckRespStateField,
                                        $txtStatusCheckRespFosField,$txtStatusCheckRespOtfField,$txtStatusCheckRespLapuNumberField,
                                        $txtStatusCheckRespMessageField,$txtStatusCheckRespSuccessKey,$txtStatusCheckRespPendingKey,$txtStatusCheckRespFailureKey,
                                        $txtStatusCheckRespRefundKey,$txtStatusCheckRespNotFoundKey,$txtStatusCheckRespSeparator,$api_id
                                        ));
                        
                        
                        $this->db->query("update callback_settings
                                        set reqid_name = ?, apirefid_name = ?, check_through_reqid = ?, status_name = ?, opid_name = ?, success_key = ?, pending_key = ?, 
                                        failure_key = ?, refund_key = ?, response_type = ? where api_id = ?",
                                        array($txtCallbackReqIdName,$chkcallbackcheckthroughreqid,$txtCallbackApiRefIdName,$txtCallbackstatusName,$txtCallbackopidName,
                                        $txtCallbackSuccessKey,$txtCallbackPendingKey,$txtCallbackFailureKey,
                                        $txtCallbackRefundKey,$txtCallbackResponse_type,$api_id
                                        ));
                        
                        // $operatorcode_array = $this->input->post("txtCode");
                        $Comm_array = $this->input->post("txtComm");
                        $CommType_array = $this->input->post("ddlcommtype");
                        $OpParam1_array = $this->input->post("txtOpParam1");
                        $OpParam2_array = $this->input->post("txtOpParam2");
                        $OpParam3_array = $this->input->post("txtOpParam3");
                        $OpParam4_array = $this->input->post("txtOpParam4");
                        $OpParam5_array = $this->input->post("txtOpParam5");
                        
                        
                        $company_rslt = $this->db->query("select company_id,company_name from tblcompany order by company_id");
                        foreach($company_rslt->result() as $rwcomp)
                        {
                            $company_id = intval($rwcomp->company_id);
                            if(isset($OpParam1_array[$company_id]))
                            {
                              
                               $commission = trim($Comm_array[$company_id]);
                               $commission_type = "PER";
                               $commission_slab = 0;
                               if(isset($CommType_array[$company_id]))
                               {
                                    $commission_type = $CommType_array[$company_id];
                               }
                               
                               $OpParam1 = trim($OpParam1_array[$company_id]);
                               $OpParam2 = "";
                               if(isset($OpParam2_array[$company_id]))
                               {
                                   $OpParam2 = trim($OpParam2_array[$company_id]);
                               }
                               $OpParam3 = "";
                               if(isset($OpParam3_array[$company_id]))
                               {
                                   $OpParam3 = trim($OpParam3_array[$company_id]);
                               }
                               $OpParam4 = "";
                               if(isset($OpParam4_array[$company_id]))
                               {
                                    $OpParam4 = trim($OpParam4_array[$company_id]);
                               }
                               $OpParam5 = "";
                               if(isset($OpParam5_array[$company_id]))
                               {
                                    $OpParam5 = trim($OpParam5_array[$company_id]);
                               }
                               
                               
                               
                              
                               
                               
                               $checkcodeexist = $this->db->query("select Id from tbloperatorcodes where api_id = ? and company_id = ?",array( $api_id,$company_id ));
                               if($checkcodeexist->num_rows() == 0)
                               {
                                   $this->db->query("insert into tbloperatorcodes(company_id,api_id,commission,commission_type,commission_slab,OpParam1,OpParam2,OpParam3,OpParam4,OpParam5) 
                                                    values(?,?,?,?,?,?,?,?,?,?)",
                                                    array($company_id,$api_id,$commission,$commission_type,$commission_slab,$OpParam1,$OpParam2,$OpParam3,$OpParam4,$OpParam5));
                               }
                               else
                               {
                                   $this->db->query("update tbloperatorcodes 
                                   set commission = ?,commission_type = ?,commission_slab = ?,OpParam1 = ?,OpParam2 = ?,OpParam3 = ?,OpParam4 = ?,OpParam5 = ?
                                   where api_id = ? and company_id = ?",
                                                    array($commission,$commission_type,$commission_slab,$OpParam1,$OpParam2,$OpParam3,$OpParam4,$OpParam5,$api_id,$company_id));
                               }
                               
                               
                            }
                        }
                        
                        
                        $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
                        $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Api Updated Successfully");
                        redirect(base_url()."_Admin/api");
                        
                        
                        
                    }
                    else
                    {
                        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                        $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Some Error Occured. Please Try Again");
                        redirect(base_url()."_Admin/api");
                    }    
                }               
            
    }
    public function getmasterapisettings()
    {
        
        if(isset($_POST["api_id"]))
        {
            $api_id = intval(trim($_POST["api_id"]));
            echo $this->Master->getApiSettings($api_id);exit;
        }
        else if(isset($_GET["api_id"]))
        {
            $api_id = intval(trim($_GET["api_id"]));
            echo $this->Master->getApiSettings($api_id);exit;
        }
        else
        {
            $resp_array = array(
                                    "status"=>1,
                                    "statuscode"=>"ERR",
                                    "message"=>"API ID NOT FOUND",
                            );
            return json_encode($resp_array);  
        }
        
    }
}