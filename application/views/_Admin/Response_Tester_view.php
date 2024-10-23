<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Response Tester</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
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
          <a class="breadcrumb-item" href="#"></a>
          <span class="breadcrumb-item active">Response Tester</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Response Tester</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-6">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form action="<?php echo base_url()."_Admin/Response_Tester" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table class="table table-borderless">
                                    <tr>
                                        <td style="width:200px;">Select API</td>
                                        <td style="padding-right:10px;">
                                            <select id="ddlapi" name="ddlapi" class="form-control" >
                                                <option value="0"></option>
                                                <?php echo $this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto(1,2,3) ;?>
                                            </select>  
                                            <script language="javascript">document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';</script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:200px;">Enter Api Response</td>
                                    	<td style="padding-right:10px;">
                                        	 
                                            <textarea id="txtResponse" name="txtResponse" col="10" rows="10" class="form-control"><?php echo $response; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:200px;"></td>
									    <td>
                                            <input type="submit" id="btnSubmit" name="btnSearch" value="Submit" class="btn btn-primary">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-6 -->
          <div class="col-sm-6 col-lg-6">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <div id="ajaxdata">
                      
                      <?php
                      if($status != '')
                      {
                          if($status == "Success")
                          {
                              echo '<div class="alert success">
                                      <span class="closebtn">&times;</span>  
                                      <strong>Recharge Success With Operator Id : '.$operator_id.'</strong>
                                    </div>';
                          }
                          if($status == "Failure")
                          {
                              echo '<div class="alert danger">
                                      <span class="closebtn">&times;</span>  
                                      <strong>Recharge Failure With Operator Id : '.$operator_id.'</strong>
                                    </div>';
                          }
                          if($status == "Pending")
                          {
                              echo '<div class="alert info">
                                      <span class="closebtn">&times;</span>  
                                      <strong>Recharge In Pendign Process</strong>
                                    </div>';
                          }
                      }
                      ?>
                      
                  </div>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-6 -->
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
