<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>BALANCE URL SETTINGS</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
         <script>
	$(document).ready(function(){
	//global vars
	$('#example').dataTable(); 
	var form = $("#frmapi_view");
	var apiname = $("#txtAPIName");
	var apinameInfo = $("#APINameInfo");
	var username = $("#txtUserName");
	var usernameInfo = $("#usernameInfo");
	var pwd = $("#txtPassword");
	var pwdInfo = $("#passwordInfo");
	apiname.focus();pwd.blur(validatePassword);
	
	form.submit(function(){
		if(validateAPIName() & validateUserName() & validatePassword())
			{				
			return true;
			}
		else
			return false;
	});
	function validateAPIName(){
		if(apiname.val() == ""){
			//apiname.addClass("error");
			apinameInfo.text("");
			jAlert('Enter API Name. e.g RoyalCapital', 'Alert Dialog');
			return false;
		}
		else{
			apiname.removeClass("error");
			apinameInfo.text("");
			return true;
		}
	}
	function validateUserName(){
		if(username.val() == ""){
			//username.addClass("error");
			jAlert('Enter User Name.<br>For Royal Capital : Enter Agent ID.', 'Alert Dialog');
			usernameInfo.text("");
			return false;
		}
		else{
			username.removeClass("error");
			usernameInfo.text("");
			return true;
		}
	}
	function validatePassword(){
		if(pwd.val()== ""){
			//pwd.addClass("error");
			jAlert('Enter API Password. For RoyalCapital : Enter Passward.', 'Alert Dialog');
			
			pwdInfo.text("");
			return false;
		}
		else{
			pwd.removeClass("error");
			pwdInfo.text("");
			return true;
		}
	}
	setTimeout(function(){$('div.message').fadeOut(1000);}, 2000);	
});
	function Confirmation(value)
	{
		var varName = document.getElementById("name_"+value).innerHTML;
		if(confirm("Are you sure?\nyou want to delete "+varName+" api.") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
	}
	function SetEdit(value)
	{
		document.getElementById('txtAPIName').value=document.getElementById("name_"+value).innerHTML;
		document.getElementById('txtUserName').value=document.getElementById("uname_"+value).innerHTML;		
		document.getElementById('txtPassword').value=document.getElementById("pwd_"+value).innerHTML;	;
		
		document.getElementById('txtIp').value=document.getElementById("ip_"+value).innerHTML;		
		document.getElementById('txtPin').value=document.getElementById("pin_"+value).innerHTML;		
		document.getElementById('txtToken').value=document.getElementById("token_"+value).innerHTML;		
		document.getElementById('txtLapuNumner').value=document.getElementById("lapunumber_"+value).innerHTML;		
		document.getElementById('txtparameters').value=document.getElementById("params_"+value).innerHTML.replace(/&amp;/g, '&');
		
	
		
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		document.getElementById('myLabel').innerHTML = "Edit API";
	}
	function SetReset()
	{
		document.getElementById('btnSubmit').value='Submit';
		document.getElementById('hidID').value = '';
		document.getElementById('myLabel').innerHTML = "Add API";
	}
	</script>
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
<script type="text/javascript">
    
	function ActionSubmit(value,name)
	{
		if(document.getElementById('action_'+value).selectedIndex != 0)
		{
			var isstatus;
			if(document.getElementById('action_'+value).value == "Success")
			{isstatus = 'Success';}
			else if(document.getElementById('action_'+value).value == "Failure")
			{isstatus='Failure';}
			else if(document.getElementById('action_'+value).value == "Pending")
			{isstatus='Pending';}
			
			if(confirm('Are you sure?\n you want to '+isstatus+' rechrge for - ['+name+']')){
				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidrechargeid').value= value;	
				document.getElementById('hidid').value= "req to get";
							
				document.getElementById('frmCallAction').submit();
				}
		}
	}
	
</script>
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

<style>
.myselect {
  margin: 1px  !important; ;
  width: 70px  !important; ;
  padding: 1px 5px 1px 1px  !important; ;
  font-size: 12px  !important; ;
  border: 1px solid #ccc  !important; ;
  height: 24px  !important; ;
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
          <a class="breadcrumb-item" href="#">DEVELOPER OPTIONS</a>
          <span class="breadcrumb-item active">API BALANCE SETTINGS</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>API BALANCE SETTINGS</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form method="post" action="<?php echo base_url()."_Admin/apibalance_setting"; ?>" name="frmapi_view" id="frmapi_view" autocomplete="off">
<fieldset>
<table >
	<tr>
    	<td>
        	<table cellpadding="3" cellspacing="3" border="0">
				<tr>
<td align="right"><label for="txtAPIName"><span style="color:#F06">*</span> Select API :</label></td>
<td align="left">
    <select id="ddlapi" name="ddlapi" class="form-control-sm" style="width:120px">
        <option value="0">Select </option>
        <?php
            $rsltapi = $this->db->query("select api_id,api_name from tblapi order by api_name");
            foreach($rsltapi->result() as $rapi)
            {?>
                <option value="<?php echo $rapi->api_id; ?>"><?php echo $rapi->api_name; ?></option>
            <?php }
        ?>
    </select>
</td>
</tr>
<tr>
    <td align="right">
        <label for="txtUserName"><span style="color:#F06">*</span> Balance Url :</label></td>
    <td align="left">
        <input type="text" id="txtUrl" class="form-control-sm" name="txtUrl" style="width:800px;">
        <span id="usernameInfo"></span>
</td>
</tr>
<tr>
    <td align="right"><label for="txtStartWord"><span style="color:#F06">*</span> Word Before Balance :</label></td>
    <td align="left"><input type="text" class="form-control-sm" id="txtStartWord"  name="txtStartWord" maxlength="50"/>
    <span id="passwordInfo"></span>
</td>
</tr>
<tr>
    <td align="right"><label for="txtEndWord"><span style="color:#F06">*</span> Word After Balance :</label></td>
    <td align="left"><input type="text" class="form-control-sm" id="txtEndWord"  name="txtEndWord" />
    <span id="passwordInfo"></span>
</td>
</tr>
			
				<tr>
<td></td><td align="left"><input type="submit" class="btn btn-primary btn-xs" id="btnSubmit" name="btnSubmit" value="Submit"/> <input type="reset" class="button" onClick="SetReset()" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>
</tr>
			</table>
        </td>
     
    </tr>
</table>
</fieldset>
<input type="hidden" id="hidID" name="hidID" />
</form>
<form action="<?php echo base_url()."_Admin/apibalance_setting"; ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="Delete" />
</form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">BALANCE API LIST</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
<table class="table  table-striped .table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;">
    <tr class="ColHeader"> 
            <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="center"  height="30" >API Name</th> 
            <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="center"  height="30" >Balance Url</th> 
            <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="center" height="30" >Before Text</th>
            <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="center"  height="30" >After Text</th>
           
            <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="center"  height="30" >Actions</th> 
        </tr>
            <?php	$i = 0;foreach($result_api->result() as $result) 	{  ?>
 
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" ><span id="name_<?php echo $result->Id; ?>"><?php echo $result->api_name; ?></span></td>
             <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" ><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->balance_url; ?></span></td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" ><span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->balancebefore_text; ?></span></td>              
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" ><span id="ip_<?php echo $result->Id; ?>"><?php echo $result->balance_after_text; ?></span></td>              
                         
             
            <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
              <img src="<?php echo base_url()."images/delete.PNG"; ?>" height="20" width="20" onClick="Confirmation('<?php echo $result->Id; ?>')" title="Delete Row" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              
              </td>  
             </tr>
		<?php 	
		$i++;} ?>
		</table>
              </div><!-- card-body -->
            </div>
             
        </div>
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
