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
          <span class="breadcrumb-item active">OPERATOR SETTING</span>
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Update Operator</h6>
                <span class="tx-12 tx-uppercase"><a href="<?php echo base_url()."_Admin/company"; ?>" class="btn btn-success" >Back</a></span>
                
              </div><!-- card-header -->
              <div class="card-body" style="background-color:#F2F2F2">
                <?php
                    $is_enabled_prop = '';
                    $is_enabled =  $company_info->row(0)->is_enabled;
                    if($is_enabled == 'yes')
                    {
                        $is_enabled_prop = 'checked';
                    }
                    
                    $is_visible_prop = '';
                    $is_visible =  $company_info->row(0)->is_visible;
                    if($is_visible == 'yes')
                    {
                        $is_visible_prop = 'checked';
                    }
                    
                    $bill_fetch_enabled_prop = '';
                    $bill_fetch_enabled =  $company_info->row(0)->bill_fetch_enabled;
                    if($bill_fetch_enabled == 'yes')
                    {
                        $bill_fetch_enabled_prop = 'checked';
                    }
                    
                    $is_bbps_prop = '';
                    $is_bbps =  $company_info->row(0)->is_bbps;
                    if($is_bbps == 'yes')
                    {
                        $is_bbps_prop = 'checked';
                    }
                    
                    $is_fiexd_amount_prop = '';
                    $is_fiexd_amount =  $company_info->row(0)->is_fiexd_amount;
                    if($is_fiexd_amount == 'yes')
                    {
                        $is_fiexd_amount_prop = 'checked';
                    }
                    
                    $apidorpdown_options = $this->Api_model->getApiListForDropdownList();
                ?>
	
	    <form id="frmaddopeartor" action="<?php echo base_url()."_Admin/company"; ?>" method="post">
                <input type="hidden" id="hidcompany_id" name="hidcompany_id" value="<?php echo $this->Common_methods->encrypt($company_info->row(0)->company_id); ?>">
          		<table class="">
                <tr>
                	<td align="right"><label>Operator Name :</label></td>
                	<td align="left">
                        <input type="text" id="txtOperatorName" name="txtOperatorName" class="text" maxlength="40" value="<?php echo $company_info->row(0)->company_name; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile App Code :</label></td>
                	<td align="left">
                        <input type="text" id="txtMcode" name="txtMcode" class="text" maxlength="5" value="<?php echo $company_info->row(0)->mcode; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is Enabled :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_enabled" name="chkis_enabled"  <?php echo $is_enabled_prop; ?>>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is Visible :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_visible" name="chkis_visible"  <?php echo $is_visible_prop; ?>>
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
                        <script language="javascript">
                            document.getElementById("ddlservice").value = '<?php echo $company_info->row(0)->service_id; ?>';
                        </script>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Display Order :</label></td>
                	<td align="left">
                        <input type="number" id="txtDisplayOrder" name="txtDisplayOrder" class="text" maxlength="40" value="<?php echo $company_info->row(0)->display_order; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Enable Fetch Bill :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkenableFetchBill" name="chkenableFetchBill"  <?php echo $bill_fetch_enabled_prop; ?>>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is BBPS :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_bbps" name="chkis_bbps"  <?php echo $is_bbps_prop; ?>>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>API 1 :</label></td>
                	<td align="left">
                        <select id="ddlapi1" name="ddlapi1" class="select">
                            <option value="0"></option>
                           <?php echo $apidorpdown_options; ?>
                        </select>
                        <script language="javascript">
                            document.getElementById("ddlapi1").value = '<?php echo $company_info->row(0)->api_id; ?>';
                        </script>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>API 2 :</label></td>
                	<td align="left">
                        <select id="ddlapi2" name="ddlapi2" class="select">
                            <option value="0"></option>
                           <?php echo $apidorpdown_options; ?>
                        </select>
                        <script language="javascript">
                            document.getElementById("ddlapi2").value = '<?php echo $company_info->row(0)->api2_id; ?>';
                        </script>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Validation Api :</label></td>
                	<td align="left">
                        <select id="ddlvalidationapi" name="ddlvalidationapi" class="select">
                            <option value="0"></option>
                           <?php echo $apidorpdown_options; ?>
                        </select>
                        <script language="javascript">
                            document.getElementById("ddlvalidationapi").value = '<?php echo $company_info->row(0)->validation_api; ?>';
                        </script>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Label Text :</label></td>
                	<td align="left">
                        <input type="text" id="txtMobileNunberlabelTExt" name="txtMobileNunberlabelTExt" class="text" maxlength="40" value="<?php echo $company_info->row(0)->mobile_number_label; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Min Length :</label></td>
                	<td align="left">
                        <input type="number" id="txtMobileNunberMinLength" name="txtMobileNunberMinLength" class="text" maxlength="40" value="<?php echo $company_info->row(0)->mobile_number_min_length; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Max Length :</label></td>
                	<td align="left">
                        <input type="number" id="txtMobileNunberMaxLength" name="txtMobileNunberMaxLength" class="text" maxlength="40" value="<?php echo $company_info->row(0)->mobile_number_max_length; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number Start With:</label></td>
                	<td align="left">
                        <input type="text" id="txtMobileNunberStartWith" name="txtMobileNunberStartWith" class="text" maxlength="40" value="<?php echo $company_info->row(0)->mobile_number_start_width; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Mobile Number End With:</label></td>
                	<td align="left">
                        <input type="text" id="txtMobileNunberEndWith" name="txtMobileNunberEndWith" class="text" maxlength="40"  value="<?php echo $company_info->row(0)->mobile_number_end_width; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Amount Label Text:</label></td>
                	<td align="left">
                        <input type="text" id="txtAmountLabelText" name="txtAmountLabelText" class="text" maxlength="40"  value="<?php echo $company_info->row(0)->amount_label; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Is Fixed Amount :</label></td>
                	<td align="left">
                        <input type="checkbox" id="chkis_fixedAmount" name="chkis_fixedAmount"  <?php echo $is_fiexd_amount_prop; ?>>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Fixed Amount Values :</label></td>
                	<td align="left">
                         <input type="text" id="txtFixedAmountValues" name="txtFixedAmountValues" class="text" maxlength="40" value="<?php echo $company_info->row(0)->fixedAmountvalues; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Min Amount :</label></td>
                	<td align="left">
                         <input type="text" id="txtMinAmount" name="txtMinAmount" class="text" maxlength="40" value="<?php echo $company_info->row(0)->minamt; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Max Amount :</label></td>
                	<td align="left">
                         <input type="text" id="txtMaxAmount" name="txtMaxAmount" class="text" maxlength="40" value="<?php echo $company_info->row(0)->mxamt; ?>">
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Amount Type:</label></td>
                	<td align="left">
                        <select id="ddlamt_type" name="ddlamt_type" class="select">
                            <option value="text">text</option>
                            <option value="json">json</option>
                        </select>
                        <script language="javascript">
                            document.getElementById("ddlamt_type").value = '<?php echo $company_info->row(0)->amount_type; ?>';
                        </script>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Amount Dropdown Content:</label></td>
                	<td align="left">
                        <textarea id="txtAmtDropdownContent" name="txtAmtDropdownContent" class="text"><?php echo $company_info->row(0)->amount_dropdown_contents; ?></textarea>
                    </td>
                </tr>
                <tr>
                	<td align="right"><label>Blocked Denominations:</label></td>
                	<td align="left">
                        <textarea id="txtblocked_amounts" name="txtblocked_amounts" class="text"><?php echo $company_info->row(0)->blocked_amounts; ?></textarea>
                    </td>
                </tr>
                <tr>
                	<td align="center" colspan="2"><input type="submit" name="btnUPdate" name="btnUPdate" value="Update" class="btn btn-primary btn-lg"></td>
                	
                </tr>
                
                
                </table>
                
         
	    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
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
