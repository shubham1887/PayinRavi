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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
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
            <th>API</th>
            <th></th>
            <th>Min Amt</th>
            <th>MaxAmt</th>
            
             
             <th  >Act</th> 
        </tr> </thead>
     <tbody>
    <?php	$i = 0;foreach($result_company->result() as $result) 	{ 
	
	 ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            	<td style="font-weight:bold;" ><span id="comp_<?php echo $result->company_id; ?>"><a href="<?php echo base_url()."_Admin/operatorapi?mcrypt=".$this->Common_methods->encrypt($result->company_id); ?>"><?php echo $result->company_name; ?></a></span></td>
                
 			<td><span id="lc_format_<?php echo $result->company_id; ?>"><?php echo $result->mcode; ?></span></td>
 			
 			
 			
 			 <td><span id="api_<?php echo $result->company_id; ?>"><?php echo $result->api_name; ?>  </span></td>
 				
  <td>
 <select id="<?php echo $result->company_id; ?>ddlapi" name="ddlapi" style="width:80px;" onChange="changeApi('<?php echo $result->company_id; ?>')" class="form-control">
<option value="0">Select</option>
<?PHP
	$api_rslt = $this->db->query("select * from tblapi where status = 1");
	if($api_rslt->num_rows() > 0)
	{
	foreach($api_rslt->result() as $row)
	{
 ?>
<option value="<?php echo $row->api_name; ?>"><?php echo $row->api_name; ?></option>
<?php } } ?>
</select>
 </td>
 			
 				
<!--
--------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------->
                
                
  <td>
  <input type="text" class="form-control-sm" style="width:80px" id="txtminamt<?php echo $result->company_id; ?>" name="txtminamt" value="<?php echo $result->minamt; ?>" onKeyUp="setmin('<?php echo $result->company_id; ?>')"><span id="spmin<?php echo $result->company_id; ?>" style="display:none"> <img src="<?php echo base_url()."ajax-loader.gif" ?>"></span>
  </td>
  <td>
  <input type="text" class="form-control-sm"  style="width:80px" id="txtmaxamt<?php echo $result->company_id; ?>" name="txtmaxamt" value="<?php echo $result->mxamt; ?>"  onKeyUp="setmax('<?php echo $result->company_id; ?>')"><span id="spmax<?php echo $result->company_id; ?>" style="display:none"> <img src="<?php echo base_url()."ajax-loader.gif" ?>"></span> </td>
  
 				
 				<td>
<i class="far fa-edit"></i>Edit                
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
      
      
      </div><!-- br-pagebody -->
       <form id="apichangeform" name="apichangeform" action="<?php echo base_url()."_Admin/company"?>" method="post">
<input type="hidden" name="api_name" id="api_name">
<input type="hidden" name="company_id" id="company_id">
<input type="hidden" name="changeapi" id="changeapi">
</form>
        <script language="javascript">
function setmin(id)
{
	document.getElementById("spmin"+id).style.display = "block";
	$.ajax({
	url:'<?php echo  base_url()."_Admin/company/setmin" ?>?id='+id+'&val='+document.getElementById("txtminamt"+id).value,
	method:'POST',
	cache:false,
	success:function(msg)
	{
		document.getElementById("spmin"+id).style.display = "none";
	}
	
	});
}
function setmax(id)
{
	document.getElementById("spmax"+id).style.display = "block";
	$.ajax({
	url:'<?php echo  base_url()."_Admin/company/setmax" ?>?id='+id+'&val='+document.getElementById("txtmaxamt"+id).value,
	method:'POST',
	cache:false,
	success:function(msg)
	{
		document.getElementById("spmax"+id).style.display = "none";
	}
	
	});
}
function setautomax_code(id)
{
	document.getElementById("automax_codespan"+id).style.display = "block";
	$.ajax({
	url:'<?php echo  base_url()."_Admin/company/setautomax_code" ?>?id='+id+'&val='+document.getElementById("automax_code"+id).value,
	method:'POST',
	cache:false,
	success:function(msg)
	{
		document.getElementById("automax_codespan"+id).style.display = "none";
	}
	
	});
}
function setautomax_code2(id)
{
	document.getElementById("automax_code2span"+id).style.display = "block";
	$.ajax({
	url:'<?php echo  base_url()."_Admin/company/setautomax_code2" ?>?id='+id+'&val='+document.getElementById("automax_code2"+id).value,
	method:'POST',
	cache:false,
	success:function(msg)
	{
		document.getElementById("automax_code2span"+id).style.display = "none";
	}
	
	});
}
</script>
<script language="javascript">
	function setvalue(field,id)
	{
	
		document.getElementById(field + "_"+id).style.backgroundColor = "yellow";
		var value = document.getElementById(field + "_" + id).value;
		$.ajax({
		url:'<?php echo base_url()."_Admin/company/setvalues?"; ?>Id='+id+'&field='+field+'&val='+value,
		cache:false,
		method:'POST',
		success:function(html)
		{
			if(field == "RANGE_API")
			{
				document.getElementById("spanrangeapiname"+id).innerHTML = value;
			}
			document.getElementById(field + "_"+id).style.backgroundColor = "white";
		}
		});
	}
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
