<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>PAYMENT REQUEST REPORT</title>

    
     
    
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
          <a class="breadcrumb-item" href="#">PAYMENT REQUEST</a>
          <span class="breadcrumb-item active">PAYMENT REQUEST HISTORY </span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">PAYMENT REQUEST REPORT</h4>
                        
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                 <button class="btn btn-success btn-sm" type="button">Approved : <?php echo $summary_array["Success"]; ?></button>
                                </div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <button class="btn btn-warning btn-sm" type="button">Pending : <?php echo $summary_array["Pending"];  ?></button>
                                  </div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <button class="btn btn-danger btn-sm" type="button">Rejected : <?php echo $summary_array["Failure"];  ?></button>
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
                 <form action="<?php echo base_url()."_Admin/payment_history?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">
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
                        <option value="Approve">APPROVED</option>
                        <option value="Pending">PENDING</option>
                        <option value="Reject">REJECTED</option>
                       
                    </select>
                </td>
               <td >
                                             <label>Wallet Type :</label>
                                           <select id="ddlWallet" name="ddlWallet" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <option value="Wallet1">Wallet1</option>
                                            <option value="Wallet2">Wallet2</option>
                                           
                                            
                                           </select>
                                           
                                        </td>
                                         <td >
                                             <label>Payment Mode :</label>
                                           <select id="ddlMode" name="ddlMode" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <option value="CASH">CASH</option>
                                            <option value="IMPS">IMPS</option>
                                            <option value="RTGS">RTGS</option>
                                            <option value="NEFT">NEFT</option>
                                            <option value="CDM DEPOSIT">DEPOSIT</option>
                                           
                                            
                                           </select>
                                           
                                        </td>
                </tr>
                <tr>
                <td>
                    <label>Agent Number :</label>
                    <input type="text" name="txtAgentNumber" id="txtAgentNumber" class="form-control-sm" value="<?php echo $txtAgentNumber; ?>"  maxlength="10" />
                </td>
                
                
              
              
                 <td>
                    <label>Amount :</label>
                    <input type="text" name="txtAmount" id="txtAmount" class="form-control-sm" value="<?php echo $txtAmount; ?>"  maxlength="10" />
                </td>
                 <td>
                    <label>Remark :</label>
                    <input type="text" name="txtRemark" id="txtRemark" class="form-control-sm" value="<?php echo $txtRemark; ?>"   />
                </td>
                     
                    <td > <label>Agent Type :</label>
                                           <select id="ddlAgent_type" name="ddlAgent_type" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <option value="MasterDealer">MasterDealer</option>
                                            <option value="Distributor">Distributor</option>
                                            <option value="Agent">Retailer</option>
                                          
                                            
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
                            <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/payment_history/dataexport" ?>" method="get">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">PAYMENT REQUEST REPORT</h6>
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
                   
                    <th>Bank</th>
                    <th>AgentName</th>
                    <th>AgentType</th>
                    <th>Wallet Type</th>  
                    <th>Payment Mode</th>  
                    <th>Ref.Id</th>
                    <th>Amount</th>
                    <th>Remark</th>
                    <th>Status</th>     
                    <th>Admin Remark</th>
                    
                    
                  
                </tr>
              </thead>
              <tbody>
             <?php 
  if($result_mdealer->num_rows() > 0){
   
    $i = 0;foreach($result_mdealer->result() as $result)  {
  
    ?>
             <td ><?php echo $result->Id; ?></td>
  <td>
              <?php echo date_format(date_create($result->add_date),'d-m-Y'); ?>
              <br>
              <?php echo date_format(date_create($result->add_date),'H:i:s'); ?>
                
              </td>
            


             <td>
              <?php echo $result->bank_name; ?><br>   
              </td>
               <td>
              <?php echo $result->username; ?><br>
              <?php echo $result->businessname; ?><br>   

              </td>
              <td>
              <?php echo $result->usertype_name; ?><br>   
              </td>
             <td><?php echo $result->wallet_type; ?></td>
             <td><?php echo $result->payment_type; ?></td>
             
             <td ><?php echo $result->transaction_id; ?><br></td>
             <td>
              <?php echo $result->amount; ?>
              <td> <?php echo $result->client_remark; ?></td>
         
       </td>
              <td>
                  <?php 
                    if($result->status == "Approve")
                    {
                      echo "<div class='btn btn-success btn-sm'>".$result->status."</div>"; 
                    }
                    else if($result->status == "Reject")
                    {
                      echo "<div class='btn btn-danger btn-sm'>".$result->status."</div>"; 
                    }
                    else if($result->status == "Pending")
                    {
                      echo "<div class='btn btn-warning btn-sm'>".$result->status."</div>"; 
                    }
                    else
                    {
                      echo "<div class=''>".$result->status."</div>";  
                    }
                  ?>
              </td>
             <td><?php echo $result->admin_remark; ?></td>

  </tr>

  
        <?php   
    $i++;}  ?>
      <?php } else{?>
        <tr>
       <td colspan="12">
       <center><div class='message'> No Records Found</div></center>
       </td>
       </tr>
      <?php } ?>
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
