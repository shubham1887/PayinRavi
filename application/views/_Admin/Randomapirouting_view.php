<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

   <title>ADMIN |Custom Api Setting</title>
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
	

});	</script>
<script>

	function Confirmation(id)
	{
		
		if(confirm("Are you sure?\nyou want to delete...??") == true)
		{
			$.ajax({
				type:"POST",
				url:document.getElementById("hidrandomdeleteurl").value,
				data:{'Id':id},
				beforeSend: function() 
				{
				    //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                },
				success: function(response)
				{
				   
				   //$('#myModalProgress').modal('hide');
					console.log(response);  
				},
				error:function(response)
				{
				   //$('#myModalProgress').modal('hide');
				},
				complete:function()
				{
				  //$('#myModalProgress').modal('hide');
				  getdata();
				  
				}
			});			 
		}
	}
	function ConfirmationAmount(id)
	{
		
		if(confirm("Are you sure?\nyou want to delete...??") == true)
		{
			$.ajax({
				type:"POST",
				url:document.getElementById("hidamountdeleteurl").value,
				data:{'Id':id},
				beforeSend: function() 
				{
				    //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                },
				success: function(response)
				{
				   
				   //$('#myModalProgress').modal('hide');
					console.log(response);  
				},
				error:function(response)
				{
				   //$('#myModalProgress').modal('hide');
				},
				complete:function()
				{
				 // $('#myModalProgress').modal('hide');
				  getdata();
				  
				}
			});			 
		}
	}
	function Confirmationstate(id)
	{
		
		if(confirm("Are you sure?\nyou want to delete...??") == true)
		{
			$.ajax({
				type:"POST",
				url:document.getElementById("hidseriesdeleteurl").value,
				data:{'Id':id},
				beforeSend: function() 
				{
				   // $('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                },
				success: function(response)
				{
				   
				  // $('#myModalProgress').modal('hide');
					console.log(response);  
				},
				error:function(response)
				{
				  // $('#myModalProgress').modal('hide');
				},
				complete:function()
				{
				  //$('#myModalProgress').modal('hide');
				  getdata();
				  
				}
			});			 
		}
	}
	
</script>
<style>
.myselect {
  margin: 1px  !important; ;
  width: 70px  !important; ;
  padding: 1px 5px 1px 1px  !important; ;
  font-size: 12px  !important; ;
  border: 1px solid #ccc  !important; ;
  height: 24px  !important; ;
}
.retry
{
	background:#FBC6FB;
}
.dont
{
	background:#C0C0C0;
}
.manual
{
background:#C0C6C0;
}
</style>
<script language="javascript">
function viewhidelog()
{
	var flag = document.getElementById("btnviewlog").value;
	if(flag == "VIEW LOG")
	{
		document.getElementById("btnviewlog").value = "HIDE LOG";
		var str = document.getElementById("hisrecids").value;
		var strarr = str.split("#");
		for(i=0;i<strarr.length;i++)
		{
			tetingalert(strarr[i]);
		}
		
	}
	else
	{
			document.getElementById("btnviewlog").value = "VIEW LOG";
			var str = document.getElementById("hisrecids").value;
			var strarr = str.split("#");
			for(i=0;i<strarr.length;i++)
			{
				document.getElementById("tr_reqresp"+strarr[i]).style.display = 'none'
			}
			
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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 2px;
    /*line-height: 1.42857143;*/
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
    border-left: 1px solid #ddd;
	border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
	border-bottom:: 1px solid #ddd;
	overflow:hidden;
	font-size:14;color:#2D2B2B;margin-left:5px;
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">Custom Api Setting</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Custom Api Setting</h4>
        </div>
      </div><!-- d-flex -->
    <?php  $apidorpdown_options = $this->Api_model->getApiListForDropdownList(); ?>
      <div class="br-pagebody">
          
          <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Random Api Setting</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form id="frmSearchajaxt" role="form" method="post" action="<?php echo base_url()."_Admin/randomapirouting?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
										<td style="font-size:14;color:#2D2B2B;margin-left:5px;">
                                        	 <label>OPERATOR NAME</label>
                                            	<select id="ddlcompany" name="ddlcompany" class="text" style="width: 120px;height:30px;">
													<option value="0">Select</option>
													<?php echo $this->Company_model->getRechargeOperators_enabled_dropdown(); ?>
											    </select>
                                        </td>
                                       
                                    </tr>
                                    </table>
                  </form>
                  <input type="hidden" id="hidgetcustomerapidataurl" value="<?php echo base_url()."_Admin/randomapirouting/getCustomApiData"; ?>">
                  <input type="hidden" id="hidaddrandomapi" value="<?php echo base_url()."_Admin/randomapirouting/addrandomapi"; ?>">
                   <input type="hidden" id="hidaddamountsapi" value="<?php echo base_url()."_Admin/randomapirouting/addamountapi"; ?>">
                   <input type="hidden" id="hidaddstateapi" value="<?php echo base_url()."_Admin/randomapirouting/addstateapi"; ?>">
                   
                   
                   
                  <input type="hidden" id="hidamountupdateurl" value="<?php echo base_url()."_Admin/randomapirouting/updateamounts"; ?>">
                  <input type="hidden" id="hidamountdeleteurl" value="<?php echo base_url()."_Admin/randomapirouting/delete_amounts_api"; ?>">
                  <input type="hidden" id="hidrandomdeleteurl" value="<?php echo base_url()."_Admin/randomapirouting/delete_random_api"; ?>">
                  
                  <input type="hidden" id="hidseriesdeleteurl" value="<?php echo base_url()."_Admin/randomapirouting/delete_series_api"; ?>">
                  <input type="hidden" id="hidstateupdateurl" value="<?php echo base_url()."_Admin/randomapirouting/update_series_api"; ?>">
                  
                  
                  
                  
                  
                  <script>
                  function getdata()
                  {
                      $.ajax({
                					type:"POST",
                					url:document.getElementById("hidgetcustomerapidataurl").value,
                					data:{'company_id':document.getElementById("ddlcompany").value},
                					beforeSend: function() 
                					{
                					 //$('#myModalProgress').modal({show:true});
                                    },
                					success: function(response)
                					{
                					   
                					    var response_array = response.split("^-^");
                					    document.getElementById("randomapidiv").innerHTML = response_array[0];
                					    document.getElementById("amountapidiv").innerHTML = response_array[1];
                					    document.getElementById("stateapidiv").innerHTML = response_array[2];
                					    
                					    
                					  // $('#myModalProgress').modal('hide');
                						console.log(response);  
                					},
                					error:function(response)
                					{
                					   //$('#myModalProgress').modal('hide');
                					},
                					complete:function()
                					{
                					  //$('#myModalProgress').modal('hide');
                					}
                				});
                  }
                      $("#ddlcompany").change( function()
                       {
                          getdata();						 
                       }
                    );
                    
                  </script>
    <div class="modal fade" id="myModalProgress" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
             <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
              <h4 class="modal-title" id="modalmptitle"></h4>
              
            </div>
            <div class="modal-body">
            <span id="spanloader" >
              <img id="imgloading" src="<?php echo base_url()."Loading.gif"; ?>"></span>
            </div>
            <div class="modal-footer">
             <span id="spanbtnclode"  style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
            </div>
          </div>
        </div>
    </div>
							
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
           
          
          
          
          
          
          
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Random Api Setting</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form id="frmInsert" role="form" method="post" action="<?php echo base_url()."_Admin/randomapirouting?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
										
                                    	<td style="font-size:14;color:#2D2B2B;margin-left:5px;">
                                        	 <label>API NAME</label>
                                            	<select id="ddlRandomApi" name="ddlRandomApi" class="text" style="width: 120px;height:30px;">
													<option value="0">Select</option>
													<?php echo $this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto(1); ?>
											    </select>
                                        </td>
                                       
                                        <td>
                                            <input type="button" id="btnAddRandomApi" name="btnAddRandomApi" value="Add" class="btn btn-primary btn-sm" >
                                        </td>
                                    </tr>
                                    </table>
                  </form>
							<script language="javascript">
							$("#btnAddRandomApi").click( function()
                           {
                               var api_id = document.getElementById("ddlRandomApi").value;
                               var company_id = document.getElementById("ddlcompany").value;
                            	$.ajax({
                					type:"POST",
                					url:document.getElementById("hidaddrandomapi").value,
                					data:{'company_id':company_id,"api_id":api_id},
                					beforeSend: function() 
                					{
                					// $('#myModalProgress').modal({show:true});
                                    },
                					success: function(response)
                					{
                					   
                					  // $('#myModalProgress').modal('hide');
                						//console.log(response);  
                					},
                					error:function(response)
                					{
                					  // $('#myModalProgress').modal('hide');
                					},
                					complete:function()
                					{
                					  //$('#myModalProgress').modal('hide');
                					  getdata();
                					}
                				});			 
                           });
								function validateandsubmit()
								{
									var apiid = document.getElementById("ddlApi").value;
									var company_id = document.getElementById("ddlcompany").value;
								
									if(apiid > 0)
									{
									    if(company_id > 0)
									    {
									        document.getElementById("frmInsert").submit();   
									    }
									    else
									    {
									        alert("Please Select Operator");	
									    }
									}
									else
									{
										alert("Please Select API");	
									}
								}
							</script>
							<div id="randomapidiv">
							    
							</div>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Denomination Wise Api Switching</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <form id="frmAmountApi" role="form" method="post" action="<?php echo base_url()."_Admin/randomapirouting/amountwiseapi?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
										<td style="font-size:12;color:#2D2B2B;margin-left:5px;">
                                        	 <h6>AMOUNTS</h6>
                                             <input type="text" id="txtAmounts" name="txtAmounts" class="text" style="width: 320px;height:30px;" >
                                        </td>
                                    	<td style="font-size:12;color:#2D2B2B;margin-left:5px;">
                                        	 <h6>API NAME</h6>
                                            	<select id="ddlAmountApi" name="ddlAmountApi" class="text" style="width: 120px;height:30px;">
													<option value="0">Select</option>
													<?php echo $this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto(2); ?>
											    </select>
                                        </td>
                                       
                                        <td valign="bottom">
                                            <input type="button" id="btnaddamount" name="btnaddamount" value="Submit" class="btn btn-primary btn-sm" >
                                        </td>
                                    </tr>
                                    </table>
                  </form>
							<script language="javascript">
							   	$("#btnaddamount").click( function()
							   	{
									var amounts = document.getElementById("txtAmounts").value;
									var amountapi = document.getElementById("ddlAmountApi").value;
									var company_id = document.getElementById("ddlcompany").value;
								    $.ajax({
                    					type:"POST",
                    					url:document.getElementById("hidaddamountsapi").value,
                    					data:{'company_id':company_id,"amounts":amounts,'amounts_api':amountapi},
                    					beforeSend: function() 
                    					{
                    					    //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                                        },
                    					success: function(response)
                    					{
                    					   
                    					   //$('#myModalProgress').modal('hide');
                    						console.log(response);  
                    					},
                    					error:function(response)
                    					{
                    					   //$('#myModalProgress').modal('hide');
                    					},
                    					complete:function()
                    					{
                    					  //$('#myModalProgress').modal('hide');
                    					  getdata();
                    					}
                				    });			 
								});
								function updataamounts(id)
								{
									var amounts = document.getElementById("amounts"+id).value;
									var ddlamountapi = document.getElementById("ddlamountapi"+id).value;
                  var ddlamountcircle = document.getElementById("ddlamountcircle"+id).value;
                //  alert(ddlamountcircle);
								    $.ajax({
                					type:"POST",
                					url:document.getElementById("hidamountupdateurl").value,
                					data:{'Id':id,"amounts":amounts,'amounts_api':ddlamountapi,'amounts_circle':ddlamountcircle},
                					beforeSend: function() 
                					{
                					    document.getElementById("amounts"+id).style.backgroundColor  = "yellow";
                					 //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                                    },
                					success: function(response)
                					{
                					   
                					   //$('#myModalProgress').modal('hide');
                					   document.getElementById("amounts"+id).style.backgroundColor  = "";
                						console.log(response);  
                					},
                					error:function(response)
                					{
                					  // $('#myModalProgress').modal('hide');
                					},
                					complete:function()
                					{
                					  //$('#myModalProgress').modal('hide');
                					  document.getElementById("amounts"+id).style.backgroundColor  = "";
                					  
                					}
                				});			 
								}
							</script>
							
							<div id="amountapidiv"></div>
						
              </div><!-- card-body -->
            </div>
        </div>
        </div>
        
        
        
        
        
        
        
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">State Wise Api Switching</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <form id="frmStateApi" role="form" method="post" action="<?php echo base_url()."_Admin/randomapirouting/statewiseapi?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
										<td style="font-size:12;color:#2D2B2B;margin-left:5px;">
                                        	 <h6>State</h6>
                                             <select id="ddlstate" name="ddlstate" style="width:120px;height:30px">
                                                 <option value="0"></option>
                                                 <?php echo $this->Address_model->getStateDropdownList(); ?>
                                             </select>
                                        </td>
                                    	<td style="font-size:12;color:#2D2B2B;margin-left:5px;">
                                        	 <h6>API NAME</h6>
                                            	<select id="ddlStateApi" name="ddlStateApi" class="text" style="width: 120px;height:30px;">
													<option value="0">Select</option>
													<?php echo $this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto(3); ?>
											    </select>
                                        </td>
                                       
                                        <td valign="bottom">
                                            <input type="button" id="btnaddstate" name="btnaddstate" value="Submit" class="btn btn-primary btn-sm" >
                                        </td>
                                    </tr>
                                    </table>
                  </form>
							<script language="javascript">
							   	$("#btnaddstate").click( function()
							   	{
									var state = document.getElementById("ddlstate").value;
									var stateapi = document.getElementById("ddlStateApi").value;
									var company_id = document.getElementById("ddlcompany").value;
								    $.ajax({
                    					type:"POST",
                    					url:document.getElementById("hidaddstateapi").value,
                    					data:{'state_id':state,"stateapi":stateapi,'company_id':company_id},
                    					beforeSend: function() 
                    					{
                    					    //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                                        },
                    					success: function(response)
                    					{
                    					   
                    					   //$('#myModalProgress').modal('hide');
                    						console.log(response);  
                    					},
                    					error:function(response)
                    					{
                    					  // $('#myModalProgress').modal('hide');
                    					},
                    					complete:function()
                    					{
                    					  //$('#myModalProgress').modal('hide');
                    					  getdata();
                    					}
                				    });			 
								});
								function updatestateapi(id)
								{
									var stateapi = document.getElementById("ddlstateapi"+id).value;
								    $.ajax({
                					type:"POST",
                					url:document.getElementById("hidstateupdateurl").value,
                					data:{'Id':id,"amounts":"",'stateapi':stateapi},
                					beforeSend: function() 
                					{
                					    document.getElementById("ddlstateapi"+id).style.backgroundColor  = "yellow";
                					 //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                                    },
                					success: function(response)
                					{
                					   
                					   //$('#myModalProgress').modal('hide');
                					   document.getElementById("ddlstateapi"+id).style.backgroundColor  = "";
                						console.log(response);  
                					},
                					error:function(response)
                					{
                					  // $('#myModalProgress').modal('hide');
                					},
                					complete:function()
                					{
                					  //$('#myModalProgress').modal('hide');
                					  document.getElementById("ddlstateapi"+id).style.backgroundColor  = "";
                					  
                					}
                				});			 
								}
							</script>
							
							<div id="stateapidiv"></div>
						
              </div><!-- card-body -->
            </div>
        </div>
        </div>
        
        
        
        
        
      </div><!-- br-pagebody -->
      <form id="frmDelete" name="frmDelete" method="post" action="">
		<input type="hidden" id="hidValue" name="hidValue">
		<input type="hidden" id="action" name="action">
		
	</form>
	<form id="frmAmountDelete" name="frmAmountDelete" method="post" action="<?php echo base_url()."_Admin/randomapirouting/amountwiseapi"; ?>">
		<input type="hidden" id="hidAmountValue" name="hidAmountValue">
		<input type="hidden" id="Amountaction" name="Amountaction">
		
	</form>
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
