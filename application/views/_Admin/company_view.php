<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

     <title>Operator Setting</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	$(document).ready(function(){
	//global vars
	
	var form = $("#frmcompany_view");
	var cname = $("#txtCompName");
	var sname = $("#ddlSerName");
	var provider = $("#txtProvider");			
	var long_code_format = $("#txtLong_Code_Format");
	
	
	cname.focus();
	form.submit(function(){
		if(validatesName() & validatecName() & validatesLong_code_format()  & validateProvider())
			{				
			return true;
			}
		else
			return false;
	});	
	function validatecName(){
		if(cname.val() == ""){
			cname.addClass("error");
			jAlert('Enter Company Name. e.g. Airtel,Vodafone', 'Alert Dialog');
			return false;
		}
		else{
			cname.removeClass("error");
			return true;
		}
	}
	
	function validatesName(){
		if(sname[0].selectedIndex == 0){
			sname.addClass("error");
			jAlert('Select Service. Click on drop down.', 'Alert Dialog');			
			return false;
		}
		else{
			sname.removeClass("error");
			return true;
		}
	}	
	function validateProvider()
	{
		if(provider.val() == ""){
			provider.addClass("error");
			jAlert('Enter Provider Code. e.g. For Vadafone RV', 'Alert Dialog');			
			return false;
		}
		else{
			provider.removeClass("error");
			return true;
		}
	}
		
	function validatesLong_code_format(){
		if(long_code_format.val() == ""){
			long_code_format.addClass("error");
			jAlert('Enter Long Code Format. e.g. For Vodafone <strong>EG VF', 'Alert Dialog');			
			return false;
		}
		else{
			long_code_format.removeClass("error");
			return true;
		}
	}		
	
	setTimeout(function(){$('div.alert').fadeOut(4000);}, 2000);
	setTimeout(function(){$('div.message').fadeOut(4000);}, 2000);
	
});
	function Confirmation(value)
	{
		var varName = document.getElementById("comp_"+value).innerHTML;
		if(confirm("Are you sure?\nyou want to delete "+varName+" company.") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
	}
	function SetEdit(value)
	{
scrolltotop();
		document.getElementById('hidID').value = value;
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('txtCompName').value=document.getElementById("comp_"+value).innerHTML;
		document.getElementById('txtLong_Code_Format').value=document.getElementById("lc_format_"+value).innerHTML;
		
		document.getElementById('txtProvider').value=document.getElementById("provider_"+value).innerHTML;	
		document.getElementById('txtPProvider').value=document.getElementById("payworld_provider_"+value).innerHTML;		
		document.getElementById('txtCProvider').value=document.getElementById("cyberplate_provider_"+value).innerHTML;		
		document.getElementById('ddlSerName').value=document.getElementById("hidservice_"+value).value;	
		document.getElementById('txtProductName').value=document.getElementById("hidproduct_"+value).value;		
		//document.getElementById('hidOldPath').value=document.getElementById("hidlogo_"+value).value;				
		
		
		
	}
	function SetReset()
	{
		document.getElementById('btnSubmit').value='Submit';
		document.getElementById('hidID').value = '';
		document.getElementById('myLabel').innerHTML = "Add Company";
	}	
	function changeApi(value)
	{
		var api_name = document.getElementById(value+"ddlapi").value;
		document.getElementById("api_name").value = api_name;
		document.getElementById("company_id").value = value;
		document.getElementById("changeapi").value = "change";
		document.getElementById("apichangeform").submit();
	}
	function changeApi2(value)
	{
		var api_name = document.getElementById(value+"ddlapi2").value;
		document.getElementById("api_name").value = api_name;
		document.getElementById("company_id").value = value;
		document.getElementById("changeapi").value = "change2";
		document.getElementById("apichangeform").submit();
	}
	
	</script>
     
    <script language="javascript">
	function enableValue()
	{
		var str = document.getElementById("ddlSchemeType").value;
		if(str == "flat")
		{
			document.getElementById("txtAmount").disabled = false;
		}
		else
		{
			document.getElementById("txtAmount").disabled = true;
		}
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
<style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
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
          <a class="breadcrumb-item" href="#">Settings</a>
          <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/Randomapirouting"; ?>">Random Api</a>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>OPERATOR SETTING</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
               <?php include("elements/messagebox.php"); ?>
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"><input type="button" id="btnAddOperator" value="Add Operator" class="btn btn-success" onClick="openoperatoraddpopup()"></span>
                <script language="javascript">
                    function openoperatoraddpopup()
                    {
                        $('#myAddOperatorModal').modal({show:true});
                    }
                </script>
              </div><!-- card-header -->
              <div class="card-body">
                 <form id="frmcompanyrow" method="post" action="<?php echo base_url()."_Admin/company/changeapiall?idstr=".$this->Common_methods->encrypt("ravikant"); ?>">
                           <input type="hidden" name="hidactionallstatus" id="hidactionallstatus">
                           <input type="hidden" name="hidactiontype" id="hidactiontype">
                           
                           
                               <table class="table table-striped .table-bordered" style="color:#000000">
    <thead> 
        <tr> 
            <th >Operator Name</th> 
            <th>OP<br> Code</th>
            <th>Reroot Count</th>
            <th>API</th>
            
            <th>Min Amt</th>
            <th>MaxAmt</th>
            
             
             <th  >Act</th> 
        </tr> </thead>
     <tbody>
    <?php
    
    $apidorpdown_options = $this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto(1,2,3);
    $i = 0;
    foreach($result_company->result() as $result) 	{ 
//	print_r($result);exit;
	 ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            	<td style="font-weight:bold;" ><span id="comp_<?php echo $result->company_id; ?>"><a href="<?php echo base_url()."_Admin/operatorapi?mcrypt=".$this->Common_methods->encrypt($result->company_id); ?>"><?php echo $result->company_name; ?></a></span></td>
                
 			<td><span id="lc_format_<?php echo $result->company_id; ?>"><?php echo $result->mcode; ?></span></td>

 			  <td>
 			      <input type="number" id="txtRerootLimit<?php echo $result->company_id; ?>" name="txtRerootLimit<?php echo $result->company_id; ?>" value="<?php echo $result->allowed_retry ?>" class="text" style="width:60px;"  onKeyUp="updateoperatorapi(<?php echo $result->company_id; ?>)" onBlur="updateoperatorapi(<?php echo $result->company_id; ?>)">
 			  </td>
              <td>
                 <select id="<?php echo $result->company_id; ?>ddlapi" name="ddlapi" style="width:80px;" onChange="updateoperatorapi('<?php echo $result->company_id; ?>')" class="text" style="width:120px;hight:30px;">
                    <option value="0">Select</option>
                    <?PHP echo $apidorpdown_options;  ?>
                </select>
                <script language="javascript">
                    document.getElementById("<?php echo $result->company_id; ?>ddlapi").value = '<?php echo $result->api_id; ?>';
                </script>
             </td>
 
            
 			
 				
<!--
--------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------->
                
                
  <td>
  <input type="text" class="form-control-sm" style="width:80px" id="txtminamt<?php echo $result->company_id; ?>" name="txtminamt" value="<?php echo $result->minamt; ?>" onKeyUp="updateoperatorapi(<?php echo $result->company_id; ?>)" onBlur="updateoperatorapi(<?php echo $result->company_id; ?>)"><span id="spmin<?php echo $result->company_id; ?>" style="display:none"> <img src="<?php echo base_url()."ajax-loader.gif" ?>"></span>
  </td>
  <td>
  <input type="text" class="form-control-sm"  style="width:80px" id="txtmaxamt<?php echo $result->company_id; ?>" name="txtmaxamt" value="<?php echo $result->mxamt; ?>"  onKeyUp="updateoperatorapi(<?php echo $result->company_id; ?>)" onBlur="updateoperatorapi(<?php echo $result->company_id; ?>)"><span id="spmax<?php echo $result->company_id; ?>" style="display:none"> <img src="<?php echo base_url()."ajax-loader.gif" ?>"></span> </td>
  
 				
 				<td>
<a href="<?php echo base_url()."_Admin/company/editoperator?hidaction=EDIT&id=".$this->Common_methods->encrypt($result->company_id) ?>"><i class="far fa-edit"></i>Edit</a>                
</td>
 </tr>
		<?php 	
		$i++;} ?>
        </tbody>
		</table>
       					  </form> 
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>

<!------------ ajax process for changeing values start------------------------>
<input type="hidden" id="hidvaluechangeurl" value="<?php echo base_url()."_Admin/company/ajaxupdate"; ?>">
    <script language="javascript">
			function updateoperatorapi(id)
			{
				
					 $('#myOverlay').show();
    				$('#loadingGIF').show();
					var api_id = document.getElementById(id+"ddlapi").value;
					var rerootlimit = document.getElementById("txtRerootLimit"+id).value;
					var minamt = document.getElementById("txtminamt"+id).value;
					var maxamt = document.getElementById("txtmaxamt"+id).value;
					
					
					$.ajax({
						url:document.getElementById("hidvaluechangeurl").value,
						cache:false,
						data:{ "company_id":id , "api_id" :api_id,"rerootlimit":rerootlimit,"minamt":minamt,"maxamt":maxamt} ,
						method:'POST',
						type:'POST',
						success:function(data)
						{
							//document.getElementById("totalpending_"+id).innerHTML = data;
						},
						error:function()
						{
							//document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
							//document.getElementById("responsespanfailure").style.display = 'block'
							//document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
						},
						complete:function()
						{
							 $('#myOverlay').hide();
							$('#loadingGIF').hide();
						}
						});
				
			}
			function updateoperatorapi2(id)
			{
				
					 $('#myOverlay').show();
    				$('#loadingGIF').show();
					
					
					
				
				
					if(document.getElementById("md_checkbox_series_"+id).checked)
					{
						var series = "yes";
					}
					else
					{
						var series = "no";
					}
				
				
					
					
				
					$.ajax({
						url:document.getElementById("hidapienabledisable").value,
						cache:false,
						data:{ "company_id":document.getElementById("hidcompany_id"+id).value , "api_id" :id,"series":series} ,
						method:'POST',
						type:'POST',
						success:function(data)
						{
							
							//document.getElementById("totalpending_"+id).innerHTML = data;
							
						},
						error:function()
						{
							//document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
							//document.getElementById("responsespanfailure").style.display = 'block'
							//document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
						},
						complete:function()
						{
							 $('#myOverlay').hide();
							$('#loadingGIF').hide();
						//	document.getElementById("frmCallAction").submit();
						}
						});
				
			}
		</script>
   <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."_Admin/operatorapi"; ?>">
    <input type="hidden" id="hidapienabledisable" value="<?php echo base_url()."_Admin/operatorapi/apienabledisable"; ?>">
      
      <div class="modal fade" id="myMessgeModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle_BDEL">Response Message</h4>
          
        </div>
        <div class="modal-body">
        
          <div id="responsespansuccess_BDEL" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_success_msg_BDEL"></strong>
                </div>
          </div>
          <div id="responsespanfailure_BDEL" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_failure_msg_BDEL"></strong>
                </div>
          </div>
          
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>    



<!----------- ajax process end ------------------------------------------------>







        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
      
      
      </div><!-- br-pagebody -->
       <form id="apichangeform" name="apichangeform" action="<?php echo base_url()."_Admin/company"?>" method="post">
<input type="hidden" name="api_name" id="api_name">
<input type="hidden" name="company_id" id="company_id">
<input type="hidden" name="changeapi" id="changeapi">
</form>

	<?php  $apidorpdown_options = $this->Api_model->getApiListForDropdownList(); ?>
	<form id="frmaddopeartor" action="" method="post">
	<div class="modal fade" id="myAddOperatorModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle_BDEL">Add New Operator</h4>
          
        </div>
        <div class="modal-body" style="background-color:#F2F2F2">
            <span id="spanloader" style="display:none">
              <img id="imgloading" src="<?php echo base_url()."Loading.gif"; ?>">
            </span>
          
          <div>
              
          		<table class="">
                <tr>
                	<td align="right"><label>Operator Name :</label></td>
                	<td align="left">
                        <input type="text" id="txtOperatorName" name="txtOperatorName" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile App Code :</label></td>
                	<td align="left">
                        <input type="text" id="txtMcode" name="txtMcode" class="text" maxlength="5" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is Enabled :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_enabled" name="chkis_enabled" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is Visible :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_visible" name="chkis_visible"  >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Provider Type :</label></td>
                	<td align="left">
                        <select id="ddlservice" name="ddlservice" class="select">
                            <option value="0"></option>
                            <?php 
                            $rsltser = $this->db->query("select service_id,service_name from tblservice order by service_name");
                            foreach($rsltser->result() as $rwser)
                            {?>
                                <option value="<?php echo $rwser->service_id; ?>"><?php echo $rwser->service_name; ?></option>
                            <?php }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Display Order :</label></td>
                	<td align="left">
                        <input type="number" id="txtDisplayOrder" name="txtDisplayOrder" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Enable Fetch Bill :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkenableFetchBill" name="chkenableFetchBill" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is BBPS :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_bbps" name="chkis_bbps">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>API 1 :</label></td>
                	<td align="left">
                        <select id="ddlapi1" name="ddlapi1" class="select">
                            <option value="0"></option>
                            <?php echo $apidorpdown_options; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>API 2 :</label></td>
                	<td align="left">
                        <select id="ddlapi2" name="ddlapi2" class="select">
                            <option value="0"></option>
                           <?php echo $apidorpdown_options; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Validation Api :</label></td>
                	<td align="left">
                        <select id="ddlvalidationapi" name="ddlvalidationapi" class="select">
                            <option value="0"></option>
                            <?php echo $apidorpdown_options; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Label Text :</label></td>
                	<td align="left">
                        <input type="text" id="txtMobileNunberlabelTExt" name="txtMobileNunberlabelTExt" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Min Length :</label></td>
                	<td align="left">
                        <input type="number" id="txtMobileNunberMinLength" name="txtMobileNunberMinLength" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Max Length :</label></td>
                	<td align="left">
                        <input type="number" id="txtMobileNunberMaxLength" name="txtMobileNunberMaxLength" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Start With:</label></td>
                	<td align="left">
                        <input type="text" id="txtMobileNunberStartWith" name="txtMobileNunberStartWith" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number End With:</label></td>
                	<td align="left">
                        <input type="text" id="txtMobileNunberEndWith" name="txtMobileNunberEndWith" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Amount Label Text:</label></td>
                	<td align="left">
                        <input type="text" id="txtAmountLabelText" name="txtAmountLabelText" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is Fixed Amount :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_fixedAmount" name="chkis_fixedAmount"  >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Fixed Amount Values :</label></td>
                	<td align="left">
                         <input type="text" id="txtFixedAmountValues" name="txtFixedAmountValues" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Min Amount :</label></td>
                	<td align="left">
                         <input type="text" id="txtMinAmount" name="txtMinAmount" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Max Amount :</label></td>
                	<td align="left">
                         <input type="text" id="txtMaxAmount" name="txtMaxAmount" class="text" maxlength="40" >
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Amount Type:</label></td>
                	<td align="left">
                        <select id="ddlamt_type" name="ddlamt_type" class="select">
                            <option value="text">text</option>
                            <option value="json">json</option>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Amount Dropdown Content:</label></td>
                	<td align="left">
                        <textarea id="txtAmtDropdownContent" name="txtAmtDropdownContent" class="text"></textarea>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Blocked Denominations:</label></td>
                	<td align="left">
                        <textarea id="txtblocked_amounts" name="txtblocked_amounts" class="text"></textarea>
                    </td>
                </tr>
                
                
                </table>
                
          </div>
        </div>
        <div class="modal-footer">
            <span id="spanbuttonsubmit"> <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary"  value="Submit">Submit</button></span>
            <span id="spanbtnclode"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      
      </div>
    </div>
  </div>   
	  </form>
	  <script language="javascript">
	      // Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='frmaddopeartor']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      firstname: "required",
      lastname: "required",
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    // Specify validation error messages
    messages: {
      firstname: "Please enter your firstname",
      lastname: "Please enter your lastname",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      email: "Please enter a valid email address"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});
	  </script>
	
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
