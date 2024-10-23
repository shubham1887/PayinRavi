  <script>
	$(document).ready(function(){
	$('#example').dataTable();
	//global vars
	var form = $("#frmcommssion_view");
	var companyname = $("#ddlCompanyName");
	var companyInfo = $("#companyInfo");
	//var apiname = $("#txtAPIName");
	//var apiInfo = $("#apiInfo");
	var priority = $("#ddlPriority");
	var priorityInfo = $("#priorityInfo");
	var txtRoyalComm = $("#txtRoyalComm");
	var txtPayworldComm = $("#txtPayworldComm");
	var txtCyberComm = $("#txtCyberComm");
	//var commissionInfo = $("#commissionInfo");			
	var scheme = $("#ddlScheme");
	var schemeInfo = $("#schemeInfo");			
	companyname.focus();
	
	form.submit(function(){
		if(validateCompany() & validateRCommssion() & validatePCommssion() & validateCCommssion() & validateScheme())
			{				
			return true;
			}
		else
			return false;
	});
	function validateCompany(){
		if(companyname[0].selectedIndex == 0)
		{
			companyname.addClass("error");
			jAlert('Select Company Name.', 'Alert Dialog');
			companyInfo.text("");
			return false;
		}
		else{companyname.removeClass("error");companyInfo.text("");return true;}
	}
	
	function validateProirity(){
		if(priority[0].selectedIndex == 0){priority.addClass("error");priorityInfo.text("");return false;}
		else{priority.removeClass("error");priorityInfo.text("");return true;}
	}
	function validateRCommssion(){
		if(txtRoyalComm.val() == ""){
			txtRoyalComm.addClass("error");
			jAlert('Enter Commssion Percentage. e.g 2.5', 'Alert Dialog');
			return false;}
		else{txtRoyalComm.removeClass("error");return true;}
	}
	function validatePCommssion(){
		if(txtPayworldComm.val() == ""){
			txtPayworldComm.addClass("error");
			jAlert('Enter Commssion Percentage. e.g 2.5', 'Alert Dialog');
			return false;}
		else{txtPayworldComm.removeClass("error");return true;}
	}
	function validateCCommssion(){
		if(txtCyberComm.val() == ""){
			txtCyberComm.addClass("error");
			jAlert('Enter Commssion Percentage. e.g 2.5', 'Alert Dialog');
			return false;}
		else{txtCyberComm.removeClass("error");return true;}
	}
	
	
	
	
	
	
	function validateScheme(){
		if(scheme[0].selectedIndex == 0){
		scheme.addClass("error");
		jAlert('Select Scheme Name.', 'Alert Dialog');
		schemeInfo.text("");
		return false;
		}
		else{scheme.removeClass("error");schemeInfo.text("");return true;}
	}	
	
	setTimeout(function(){$('div.message').fadeOut(1000);}, 2000);
	
});
	function Confirmation(value)
	{
		var varName = document.getElementById("name_"+value).innerHTML;
		if(confirm("Are you sure?\nyou want to delete "+varName+" commission.") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
	}
	function SetEdit(value)
	{
		document.getElementById('ddlCompanyName').value=document.getElementById("hidname_"+value).value;
		document.getElementById('txtRoyalComm').value=document.getElementById("rcomm_"+value).innerHTML;
		document.getElementById('txtPayworldComm').value=document.getElementById("pcomm_"+value).innerHTML;
		document.getElementById('txtCyberComm').value=document.getElementById("ccomm_"+value).innerHTML;
		document.getElementById('ddlScheme').value=document.getElementById("hidscheme_"+value).value;		
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		document.getElementById('myLabel').innerHTML = "Edit Commission";
	}
	function SetReset()
	{
		document.getElementById('btnSubmit').value='Submit';
		document.getElementById('hidID').value = '';
		document.getElementById('myLabel').innerHTML = "Add Commission";
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
	input
	{
		width:120px;
	}
	</style>  
    <script language="javascript">

	
	function ddlAPIchange()
	{
		document.getElementById('ajaxload').style.display="block";
		document.getElementById('divcomm').style.display="none";
		if(document.getElementById('ddlAPIUSER').selectedIndex != 0)
		{
			document.getElementById('ddlMD').selectedIndex = 0;
			document.getElementById('ddlD').selectedIndex = 0;
			document.getElementById('ddlAGENT').selectedIndex = 0;
			var id = document.getElementById('ddlAPIUSER').value;
				
				getCommission(id);
				
			}
		}
	function ddlmdchange()
	{
		
		if(document.getElementById('ddlMD').selectedIndex != 0)
		{
			var id = document.getElementById('ddlMD').value;
			
				getCommission(id);
				
			}
		}
		function ddldchange()
		{
		
		if(document.getElementById('ddlD').selectedIndex != 0)
		{
			var id = document.getElementById('ddlD').value;
			$.ajax({
				  type: "GET",
				  url: '<?php echo base_url(); ?>_Admin/Set_UserApi/getretailer?id='+""+id,
				  cache:false,
				  success: function(html)
				  	{

    					$("#ddlAGENT").html(html);
  					}
				});
				
				getCommission(id);
				
			}
		}
		function ddlachange()
		{
			
		if(document.getElementById('ddlAGENT').selectedIndex != 0)
		{
			var id = document.getElementById('ddlAGENT').value;
				getCommission(id);
				
			}
		}
		function getCommission(id)
		{
			$.ajax({
				  type: "GET",
				  url: '<?php echo base_url(); ?>_Admin/Set_UserApi/getCommission?id='+""+id,
				  cache:false,
				  success: function(html)
				  	{
						document.getElementById('ajaxload').style.display="none";
						document.getElementById('divcomm').style.display="block";
    					$("#divcomm").html(html);
  					}
				});
		}
		function changecommission(company_id,usertype)
		{
			document.getElementById("ajaxload").style.display = "block";
			var com = document.getElementById("txtComm"+company_id).value;
			
			var mincomm = document.getElementById("txtMinComm"+company_id).value;
			var maxcomm = document.getElementById("txtMaxComm"+company_id).value;
			var comtype = document.getElementById("ddlcomtype"+company_id).value;
			var api_id = document.getElementById("ddlapi"+company_id).value;
			
			
		
			
			//document.getElementById("modelmp_failure_msg_BDEL").innerHTML ="";
			//document.getElementById("modelmp_success_msg_BDEL").innerHTML ="";
			//document.getElementById("responsespansuccess_BDEL").style.display = "none";
			//document.getElementById("responsespanfailure_BDEL").style.display = "none";
			$.ajax({
				  type: "GET",
				  url: '<?php echo base_url(); ?>_Admin/Set_UserApi/ChangeCommission?company_id='+company_id+"&com="+com+"&id="+document.getElementById("uid").value+'&mincomm='+mincomm+'&maxcomm='+maxcomm+'&comtype='+comtype+"&api_id="+api_id,
				  cache:false,
				  success:function(html)
				  	{
				
						if(usertype == "Distributor")
						{
							var id = document.getElementById('ddlD').value;
							getCommission(id);
							
							//modelmp_failure_msg_BDEL#modelmp_success_msg_BDEL
							//myMessgeModal,responsespansuccess_BDEL,responsespanfailure_BDEL
						}
						else if(usertype == "Agent")
						{
							var id = document.getElementById('ddlAGENT').value;
							getCommission(id);
						}
						else if(usertype == "APIUSER")
						{
							var id = document.getElementById('ddlAPIUSER').value;
							getCommission(id);
						}
						document.getElementById("ajaxload").style.display = "none";
						if(html == "OK")
						{
							
							//document.getElementById("modelmp_success_msg_BDEL").innerHTML ="Commission Updated Successfully";
							//document.getElementById("responsespansuccess_BDEL").style.display = "block";
							//$('#myMessgeModal').modal({show:true});
						}
						else
						{
							//document.getElementById("modelmp_failure_msg_BDEL").innerHTML =html;
							//document.getElementById("responsespanfailure_BDEL").style.display = "block";
							
							//$('#myMessgeModal').modal({show:true});
						}
				
  					}
				});
			
		}
			
	</script>