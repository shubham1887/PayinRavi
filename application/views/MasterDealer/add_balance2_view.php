<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterDealer |  WALLET2 FUND TRANSFER</title>
      <?php include("files/links.php"); ?>
      <?php include("files/apijaxscripts.php"); ?>
 <script>
$(document).ready(function(){
	//global vars
	var form = $("#frmBalance");
	var amount = $("#txtAmount");
	var remark = $("#txtRemark");
	amount.focus();
	amount.blur(validatesAmount);
	form.submit(function(){
		if(validatesAmount() & validatesRemark() & validateCheckbox())
			{
				if(Check() == false)
				{
					return false;
				}
			}
		else
			return false;
	});
	function validatesAmount(){
		if(amount.val() == ""){
			amount.addClass("error");
			return false;
		}
		//if it's valid
		else{
			amount.removeClass("error");
			return true;
		}
	}
	function validatesRemark(){
		if(remark.val() == ""){
			remark.addClass("error");
			return false;
		}
		//if it's valid
		else{
			remark.removeClass("error");
			return true;
		}
	}
	function validateCheckbox()
	{
		
        var chkBox = document.getElementById('credit');
    	if (chkBox.checked)
		{
			document.getElementById("hidpaymentType").value = "credit";
		}
		else
		{
			document.getElementById("hidpaymentType").value = "cash";
		}
		return true;
        
	}
});
	function Check()
	{		
		if(confirm("are you sure? you want to process balance for ["+document.getElementById('dname').innerHTML+"]") == true)
		{
	document.getElementById("frmBalance").submit();
	
		}
		else
		{
			return false;
		}
	}
	$(".checkbox").change(function() {
    if(this.checked) {
        alert("hi");
    }
});
	</script>
    <script language="javascript">
	function getFlatCommission()
	{
		var amount = document.getElementById("txtAmount").value; 
		var comPer = '<?php echo $flat_commission; ?>';
		var commAmount = (amount * comPer) / 100;
		document.getElementById("txtFlatComm").innerHTML = commAmount; 
		
	}
	function clear()
	{
		document.getElementById("txtFlatComm").innerHTML = 0; 
		document.getElementById("txtAmount").innerHTML = 0; 
	}
	</script>
     <style>
	 .odd { 
        background-color: #FCF7F7;
      }
    .even {
        background-color: #E3DCDB;
    }
	
	 </style>    
</head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->
        <!-- navbar side -->
        <?php include("files/mdheader.php"); ?> 
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <?php include("files/mdsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">WALLET2 FUND TRANSFER</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Area Chart Example
                            
                        </div>
                        <div class="panel-body">
                           <div class="breadcrumb">
			<h2 class="h2">Fund Transfer</h2>   
    		<fieldset>
    <form id="frmaddbal" name="frmaddbal" method="post" action="<?php echo base_url()."MasterDealer/add_balance2?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                	  <input type="hidden" id="hidid" name="hidid" value="<?php echo $userinfo->row(0)->user_id; ?>">
                	  <table class="table table" style="width:450px">
                                    <tr>
                                    	<td style="padding-right:10px;" align="right">Agent Name :</td>
                                        	 <td>
                                           	<span style="font-weight:bold;color:#000000"><?php echo $userinfo->row(0)->businessname; ?></span>
                                        </td>
                                     </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">AgentId</td>
                                        	 <td>
                                            <span style="font-weight:bold;color:#000000"><?php echo $userinfo->row(0)->username; ?></span>
                                        </td>
                                     </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	Current Wallet 2 Balance</td>
                                        	 <td>
                                             <span style="font-weight:bold;color:#000000">
											 	<?php 
												$this->load->model("Ew2");
												echo $this->Ew2->getAgentBalance($userinfo->row(0)->user_id); ?>
                                             </span>
                                        </td>
                                      </tr>
                                      <tr>
                                       <td style="padding-right:10px;"  align="right">
                                        	 Action</td>
                                        	 <td>
                                            <select id="ddlaction" name="ddlaction" class="form-control" style="width:200px">
                                                <option value="ADD">ADD</option>
                                                <option value="REVERT">REVERT</option>
											</select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Amount</td>
                                        	 <td>
                                            <input type="text" id="txtAmount" name="txtAmount" style="width:200px" class="form-control" >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Remark</td>
                                        	 <td>
                                            <input type="text" id="txtRemark" name="txtRemark" style="width:200px" class="form-control" >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        	 <td>
                                        	<input type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success" value="Submit" onClick="validateandsubmit()">
                                        </td>
                                      </tr>
                                    </tr>
                                    </table>
                </form>
                <script language="javascript">
				function validateandsubmit()
				{
					if(validateamount() & validateremark())
					{
						document.getElementById("frmaddbal").submit();
					}
				}
				function validateamount()
				{
					var amt = document.getElementById("txtAmount").value;
					if(amt == "")
					{
						$("#txtAmount").addClass("error");
						return false;
					}
					else
					{
						$("#txtAmount").removeClass("error");
						return true;
					}
				}
				function validateremark()
				{
					var remark = document.getElementById("txtRemark").value;
					if(remark == "")
					{
						$("#txtRemark").addClass("error");
						return false;
					}
					else
					{
						$("#txtRemark").removeClass("error");
						return true;
					}
				}
				</script>
        </fieldset>
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
   
   <?php include("files/adminfooter.php"); ?> 
</body>
</html>
