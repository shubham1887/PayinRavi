<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Admin Banks</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
	
	
	
 $(function() {
            $( "#txtFromDate" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	


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
          <span class="breadcrumb-item active">Admin Banks</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        
        <div class="col-sm-6 col-lg-5">
          <h4>Admin Banks</h4>
        </div>
        
        <div class="col-sm-6 col-lg-7">
            
            
            
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>

                <!--- strat --->
                <div style="float:right">

                <a href="#modal-form" role="button" class="blue btn btn-primary" data-toggle="modal" onClick="addform()"> <i class="ace-icon fa fa-plus bigger-120"></i>Add New Bank </a>
                <script language="javascript">
                  function addform()
                  {
                    document.getElementById("HIDACTION").value = "INSERT";
                  }
                </script>
              </div>
                <!---- end--->




              </div><!-- card-header -->
              <div class="card-body">
                  <div class="table-responsive">
                                    <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
                      <thead>
                        <tr>
                          
                          <th class="detail-col">Sr.</th>
                          <th>Account Name</th><th>Bank Name</th><th>Account Number</th><th>IFSC</th><th>Branch</th><th>DateTime</th>
                          <th></th>
                        </tr>
                      </thead>

                      <tbody><?php $i=1;foreach($data->result() as $row)
                    { ?><tr>
                          <td><a href="#"><?php echo $i; ?></a></td>
                          <td>
                              <?php echo $row->account_name; ?>
                              <input type="hidden" id="hidaccount_name<?php echo $row->Id; ?>" value="<?php echo $row->account_name; ?>">
                          </td>
                          <td><?php echo $row->bank_name; ?>
                            <input type="hidden" id="hidbank_id<?php echo $row->Id; ?>" value="<?php echo $row->bank_id; ?>">
                          </td>
                          
                          
                          <td><?php echo $row->account_number; ?>
                            <input type="hidden" id="hidaccount_number<?php echo $row->Id; ?>" value="<?php echo $row->account_number; ?>">
                          </td>
                          
                          <td><?php echo $row->ifsc; ?>
                            <input type="hidden" id="hidifsc<?php echo $row->Id; ?>" value="<?php echo $row->ifsc; ?>">
                          </td>
                          
                          <td><?php echo $row->branch; ?>
                            <input type="hidden" id="hidbranch<?php echo $row->Id; ?>" value="<?php echo $row->branch; ?>">
                          </td>
                          
                          
                          
                          <td class="hidden-480"><?php echo $row->add_date; ?></td>
                          
                          <td>
                            <div class="hidden-sm hidden-xs btn-group">
                              <button class="btn btn-xs btn-success">
                                <i class="ace-icon fa fa-check bigger-120"></i>                             </button>

                              <button class="btn btn-xs btn-info" onClick="editform(<?php echo $row->Id; ?>)" href="#modal-form" data-toggle="modal">
                                <i class="ace-icon fa fa-pencil bigger-120"></i>Edit                              </button>
                                <script language="javascript">
                                function editform(id)
                                {
                                    
                                  document.getElementById("hidPrimaryId").value =  id;
                                  document.getElementById("HIDACTION").value =  "UPDATE";
                                  
                                  document.getElementById("account_name").value =  document.getElementById("hidaccount_name"+id).value;
                                  document.getElementById("ddlbank").value =  document.getElementById("hidbank_id"+id).value;
                                  document.getElementById("account_number").value =  document.getElementById("hidaccount_number"+id).value;
                                  document.getElementById("ifsc").value =  document.getElementById("hidifsc"+id).value;
                                  document.getElementById("branch").value =  document.getElementById("hidbranch"+id).value;
                                }
                                </script>

                              <button class="btn btn-xs btn-danger" onClick="deletitem(<?php echo $row->Id; ?>)" href="#modal-formdelete" data-toggle="modal">
                                <i class="ace-icon fa fa-trash-o bigger-120"></i>Delete                             </button>
                                <script language="javascript">
                                function deletitem(id)
                                {
                                  document.getElementById("hidPrimaryId").value =  id;
                                  document.getElementById("HIDACTION").value =  "DELETE";
                                }
                                </script>

                              <button class="btn btn-xs btn-warning">
                                <i class="ace-icon fa fa-flag bigger-120"></i>                              </button>
                            </div>
                          </td>
                        </tr><?php $i++;} ?>

                        

                      </tbody>
                    </table>
                                </div>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      </div><!-- br-pagebody -->
      


















<!-------------------------------------- INSERT EDIT MODEL START ----------------------->               
                <div id="modal-form" class="modal" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">Please fill the following form fields</h4>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                          
                          <div class="col-xs-12 col-sm-7">
                          <form id="frmPopup" method="post" action="">
                          <input type="hidden" id="hidPrimaryId" name="hidPrimaryId">
                          
                                <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
                                <div class="form-group">
                                <label for="form-field-select-3" style="color:#000000"><b>Bank Name</b></label>
                                <div>
                                  <select name="ddlbank" id="ddlbank" class="form-control"  style="color:#000">
                                  <option value="0">Select</option>
                                  <?php 
                                  $bankresult  = $this->db->query("select bank_name,bank_id from tblbank order by bank_name");
                                  foreach($bankresult->result() as $bank)
                                  {
                                  ?>
                                  <option value="<?php echo $bank->bank_id; ?>"><?php echo $bank->bank_name; ?></option>
                                  <?php } ?>
                                </select>
                                </div>
                              </div>
                              <div class="space-4"></div>
                              
                              <div class="form-group">
                                <label for="form-field-select-3" style="color:#000000"><b>Account Holder Name</b></label>
                                <div>
                                  <input type="text" name="account_name" id="account_name" class="form-control" style="color:#000">
                                </div>
                              </div>
                              <div class="space-4"></div>
                              
                              
                              <div class="form-group">
                                <label for="form-field-select-3" style="color:#000000"><b>Account Number</b></label>
                                <div>
                                  <input type="text" name="account_number" id="account_number" class="form-control" style="color:#000">
                                </div>
                              </div>
                              <div class="space-4"></div>
                              
                              <div class="form-group">
                                <label for="form-field-select-3" style="color:#000000"><b>IFSC</b></label>
                                <div>
                                  <input type="text" name="ifsc" id="ifsc" class="form-control" style="color:#000">
                                </div>
                              </div>
                              <div class="space-4"></div>
                              
                              <div class="form-group">
                                <label for="form-field-select-3" style="color:#000000"><b>Branch</b></label>
                                <div>
                                  <input type="text" name="branch" id="branch" class="form-control" style="color:#000">
                                </div>
                              </div>
                              <div class="space-4"></div>
                              
                              
                            </form>
                          </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal">
                          <i class="ace-icon fa fa-times"></i>
                          Cancel
                        </button>

                        <button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="validateandsubmit()">
                          <i class="ace-icon fa fa-check"></i>
                          Save
                        </button>
                        <script language="javascript">
                        function validateandsubmit()
                        {
                          document.getElementById("frmPopup").submit();
                        }
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------> 


<!-------------------------------------- DELETE MODEL START ----------------------->                
                <div id="modal-formdelete" class="modal" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">Are You Soure Want To Delete <span id="spanDeletePopupName"></span></h4>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal">
                          <i class="ace-icon fa fa-times"></i>
                          Cancel
                        </button>

                        <button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="deletesubmit()">
                          <i class="ace-icon fa fa-check"></i>
                          Yes
                        </button>
                        <script language="javascript">
                          function deletesubmit()
                          {
                            document.getElementById("HIDACTION").value="DELETE";
                            document.getElementById("frmPopup").submit();
                          }
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------>   





















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
