<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN::Operator Settings</title>
      <?php include("files/links.php"); ?>
      <?php include("files/apijaxscripts.php"); ?>

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
	
	setTimeout(function(){$('div.alert').fadeOut(1000);}, 2000);
	setTimeout(function(){$('div.message').fadeOut(1000);}, 2000);
	
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
	.row1
	{
		background-color:#BFCDDD;
	}
	</style>
</head>

<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->

        <!-- navbar side -->
        <?php include("files/adminheader.php"); ?> 
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <?php include("files/adminsidebar.php"); ?>
       <?php
	   $api_rslt = $this->db->query("select * from tblapi");
	    ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
           <div class="col-lg-12">
                <br><br>
                <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Quick Links
                        </div>
                        <div class="panel-body">
						<a class="link" href="<?php echo base_url()."_Admin/randomapirouting?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Random APi Settings</a> | 
                        <a class="link" href="<?php echo base_url()."_Admin/company?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Operator Settings</a> | <a href="<?php echo base_url()."_Admin/list_recharge?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Recharge List</a> | <a href="<?php echo base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Retailer List</a>
                        </div>
                        </div>
                 </div>
                 
                
                  
                </div>
            <div class="row">
                
                <div class="col-lg-12">
                <?php include("files/messagebox.php"); ?>
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                        
                            <i class="fa fa-fw"></i>
                           
                            
                        </div>

                        <div class="panel-body">
                           <div class="table-responsive">
                           <table  class="table table-bordered stripped">
    <thead> 
        <tr> 
             <th  style="width:80px">Operator Name</th> 
          
            
            
            <th style="background:#CCCCCC">API : Retailer</th>
            <th  style="background:#CCCCCC">Amounts</th>
            <th  style="background:#CCCCCC">Change Api :: Retailer</th>
            
            <th  style="background:#D1D1C5">API:: APIUSER</th>
            <th   style="background:#D1D1C5">Amounts</th>
            <th   style="background:#D1D1C5">Change Api :: APIUSER</th>
            
        </tr> </thead>
     <tbody>
    <?php	
		$i = 0;
		foreach($result_company->result() as $result) 	
		{ ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            	<td  style="width:80px"><span id="comp_<?php echo $result->company_id; ?>"><?php echo $result->company_name; ?></span></td>
 				
 				
<!--


--------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------->
                
                <td style="background:#CCCCCC"><span id="txtamounts_api_<?php echo $result->company_id; ?>"><?php echo $result->retailer_api_name; ?>  </span></td>
 				<td style="background:#CCCCCC">
                <span id="api_<?php echo $result->company_id; ?>">
                <input type="text" id="retailer_txtAmounts_<?php echo $result->company_id; ?>" value="<?php echo $result->amounts; ?>" onKeyUp="setvalue('retailer_txtAmounts','<?php echo $result->company_id; ?>')" class="form-control">
                </span>
                </td>
  				<td style="background:#CCCCCC">
  					<select id="amounts_api_<?php echo $result->company_id; ?>" name="ddlapi" style="width:80px;" onChange="setvalue('amounts_api','<?php echo $result->company_id; ?>')" class="form-control">
                                        <option value="0">Select</option>
                                        <?PHP
                                            
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
 
  				<td style="background:#CCCCCC"><span id="txtamounts_for_apiuser_api_<?php echo $result->company_id; ?>"><?php echo $result->apiuser_api_name; ?>  </span></td>
 				<td style="background:#CCCCCC">
                <span id="api_<?php echo $result->company_id; ?>">
                <input type="text" id="apiuser_txtAmounts_<?php echo $result->company_id; ?>" value="<?php echo $result->amounts_for_apiuser; ?>" onKeyUp="setvalue('apiuser_txtAmounts','<?php echo $result->company_id; ?>')" class="form-control">
                </span>
                </td>
  				<td style="background:#CCCCCC">
  					<select id="amounts_for_apiuser_api_<?php echo $result->company_id; ?>" name="ddlapi" style="width:80px;" onChange="setvalue('amounts_for_apiuser_api','<?php echo $result->company_id; ?>')" class="form-control">
                                        <option value="0">Select</option>
                                        <?PHP
                                            
                                            if($api_rslt->num_rows() > 0)
                                            {
                                            foreach($api_rslt->result() as $row)
                                            {
                                         ?>
                                        <option value="<?php echo $row->api_name; ?>"><?php echo $row->api_name; ?></option>
                                        <?php } } ?>
                    				</select>
 				</td>
 </tr>
		<?php 	
		$i++;} ?>
        </tbody>
		</table>
       					  
                            </div>
                        </div>

                    </div>
                        
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->
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
		if(field == "amounts_api")
		{
				document.getElementById("txtamounts_api_"+id).style.backgroundColor = "yellow";
				var value = document.getElementById(field + "_" + id).value;
				$.ajax({
				url:'<?php echo base_url()."_Admin/operator_settings/setvalues?"; ?>Id='+id+'&field='+field+'&val='+value,
				cache:false,
				method:'POST',
				success:function(html)
				{
					
					document.getElementById("txtamounts_api_"+id).style.backgroundColor = "white";
					document.getElementById("txtamounts_api_"+id).innerHTML = value;
				}
				});
		}
		else if(field == "amounts_for_apiuser_api")
		{
				document.getElementById("txtamounts_for_apiuser_api_"+id).style.backgroundColor = "yellow";
				var value = document.getElementById(field + "_" + id).value;
				$.ajax({
				url:'<?php echo base_url()."_Admin/operator_settings/setvalues?"; ?>Id='+id+'&field='+field+'&val='+value,
				cache:false,
				method:'POST',
				success:function(html)
				{
					
					document.getElementById("txtamounts_for_apiuser_api_"+id).style.backgroundColor = "white";
					document.getElementById("txtamounts_for_apiuser_api_"+id).innerHTML = value;
				}
				});
		}
		
		else
		{
				document.getElementById(field + "_"+id).style.backgroundColor = "yellow";
				var value = document.getElementById(field + "_" + id).value;
				$.ajax({
				url:'<?php echo base_url()."_Admin/operator_settings/setvalues?"; ?>Id='+id+'&field='+field+'&val='+value,
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
		
		
		
	}
	</script>
    <!-- Core Scripts - Include with every page -->
   
   <?php include("files/adminfooter.php"); ?> 
</body>

</html>
