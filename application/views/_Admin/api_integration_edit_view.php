<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>API INTEGRATION</title>

    
      
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


    <link href="<?php echo base_url(); ?>lib/timepicker/jquery.timepicker.css" rel="stylesheet">
	<script>
		$(document).ready(function(){
			$(function() {
		            $( "#txtFromTime" ).timepicker({dateFormat:'H:i:s'});
		            $( "#txtToTime" ).timepicker({dateFormat:'H:i:s'});
		         });
		});
	</script>


    <script>
    function SetEdit(value)
	{
		document.getElementById('txtAPIName').value=document.getElementById("name_"+value).innerHTML;
		document.getElementById('txtUserName').value=document.getElementById("uname_"+value).innerHTML;		
		document.getElementById('txtPassword').value=document.getElementById("pwd_"+value).innerHTML;
		document.getElementById('txtIp').value=document.getElementById("ipaddr_"+value).innerHTML;
		document.getElementById('ddlhttpmethod').value=document.getElementById("method_"+value).innerHTML;
		
		
		document.getElementById('txtparameters').innerHTML=document.getElementById("params_"+value).innerHTML;
		document.getElementById('ddlstatus').value=document.getElementById("hidstatus_"+value).value;
		document.getElementById('txtMinBalanceLimit').value=document.getElementById("minbal_"+value).innerHTML;
		document.getElementById('ddlapigroup').value=document.getElementById("hidapigroup_"+value).value;
		
		document.getElementById('txtToken').value=document.getElementById("token_"+value).innerHTML;
		
		
		
		
		
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		//document.getElementById('myLabel').innerHTML = "Edit API";
	}
</script>
<style>
	 
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 5px;
}  
	  
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.message
{
	padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
.table >thead > tr
{
     padding: 10px;
    margin-bottom:10px;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 10px;
    margin-bottom:10px;
    /*line-height: 1.42857143;*/
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
 /*   border-left: 1px solid #ddd;*/
	/*border-right: 1px solid #ddd;*/
 /*   border-top: 1px solid #ddd;*/
	/*border-bottom:: 1px solid #ddd;*/
	overflow:hidden;
}
.text
{
    width:500px;
}
.mytablestyle > table > tr > td
{
    margin-bottom:20px;
    padding-bottom:20px;
}
table {
   border-collapse: collapse; /* [1] */
}

th, td {
  border-bottom: 10px solid transparent; /* [2] */
  background-clip: padding-box; /* [4] */
  padding-left : 10px;
}

</style>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/header.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Developers Options</a>
          <span class="breadcrumb-item active">API CONFIGURATION</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>API CONFIGURATION</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
          <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-6">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body" style="background-color:#F2F2F2">
                  <h2>URL Template Fields</h2>
                 <table>
                     <tr >
                         <td align="right">Parameters</td><td>@param1,@param2,@param3,@param4,@param5</td>
                     </tr>
                     <tr>
                         <td>Operator Parameters</td><td>@opparam1,@opparam2,@opparam3,@opparam4,@opparam5</td>
                     </tr>
                     <tr>
                         <td>Mobile Number</td><td>@mn</td>
                     </tr>
                     <tr>
                         <td>Amount</td><td>@amt</td>
                     </tr>
                     <tr>
                         <td>Amount With Decimal</td><td>@decimalamt</td>
                     </tr>
                     <tr>
                         <td>Web Reference Id</td><td>@reqid</td>
                     </tr>
                     <tr>
                         <td>Api Reference Id</td><td>@apirefid</td>
                     </tr>
                     <tr>
                         <td>Extra Field 1</td><td>@field1</td>
                     </tr>
                     <tr>
                         <td>Extra Field 2</td><td>@field2</td>
                     </tr>
                     <tr>
                         <td>Date</td><td>@dd</td>
                     </tr>
                     <tr>
                         <td>Month</td><td>@MM</td>
                     </tr>
                     <tr>
                         <td>Year</td><td>@yyyy</td>
                     </tr>
                     <tr>
                         <td>Hours</td><td>@hh</td>
                     </tr>
                     <tr>
                         <td>Minutes</td><td>@mm</td>
                     </tr>
                     <tr>
                         <td>Seconds</td><td>@ss</td>
                     </tr>
                     <tr>
                         <td>Timestamp</td><td>@timestamp</td>
                     </tr>
                 </table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-6 -->
          <div class="col-sm-6 col-lg-6">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0"></h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body" style="background-color:#F2F2F2">
                  <h2>Text Mode  Grammer Fields</h2>
                 <table>
                     <tr>
                         <td>Status</td><td>@status</td>
                     </tr>
                     <tr>
                         <td>Mobile Number</td><td>@mn</td>
                     </tr>
                     <tr>
                         <td>Api Reference Id</td><td>@apirefid</td>
                     </tr>
                     <tr>
                         <td>Amount</td><td>@amt</td>
                     </tr>
                     <tr>
                         <td>Balance</td><td>@balance</td>
                     </tr>
                     <tr>
                         <td>Operator Id</td><td>@opid</td>
                     </tr>
                     <tr>
                         <td>Discount Amount</td><td>@rofferamt</td>
                     </tr>
                     <tr>
                         <td>Any Other Text</td><td>@other</td>
                     </tr>
                     <tr>
                         <td>Remark</td><td>@remark</td>
                     </tr>
                     
                 </table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
        
       <form id="frmApi" action="<?php echo base_url()."_Admin/Api_integration/updateallfields"; ?>" method="POST">
        <input type="hidden" id="hidapiid" name="hidapiid" value="<?php echo $api_data->row(0)->Id; ?>">
        <input type="hidden" id="hidfrmaction" name="hidfrmaction" value="UPDATE">
        
        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Add API</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body mytablestyle" style="background-color:#F2F2F2">
                 
                 <table  class="mytablestyle" style="color:#00000E">
                     <tr >
                         <td style="width:300px;" align="right">Api Name: </td>
                         <td >
                             <input type="text" id="txtApiName" name="txtApiName" class="text" value="<?php echo $api_data->row(0)->api_name; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Api Type : </td>
                         <td>
                             <select id="ddlapitype" name="ddlapitype" class="text">
                                 <option value="http">http</option>
                                 <option value="https">https</option>
                             </select>
                             <script language="javascript">document.getElementById("ddlapitype").value = '<?php echo $api_data->row(0)->api_type; ?>';</script>
                         </td>
                     </tr>
                     <?php
                        $is_active = $api_data->row(0)->is_active;
                        $enable_recharge = $api_data->row(0)->enable_recharge;
                        $enable_balance_check = $api_data->row(0)->enable_balance_check;
                        $enable_status_check = $api_data->row(0)->enable_status_check;
                        
                        $is_active_prop = '';
                        $enable_recharge_prop = '';
                        $enable_balance_check_prop = '';
                        $enable_status_check_prop = '';
                        
                        
                        if($is_active == 'yes')
                        {
                            $is_active_prop = 'checked';
                        }
                        if($enable_recharge == 'yes')
                        {
                            $enable_recharge_prop = 'checked';
                        }
                        if($enable_balance_check == 'yes')
                        {
                            $enable_balance_check_prop = 'checked';
                        }
                        if($enable_status_check == 'yes')
                        {
                            $enable_status_check_prop = 'checked';
                        }
                        

                        $api_time_from = $api_data->row(0)->api_time_from;
                        $api_time_to = $api_data->row(0)->api_time_to;
                        $min_balance_limit = $api_data->row(0)->min_balance_limit;

                        $hostname = $api_data->row(0)->hostname;
                        $param1 = $api_data->row(0)->param1;
                        $param2 = $api_data->row(0)->param2;
                        $param3 = $api_data->row(0)->param3;
                        $param4 = $api_data->row(0)->param4;
                        $param5 = $api_data->row(0)->param5;
                        $param6 = $api_data->row(0)->param6;
                        $param7 = $api_data->row(0)->param7;
                        
                        
                        $header_key1 = $api_data->row(0)->header_key1;
                        $header_value1 = $api_data->row(0)->header_value1;
                        
                        $header_key2 = $api_data->row(0)->header_key2;
                        $header_value2 = $api_data->row(0)->header_value2;
                        
                        $header_key3 = $api_data->row(0)->header_key3;
                        $header_value3 = $api_data->row(0)->header_value3;
                        
                        $header_key4 = $api_data->row(0)->header_key4;
                        $header_value4 = $api_data->row(0)->header_value4;
                        
                        $header_key5 = $api_data->row(0)->header_key5;
                        $header_value5 = $api_data->row(0)->header_value5;
                        
                        
                        $status_check_api_method = $api_data->row(0)->status_check_api_method;
                        $status_check_api = $api_data->row(0)->status_check_api;
                        $validation_api_method = $api_data->row(0)->validation_api_method;
                        $validation_api = $api_data->row(0)->validation_api;
                        $transaction_api_method = $api_data->row(0)->transaction_api_method;
                        $api_prepaid = $api_data->row(0)->api_prepaid;
                        $api_dth = $api_data->row(0)->api_dth;
                        $api_postpaid = $api_data->row(0)->api_postpaid;
                        $api_electricity = $api_data->row(0)->api_electricity;
                        $api_gas = $api_data->row(0)->api_gas;
                        $api_insurance = $api_data->row(0)->api_insurance;
                        
                        
                        $dunamic_callback_url = $api_data->row(0)->dunamic_callback_url;
                        $response_parser = $api_data->row(0)->response_parser;
                        
                        
                        
                        $balance_check_api_method = $api_data->row(0)->balance_check_api_method;
                        $balance_ceck_api = $api_data->row(0)->balance_ceck_api;
                        $balnace_check_response_type = $api_data->row(0)->balnace_check_response_type;
                        $balnace_check_response_balfieldName = $api_data->row(0)->balnace_check_response_balfieldName;
                        $balance_check_start_word = $api_data->row(0)->balance_check_start_word;
                        $balance_check_end_word = $api_data->row(0)->balance_check_end_word;
                        
                        
                        $recharge_response_type = $api_data->row(0)->recharge_response_type;
                        $response_separator = $api_data->row(0)->response_separator;
                        
                        
                        $recharge_response_status_field = $api_data->row(0)->recharge_response_status_field;
                        $recharge_response_opid_field = $api_data->row(0)->recharge_response_opid_field;
                        $recharge_response_apirefid_field = $api_data->row(0)->recharge_response_apirefid_field;
                        $recharge_response_balance_field = $api_data->row(0)->recharge_response_balance_field;
                        $recharge_response_remark_field = $api_data->row(0)->recharge_response_remark_field;
                        $recharge_response_stat_field = $api_data->row(0)->recharge_response_stat_field;
                        $recharge_response_fos_field = $api_data->row(0)->recharge_response_fos_field;
                        $recharge_response_otf_field = $api_data->row(0)->recharge_response_otf_field;
                        $recharge_response_lapunumber_field = $api_data->row(0)->recharge_response_lapunumber_field;
                        $recharge_response_message_field = $api_data->row(0)->recharge_response_message_field;
                        
                        $pendingOnEmptyTxnId_prop = '';
                        $pendingOnEmptyTxnId = $api_data->row(0)->pendingOnEmptyTxnId;
                        if($pendingOnEmptyTxnId == "yes")
                        {
                            $pendingOnEmptyTxnId_prop = 'checked';
                        }
                        
                        
                        
                        $RecRespSuccessKey = $api_data->row(0)->RecRespSuccessKey;
                        $RecRespPendingKey = $api_data->row(0)->RecRespPendingKey;
                        $RecRespFailureKey = $api_data->row(0)->RecRespFailureKey;
                        $RecRespFailureText = $api_data->row(0)->RecRespFailureText;
                        
                        
                        $status_response_type = '';
                        $status_status_field = '';
                        $status_opid_field = '';
                        $status_state_field = '';
                        $status_fos_field = '';
                        $status_otf_field = '';
                        $status_lapunumber_field = '';
                        $status_message_field = '';
                        $status_success_key = '';
                        $status_pending_key = '';
                        $status_failure_key = '';
                        $status_refund_key = '';
                        $status_notfound_key = '';
                        if($statusapi_data != false)
                        {
                            $status_response_type = $statusapi_data->row(0)->response_type;
                            $status_status_field = $statusapi_data->row(0)->status_field;
                            $status_opid_field = $statusapi_data->row(0)->opid_field;
                            $status_state_field = $statusapi_data->row(0)->state_field;
                            $status_fos_field = $statusapi_data->row(0)->fos_field;
                            $status_otf_field = $statusapi_data->row(0)->otf_field;
                            $status_lapunumber_field = $statusapi_data->row(0)->lapunumber_field;
                            $status_message_field = $statusapi_data->row(0)->message_field;
                            $status_success_key = $statusapi_data->row(0)->success_key;
                            $status_pending_key = $statusapi_data->row(0)->pending_key;
                            $status_failure_key = $statusapi_data->row(0)->failure_key;
                            $status_refund_key = $statusapi_data->row(0)->refund_key;
                            $status_notfound_key = $statusapi_data->row(0)->notfound_key;
                            $status_str_separator = $statusapi_data->row(0)->str_separator;

                            
                        }
                        
                        
                        $callback_reqid_name = '';
                        $callback_apirefid_name = '';
                        $callback_check_through_reqid = '';
                        $callback_status_name = '';
                        $callback_opid_name = '';
                        $callback_success_key = '';
                        $callback_pending_key = '';
                        $callback_failure_key = '';
                        $callback_refund_key = '';
                        $callback_check_through_reqid_prop = '';
                        $callback_check_response_type = '';

                        if($callback_data != false)
                        {
                            $callback_reqid_name = $callback_data->row(0)->reqid_name;
                            $callback_apirefid_name = $callback_data->row(0)->apirefid_name;
                            $callback_check_through_reqid = $callback_data->row(0)->check_through_reqid;
                            $callback_status_name = $callback_data->row(0)->status_name;
                            $callback_opid_name = $callback_data->row(0)->opid_name;
                            $callback_success_key = $callback_data->row(0)->success_key;
                            $callback_pending_key = $callback_data->row(0)->pending_key;
                            $callback_failure_key = $callback_data->row(0)->failure_key;
                            $callback_refund_key = $callback_data->row(0)->refund_key;
                            $callback_check_response_type = $callback_data->row(0)->response_type;
                            
                            
                            if($callback_check_through_reqid == 'yes')
                            {
                                $callback_check_through_reqid_prop = 'checked';
                            }
                        }
                        
                        
                     ?>
                     <tr>
                         <td style="width:300px;" align="right">Is Active : </td>
                         <td>
                             <input <?php echo $is_active_prop; ?> type="checkbox" id="chkisapiactive" name="chkisapiactive" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Enable Recharge : </td>
                         <td>
                             <input <?php echo $enable_recharge_prop; ?> type="checkbox" id="chkenableRecharge" name="chkenableRecharge" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Enable Balance Check : </td>
                         <td>
                             <input <?php echo $enable_balance_check_prop; ?> type="checkbox" id="chkenableBalanceCheck" name="chkenableBalanceCheck" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Enable Status Check : </td>
                         <td>
                             <input <?php echo $enable_status_check_prop; ?> type="checkbox" id="chkenableStatusCheck" name="chkenableStatusCheck" value="yes">
                         </td>
                     </tr>

                     <tr>
                         <td style="width:300px;" align="right">TIME : </td>
                         <td>
                            <div class="input-group wd-150">
				              <div class="input-group-prepend">
				                <div class="input-group-text">
				                  <i class="far fa-clock tx-16 lh-0 op-6"></i>
				                </div>
				                 <input class="form-control" value="<?php echo $api_time_from; ?>" id="txtFromTime" name="txtFromTime" type="text" style="width:120px;" placeholder="From Time">
				                 <input class="form-control" value="<?php echo $api_time_to; ?>" id="txtToTime" name="txtToTime" type="text" style="width:120px;" placeholder="To Time">
				              </div>
				             
				              
				            </div>
                         </td>
                     </tr>

                     <tr>
                         <td style="width:300px;" align="right">Balance Limit : </td>
                         <td>
                             <input type="text" id="txtMinBalanceLimit" name="txtMinBalanceLimit" class="text" placeholder="0" value="<?php echo $min_balance_limit; ?>">
                         </td>
                     </tr>    

                     <tr>
                         <td style="width:300px;" align="right">Host : </td>
                         <td>
                             <input type="text" id="txtHostName" name="txtHostName" class="text" placeholder="e.g http://www.google.com" value="<?php echo $hostname; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 1 : </td>
                         <td>
                             <input type="text" id="txtParam1" name="txtParam1" class="text" placeholder="Api Username of Api Key" value="<?php echo $param1; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 2 : </td>
                         <td>
                             <input type="text" id="txtParam2" name="txtParam2" class="text" placeholder="Api Password of Api pin" value="<?php echo $param2; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 3 : </td>
                         <td>
                             <input type="text" id="txtParam3" name="txtParam3" class="text" value="<?php echo $param3; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 4 : </td>
                         <td>
                             <input type="text" id="txtParam4" name="txtParam4" class="text" value="<?php echo $param4; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 5 : </td>
                         <td>
                             <input type="text" id="txtParam5" name="txtParam5" class="text" value="<?php echo $param5; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 6 : </td>
                         <td>
                             <input type="text" id="txtParam6" name="txtParam6" class="text" value="<?php echo $param6; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 7 : </td>
                         <td>
                             <input type="text" id="txtParam7" name="txtParam7" class="text" value="<?php echo $param7; ?>">
                         </td>
                     </tr>
                     
                     
                     
                     <tr> 
                         <td style="width:300px;" align="right">Header Key 1 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey1" name="txtHeaderKey1" class="text" value="<?php echo $header_key1; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 1 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue1" name="txtHeaderValue1" class="text" value="<?php echo $header_value1; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 2 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey2" name="txtHeaderKey2" class="text" value="<?php echo $header_key2; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 2: </td>
                         <td>
                             <input type="text" id="txtHeaderValue2" name="txtHeaderValue2" class="text" value="<?php echo $header_value2; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 3 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey3" name="txtHeaderKey3" class="text" value="<?php echo $header_key3; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 3 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue3" name="txtHeaderValue3" class="text" value="<?php echo $header_value3; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 4 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey4" name="txtHeaderKey4" class="text" value="<?php echo $header_key4; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 4 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue4" name="txtHeaderValue4" class="text" value="<?php echo $header_value4; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 5 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey5" name="txtHeaderKey5" class="text" value="<?php echo $header_key5; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 5 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue5" name="txtHeaderValue5" class="text" value="<?php echo $header_value5; ?>">
                         </td>
                     </tr>
                     
                     <tr>
                         <td style="width:300px;" align="right">Status Check Api Method : </td>
                         <td>
                            <select id="ddlstatuscheckapimethod" name="ddlstatuscheckapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                             </select>
                             <script language="javascript">
                                 document.getElementById("ddlstatuscheckapimethod").value = '<?php echo $status_check_api_method; ?>';
                             </script>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Status Check API : </td>
                         <td>
                             <input type="text" id="txtStatusCheckApi" name="txtStatusCheckApi" class="text"  value="<?php echo $status_check_api; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Validation Api Method : </td>
                         <td>
                            <select id="ddlvalidationcheckapimethod" name="ddlvalidationcheckapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                             </select>
                             <script language="javascript">
                                 document.getElementById("ddlvalidationcheckapimethod").value = '<?php echo $validation_api_method; ?>';
                             </script>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Validation Check API : </td>
                         <td>
                             <input type="text" id="txtValidationCheckApi" name="txtValidationCheckApi" class="text" value="<?php echo $validation_api; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Transaction Api Method : </td>
                         <td>
                            <select id="ddltransactionapimethod" name="ddltransactionapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                             </select>
                             <script language="javascript">
                                 document.getElementById("ddltransactionapimethod").value = '<?php echo $transaction_api_method; ?>';
                             </script>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Prepaid : </td>
                        <td>
                             <textarea id="txtApiPrepaid" name="txtApiPrepaid" class="text"><?php echo $api_prepaid; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api DTH : </td>
                        <td>
                             <textarea id="txtApiDth" name="txtApiDth" class="text"><?php echo $api_dth; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Postpaid : </td>
                        <td>
                             <textarea id="txtApiPostpaid" name="txtApiPostpaid" class="text"><?php echo $api_postpaid; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Electricity : </td>
                        <td>
                             <textarea id="txtApiElectricity" name="txtApiElectricity" class="text"><?php echo $api_electricity; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Gas : </td>
                        <td>
                             <textarea id="txtApiGas" name="txtApiGas" class="text"><?php echo $api_gas; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Insurance : </td>
                        <td>
                             <textarea id="txtApiInsurance" name="txtApiInsurance" class="text"><?php echo $api_insurance; ?></textarea>
                         </td>
                     </tr>
                     
                     <tr>
                         <td style="width:200px;" align="right">Dynamic Callback Url : </td>
                        <td>
                             <textarea id="txtDynamicCallBackUrl" name="txtDynamicCallBackUrl" class="text" readonly><?php echo base_url()."GetCallBack/index/".$this->Encr->encrypt($api_data->row(0)->Id); ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Parser : </td>
                        <td>
                           <?php 
                            $parserlist= $this->db->query("select * from tblresponseparser order by parser_name");
                            ?>
                            <select id="ddlparser" name="ddlparser" class="text" onchange="togglefields()">
                                 <option value="0"></option>
                                 <?php foreach($parserlist->result() as $rwparser){ ?>
                                 <option value="<?php echo $rwparser->Id;  ?>"><?php echo $rwparser->parser_name;  ?></option>
                                 <?php } ?>
                             </select>
                             <script language="javascript">
                                 document.getElementById("ddlparser").value = '<?php echo $response_parser; ?>';
                             </script>
                             <script language="javascript">
                                 function togglefields()
                                 {
                                   
                                     var parserid = document.getElementById("ddlparser").value;
                                     if(parserid > 0)
                                     {
                                         $("#txtRecRespStatusField").prop('disabled', true); 
                                         $("#txtRecRespOpIdField").prop('disabled', true); 
                                         $("#txtRecRespApirefidField").prop('disabled', true); 
                                         $("#txtRecRespBalanceField").prop('disabled', true); 
                                         $("#txtRecRespRemarkField").prop('disabled', true); 
                                         $("#txtRecRespStateField").prop('disabled', true); 
                                         $("#txtRecRespFosField").prop('disabled', true); 
                                         $("#txtRecRespOtfField").prop('disabled', true); 
                                         $("#txtRecRespLapuNumberField").prop('disabled', true); 
                                         $("#txtRecRespMessageField").prop('disabled', true); 
                                         
                                         $("#txtRecRespSuccessKey").prop('disabled', true); 
                                         $("#txtRecRespPendingKey").prop('disabled', true); 
                                         $("#txtRecRespFailureKey").prop('disabled', true); 
                                     }
                                     else
                                     {
                                        $("#txtRecRespStatusField").prop('disabled', false); 
                                         $("#txtRecRespOpIdField").prop('disabled', false); 
                                         $("#txtRecRespApirefidField").prop('disabled', false); 
                                         $("#txtRecRespBalanceField").prop('disabled', false); 
                                         $("#txtRecRespRemarkField").prop('disabled', false); 
                                         $("#txtRecRespStateField").prop('disabled', false); 
                                         $("#txtRecRespFosField").prop('disabled', false); 
                                         $("#txtRecRespOtfField").prop('disabled', false); 
                                         $("#txtRecRespLapuNumberField").prop('disabled', false); 
                                         $("#txtRecRespMessageField").prop('disabled', false); 
                                         $("#txtRecRespSuccessKey").prop('disabled', false); 
                                         $("#txtRecRespPendingKey").prop('disabled', false); 
                                         $("#txtRecRespFailureKey").prop('disabled', false); 
                                     }
                                 }
                             </script>
                         </td>
                     </tr>
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response type : </td>
                        <td>
                             <select id="ddlrecRespType" name="ddlrecRespType" class="text">
                                 <option value="JSON">JSON</option>
                                 <option value="XML">XML</option>
                                 <option value="CSV">CSV</option>
                                 <option value="TEXT">TEXT</option>
                                 <option value="PARSER">PARSER</option>
                             </select>
                             <script language="javascript">
                                 document.getElementById("ddlrecRespType").value = '<?php echo $recharge_response_type; ?>';
                             </script>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Response Separator : </td>
                        <td>
                            <textarea id="txtRecRespSeparatorField" name="txtRecRespSeparatorField" class="text" ><?php echo $response_separator; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Status Field : </td>
                        <td>
                            <textarea id="txtRecRespStatusField" name="txtRecRespStatusField" class="text" ><?php echo $recharge_response_status_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                        
                         <td style="width:200px;" align="right">Recharge Response Opid Field : </td>
                        <td>
                            <textarea id="txtRecRespOpIdField" name="txtRecRespOpIdField" class="text" ><?php echo $recharge_response_opid_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response ApiRefId Field : </td>
                        <td>
                            <textarea id="txtRecRespApirefidField" name="txtRecRespApirefidField" class="text" ><?php echo $recharge_response_apirefid_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Balance Field : </td>
                        <td>
                            <textarea id="txtRecRespBalanceField" name="txtRecRespBalanceField" class="text" ><?php echo $recharge_response_balance_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Remark Field : </td>
                        <td>
                            <textarea id="txtRecRespRemarkField" name="txtRecRespRemarkField" class="text" ><?php echo $recharge_response_remark_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response State Field : </td>
                        <td>
                            <textarea id="txtRecRespStateField" name="txtRecRespStateField" class="text" ><?php echo $recharge_response_stat_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Fos Field : </td>
                        <td>
                            <textarea id="txtRecRespFosField" name="txtRecRespFosField" class="text" ><?php echo $recharge_response_fos_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Otf Field : </td>
                        <td>
                            <textarea id="txtRecRespOtfField" name="txtRecRespOtfField" class="text" ><?php echo $recharge_response_otf_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response LapuNumber Field : </td>
                        <td>
                            <textarea id="txtRecRespLapuNumberField" name="txtRecRespLapuNumberField" class="text" ><?php echo $recharge_response_lapunumber_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                        ,,
                         <td style="width:200px;" align="right">Recharge Response Message Field : </td>
                        <td>
                            <textarea id="txtRecRespMessageField" name="txtRecRespMessageField" class="text" ><?php echo $recharge_response_message_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Keep Transaction Pendign On Empty OpId : </td>
                         <td>
                             <input <?php echo $pendingOnEmptyTxnId_prop; ?> type="checkbox" id="chkKeepTxnPendingEmptyOpid" name="chkKeepTxnPendingEmptyOpid" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Success Key : </td>
                        <td>
                            <textarea id="txtRecRespSuccessKey" name="txtRecRespSuccessKey" class="text" ><?php echo $RecRespSuccessKey; ?></textarea>
                            <br>Comma Separated Values e.g. SUCCESS,SUCC,success,Success
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Pending Key : </td>
                        <td>
                            <textarea id="txtRecRespPendingKey" name="txtRecRespPendingKey" class="text" ><?php echo $RecRespPendingKey; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Failure Key : </td>
                        <td>
                            <textarea id="txtRecRespFailureKey" name="txtRecRespFailureKey" class="text" ><?php echo $RecRespFailureKey; ?></textarea>
                         </td>
                     </tr>
                     


                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Failure Text : </td>
                        <td>
                            <textarea id="txtRecRespFailureText" name="txtRecRespFailureText" class="text" ><?php echo $RecRespFailureText; ?></textarea>
                         </td>
                     </tr>
                     
                     
                     
                     <tr>
                         <td colspan="2"><br><hr><br></td>
                     </tr>
                     
                     
                     
                     <tr>
                         <td style="width:300px;" align="right">Balance Check Api Method : </td>
                         <td>
                            <select id="ddlbalcheckapimethod" name="ddlbalcheckapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                                 
                             </select>
                             
                             <script language="javascript">
                                 document.getElementById("ddlbalcheckapimethod").value = '<?php echo $balance_check_api_method; ?>';
                             </script>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Balance Check API : </td>
                         <td>
                             <input type="text" id="txtBalnaceCheckApi" name="txtBalnaceCheckApi" class="text" value="<?php echo $balance_ceck_api; ?>">
                             <br>
                             <p>For raw body separate with url and the body content with @body. e.g. http://gogle.com@body{"query":"hello"}</p>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Balance Check Response Type : </td>
                        <td>
                            <select id="ddlBalanceCheckResponseType" name="ddlBalanceCheckResponseType" class="text">
                                 <option value="JSON">JSON</option>
                                 <option value="XML">XML</option>
                                 <option value="CSV">CSV</option>
                                 <option value="PARSER">PARSER</option>
                             </select>
                             <script language="javascript">
                                 document.getElementById("ddlBalanceCheckResponseType").value = '<?php echo $balnace_check_response_type; ?>';
                             </script>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Balance Check Response Balance Field Name : </td>
                        <td>
                             <textarea id="txtBalanceCheckRespBalFieldName" name="txtBalanceCheckRespBalFieldName" class="text" ><?php echo $balnace_check_response_balfieldName; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Balance Check Start Word: </td>
                         <td>
                             <input type="text" id="txtbalance_check_start_word" name="txtbalance_check_start_word" class="text" value="<?php echo $balance_check_start_word; ?>">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Balance Check End Word: </td>
                         <td>
                             <input type="text" id="txtbalance_check_end_word" name="txtbalance_check_end_word" class="text" value="<?php echo $balance_check_end_word; ?>">
                         </td>
                     </tr>
                     
                     
                     
                 </table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-6 -->
         
        </div>
        
   <!-- status check start -->     
        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Status Check</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body" style="background-color:#F2F2F2">
                 
                   <table  class="mytablestyle" style="color:#00000E">
                   
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response type</td>
                        <td>
                             <select id="ddlStatusCheckRespType" name="ddlStatusCheckRespType" class="text">
                                 <option value="json">json</option>
                                 <option value="xml">xml</option>
                                 <option value="csv">csv</option>
                             </select>
                             <script language="javascript">
                                 document.getElementById("ddlStatusCheckRespType").value = '<?php echo $status_response_type; ?>';
                             </script>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Separator</td>
                        <td>
                            <textarea id="txtStatusCheckRespSeparator" name="txtStatusCheckRespSeparator" class="text" ><?php echo $status_str_separator; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Status Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespStatusField" name="txtStatusCheckRespStatusField" class="text" ><?php echo $status_status_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response OpId Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespOpIdField" name="txtStatusCheckRespOpIdField" class="text" ><?php echo $status_opid_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response State Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespStateField" name="txtStatusCheckRespStateField" class="text" ><?php echo $status_state_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Fos Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespFosField" name="txtStatusCheckRespFosField" class="text" ><?php echo $status_fos_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Otf Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespOtfField" name="txtStatusCheckRespOtfField" class="text" ><?php echo $status_otf_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response LapuNumber Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespLapuNumberField" name="txtStatusCheckRespLapuNumberField" class="text" ><?php echo $status_lapunumber_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Message Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespMessageField" name="txtStatusCheckRespMessageField" class="text" ><?php echo $status_message_field; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Success Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespSuccessKey" name="txtStatusCheckRespSuccessKey" class="text" ><?php echo $status_success_key; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Pending Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespPendingKey" name="txtStatusCheckRespPendingKey" class="text" ><?php echo $status_pending_key; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Failure Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespFailureKey" name="txtStatusCheckRespFailureKey" class="text" ><?php echo $status_failure_key; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Refund Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespRefundKey" name="txtStatusCheckRespRefundKey" class="text" ><?php echo $status_refund_key; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response NotFound Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespNotFoundKey" name="txtStatusCheckRespNotFoundKey" class="text" ><?php echo $status_notfound_key; ?></textarea>
                         </td>
                     </tr>
                    
                 </table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-6 -->
        </div>
        
        
       <!-- callback start -->      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Call Back Url Settings</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
               <div class="card-body"  style="background-color:#F2F2F2">
                 <table  class="mytablestyle" style="color:#00000E">


                    <tr>
                         <td style="width:300px;"   align="right">CallBack Response Type</td>
                        <td>
                            <select id="ddlcallback_response_type" name="ddlcallback_response_type" class="text">
                                <option value="get">get</option>
                                <option value="post">post</option>
                                <option value="PARSER">PARSER</option>
                            </select>
                            <script language="javascript">
                                document.getElementById("ddlcallback_response_type").value = '<?php echo $callback_check_response_type; ?>';
                            </script>
                         </td>
                     </tr>
                    <tr>
                         <td style="width:300px;"   align="right">CallBack reqid Name</td>
                        <td>
                            <textarea id="txtCallbackReqIdName" name="txtCallbackReqIdName" class="text" ><?php echo $callback_reqid_name; ?></textarea>
                         </td>
                     </tr>
                    <tr>
                         <td style="width:300px;"   align="right">CallBack apirefid Name</td>
                        <td>
                            <textarea id="txtCallbackApiRefIdName" name="txtCallbackApiRefIdName" class="text" ><?php echo $callback_apirefid_name; ?></textarea>
                         </td>
                     </tr>
                      <tr>
                         <td style="width:300px;"   align="right">CallBack Check Through reqid</td>
                         <td>
                             <input <?php echo $callback_check_through_reqid_prop; ?> type="checkbox" id="chkcallbackcheckthroughreqid" name="chkcallbackcheckthroughreqid" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack status Name</td>
                        <td>
                            <textarea id="txtCallbackstatusName" name="txtCallbackstatusName" class="text" ><?php echo $callback_status_name; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack opid Name</td>
                        <td>
                            <textarea id="txtCallbackopidName" name="txtCallbackopidName" class="text" ><?php echo $callback_opid_name; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Success Key</td>
                        <td>
                            <textarea id="txtCallbackSuccessKey" name="txtCallbackSuccessKey" class="text" ><?php echo $callback_success_key; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Failure Key</td>
                        <td>
                            <textarea id="txtCallbackFailureKey" name="txtCallbackFailureKey" class="text" ><?php echo $callback_failure_key; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Pending Key</td>
                        <td>
                            <textarea id="txtCallbackPendingKey" name="txtCallbackPendingKey" class="text" ><?php echo $callback_pending_key; ?></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Refund Key</td>
                        <td>
                            <textarea id="txtCallbackRefundKey" name="txtCallbackRefundKey" class="text" ><?php echo $callback_refund_key; ?></textarea>
                         </td>
                     </tr>
                    
                 </table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-6 -->
          
        </div>
        
        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Commission Info</h6>
                <span class="tx-12 tx-uppercase">Global Commission Settings</span>
              </div><!-- card-header -->
              <div class="card-body">
                 
                <table  class="table table-bordered table-striped" style="color:#00000E">
                    
                     <tr>
                         
                        <td>
                             <h5>is Percent</h5>
                            <select id="ddlflobalisper" name="ddlflobalisper" class="text">
                                <option value="%">%</option>
                                <option value="AMOUNT">Amount</option>
                            </select>
                         </td>
                     
                        <td>
                            <h5>Commission</h5>
                            <input type="text" id="txtGlobalCommission" name="txtGlobalCommission" class="text" >
                         </td>
                     </tr>
                 </table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-6 -->
         </div>
          
          
          <?php

$str_company_id = "";
foreach($service_array as $service_rw)
{

?>  
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0"><?php echo  $service_rw; ?></h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <table  class="table table-bordered table-striped" style="color:#00000E">
                      <thead class="thead-colored thead-primary" style="width:800px;" >
                    <tr>
                        <th>Sr</th>
                        <th style="width:200px;max-width:200px;">Company Name</th>
                        
                        <th>Commission</th>
                        <th>Is Percent</th>
                        <th></th>
                        <th>Slab</th>
                        <th>OPParam1</th>
                        <th>OPParam2</th>
                        <th>OPParam3</th>
                        <th>OPParam4</th>
                        <th>OPParam5</th>
                    </tr> 
                    </thead>
                  
                <?php 
                $i=1;
                    $dataarr = $data[$service_rw];
                    foreach( $dataarr as $opar)
                    {
                         $str_company_id.=$opar->company_id.",";
                    ?>
                       <tr>
                            <td><?php echo $i; ?></td>
                            <td style="width:200px;max-width:200px;"><?php echo $opar->company_name; ?></td>
                           
                            <td>
                                <input type="text" id="txtComm<?php echo $opar->company_id; ?>" name="txtComm[<?php echo $opar->company_id; ?>]" value="<?php echo $opar->commission; ?>" class="text" style="width:60px">
                            </td>
                            <td>
                                <select  id="ddlcommtype<?php echo $opar->company_id; ?>" name="ddlcommtype[<?php echo $opar->company_id; ?>]" class="text" style="width:60px">
                                    <option value="PER">%</option>
                                    <option value="AMOUNT">AMOUNT</option>
                                </select>
                                <script language="javascript">document.getElementById("ddlcommtype"+<?php echo $opar->company_id; ?>).value = '<?php echo $opar->commission_type; ?>';</script>
                            </td>
                            <td>or</td>
                            <td>
                                <select  id="ddlslab<?php echo $opar->company_id; ?>" name="ddlslab[<?php echo $opar->company_id; ?>]" class="text" style="width:60px">
                                    
                                </select>
                            </td>
                             <td>
                                <input type="text" id="txtOpParam1<?php echo $opar->company_id; ?>" name="txtOpParam1[<?php echo $opar->company_id; ?>]" value="<?php echo $opar->OpParam1; ?>"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam2<?php echo $opar->company_id; ?>" name="txtOpParam2[<?php echo $opar->company_id; ?>]" value="<?php echo $opar->OpParam2; ?>"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam3<?php echo $opar->company_id; ?>" name="txtOpParam3[<?php echo $opar->company_id; ?>]" value="<?php echo $opar->OpParam3; ?>"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam4<?php echo $opar->company_id; ?>" name="txtOpParam4[<?php echo $opar->company_id; ?>]" value="<?php echo $opar->OpParam4; ?>"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam5<?php echo $opar->company_id; ?>" name="txtOpParam5[<?php echo $opar->company_id; ?>]" value="<?php echo $opar->OpParam5; ?>"  class="text" style="width:60px">
                            </td>
                        </tr>
                       
                    <?php $i++;}
                
                ?>
                </table>
                
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
<?php } ?> 



<div>
    <input type="hidden" id="hidcompany_ids" value="<?php echo $str_company_id; ?>">
    <center>
        <input type="submit" id="btnEditAll" name="btnEditAll" value="Submit" class="btn btn-primary btn-lg" >
        <img style="width:60px;display:none" id="imgloadingbtn" src="<?php echo base_url()."Loading.gif"; ?>" ></span>
        </center>   
</form>    
    <script language="javascript">
function changealldata()
{
    //  $('#myOverlay').show();
    //  $('#myModal').modal({show:true});
    var ids = document.getElementById("hidcompany_ids").value;
    var struserarr = ids.split(",");
    for(i=0;i<struserarr.length;i++)
	{
	     document.getElementById("imgloadingbtn").style.display="block";
		var id = struserarr[i];
		changeCommission(id);
		 document.getElementById("imgloadingbtn").style.display="none";
	}
    //  $('#myModal').modal('hide');
    //  $('#myModal').hide();
}
function changeCommission(id)
{
  
	var company_id = id;
	var commission = document.getElementById("txtComm"+id).value;
	var commission_type = document.getElementById("ddlcommtype"+id).value;
	var commission_slab = document.getElementById("ddlslab"+id).value;
	var group_id ='0';
	if(commission <= 5)
	{
	  if(company_id > 0)
	  {
	      
		$.ajax({
          type: "POST",
          url:'<?php echo base_url();?>_Admin/commission_settings/ChangeCommission',
          cache:false,
          data:{'company_id':company_id,'group_id':group_id,'commission':commission,'commission_type':commission_type,'commission_slab':commission_slab},
          beforeSend: function() 
		  {
           
          },
          success: function(html)
          {
            
          },
          complete:function()
    	  {
    		  // document.getElementById("imgloadingbtn").style.display="none";
    			//$('#myLoader').hide();
    	  }
        });
	  }
    }
  
	
}
function changeCommission_all()
{
    var params = new Array()
   var ids = document.getElementById("hidcompany_ids").value;
   var struserarr = ids.split(",");
   for(i=0;i<struserarr.length;i++)
   {
       var jcompany_id = struserarr[i];
       if(jcompany_id > 0)
       {
           params[jcompany_id]= document.getElementById("txtComm"+jcompany_id).value+"@"+document.getElementById("ddlcommtype"+jcompany_id).value+"@"+document.getElementById("ddlslab"+jcompany_id).value;
       }
       
       
       
   }
   $.ajax({
          type: "POST",
          url:'<?php echo base_url();?>_Admin/commission_settings/ChangeCommission',
          cache:false,
          data:{'params':params,'group_id':'0'},
          beforeSend: function() 
		  {
		    document.getElementById("imgloadingbtn").style.display="block";
            $('#myModal').modal({show:true});
          },
          success: function(html)
          {
            console.log( html );
          },
          complete:function()
    	  {
    		document.getElementById("imgloadingbtn").style.display="none";
    		$('#myModal').modal('hide');
    		$('#myModal').hide();
    	  }
        });
  
	

	
	 
	  
	      
		
	  
    
  
	
}
</script>
    
</div>
       
        
      
      </div><!-- br-pagebody -->
      
      <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>
	<script src="<?php echo base_url();?>lib/timepicker/jquery.timepicker.min.js"></script>
    <script src="<?php echo base_url();?>js/bracket.js"></script>
  </body>
</html>