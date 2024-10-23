<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterDealer::ACCOUNT REPORT</title>
      <?php include("files/links.php"); ?>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
     <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	

	
	</script>

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
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SEARCH RECHARGE
                            
                        </div>

                        <div class="panel-body">
                           <form action="<?php echo base_url()."MasterDealer/bill_home"; ?>" method="post" name="frmRecharge" id="frmRecharge" autocomplete="off">
    <input type="hidden" name="hidSubmitRecharge" id="hidSubmitRecharge" value="Success" />    
    
    <table class="table">
    <tr>
    <td  width="600px">
    <table border="0" cellspacing="3" cellpadding="3">
    <tr>
    <td align="right">BILL PAYMENT:</td>
    <td>
   
    </td>
    </tr>
    <tr>
    <td align="right"><label for="ddlCircleName">BILLER NAME:</label></td>
    <td>
    <select id="ddlbiller" tabindex="1" placeholder="Select Biller Name"  name="ddlbiller" class="form-control">
    <option>--Select--</option>
    <optgroup label="Electricity">
    	<option value="DGVCL">DGVCL</option>
    <option value="MGVCL">MGVCL</option>
    </optgroup>
    
    <optgroup label="Gas">
    	<option value="ADANIGAS">Adani Gas Limited</option>
    <option value="GSPC">GSPC</option>
    <option value="GUJARATGAS">Gujarat Gas</option>
    <option value="MAHANAGARGAS">Mahanagar Gas</option>
    </optgroup>
    <optgroup label="Landline">
    	<option value="AIRTEL_LANDLINE">Airtel Landline</option>
    <option value="MTNL">MTNL Delhi</option>
    <option value="RELIANCE">RELIANCE</option>
    <option value="DOCOMOCDMA">Tata Docomo CDMA</option>
    </optgroup>
    <optgroup label="Postpaid">
    <option value="Postpaid_BSNL">BSNL</option>
    <option value="Postpaid_AIRCEL">Aircel</option>
    <option value="Postpaid_DOCOMO_CDMA">Docomo CDMA</option>
    <option value="Postpaid_DOCOMO_GSM">Tata Docomo CDMA</option>
    <option value="Postpaid_IDEA">IDEA</option>
    <option value="Postpaid_LOOP">Loop Mobile</option>
    <option value="Postpaid_RELIANCE_CDMA">Reliance CDMA</option>
    <option value="Postpaid_RELIANCE_GSM">Reliance CDMA</option>
    <option value="Postpaid_VODAFONE">Vodafone</option>
    </optgroup>
    
    </select>  <br>  
    </td>
  </tr>
  
    <tr>
    <td align="right"><label for="txtAmount">CUSTOMER NAME. :</label></td>
    <td><input type="text" tabindex="2" placeholder="Enter Customer Name."  name="txtCustName" maxlength="30" id="txtCustName" class="form-control" /><br></td>
    </tr>
    <tr>
    <td align="right"><label for="txtMobileNo"><span id="lblLabel">CUSTOMER MOBILE NO. :</span></label></td>
    <td><input type="text" tabindex="3" placeholder="Enter Recharge Number."  name="txtMobileNo" maxlength="40" id="txtMobileNo" class="form-control" /><br></td>
  </tr>
  
  <tr>
    <td align="right"><label for="txtAmount">BILL AMOUNT :</label></td>
    <td><input type="text" tabindex="4" placeholder="Enter Bill amount." onKeyPress="return isNumeric(event);" name="txtAmount" maxlength="4" id="txtAmount" class="form-control" /><br></td>
    </tr>
    
     <tr>
    <td align="right"><label for="txtAmount">CUSTOMER ACCOUNT NO. :</label></td>
    <td><input type="text" tabindex="5" placeholder="Enter Cust Account Number."  name="txtCustAccNo" maxlength="30" id="txtCustAccNo" class="form-control" /><br></td>
    </tr>
    
  <tr><td></td><td><input type="submit" tabindex="6" name="btnRecharge" id="btnRecharge" value="Submit" class="btn btn-primary" /></td></tr>
</table>
</td>
 
    <td  style="padding:0;margin:0;margin-top:-200px;position:relative;" >
    </td>
</tr>
</table>
</form>
                        </div>

                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
            <div class="row">
                
                <div class="col-lg-12">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>BILL LIST
                            
                        </div>

                        <div class="panel-body">
                           <div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
    <tr>
    <th>BILL ID</th>
    <th>Biller name</th>
    <th>Cust Acc No</th>
   <th>Amount</th>
   <th>Customer Name</th>
   <th>Customer Mobile No</th>
   <th>Status</th>
   <th>Response Message</th>
  
   </tr>
    <?php
	$str_query_recharge = "select * from tblbillpay where  user_id=".$this->session->userdata('DistId')." order by Id desc limit 0, 7";
		$result_bill = $this->db->query($str_query_recharge);		
	$i = 0;foreach($result_bill->result() as $row) 	{  ?>
<tr class="<?php echo $i%2 == 0 ? 'row1':'row2'; ?>">
<td><?php echo $row->Id; ?></td>
<td><?php echo $row->company_name; ?></td>
<td><?php echo $row->cust_acc_no; ?></td>
<td><?php echo $row->amount; ?></td>
<td><?php echo $row->cust_name; ?></td>
<td><?php echo $row->cust_mob_no; ?></td>
<td><?php if($row->status == "Pending"){echo "<span class='orange'>".$row->status."</span>";} ?><?php if($row->status == "Success"){echo "<span class='green'>".$row->status."</span>";} ?><?php if($row->status == "Failure"){echo "<span class='red'>".$row->status."</span>";} ?></td>
<td><?php echo $row->admin_remark; ?></td>
    
   
</tr>
		<?php 	
		$i++;} ?>
		</table>
                            </div>
                        </div>

                    </div>
                        
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
   
 
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>

</html>
