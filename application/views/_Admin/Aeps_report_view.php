<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>AEPS REPORT</title>

    
     
    
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
          <span class="breadcrumb-item active">AEPS REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">AEPS REPORT</h4>
                        
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                 <button class="btn btn-success btn-sm" type="button">Success : <?php echo $summary_array["Success"]; ?></button>
                                </div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <button class="btn btn-warning btn-sm" type="button">Pending : <?php echo $summary_array["Pending"];  ?></button>
                                  </div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <button class="btn btn-danger btn-sm" type="button">Failure : <?php echo $summary_array["Failure"];  ?></button>
                                  </div>
                                
                            </div>

                            
                        </div>
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
                 <form action="<?php echo base_url()."_Admin/Aeps_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">
            <table class="table">
            <tr>
                <td>
                    <label>From Date :</label>
                    <input type="text" readonly name="txtFrom" id="txtFrom" value="<?php echo $from; ?>" class="form-control-sm" title="Select From Date." maxlength="10"  style="cursor: pointer"/>
                </td>
                <td>
                    <label>To Date :</label>
                    <input type="text" readonly name="txtTo" id="txtTo" class="form-control-sm" value="<?php echo $to; ?>" title="Select From To." maxlength="10" style="cursor: pointer"/ />
                </td>
                <td>
                    <label>Status :</label>
                    <select id="ddlstatus" name="ddlstatus" class="form-control-sm" >
                        <option value="ALL">ALL</option>
                        <option value="SUCCESS">SUCCESS</option>
                        <option value="PENDING">PENDING</option>
                        <option value="FAILED">FAILED</option>
                       
                    </select>
                </td>
               <td >
                                             <label>Operator :</label>
                                           <select id="ddloperator" name="ddloperator" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <option value="WAP">Withdrawal</option>
                                            <option value="BAP">Balance Check</option>
                                            <option value="MIS">Statement</option>
                                            
                                           </select>
                                           
                                        </td>
                </tr>
                <tr>
                <td>
                    <label>Remitter :</label>
                    <input type="text" name="txtRemitter" id="txtRemitter" class="form-control-sm" value="<?php echo $txtRemitter; ?>"  maxlength="10" />
                </td>
                
                 <td>
                    <label>Aaadhar No :</label>
                    <input type="text" name="txtcustomer_params" id="txtcustomer_params" class="form-control-sm" value="<?php echo $txtcustomer_params; ?>"  maxlength="12" />
                </td>
                 <td>
                    <label>Amount :</label>
                    <input type="text" name="txtAmount" id="txtAmount" class="form-control-sm" value="<?php echo $txtAmount; ?>"  maxlength="5" />
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
                            <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/Aeps_report/dataexport" ?>" method="get">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">AEPS REPORT</h6>
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
                    
                    <th>DateTime</th>
                   
                    <th>DealerName</th>
                    <th>AgentName</th>
                    <th>Remitter</th> 
                    <th>Aadhar No.</th>
                    <th>Oprator</th>     
                    <th>Remitter Balance</th>
                    <th>Amount</th>
                    <th>Response</th>        
                    <th>Response id</th>        
                    <th>Status</th> 
                    
                  
                </tr>
              </thead>
              <tbody>
               <?php   
            foreach($result_all->result() as $result)   
            {

        ?>
            
 <td style="display: none;"><input class="form-control checkBoxrecharge" style="width: 15px;" type="checkbox" id="chkdmr<?php echo $result->Id;  ?>" name="chkdmr[]" value="<?php echo $result->Id; ?>"> </td>
 
<td >
    <a href="javascript:void(0)" onClick="tetingalert('<?php echo $result->Id; ?>')">
         <?php echo $result->Id;?>
    </a>


 </td> 
 
  <td><?php echo "<span id='db_ssid".$i."'>".$result->add_date."</span>"; ?></td>
 
 <td><?php echo "<span id='db_date".$i."'>".$result->dist_businessname."<br>[".$result->dist_mobile_no."]"."</span>"; ?></td>

  <td><?php echo "<span id='db_date".$i."'>".$result->businessname."<br>[".$result->mobile_no."]"."</span>"; ?></td>

  
  

   <td><?php echo "<span id='db_date".$i."'>".$result->outlet_mobile."</span>"; ?></td>

   <td><?php echo "<span id='db_date".$i."'>".$result->customer_params."</span>"; ?></td>
    <td>
 
  <?php if($result->sp_key == "WAP"){echo "<span>Cash Withdrawal</span>";} ?>
  <?php if($result->sp_key == "BAP"){echo "<span>Balance Enquiry</span>";} ?>
  <?php if($result->sp_key == "SAP"){echo "<span>Mini Statement</span>";} ?>

 </td>
   <td><?php echo "<span id='db_date".$i."'>".$result->balance."</span>"; ?></td>
   <td><?php echo "<span id='db_date".$i."'>".$result->amount."</span>"; ?></td>
  
 
 <td><?php echo $result->response_code."<br>".$result->response_msg; ?></td>
   <td><?php echo "<span id='db_date".$i."'>".$result->request_id."</span>"; ?></td>

 <td>
 
  <?php if($result->cb_status == "SUCCESS"){echo "<span class='btn btn-success btn-sm'>".$result->cb_status."</span>";} ?>
  <?php if($result->cb_status == "FAILED"){echo "<span class='btn btn-danger btn-sm'>".$result->cb_status."</span>";} ?>
 </td>

 

  
  
  
  
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
