<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Group Commission</title>

    
     
    
  <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
   <script>
    
$(document).ready(function(){
  getdata();
  getpayoutdata();
  getpgdata();
  getINDONEPALdata();

}); </script>
        <style>
   .odd { 
        background-color: #FCF7F7;
      }
    .even {
        background-color: #E3DCDB;
    }
  
   </style>
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
          <span class="breadcrumb-item active">Group Commission Settings</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Commission Setting</h4>
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
                  <div id="ajaxprocess" style="display:none">
                  <img src="<?php echo base_url(); ?>ajax-loader_bert.gif">
                  </div>
                 <form method="post"  name="frmscheme_view" id="frmscheme_view" autocomplete="off">
<div class="breadcrumb" style="padding:20px;">
<table>
<tr>
<td>
<table cellpadding="3" cellspacing="3" border="0">
  <tr>
        <td align="right">
            <label for="txtGroupName" style="font-size:20px;"><span style="color:#F06">*</span>Group Name :</label></td><td align="left">
           <input type="text" name="txtGroupName" id="txtGroupName" class="form-control" value="<?php echo $group_info->row(0)->group_name; ?>">
            
        </td>
    </tr>
    
</table>
</td>
</tr>
</table>
</div>
<input type="hidden" id="hidID" name="hidID" />
</form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
        
        
<?php
$slaboptions = $this->Commission->getCommissionSlab_dropdown_options();


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
                      <thead class="thead-colored thead-primary" >
                    <tr>
                        <th>Sr</th>
                        <th>Company Name</th>
                        <th>Operator Code</th>
                        <th>Comm. Per</th>
                        <th>Comm. Amount</th>
                        <th>Charge Per</th>
                        <th>Charge Amt</th>
                        <th>Is Percent</th>
                        <th></th>
                        <th>Slab</th>
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
                            <td><?php echo $opar->company_name; ?></td>
                            <td><?php echo $opar->mcode; ?></td>
                            <td>
                                <input type="text" id="txtComm<?php echo $opar->company_id; ?>" name="txtComm<?php echo $opar->company_id; ?>" value="<?php echo $opar->commission_per; ?>" class="form-control" style="width:120px">
                            </td>

                            <td>
                                <input type="text" id="txtCommAmt<?php echo $opar->company_id; ?>" name="txtCommAmt<?php echo $opar->company_id; ?>" value="<?php echo $opar->CommissionAmount; ?>" class="form-control" style="width:120px">
                            </td>

                            <td>
                                <input type="text" id="txtChargePer<?php echo $opar->company_id; ?>" name="txtChargePer<?php echo $opar->company_id; ?>" value="<?php echo $opar->Charge_per; ?>" class="form-control" style="width:120px">
                            </td>

                            <td>
                                <input type="text" id="txtChargeAmt<?php echo $opar->company_id; ?>" name="txtChargeAmt<?php echo $opar->company_id; ?>" value="<?php echo $opar->Charge_amount; ?>" class="form-control" style="width:120px">
                            </td>

                            <td>
                                <select  id="ddlcommtype<?php echo $opar->company_id; ?>" name="ddlcommtype<?php echo $opar->company_id; ?>" class="form-control" style="width:120px">
                                    <option value="PER">%</option>
                                    <option value="AMOUNT">AMOUNT</option>
                                </select>
                                <script language="javascript">document.getElementById("ddlcommtype"+<?php echo $opar->company_id; ?>).value = '<?php echo $opar->commission_type; ?>';</script>
                            </td>
                            <td>or</td>
                            <td>
                                <select  id="ddlslab<?php echo $opar->company_id; ?>" name="ddlslab<?php echo $opar->company_id; ?>" class="form-control" style="width:120px">
                                    <option value="0"></option>
                                    <?php echo $slaboptions; ?>
                                </select>
                                <script language="javascript">document.getElementById("ddlslab"+<?php echo $opar->company_id; ?>).value = '<?php echo $opar->commission_slab; ?>';</script>
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




<!--------------- aeps slab start ---------------->
<!--------------- aeps slab start ---------------->
<!--------------- aeps slab start ---------------->
<!--------------- aeps slab start ---------------->
<!--------------- aeps slab start ---------------->
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
          <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">AEPS</h6>
                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->
              <div class="card-header">
              <table class="col-10">
                  <tr>
                      <td align="center">
                            <h5>Amount From : </h5>
                            <input type="text" name="txtAEpSAmountFrom" id="txtAEpSAmountFrom" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Amount To : </h5>
                            <input type="text" name="txtAEpSAmountTo" id="txtAEpSAmountTo" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Commission : </h5>
                            <input type="text" name="txtAEpSCommission" id="txtAEpSCommission" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Commission Type: </h5>
                            <select name="txtAEpSCommissionType" id="txtAEpSCommissionType" style="width:80px;">
                              <option value="PER">%</option>
                              <option value="AMOUNT">Amount</option>
                            </select>
                      </td>
                      <td  align="center">
                            <h5>Max Commission : </h5>
                            <input type="text"  name="txtAEpSMaxCommission" id="txtAEpSMaxCommission"  style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Aeps Type: </h5>
                            <select name="txtAEpSType" id="txtAEpSType" style="width:80px;">
                              <option value="W">Cash Withdrawal</option>
                              <option value="B">Balance Inquiry</option>
                              <option value="S">Mini Statement</option>
                            </select>
                      </td>
                      <td  align="center">
                        <h5>&nbsp;</h5>
                        <input type="button" name="btnAEpSAddSlab" id="btnAEpSAddSlab" value="Add" class="btn btn-success btn-sm" style="width:100px;">
                      </td>
                  </tr>
                </table>
                <input type="hidden" id="hidaelsslablist" value="<?php echo base_url(); ?>_Admin/Commission_settings/getAepsSlabList">
                <input type="hidden" id="hidaepsslabdeleteurl" value="<?php echo base_url(); ?>_Admin/Commission_settings/deleteAepsSlab">
                <input type="hidden" id="hidaepsslaburl" value="<?php echo base_url(); ?>_Admin/Commission_settings/AddAepsSlab">
                <script>
                  function getdata()
                  {
                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                      $.ajax({
                          type:"POST",
                          url:document.getElementById("hidaelsslablist").value,
                          data:{'group_id':group_id},
                          beforeSend: function() 
                          {
                           //$('#myModalProgress').modal({show:true});
                                    },
                          success: function(response)
                          {
                             
                             
                              document.getElementById("aeps_slab_div").innerHTML = response;
                              
                              
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
                  function AepsSlabDeleteConfirmation(id)
                {
                  
                  if(confirm("Are you sure?\nyou want to delete...??") == true)
                  {
                    $.ajax({
                      type:"POST",
                      url:document.getElementById("hidaepsslabdeleteurl").value,
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
                    
                  </script>
                
                <script language="javascript">
                  $("#btnAEpSAddSlab").click( function()
                  {
                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                  var aeps_amount_from = document.getElementById("txtAEpSAmountFrom").value;
                  var aeps_amount_to = document.getElementById("txtAEpSAmountTo").value;
                  var aeps_commission = document.getElementById("txtAEpSCommission").value;
                  var aeps_commission_type = document.getElementById("txtAEpSCommissionType").value;
                  var aeps_maxcommission = document.getElementById("txtAEpSMaxCommission").value;
                  var aeps_type = document.getElementById("txtAEpSType").value;
                  
                    $.ajax({
                              type:"POST",
                              url:document.getElementById("hidaepsslaburl").value,
                              data:{'group_id':group_id,"amount_from":aeps_amount_from,'amount_to':aeps_amount_to,'aeps_commission':aeps_commission,'maxcommission':aeps_maxcommission,'commission_type':aeps_commission_type,'aeps_type':aeps_type},
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
              </div>
              <div class="card-body">
                  <div id="aeps_slab_div">
                  </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>

<!-------------- END aeps commission ---------------------->
<!-------------- END aeps commission ---------------------->
<!-------------- END aeps commission ---------------------->
<!-------------- END aeps commission ---------------------->
<!-------------- END aeps commission ---------------------->





<!-------- payout commission start -------->

        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
          <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">PAYOUT</h6>
                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->
              <div class="card-header">
              <table class="col-10">
                  <tr>
                      <td align="center">
                            <h5>Amount From : </h5>
                            <input type="text" name="txtPayoutAmountFrom" id="txtPayoutAmountFrom" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Amount To : </h5>
                            <input type="text" name="txtPayoutAmountTo" id="txtPayoutAmountTo" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>IMPS Charge : </h5>
                            <input type="text" name="txtPayoutCharge" id="txtPayoutCharge" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>NEFT CHARGE : </h5>
                            <input type="text"  name="txtPayoutNEFTCharge" id="txtPayoutNEFTCharge"  style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Charge Type: </h5>
                            <select name="txtPayoutChargeType" id="txtPayoutChargeType" style="width:80px;">
                              <option value="PER">%</option>
                              <option value="AMOUNT">Amount</option>
                            </select>
                      </td>
                      
                      <td  align="center">
                        <h5>&nbsp;</h5>
                        <input type="button" name="btnPayoutAddSlab" id="btnPayoutAddSlab" value="Add" class="btn btn-success btn-sm" style="width:100px;">
                      </td>
                  </tr>
                </table>
                <input type="hidden" id="hidPayoutslablist" value="<?php echo base_url(); ?>_Admin/Commission_settings/getPayoutSlabList">
                <input type="hidden" id="hidPayoutslabdeleteurl" value="<?php echo base_url(); ?>_Admin/Commission_settings/deletePayoutSlab">
                <input type="hidden" id="hidPayoutslaburl" value="<?php echo base_url(); ?>_Admin/Commission_settings/AddPayoutSlab">
                <script>
                  function getpayoutdata()
                  {
                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                      $.ajax({
                          type:"POST",
                          url:document.getElementById("hidPayoutslablist").value,
                          data:{'group_id':group_id},
                          beforeSend: function() 
                          {
                           //$('#myModalProgress').modal({show:true});
                                    },
                          success: function(response)
                          {
                             
                             
                              document.getElementById("payout_slab_div").innerHTML = response;
                              
                              
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
                          getpayoutdata();             
                       }
                  );
                  function PayoutSlabDeleteConfirmation(id)
                {
                  
                  if(confirm("Are you sure?\nyou want to delete...??") == true)
                  {
                    $.ajax({
                      type:"POST",
                      url:document.getElementById("hidPayoutslabdeleteurl").value,
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
                        getpayoutdata();
                        
                      }
                    });      
                  }
                }
                    
                  </script>
                
                <script language="javascript">
                  $("#btnPayoutAddSlab").click( function()
                  {

                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                  var payout_amount_from = document.getElementById("txtPayoutAmountFrom").value;
                  var payout_amount_to = document.getElementById("txtPayoutAmountTo").value;
                  var payout_charge = document.getElementById("txtPayoutCharge").value;
                  var payout_neftcharge = document.getElementById("txtPayoutNEFTCharge").value;
                  var payout_charge_type = document.getElementById("txtPayoutChargeType").value;
                  
                    $.ajax({
                              type:"POST",
                              url:document.getElementById("hidPayoutslaburl").value,
                              data:{'group_id':group_id,"amount_from":payout_amount_from,'amount_to':payout_amount_to,'payout_charge':payout_charge,'payout_neftcharge':payout_neftcharge,'charge_type':payout_charge_type},
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
                                getpayoutdata();
                              }
                            });      
                });
                
              </script>
              </div>
              <div class="card-body">
                  <div id="payout_slab_div">
                  </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>

<!---------- payout charge end ---------------->




















<!-------- PG commission start -------->

        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
          <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">PAYMENT GETWAY</h6>
                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->
              <div class="card-header">
              <table class="col-10">
                  <tr>
                      <td align="center">
                            <h5>Payment Group : </h5>
                            <select id="ddlpggroup"  name="ddlpggroup">
                                  <option value=""></option>
                                  <option value="upi">UPI</option>
                                  <option value="wallet">Wallet</option>
                                  <option value="debit_card">DEBIT CARD</option>
                                  <option value="credit_card">CREDIT CARD</option>
                                  <option value="prepaid_card">PREPAID CARD</option>
                                  <option value="AMEX">American Express</option>
                                  
                                  <!--<option value="net_banking">NET BANKING</option>
                                  <option value="net_banking">NET BANKING</option>
                                  <option value="net_banking">NET BANKING</option>-->
                            </select>
                      </td>
                      
                      <td  align="center">
                            <h5>Charge : </h5>
                            <input type="text" name="txtPGCharge" id="txtPGCharge" style="width:120px;">
                      </td>
                     
                      <td  align="center">
                            <h5>Charge Type: </h5>
                            <select name="txtPGChargeType" id="txtPGChargeType" style="width:80px;">
                              <option value="PER">%</option>
                              <option value="AMOUNT">Amount</option>
                            </select>
                      </td>
                      
                      <td  align="center">
                        <h5>&nbsp;</h5>
                        <input type="button" name="btnPGAddSlab" id="btnPGAddSlab" value="Add" class="btn btn-success btn-sm" style="width:100px;">
                      </td>
                  </tr>
                </table>
                <input type="hidden" id="hidPGslablist" value="<?php echo base_url(); ?>_Admin/Commission_settings/getPGSlabList">
                <input type="hidden" id="hidPGslabdeleteurl" value="<?php echo base_url(); ?>_Admin/Commission_settings/deletePGSlab">
                <input type="hidden" id="hidPGslaburl" value="<?php echo base_url(); ?>_Admin/Commission_settings/AddPGSlab">
                <script>
                  function getpgdata()
                  {
                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                      $.ajax({
                          type:"POST",
                          url:document.getElementById("hidPGslablist").value,
                          data:{'group_id':group_id},
                          beforeSend: function() 
                          {
                           //$('#myModalProgress').modal({show:true});
                                    },
                          success: function(response)
                          {
                             
                             
                              document.getElementById("pg_slab_div").innerHTML = response;
                              
                              
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
                          getpayoutdata();             
                       }
                  );
                  function PGSlabDeleteConfirmation(id)
                {
                  
                  if(confirm("Are you sure?\nyou want to delete...??") == true)
                  {
                    $.ajax({
                      type:"POST",
                      url:document.getElementById("hidPGslabdeleteurl").value,
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
                        getpgdata();
                        
                      }
                    });      
                  }
                }
                    
                  </script>
                
                <script language="javascript">
                  $("#btnPGAddSlab").click( function()
                  {

                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                  var pg_group = document.getElementById("ddlpggroup").value;
                  var pg_charge = document.getElementById("txtPGCharge").value;
                  var pg_charge_type = document.getElementById("txtPGChargeType").value;
                  
                    $.ajax({
                              type:"POST",
                              url:document.getElementById("hidPGslaburl").value,
                              data:{'group_id':group_id,"pg_group":pg_group,'pg_charge':pg_charge,'charge_type':pg_charge_type},
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
                                getpgdata();
                              }
                            });      
                });
                
              </script>
              </div>
              <div class="card-body">
                  <div id="pg_slab_div">
                  </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>













































<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->
<!-------- indonepal spab commission start -------->

        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
          <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">IndoNepal Commission</h6>
                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->
              <div class="card-header">
              <table class="col-10">
                  <tr>
                      <td align="center">
                            <h5>Amount From : </h5>
                            <input type="text" name="txtINDONEPALAmountFrom" id="txtINDONEPALAmountFrom" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Amount To : </h5>
                            <input type="text" name="txtINDONEPALAmountTo" id="txtINDONEPALAmountTo" style="width:120px;">
                      </td>
                      <td  align="center">
                            <h5>Commission : </h5>
                            <input type="text" name="txtINDONEPALCharge" id="txtINDONEPALCharge" style="width:120px;">
                      </td>
                      
                      <td  align="center">
                            <h5>Commission Type: </h5>
                            <select name="txtINDONEPALChargeType" id="txtINDONEPALChargeType" style="width:80px;">
                              <option value="PER">%</option>
                              <option value="AMOUNT">Amount</option>
                            </select>
                      </td>
                      
                      <td  align="center">
                        <h5>&nbsp;</h5>
                        <input type="button" name="btnINDONEPALAddSlab" id="btnINDONEPALAddSlab" value="Add" class="btn btn-success btn-sm" style="width:100px;">
                      </td>
                  </tr>
                </table>
                <input type="hidden" id="hidINDONEPALslablist" value="<?php echo base_url(); ?>_Admin/Commission_settings/getINDONEPALSlabList">
                <input type="hidden" id="hidINDONEPALslabdeleteurl" value="<?php echo base_url(); ?>_Admin/Commission_settings/deleteINDONEPALSlab">
                <input type="hidden" id="hidINDONEPALslaburl" value="<?php echo base_url(); ?>_Admin/Commission_settings/AddINDONEPALSlab">
                <script>
                  function getINDONEPALdata()
                  {
                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                      $.ajax({
                          type:"POST",
                          url:document.getElementById("hidINDONEPALslablist").value,
                          data:{'group_id':group_id},
                          beforeSend: function() 
                          {
                           //$('#myModalProgress').modal({show:true});
                                    },
                          success: function(response)
                          {
                             
                             
                              document.getElementById("INDONEPAL_slab_div").innerHTML = response;
                              
                              
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
                          getINDONEPALdata();             
                       }
                  );
                  function INDONEPALSlabDeleteConfirmation(id)
                {
                  
                  if(confirm("Are you sure?\nyou want to delete...??") == true)
                  {
                    $.ajax({
                      type:"POST",
                      url:document.getElementById("hidINDONEPALslabdeleteurl").value,
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
                        getINDONEPALdata();
                        
                      }
                    });      
                  }
                }
                    
                  </script>
                
                <script language="javascript">
                  $("#btnINDONEPALAddSlab").click( function()
                  {

                    var group_id = '<?php echo $group_info->row(0)->Id; ?>';
                    var amount_from = document.getElementById("txtINDONEPALAmountFrom").value;
                    var amount_to = document.getElementById("txtINDONEPALAmountTo").value;
                    var commission = document.getElementById("txtINDONEPALCharge").value;
                    var commission_type = document.getElementById("txtINDONEPALChargeType").value;
                  
                    $.ajax({
                              type:"POST",
                              url:document.getElementById("hidINDONEPALslaburl").value,
                              data:{'group_id':group_id,"amount_from":amount_from,'amount_to':amount_to,'commission':commission,'commission_type':commission_type},
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
                                getINDONEPALdata();
                              }
                            });      
                });
                
              </script>
              </div>
              <div class="card-body">
                  <div id="INDONEPAL_slab_div">

                  </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->
<!----- indonepal slab end --------------------------------->






















































<div>
    <input type="hidden" id="hidcompany_ids" value="<?php echo $str_company_id; ?>">
    <center>
        <input type="button" id="btnSubmitAll" name="btnSubmitAll" value="Update All" class="btn btn-primary btn-lg" onClick="changeCommission_all()">
        <img style="width:60px;display:none" id="imgloadingbtn" src="<?php echo base_url()."Loading.gif"; ?>" ></span>
        </center>   
    
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
  //txtCommAmt,txtChargePer,txtChargeAmt
  
  var company_id = id;
  var commission = document.getElementById("txtComm"+id).value;
  var CommissionAmount = document.getElementById("txtCommAmt"+id).value;
  var ChargePer = document.getElementById("txtChargePer"+id).value;
  var ChargeAmount = document.getElementById("txtChargeAmt"+id).value;

  var commission_type = document.getElementById("ddlcommtype"+id).value;
  var commission_slab = document.getElementById("ddlslab"+id).value;
  var group_id ='<?php echo $group_info->row(0)->Id; ?>';
  if(commission <= 5)
  {
    if(company_id > 0)
    {
        
    $.ajax({
          type: "POST",
          url:'<?php echo base_url();?>_Admin/commission_settings/ChangeCommission',
          cache:false,
          data:{'company_id':company_id,'group_id':group_id,'commission':commission,'commission_type':commission_type,'commission_slab':commission_slabm ,'CommissionAmount':CommissionAmount,'ChargePer':ChargePer,'ChargeAmount':ChargeAmount},
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
           params[jcompany_id]= document.getElementById("txtComm"+jcompany_id).value+"@"+document.getElementById("ddlcommtype"+jcompany_id).value+"@"+document.getElementById("ddlslab"+jcompany_id).value+"@"+document.getElementById("txtCommAmt"+jcompany_id).value+"@"+document.getElementById("txtChargePer"+jcompany_id).value+"@"+document.getElementById("txtChargeAmt"+jcompany_id).value;
       }
       
       
       
   }
   $.ajax({
          type: "POST",
          url:'<?php echo base_url();?>_Admin/commission_settings/ChangeCommission',
          cache:false,
          data:{'params':params,'group_id':'<?php echo $group_info->row(0)->Id; ?>'},
          beforeSend: function() 
      {
        document.getElementById("imgloadingbtn").style.display="block";
            //$('#myModal').modal({show:true});
          },
          success: function(html)
          {
            console.log( html );
          },
          complete:function()
        {
        document.getElementById("imgloadingbtn").style.display="none";
        //$('#myModal').modal('hide');
        //$('#myModal').hide();
        }
        });
  
  

  
   
    
        
    
    
    
  
  
}
</script>
    
</div>

      </div><!-- br-pagebody -->
      
      
      <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header">
             <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
              <h4 class="modal-title" id="modaltitle">Please wait we process your data.</h4>

            </div>
            <div class="modal-body">
            <span id="spanloader">
              <img style="width:120px" id="imgloading" src="<?php echo base_url()."Loading.gif"; ?>"></span>
              <span id="responsespan" class="alert alert-primary"  style="font-weight: bold;display:none"></span>
            </div>
            <div class="modal-footer">
             <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
            </div>
            </div>
          </div>
        </div>  
      
      
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
