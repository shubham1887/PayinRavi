<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RETAILER::BENEFICIARY REGISTRATION</title>
    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
   <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
      <link href="<?php echo base_url();?>assets/css/main-style.css" rel="stylesheet" />
      <script src="<?php echo base_url()."js/jquery-1.4.4.js"; ?>"></script>
<style>
	.row1
	{
		background-color:#BFCDDD;
	}
	</style>
	
	
	<!-- Core CSS - Include with every page -->
	
      <script language="javascript">
	  
	  $(document).ready(function(){});
	  
	  var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) 
		{
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
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
</style>
    <style>
	.error
	{
  		background-color: #ffdddd;
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
#myOverlay{position:absolute;height:100%;width:100%;}
#myOverlay{background:black;opacity:.7;z-index:2;display:none;}

#loadingGIF{position:absolute;top:40%;left:45%;z-index:3;display:none;}
</style>
</head>
<body>
	<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->
        <!-- navbar side -->
       <?php include("files/distheader.php"); ?> 
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <?php include("files/distsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
					<?php include("files/messagebox.php"); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SEARCH RECHARGE
                            
                        </div>
                        <div class="panel-body">
                           <form action="<?php echo base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmdmr" id="frmdmr">
            <input type="hidden" id="hidformaction" name="hidformaction">
             <input type="hidden" id="hidbeneid" name="hidbeneid">
              <input type="hidden" id="txtotp" name="txtotp">
              <input type="hidden" id="hidremiterid" name="hidremiterid">
                <table class="table table-bordered" >
                <tr>
                	<td><label>Beneficiary Name:</label></td>
                    <td>
                        <input type="hidden" id="hidencrdata" name="hidencrdata" value="<?php echo $this->Common_methods->encrypt($this->session->userdata("session_id")); ?>">
                         <input type="text" name="txtbeneName" id="txtbeneName"  class="form-control"  maxlength="20"  style="width:300px;" ondrop="return false;" onpaste="return false;">
                    </td>
                </tr>
                <tr>
                	<td><label>Account Number:</label></td>
                    <td>
                       <input type="text" name="txtAccountNo" id="txtAccountNo"  class="form-control"  maxlength="30"  style="width:300px;" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                    </td>
                </tr>
					<tr>
                                            <td style="font-size:18px;font-weight:bold;width:120px;min-width:120px;">Select Bank:</span></label></td>
                                            <td align="left">
                                            	<select id="dropdownbank" name="ddlbank" class="form-control" style="width:300px" onChange="setifsctotxt()">
                                                <option value="">Select</option>
                                                <?php
                                                $rsldefi = $this->db->query("select * from dezire_banklist order by priority desc");
                                                foreach($rsldefi->result() as $rbnk)
                                                {?>
                                                <option value="<?php echo $rbnk->ifsc; ?>"><?php echo $rbnk->bank_name; ?></option>
                                                <?php }
                                                 ?>
                                                </select>
                                              <script language="javascript">
											  function setifsctotxt()
											  {
											  	document.getElementById("txtIfsc").value = document.getElementById("dropdownbank").value;
											  }
											  </script>  
        									</td>
                                          </tr>
                <tr>
                	<td><label>IFSC Code:</label></td>
                    <td>
                       <input type="text" name="txtIfsc" id="txtIfsc"  class="form-control"  maxlength="11"  style="width:300px;" >
                    </td>
                </tr>
                <tr>
                	<td><label>Mobile Number:</label></td>
                    <td>
                       <input type="text" name="txtMobile" id="txtMobile"  class="form-control"  maxlength="10"  style="width:300px;" value="<?php echo $this->session->flashdata("sendermobile") ?>" >
                    </td>
                </tr>
                
                <tr>
                    <td></td>
                    <td style="padding-top:30px;">
						
						
						<input type="button" id="btnverify" class="btn btn-warning" value="Verify" onClick="Verifybene()" style="width: 100px">
                      <input type="button" name="btnSearch" id="btnSearch" value="Add Beneficiary" class="btn btn-success" title="Click to search." onClick="validataandsubmit()"  style="width: 140px"/>
						
                    </td>
                </tr>
                </table>
			</form>
							<script language="javascript">
	function validataandsubmit()
	{
		if(validatamobile() & validatebenename() & validateifsc() & validateaccno())
		{
			benereg();
		}
		else
		{
			alert("Please Fill All The Field");
		}
			
	}
	function validateaccno()
	{
		var accno = document.getElementById("txtAccountNo").value;
		if(accno.length >= 6)
		{
				$("#txtAccountNo").removeClass("error");
				return true;
		}
		else
		{
			$("#txtAccountNo").addClass("error");
			return false;
		}
	}
	function validatebenename()
	{
		var name = document.getElementById("txtbeneName").value;
		if(name.length >= 4)
		{
				$("#txtbeneName").removeClass("error");
				return true;
		}
		else
		{
			$("#txtbeneName").addClass("error");
			return false;
		}
	}
	function validateifsc()
	{
		var ifsc = document.getElementById("txtIfsc").value;
		if(ifsc.length == 11)
		{
				$("#txtIfsc").removeClass("error");
				return true;
		}
		else
		{
			$("#txtIfsc").addClass("error");
			return false;
		}
	}
	function validatamobile()
	{
		var mob = document.getElementById("txtMobile").value;
		if(mob.length == 10)
		{
				$("#txtMobile").removeClass("error");
				return true;
		}
		else
		{
			$("#txtMobile").addClass("error");
			return false;
		}
	}
								
								
								
</script>
                        </div>
                    </div>
                        
                    </div>
                    <input type="hidden" id="hidurllivedata" value="<?php echo base_url()."Retailer/recharge_home/getLiveTransactions"; ?>">
      
      <script language="javascript">
	  	function benereg(id)
		{
			 $('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("hidformaction").value = "BENEREGISTRATION";
			document.getElementById("responsespanfailure").style.display = 'none'
			document.getElementById("responsespansuccess").style.display = 'none'
			document.getElementById("responsespanotpinput").style.display = 'none'
			
			document.getElementById("modelmp_success_msg").innerHTML  = "";
			document.getElementById("modelmp_failure_msg").innerHTML  = "";
			document.getElementById("modalmptitle").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmdmr').serialize(),
				method:'POST',
				type:'POST',
				success:function(data)
				{
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					 document.getElementById("modalmptitle").innerHTML  = msg;
					document.getElementById("responsespansuccess").style.display = 'block'
					document.getElementById("modelmp_success_msg").innerHTML = msg;
					
					/*if(sts == 0)
					{
						var remiter_id = jsonobj.remiter_id;
						var beneid = jsonobj.beneid;
						document.getElementById("hidremiterid").value = remiter_id;
						document.getElementById("hidbeneid").value = beneid;
						document.getElementById("modalmptitle").innerHTML  = msg;
						//document.getElementById("responsespanotpinput").style.display = 'block';
						
					}
					else
					{
						document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
						document.getElementById("responsespanfailure").style.display = 'block'
						document.getElementById("modelmp_failure_msg").innerHTML = msg;
					}*/
				},
				error:function()
				{
					document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
					document.getElementById("responsespanfailure").style.display = 'block'
					document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					 $('#myOverlay').hide();
    				$('#loadingGIF').hide();
					$('#myMPModal').modal({show:true,backdrop: 'static',keyboard: false});
					
						window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
				}
				});
		}
		function validatebenereg()
		{
			$('#myMPModal').modal('hide');
			$('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("txtotp").value = document.getElementById("hidotp").value;
			document.getElementById("hidformaction").value = "OTPBENEREGISTRATION";
			document.getElementById("responsespanfailure").style.display = 'none'
			document.getElementById("responsespansuccess").style.display = 'none'
			document.getElementById("responsespanotpinput").style.display = 'none'
			
			document.getElementById("modelmp_success_msg").innerHTML  = "";
			document.getElementById("modelmp_failure_msg").innerHTML  = "";
			document.getElementById("modalmptitle").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmdmr').serialize(),
				type:'POST',
				success:function(data)
				{
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						document.getElementById("modalmptitle").innerHTML  = msg;
						document.getElementById("responsespansuccess").style.display = 'block'
						document.getElementById("modelmp_success_msg").innerHTML = msg;
					}
					else
					{
						document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
						document.getElementById("responsespanfailure").style.display = 'block'
						document.getElementById("modelmp_failure_msg").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
					document.getElementById("responsespanfailure").style.display = 'block'
					document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					$('#myOverlay').hide();
    				$('#loadingGIF').hide();
					$('#myMPModal').modal({show:true,backdrop: 'static',keyboard: false});
					
					
					window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
					
				}
				});
		}
		function resendotp()
		{
			$('#myMPModal').modal('hide');
			$('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("txtotp").value = "";
			document.getElementById("hidformaction").value = "RESENDOTPBENEREGISTRATION";
			document.getElementById("responsespanfailure").style.display = 'none'
			document.getElementById("responsespansuccess").style.display = 'none'
			document.getElementById("responsespanotpinput").style.display = 'none'
			
			document.getElementById("modelmp_success_msg").innerHTML  = "";
			document.getElementById("modelmp_failure_msg").innerHTML  = "";
			document.getElementById("modalmptitle").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmdmr').serialize(),
				type:'POST',
				success:function(data)
				{
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						var remiter_id = jsonobj.remiter_id;
						var beneid = jsonobj.beneid;
						document.getElementById("hidremiterid").value = remiter_id;
						document.getElementById("hidbeneid").value = beneid;
						document.getElementById("modalmptitle").innerHTML  = msg;
						document.getElementById("responsespanotpinput").style.display = 'block';
					}
					else
					{
						document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
						document.getElementById("responsespanfailure").style.display = 'block'
						document.getElementById("modelmp_failure_msg").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
					document.getElementById("responsespanfailure").style.display = 'block'
					document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					$('#myOverlay').hide();
    				$('#loadingGIF').hide();
					$('#myMPModal').modal({show:true,backdrop: 'static',keyboard: false});
					
				}
				});
		}
	  </script>
		
		
		<script language="javascript">
			function Verifybene()
			{
				if(validateifsc() & validateaccno())
				{
					 $('#myOverlay').show();
    				$('#loadingGIF').show();
					document.getElementById("hidformaction").value = "BENEVERIFICATION";
					document.getElementById("responsespanfailure").style.display = 'none'
					document.getElementById("responsespansuccess").style.display = 'none'
					document.getElementById("responsespanotpinput").style.display = 'none'

					document.getElementById("modelmp_success_msg").innerHTML  = "";
					document.getElementById("modelmp_failure_msg").innerHTML  = "";
					document.getElementById("modalmptitle").innerHTML  = "";

					$.ajax({
						url:document.getElementById("hidbregvalurl").value,
						cache:false,
						data:$('#frmdmr').serialize(),
						method:'POST',
						type:'POST',
						success:function(data)
						{
							//alert(data);
							//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}

							var jsonobj = JSON.parse(data);
							var msg = jsonobj.message;
							var sts = jsonobj.status;

							if(sts == 0)
							{
								var datastr = jsonobj.data;
								var benename = datastr.benename;
								document.getElementById("txtbeneName").value = benename;
								document.getElementById("modalmptitle").innerHTML  = msg;
								document.getElementById("responsespanotpinput").style.display = 'block';

							}
							else
							{
								document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
								document.getElementById("responsespanfailure").style.display = 'block'
								document.getElementById("modelmp_failure_msg").innerHTML = msg;
							}
						},
						error:function()
						{
							document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
							document.getElementById("responsespanfailure").style.display = 'block'
							document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
						},
						complete:function()
						{
							 $('#myOverlay').hide();
							$('#loadingGIF').hide();
						}
						});
				}
				else
				{
					alert("Please Fill All The Field");
				}
			}
		</script>
      
      <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."Retailer/dmr_bene_registration"; ?>">
      <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmr_dashboard"; ?>">
					<div class="modal fade" id="myMPModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle"></h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloader" style="display:none">
          <img id="imgloading" src="<?php echo base_url()."images/ajax-loader.gif"; ?>"></span>
          <div id="responsespansuccess" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_success_msg"></strong>
                </div>
          </div>
          <div id="responsespanfailure" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_failure_msg"></strong>
                </div>
          </div>
           <div id="responsespanotpinput" style="display:none">
          		<table class="table">
                <tr>
                	<td><label>Enter OTP</label></td>
                	<td>
                    <input type="text" id="hidotp" name="hidotp" class="form-control" maxlength="8" onkeypress="return IsNumeric(event);">
                    </td>
                    <td>
                    <input type="button" id="btnSubmitOtp" name="btnSubmitOtp" class="btn btn-success" value="Submit" onClick="validatebenereg()">
                    </td>
                    <td>
                    <input type="button" id="btnResendOtp" name="btnResendOtp" class="btn btn-primary" value="Resend OTP" onClick="resendotp()">
                    </td>
                </tr>
                </table>
          </div>
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode" > <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>
                     <!-- End Form Elements -->
                </div>
            </div>
            
        </div>
        <!-- end page-wrapper -->
    </div>
    <!-- end wrapper -->
    <!-- Core Scripts - Include with every page -->
   
 
 <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>
</html>
