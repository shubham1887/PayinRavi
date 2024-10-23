<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>API INTEGRATION</title>

    
     
    
    <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
        
       <form id="frmApi" action="" method="POST">
        
        
        
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
                             <input type="text" id="txtApiName" name="txtApiName" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Api Type : </td>
                         <td>
                             <select id="ddlapitype" name="ddlapitype" class="text">
                                 <option value="http">http</option>
                                 <option value="https">https</option>
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Is Active : </td>
                         <td>
                             <input type="checkbox" id="chkisapiactive" name="chkisapiactive" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Enable Recharge : </td>
                         <td>
                             <input type="checkbox" id="chkenableRecharge" name="chkenableRecharge" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Enable Balance Check : </td>
                         <td>
                             <input type="checkbox" id="chkenableBalanceCheck" name="chkenableBalanceCheck" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Enable Status Check : </td>
                         <td>
                             <input type="checkbox" id="chkenableStatusCheck" name="chkenableStatusCheck" value="yes">
                         </td>
                     </tr>
                     <tr >
                         <td style="width:300px;" align="right">Select Api Group: </td>
                         <td >
                             <select id="ddldevapi" name="ddldevapi"  class="text" >
                                 <option value="0"></option>
                                <?php echo $this->Master->getApiDropdown(); ?>     
                             </select>
                            
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Host : </td>
                         <td>
                             <input type="text" id="txtHostName" name="txtHostName" class="text" placeholder="e.g http://www.google.com">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 1 : </td>
                         <td>
                             <input type="text" id="txtParam1" name="txtParam1" class="text" placeholder="Api Username of Api Key">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 2 : </td>
                         <td>
                             <input type="text" id="txtParam2" name="txtParam2" class="text" placeholder="Api Password of Api pin">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 3 : </td>
                         <td>
                             <input type="text" id="txtParam3" name="txtParam3" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 4 : </td>
                         <td>
                             <input type="text" id="txtParam4" name="txtParam4" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 5 : </td>
                         <td>
                             <input type="text" id="txtParam5" name="txtParam5" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 6 : </td>
                         <td>
                             <input type="text" id="txtParam6" name="txtParam6" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Param 7 : </td>
                         <td>
                             <input type="text" id="txtParam7" name="txtParam7" class="text">
                         </td>
                     </tr>
                     
                     
                     
                     <tr> 
                         <td style="width:300px;" align="right">Header Key 1 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey1" name="txtHeaderKey1" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 1 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue1" name="txtHeaderValue1" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 2 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey2" name="txtHeaderKey2" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 2: </td>
                         <td>
                             <input type="text" id="txtHeaderValue2" name="txtHeaderValue2" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 3 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey3" name="txtHeaderKey3" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 3 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue3" name="txtHeaderValue3" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 4 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey4" name="txtHeaderKey4" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 4 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue4" name="txtHeaderValue4" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Key 5 : </td>
                         <td>
                             <input type="text" id="txtHeaderKey5" name="txtHeaderKey5" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Header Value 5 : </td>
                         <td>
                             <input type="text" id="txtHeaderValue5" name="txtHeaderValue5" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Balance Check Api Method : </td>
                         <td>
                            <select id="ddlbalcheckapimethod" name="ddlbalcheckapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Balance Check API : </td>
                         <td>
                             <input type="text" id="txtBalnaceCheckApi" name="txtBalnaceCheckApi" class="text">
                             <br>
                             <p>For raw body separate with url and the body content with @body. e.g. http://gogle.com@body{"query":"hello"}</p>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;" align="right">Status Check Api Method : </td>
                         <td>
                            <select id="ddlstatuscheckapimethod" name="ddlstatuscheckapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Status Check API : </td>
                         <td>
                             <input type="text" id="txtStatusCheckApi" name="txtStatusCheckApi" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Validation Api Method : </td>
                         <td>
                            <select id="ddlvalidationcheckapimethod" name="ddlvalidationcheckapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Validation Check API : </td>
                         <td>
                             <input type="text" id="txtValidationCheckApi" name="txtValidationCheckApi" class="text">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Transaction Api Method : </td>
                         <td>
                            <select id="ddltransactionapimethod" name="ddltransactionapimethod" class="text">
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Prepaid : </td>
                        <td>
                             <textarea id="txtApiPrepaid" name="txtApiPrepaid" class="text"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api DTH : </td>
                        <td>
                             <textarea id="txtApiDth" name="txtApiDth" class="text"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Postpaid : </td>
                        <td>
                             <textarea id="txtApiPostpaid" name="txtApiPostpaid" class="text"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Electricity : </td>
                        <td>
                             <textarea id="txtApiElectricity" name="txtApiElectricity" class="text"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Gas : </td>
                        <td>
                             <textarea id="txtApiGas" name="txtApiGas" class="text"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Api Insurance : </td>
                        <td>
                             <textarea id="txtApiInsurance" name="txtApiInsurance" class="text"></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Dynamic Callback Url : </td>
                        <td>
                             <textarea id="txtDynamicCallBackUrl" name="txtDynamicCallBackUrl" class="text" readonly></textarea>
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
                         <td style="width:200px;" align="right">Balance Check Response Type : </td>
                        <td>
                            <select id="ddlBalanceCheckResponseType" name="ddlBalanceCheckResponseType" class="text">
                                 <option value="json">json</option>
                                 <option value="xml">xml</option>
                                 <option value="csv">CSV</option>
                                 <option value="text">TEXT</option>
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Balance Check Response Balance Field Name : </td>
                        <td>
                             <textarea id="txtBalanceCheckRespBalFieldName" name="txtBalanceCheckRespBalFieldName" class="text" ></textarea>
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
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Response Separator : </td>
                        <td>
                            <textarea id="txtRecRespSeparatorField" name="txtRecRespSeparatorField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Status Field : </td>
                        <td>
                            <textarea id="txtRecRespStatusField" name="txtRecRespStatusField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Opid Field : </td>
                        <td>
                            <textarea id="txtRecRespOpIdField" name="txtRecRespOpIdField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response ApiRefId Field : </td>
                        <td>
                            <textarea id="txtRecRespApirefidField" name="txtRecRespApirefidField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Balance Field : </td>
                        <td>
                            <textarea id="txtRecRespBalanceField" name="txtRecRespBalanceField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Remark Field : </td>
                        <td>
                            <textarea id="txtRecRespRemarkField" name="txtRecRespRemarkField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response State Field : </td>
                        <td>
                            <textarea id="txtRecRespStateField" name="txtRecRespStateField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Fos Field : </td>
                        <td>
                            <textarea id="txtRecRespFosField" name="txtRecRespFosField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Otf Field : </td>
                        <td>
                            <textarea id="txtRecRespOtfField" name="txtRecRespOtfField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response LapuNumber Field : </td>
                        <td>
                            <textarea id="txtRecRespLapuNumberField" name="txtRecRespLapuNumberField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Message Field : </td>
                        <td>
                            <textarea id="txtRecRespMessageField" name="txtRecRespMessageField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Keep Transaction Pendign On Empty OpId : </td>
                         <td>
                             <input type="checkbox" id="chkKeepTxnPendingEmptyOpid" name="chkKeepTxnPendingEmptyOpid" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Success Key : </td>
                        <td>
                            <textarea id="txtRecRespSuccessKey" name="txtRecRespSuccessKey" class="text" ></textarea>
                            <br>Comma Separated Values e.g. SUCCESS,SUCC,success,Success
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Pending Key : </td>
                        <td>
                            <textarea id="txtRecRespPendingKey" name="txtRecRespPendingKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:200px;" align="right">Recharge Response Failure Key : </td>
                        <td>
                            <textarea id="txtRecRespFailureKey" name="txtRecRespFailureKey" class="text" ></textarea>
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
                                 <option value="text">text</option>
                             </select>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Status Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespStatusField" name="txtStatusCheckRespStatusField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response OpId Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespOpIdField" name="txtStatusCheckRespOpIdField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response State Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespStateField" name="txtStatusCheckRespStateField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Fos Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespFosField" name="txtStatusCheckRespFosField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Otf Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespOtfField" name="txtStatusCheckRespOtfField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response LapuNumber Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespLapuNumberField" name="txtStatusCheckRespLapuNumberField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Message Field</td>
                        <td>
                            <textarea id="txtStatusCheckRespMessageField" name="txtStatusCheckRespMessageField" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Success Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespSuccessKey" name="txtStatusCheckRespSuccessKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Pending Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespPendingKey" name="txtStatusCheckRespPendingKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Failure Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespFailureKey" name="txtStatusCheckRespFailureKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response Refund Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespRefundKey" name="txtStatusCheckRespRefundKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"  align="right">Status Check Response NotFound Key</td>
                        <td>
                            <textarea id="txtStatusCheckRespNotFoundKey" name="txtStatusCheckRespNotFoundKey" class="text" ></textarea>
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
                         <td style="width:300px;"   align="right">CallBack reqid Name</td>
                        <td>
                            <textarea id="txtCallbackReqIdName" name="txtCallbackReqIdName" class="text" ></textarea>
                         </td>
                     </tr>
                    <tr>
                         <td style="width:300px;"   align="right">CallBack apirefid Name</td>
                        <td>
                            <textarea id="txtCallbackApiRefIdName" name="txtCallbackApiRefIdName" class="text" ></textarea>
                         </td>
                     </tr>
                      <tr>
                         <td style="width:300px;"   align="right">CallBack Check Through reqid</td>
                         <td>
                             <input type="checkbox" id="chkcallbackcheckthroughreqid" name="chkcallbackcheckthroughreqid" value="yes">
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack status Name</td>
                        <td>
                            <textarea id="txtCallbackstatusName" name="txtCallbackstatusName" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack opid Name</td>
                        <td>
                            <textarea id="txtCallbackopidName" name="txtCallbackopidName" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Success Key</td>
                        <td>
                            <textarea id="txtCallbackSuccessKey" name="txtCallbackSuccessKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Failure Key</td>
                        <td>
                            <textarea id="txtCallbackFailureKey" name="txtCallbackFailureKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Pending Key</td>
                        <td>
                            <textarea id="txtCallbackPendingKey" name="txtCallbackPendingKey" class="text" ></textarea>
                         </td>
                     </tr>
                     <tr>
                         <td style="width:300px;"   align="right">CallBack Refund Key</td>
                        <td>
                            <textarea id="txtCallbackRefundKey" name="txtCallbackRefundKey" class="text" ></textarea>
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
                                <input type="text" id="txtComm<?php echo $opar->company_id; ?>" name="txtComm[<?php echo $opar->company_id; ?>]"  class="text" style="width:60px">
                            </td>
                            <td>
                                <select  id="ddlcommtype<?php echo $opar->company_id; ?>" name="ddlcommtype[<?php echo $opar->company_id; ?>]" class="text" style="width:60px">
                                    <option value="PER">%</option>
                                    <option value="AMOUNT">AMOUNT</option>
                                </select>
                                
                            </td>
                            <td>or</td>
                            <td>
                                <select  id="ddlslab<?php echo $opar->company_id; ?>" name="ddlslab[<?php echo $opar->company_id; ?>]" class="text" style="width:80px">
                                    
                                </select>
                            </td>
                            <td>
                                <input type="text" id="txtOpParam1<?php echo $opar->company_id; ?>" name="txtOpParam1[<?php echo $opar->company_id; ?>]"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam2<?php echo $opar->company_id; ?>" name="txtOpParam2[<?php echo $opar->company_id; ?>]"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam3<?php echo $opar->company_id; ?>" name="txtOpParam3[<?php echo $opar->company_id; ?>]"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam4<?php echo $opar->company_id; ?>" name="txtOpParam4[<?php echo $opar->company_id; ?>]"  class="text" style="width:60px">
                            </td>
                            <td>
                                <input type="text" id="txtOpParam5<?php echo $opar->company_id; ?>" name="txtOpParam5[<?php echo $opar->company_id; ?>]"  class="text" style="width:60px">
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
    <input type="hidden" id="hidgetapisettingsurl" value="<?php echo base_url()."_Admin/Api_integration/getmasterapisettings"; ?>">
    <input type="hidden" id="hidcompany_ids" value="<?php echo $str_company_id; ?>">
    
    <center>
        <input type="submit" id="btnSubmitAll" name="btnSubmitAll" value="Submit" class="btn btn-primary btn-lg" >
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


$("#ddldevapi").change( function()
           {
              var api_id = document.getElementById("ddldevapi").value;
              if(api_id > 0)
              {
                $.ajax({
                        type:"POST",
                        url:document.getElementById("hidgetapisettingsurl").value,
                        data:{'api_id':api_id},
                        beforeSend: function() 
                        {
                           //document.getElementById("popupalertdiv").style.display="none";
                           //document.getElementById("spanloader").style.display="block";
                        },
                        success: function(response)
                        {
                           
                            //document.getElementById("spanloader").style.display="none";
                            //document.getElementById("popupalertdiv").style.display="block";
                            var jsonobj = JSON.parse(response);
                            var msg = jsonobj.message;
                            var sts = jsonobj.status;
                            var stscode = jsonobj.statuscode;
                            if(stscode == "TXN")
                            {
                                var data = jsonobj.data;
                               
                                var api_type = data.api_type
                                var is_active = data.is_active
                                
                                var enable_recharge = data.enable_recharge
                                var enable_balance_check = data.enable_balance_check
                                var enable_status_check = data.enable_status_check
                                var hostname = data.hostname
                                var param1 = data.param1
                                var param2 = data.param2
                                var param3 = data.param3
                                var param4 = data.param4
                                var param5 = data.param5
                                var param6 = data.param6
                                var param7 = data.param7
                                var header_key1 = data.header_key1
                                var header_value1 = data.header_value1
                                var header_key2 = data.header_key2
                                var header_value2 = data.header_value2
                                var header_key3 = data.header_key3
                                var header_value3 = data.header_value3
                                var header_key4 = data.header_key4
                                var header_value4 = data.header_value4
                                var header_key5 = data.header_key5
                                var header_value5 = data.header_value5
                                var balance_check_api_method = data.balance_check_api_method
                                var balance_ceck_api = data.balance_ceck_api
                                var status_check_api_method = data.status_check_api_method
                                var status_check_api = data.status_check_api
                                var validation_api_method = data.validation_api_method
                                var validation_api = data.validation_api
                                var transaction_api_method = data.transaction_api_method
                                var api_prepaid = data.api_prepaid
                                var api_dth = data.api_dth
                                var api_postpaid = data.api_postpaid
                                var api_electricity = data.api_electricity
                                var api_gas = data.api_gas
                                var api_insurance = data.api_insurance
                                var dunamic_callback_url = data.dunamic_callback_url
                                var response_parser = data.response_parser
                                var balnace_check_response_type = data.balnace_check_response_type
                                var balnace_check_response_balfieldName = data.balnace_check_response_balfieldName
                                var recharge_response_type = data.recharge_response_type
                                var response_separator = data.response_separator
                                var recharge_response_status_field = data.recharge_response_status_field
                                var recharge_response_opid_field = data.recharge_response_opid_field
                                var recharge_response_apirefid_field = data.recharge_response_apirefid_field
                                var recharge_response_balance_field = data.recharge_response_balance_field
                                var recharge_response_remark_field = data.recharge_response_remark_field
                                var recharge_response_stat_field = data.recharge_response_stat_field
                                var recharge_response_fos_field = data.recharge_response_fos_field
                                var recharge_response_otf_field = data.recharge_response_otf_field
                                var recharge_response_lapunumber_field = data.recharge_response_lapunumber_field
                                var recharge_response_message_field = data.recharge_response_message_field
                                var pendingOnEmptyTxnId = data.pendingOnEmptyTxnId
                                var RecRespSuccessKey = data.RecRespSuccessKey
                                var RecRespPendingKey = data.RecRespPendingKey
                                var RecRespFailureKey = data.RecRespFailureKey
                                document.getElementById("ddlapitype").value = api_type;
                               
                                //document.getElementById("").value = is_active;
                                //document.getElementById("").value = is_random;
                                //document.getElementById("").value = enable_recharge;
                                //document.getElementById("").value = enable_balance_check;
                                //document.getElementById("").value = enable_status_check;
                                //alert(hostname);
                                document.getElementById("txtHostName").value = hostname;
                                document.getElementById("txtParam1").value = param1;
                                document.getElementById("txtParam2").value = param2;
                                document.getElementById("txtParam3").value = param3;
                                document.getElementById("txtParam4").value = param4;
                                document.getElementById("txtParam5").value = param5;
                                document.getElementById("txtParam6").value = param6;
                                document.getElementById("txtParam7").value = param7;
                                document.getElementById("txtHeaderKey1").value = header_key1;
                                document.getElementById("txtHeaderValue1").value = header_value1;
                                document.getElementById("txtHeaderKey2").value = header_key2;
                                document.getElementById("txtHeaderValue2").value = header_value2;
                                document.getElementById("txtHeaderKey3").value = header_key3;
                                document.getElementById("txtHeaderValue3").value = header_value3;
                                document.getElementById("txtHeaderKey4").value = header_key4;
                                document.getElementById("txtHeaderValue4").value = header_value4;
                                document.getElementById("txtHeaderKey5").value = header_key5;
                                document.getElementById("txtHeaderValue5").value = header_value5;
                                document.getElementById("ddlbalcheckapimethod").value = balance_check_api_method;
                                document.getElementById("txtBalnaceCheckApi").value = balance_ceck_api;
                                document.getElementById("ddlstatuscheckapimethod").value = status_check_api_method;
                                document.getElementById("txtStatusCheckApi").value = status_check_api;
                                document.getElementById("ddlvalidationcheckapimethod").value = validation_api_method;
                                document.getElementById("txtValidationCheckApi").value = validation_api;
                                document.getElementById("ddltransactionapimethod").value = transaction_api_method;
                                document.getElementById("txtApiPrepaid").value = api_prepaid;
                                document.getElementById("txtApiDth").value = api_dth;
                                document.getElementById("txtApiPostpaid").value = api_postpaid;
                                document.getElementById("txtApiElectricity").value = api_electricity;
                                document.getElementById("txtApiGas").value = api_gas;
                                document.getElementById("txtApiInsurance").value = api_insurance;
                                document.getElementById("txtDynamicCallBackUrl").value = dunamic_callback_url;
                                document.getElementById("ddlparser").value = response_parser;
                                document.getElementById("ddlBalanceCheckResponseType").value = balnace_check_response_type;
                                document.getElementById("txtBalanceCheckRespBalFieldName").value = balnace_check_response_balfieldName;
                                document.getElementById("ddlrecRespType").value = recharge_response_type;
                                document.getElementById("txtRecRespSeparatorField").value = response_separator;
                                document.getElementById("txtRecRespStatusField").value = recharge_response_status_field;
                                document.getElementById("txtRecRespOpIdField").value = recharge_response_opid_field;
                                document.getElementById("txtRecRespApirefidField").value = recharge_response_apirefid_field;
                                document.getElementById("txtRecRespBalanceField").value = recharge_response_balance_field;
                                document.getElementById("txtRecRespRemarkField").value = recharge_response_remark_field;
                                document.getElementById("txtRecRespStateField").value = recharge_response_stat_field;
                                document.getElementById("txtRecRespFosField").value = recharge_response_fos_field;
                                document.getElementById("txtRecRespOtfField").value = recharge_response_otf_field;
                                document.getElementById("txtRecRespLapuNumberField").value = recharge_response_lapunumber_field;
                                document.getElementById("txtRecRespMessageField").value = recharge_response_message_field;
                                
                                document.getElementById("txtRecRespSuccessKey").value = RecRespSuccessKey;
                                document.getElementById("txtRecRespPendingKey").value = RecRespPendingKey;
                                document.getElementById("txtRecRespFailureKey").value = RecRespFailureKey;







                   

                                ////status params
                                var stc_response_type = data.stc_response_type
                                var stc_status_field = data.stc_status_field
                                var stc_opid_field = data.stc_opid_field
                                var stc_state_field = data.stc_state_field
                                var stc_fos_field = data.stc_fos_field
                                var stc_otf_field = data.stc_otf_field
                                var stc_lapunumber_field = data.stc_lapunumber_field
                                var stc_message_field = data.stc_message_field
                                var stc_success_key = data.stc_success_key
                                var stc_pending_key = data.stc_pending_key
                                var stc_failure_key = data.stc_failure_key
                                var stc_refund_key = data.stc_refund_key
                                var stc_notfound_key = data.stc_notfound_key
                                
                                document.getElementById("ddlStatusCheckRespType").value = stc_response_type;
                                document.getElementById("txtStatusCheckRespStatusField").value = stc_status_field;
                                document.getElementById("txtStatusCheckRespOpIdField").value = stc_opid_field;
                                document.getElementById("txtStatusCheckRespStateField").value = stc_state_field;
                                document.getElementById("txtStatusCheckRespFosField").value = stc_fos_field;
                                document.getElementById("txtStatusCheckRespOtfField").value = stc_otf_field;
                                document.getElementById("txtStatusCheckRespLapuNumberField").value = stc_lapunumber_field;
                                document.getElementById("txtStatusCheckRespMessageField").value = stc_message_field;
                                document.getElementById("txtStatusCheckRespSuccessKey").value = stc_success_key;
                                document.getElementById("txtStatusCheckRespPendingKey").value = stc_pending_key;
                                document.getElementById("txtStatusCheckRespFailureKey").value = stc_failure_key;
                                document.getElementById("txtStatusCheckRespRefundKey").value = stc_refund_key;
                                document.getElementById("txtStatusCheckRespNotFoundKey").value = stc_notfound_key;
                                
                                


                                //callback settings
                              

                                var cb_reqid_name = data.cb_reqid_name
                                var cb_apirefid_name = data.cb_apirefid_name
                                var cb_check_through_reqid = data.cb_check_through_reqid
                                var cb_status_name = data.cb_status_name
                                var cb_opid_name = data.cb_opid_name
                                var cb_success_key = data.cb_success_key
                                var cb_pending_key = data.cb_pending_key
                                var cb_failure_key = data.cb_failure_key
                                var cb_refund_key = data.cb_refund_key
                               
                                 document.getElementById("txtCallbackReqIdName").value = cb_reqid_name;
                                 document.getElementById("txtCallbackApiRefIdName").value = cb_apirefid_name;
                                 document.getElementById("chkcallbackcheckthroughreqid").value = cb_check_through_reqid;
                                 document.getElementById("txtCallbackstatusName").value = cb_status_name;
                                 document.getElementById("txtCallbackopidName").value = cb_opid_name;
                                 document.getElementById("txtCallbackSuccessKey").value = cb_success_key;
                                 document.getElementById("txtCallbackFailureKey").value = cb_pending_key;
                                 document.getElementById("txtCallbackPendingKey").value = cb_failure_key;
                                 document.getElementById("txtCallbackRefundKey").value = cb_refund_key;




                                var operatorcodes = data.operatorcodes;
                                for (i in operatorcodes) 
                                {
                                    var company_id = operatorcodes[i]["company_id"];
                                    var OpParam1 = operatorcodes[i]["OpParam1"];
                                    var OpParam2 = operatorcodes[i]["OpParam2"];
                                    var OpParam3 = operatorcodes[i]["OpParam3"];
                                    var OpParam4 = operatorcodes[i]["OpParam4"];
                                    var OpParam5 = operatorcodes[i]["OpParam5"];
                                  //  alert(OpParam1);

                                    document.getElementById("txtOpParam1"+company_id).value = OpParam1;
                                    document.getElementById("txtOpParam2"+company_id).value = OpParam2;
                                    document.getElementById("txtOpParam3"+company_id).value = OpParam3;
                                    document.getElementById("txtOpParam4"+company_id).value = OpParam4;
                                    document.getElementById("txtOpParam5"+company_id).value = OpParam5;
                                    
                                }
                                var k=0;
                                // for(k=0;k<operatorcodes.length;k++)
                                // {
                                //     alert(operatorcodes[k]);
                                // }
                                
                            }
                            else
                            {
                              //   $("#popupalertdiv").addClass('alert-danger');
                              //  document.getElementById("spanpopupalertmessage").innerHTML = msg;
                            }
                            
                             
                        
                            console.log(response);  
                        },
                        error:function(response)
                        {
                    //      $("#popupalertdiv").addClass('alert-danger');
                    //    document.getElementById("spanloader").style.display="none";
                    //    document.getElementById("popupalertdiv").style.display="block";
                    //    document.getElementById("spanpopupalertmessage").innerHTML = "Some Error Occured";
                        },
                        complete:function()
                        {
                           // document.getElementById("popupalertdiv").style.display="block";
                           // document.getElementById("spanloader").style.display="none";
                            
                        }
                    });   
              } 
              else
              {
                  alert("Please Select Api To Resend");
              }
           }
        );




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

    <script src="<?php echo base_url();?>js/bracket.js"></script>
  </body>
</html>