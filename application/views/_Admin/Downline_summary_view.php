<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Downline summary</title>

    
     
    
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
    document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
    document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
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

<input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getdmtlogs"; ?>">
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
          <span class="breadcrumb-item active">Downline summary</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">Downline summary</h4>
                        
                    </div>
                    <div class="col-sm-6 col-lg-9">
            
        
            <span class="breadcrumb-item">
            <button class="btn btn-outline btn-sm" type="button" style="font-size:14px;">DEBIT :<?php echo $summary_array["totaldebit"]; ?></button>
            </span>
            <span class="breadcrumb-item">
            <button class="btn btn-outline btn-sm" type="button" style="font-size:14px;">CRADIT :<?php echo $summary_array["totalcredit"];?></button>
            </span>
            <span class="breadcrumb-item">
            <button class="btn btn-outline btn-sm" type="button" style="font-size:14px;">COMMISION :<?php echo $summary_array["totalcommission"];?></button>
            </span>
            <span class="breadcrumb-item active">
            <button class="btn btn-success btn-sm" type="button" style="font-size:14px;">PAYMENT: <?php echo $summary_array["totalpayment"];  ?></button>
            </span>
         
         
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
                 <form action="<?php echo base_url()."_Admin/Downline_summary?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">
            <table class="table">
            <tr>
                <td>
                    <label>From Date :</label>
                    <input type="text" readonly name="txtFrom" id="txtFrom" value="<?php echo $from_date; ?>" class="form-control-sm" title="Select From Date." maxlength="10"  style="cursor: pointer"/>
                </td>
                <td>
                    <label>To Date :</label>
                    <input type="text" readonly name="txtTo" id="txtTo" class="form-control-sm" value="<?php echo $to_date; ?>" title="Select From To." maxlength="10" style="cursor: pointer"/ />
                </td>
                <td>
                    <label>Tran. Type :</label>
                    <select id="ddlstatus" name="ddlstatus" class="form-control-sm" >
                        <option value="ALL">ALL</option>
                        <option value="PAYMENT">PAYMENT</option>
                        <option value="CRADIT">CRADIT</option>
                        <option value="DEBIT ">DEBIT</option>
                      
                       
                    </select>
                </td>
                </tr>
                <tr>
                <td>
                    <label>User Number :</label>
                    <input type="text" name="txtRemitter" id="txtRemitter" class="form-control-sm" value="<?php echo $txtRemitter; ?>"  maxlength="10" />
                </td>
                
                
                 <td>
                     <label>Tran. Type :</label>
                    <select id="ddlremark" name="ddlremark" class="form-control-sm" >
                        <option value="ALL">ALL</option>
                        <option value="Commission">COMMISSION</option>
                       
                       
                       
                    </select>
                </td>

                
                <td>
                    <label>Data :</label>
                    <select id="ddldb" name="ddldb" class="form-control-sm" >
                        <option value="LIVE">LIVE</option>
                        <option value="ARCHIVE">ARCHIVE</option>
                    </select>
                </td>
                </tr>
                <tr>
                <td colspan="4">
                    <label></label>
                  <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success btn-sm" title="Click to search." />
                      <input type="button" name="btnExport" id="btnExport" value="Export" class="btn btn-primary btn-sm" onClick="startexoprt()"  />    
                     
                </td>
                <td style="padding-top:30px;">
                    <label></label>
                
                    
                </td>
                <td >
                    <label></label>

                    
                    
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Downline summary</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
               <div class="table-responsive">
  
  
    <div id="all_transaction">
 <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
                    <th style="display: none;"></th>
                   
                   <th>ID</th>
                    <th>bank</th>
                    <th>timestamp</th>
                  
                    <th>User</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>payment Remak</th>
                    <th>OPENDING</th>        
                    
                    <th>CR.AMOUNT</th>        
                    <th>CHARGE</th>        
                        
                    <th>DR.AMOUNT</th>        
                    <th>CLOSING</th> 
                    
                  
                </tr>
              </thead>
              <tbody>
               <?php 
      $i = 0;
      foreach($result_mdealer->result() as $result)
      {
        
      ?>   
 <td><?php echo $result->payment_id; ?></td>
       <td></td>        

 <td><?php echo $result->add_date; ?></td>

  <td><?php echo "<span id='db_date".$i."'>".$result->businessname."<br>[".$result->mobile_no."]"."</span>"; ?></td>
 <td ><?php echo ($result->usertype_name); ?></td>
   
  <td ><?php echo "<span id='db_date".$i."'>".$result->transaction_type."</span><br>";
   if ($result->payment_type == "Commission") {
     echo"<span>COMMISSION</span>"; } ?></td>
 <td ><?php echo ($result->description); ?></td>
 
 <td ><?php if ($result->opening != "0") {echo round($result->opening,2); } else{echo "";}?></td>
 <td ><?php if ($result->credit_amount != "0") {echo round($result->credit_amount,2); } else{echo "";}?></td>
 <td ><?php if ($result->remark == "Transaction Charge"){ if ($result->debit_amount != "0") {echo round($result->debit_amount,2); } else{echo "";}}
    elseif ($result->remark == "Transaction Charge R"){ if ($result->credit_amount != "0") {echo round($result->credit_amount,2); } else{echo "";}}?></td>
 
  <td ><?php 
   
    if ($result->debit_amount != "0") {echo round($result->debit_amount,2); }
     else{echo "";}


 ?></td> 
  <td><?php if ($result->balance != "0") {echo round($result->balance,2);} else{echo "";} ?></td>
  </tr>

 
       <?php   
    }$i++; ?>
    <tr class="table table-bordered table-striped" style="color:#00000E,border-style: solid;">
    <td colspan="6" ><center></center></td>
    <td  ><center>Payment : <?php echo $summary_array["PAYMENT"];?></center></td>
    <td><center>Cr: <?php echo $summary_array["totalcredit"];?></center></td>
    <td><center>Dr: <?php echo $summary_array["totaldebit"];?></center></td>
    <td><center></center></td>

        </tr>
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
