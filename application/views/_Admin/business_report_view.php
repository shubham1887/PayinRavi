<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Business Report</title>

    
     
    
    <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
   <script>
        
$(document).ready(function(){
    
    
    document.getElementById("ddlpaymenttype").value = '<?php echo $ddlpaymenttype; ?>';
    document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
    
 $(function() {
            $( "#txtFromDate" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
    

    function startexoprt()
{
        $('.DialogMask').show();
        
        var from = document.getElementById("txtFromDate").value;
        var to = document.getElementById("txtToDate").value;
        var db = document.getElementById("ddldb").value;
        document.getElementById("hidfrm").value = from;
        document.getElementById("hidto").value = to;
        document.getElementById("hiddb").value = db;
        document.getElementById("frmexport").submit();
    $('.DialogMask').hide();
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">ACCOUNT REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>ACCOUNT REPORT</h4>
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
                <form action="<?php echo base_url()."_Admin/business_report?crypt=".$this->Common_methods->encrypt("myData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                           <h5>From Date</h5>
                                            <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;cursor:pointer" readonly >
                                        </td>
                                      <td style="padding-right:10px;">
                                           <h5>To Date</h5>
                                            <input class="form-control-sm" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:120px;cursor:pointer" readonly >
                                        </td>
                                        <td style="padding-right:10px;">
                                         <h5>Select User</h5>
                                        <select id="ddlusertype" name="ddlusertype" class="form-control-sm" style="width:120px;">
                                            <option value="Agent">Agent</option>
                                            <option value="Distributor">Distributor</option>
                                            <option value="MasterDealer">MasterDealer</option>
                                            <option value="APIUSER">APIUSER</option>
                                        </select>
                                        </td>
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary">
                                        <input type="button" class="btn btn-success" value="Export" onClick="startexoprttwo()">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">ACCOUNT REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
               <?php

              


                if($result_recharge != false) {?>
       <table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
            <tr>  
            <th>Username</th>
            <th>Business Name</th>
           <!-- <th>Parent Name</th>-->
        
             
              <th  >Total Recharge</th>
               <th  >Total Commission</th>
              
             
            </tr>
            <?php
        
        
        $tTotalRecharge = 0;
     $tTotalcommission = 0;
        $tcommission_amount = 0;
        
             $i=0; foreach($result_recharge->result() as $result)   
            {
            $commission = 0;
      $totalrec = 0;
            $user_id = $result->user_id;
      if(isset($rechargearray[$result->user_id]["totalrecharge"]))
      {
        $totalrec = round($rechargearray[$result->user_id]["totalrecharge"],5); 
      }
      if(isset($rechargearray[$result->user_id]["totalcommission"]))
      {
        $commission = round($rechargearray[$result->user_id]["totalcommission"],5); 
      }
      
             ?>
                    <tr id="tr<?php echo $i; ?>" >
                    <td><?php echo $result->username; ?></td>
        
          <td><?php echo $result->businessname; ?></td>
         <!--  <td><?php echo ""; ?></td>-->
        
         
         <td><?php echo round($totalrec,5); ?></td> 
         <td><?php echo round($commission,5); ?></td> 
          
         </tr>
                <?php
                
                
        $tTotalRecharge += round($totalrec,5);
        $tTotalcommission += round($commission,5);
                    
                $i++;} ?>
               
                <tr style="background-color:#FED9AF">
                   <td><b>Total</b></td>
        
          <td></td>
        <!--<td></td>-->
        
         <td ><b><?php echo $tTotalRecharge; ?></b></td> 
         <td ><b><?php echo $tTotalcommission; ?></b></td> 
         
         
         
                </tr>
              
                </table>
        <?php } ?> 
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
      <script language="javascript">
    function changestatus(val1,id)
    {
        
                $.ajax({
                url:'<?php echo base_url()."_Admin/account_report/setvalues?"; ?>Id='+id+'&field=payment_type&val='+val1,
                cache:false,
                method:'POST',
                success:function(html)
                {
                    if(html == "cash")
                    {
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'credit\',\''+id+'\')">'+html+'</a>     ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    else
                    {
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'cash\',\''+id+'\')">'+html+'</a>   ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    
                }
                }); 
            
        
    }
</script>
<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/account_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
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
