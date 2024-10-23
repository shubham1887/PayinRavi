<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>ER ACCOUNT REPORT</title>

    
     
    
    <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
        
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
    
});
    

    function startexoprt()
{
        $('.DialogMask').show();
        
        var from = document.getElementById("txtFrom").value;
        var to = document.getElementById("txtTo").value;
        var db = document.getElementById("ddldb").value;
        document.getElementById("hidfrm").value = from;
        document.getElementById("hidto").value = to;
        document.getElementById("hiddb").value = db;
        
        document.getElementById("frmexport").submit();
    $('.DialogMask').hide();
}
</script>


         <style>
          .success
{
  color: green;
  font-weight: bold;
  font-family: sans-serif;
}
.danger
{
  color: red;
  font-weight: bold;
  font-family: sans-serif;
}
.pending
{
  color: blue;
  font-weight: bold;
  font-family: sans-serif;
}
        </style>

  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>

<input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getERlogs"; ?>">
    <input type="hidden" id="hidgetuserdataurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
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
          <span class="breadcrumb-item active">ER ACCOUNT REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">ER ACCOUNT REPORT</h4>
        </div>
        <div class="col-sm-6 col-lg-9">
            <span class="btn btn-primary">UPI : <?php echo $summary["UPI"]; ?></span>    
            <span class="btn btn-primary">WALLET : <?php echo $summary["WALLET"]; ?></span>    
            <span class="btn btn-primary">DEBIT CARD : <?php echo $summary["DEBIT_CARD"]; ?></span>    
            <span class="btn btn-primary">CREDIT CARD : <?php echo $summary["CREDIT_CARD"]; ?></span>    
            <span class="btn btn-primary">NET BANKING : <?php echo $summary["NET_BANKING"]; ?></span>    
            <span class="btn btn-success">TOTAL : <?php echo $summary["TOTAL"]; ?></span>    
        </div>

      </div><!-- d-flex -->

  <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <form action="<?php echo base_url();?>_Admin/CashFree_report?crypt=<?php echo $this->Common_methods->encrypt('MyData'); ?>" method="post" name="frmReport" id="frmReport">
            <table class="table">
            <tr>
                <td>
                    <h5>From Date :</h5>
                    <input type="text" readonly name="txtFrom" id="txtFrom" value="<?php echo $from; ?>" class="form-control-sm" title="Select From Date." maxlength="10"  style="cursor: pointer"/>
                </td>
                <td>
                    <h5>To Date :</h5>
                    <input type="text" readonly name="txtTo" id="txtTo" class="form-control-sm" value="<?php echo $to; ?>" title="Select From To." maxlength="10" style="cursor: pointer"/ />
                </td>
                <td>
                    <h5>Payment Group:</h5>
                    <select id="ddlmode" name="ddlmode" class="form-control-sm" style="width:120px;" >
                        <option value="ALL">ALL</option>
                        <option value="upi">UPI</option>
                        <option value="wallet">Wallet</option>
                        <option value="debit_card">DEBIT CARD</option>
                        <option value="credit_card">CREDIT CARD</option>
                        <option value="net_banking">NET BANKING</option>
                    </select>
                    <script type="text/javascript">
                      document.getElementById("ddlmode").value = '<?php echo $ddlmode; ?>';
                    </script>
                </td>
                <td>
                    <h5>User Number :</h5>
                    <input type="text" name="txtRemitter" id="txtRemitter" class="form-control-sm" value="<?php echo ''; ?>"  maxlength="10" />
                </td>
                <td >
                    <h5>&nbsp;</h5>
                    <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success btn-sm" title="Click to search." />
                    <input type="button" name="btnExport" id="btnExport" value="Export" class="btn btn-primary btn-sm" onClick="startexoprt()"  />    
                     
                </td>
                </tr>
                
            </table>
    
                            </form>
                            <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/Account_report2/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
          <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">ER ACCOUNT REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
               <div class="table-responsive">
  
  
    <div id="all_transaction">
 <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
                    <th>ID</th>
                    <th>DateTime</th>
                    <th>AgentName</th>
                    <th>OrderId</th>
                    <th>CF_Id</th>
                    <th>PaymentStatus</th>
                    <th>Amount</th>
                    <th>BankRef</th>
                    <th>Message</th>
                    <th>Mode</th>
                </tr>
              </thead>
              <tbody>
               <?php 
      $i = 0;
      foreach($result_mdealer->result() as $result)
      {
      ?>   
        <td><?php echo $result->Id; ?></td>
        <td><?php echo $result->add_date; ?></td>
        <td><?php echo $result->businessname; ?></td>
        <td><?php echo $result->order_id; ?></td>
        <td><?php echo $result->cf_payment_id; ?></td>
        <td><?php echo $result->payment_status; ?></td>
        <td><?php echo $result->payment_amount; ?></td>
        <td><?php echo $result->bank_reference; ?></td>
        <td><?php echo $result->payment_message; ?></td>
        <td><?php echo $result->payment_group; ?></td>
  </tr>

  
       <?php   
    $i++;} ?>
    
              </tbody>
            </table>
  
        </div>
        
                           </div>
                                <?php  echo $pagination; ?>     
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
