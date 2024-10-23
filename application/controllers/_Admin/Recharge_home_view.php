<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootsrtap Free Admin Template - SIMINTA | Admin Dashboad Template</title>
    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
      <link href="<?php echo base_url(); ?>assets/css/main-style.css" rel="stylesheet" />


</head>

<body>
    <!--  wrapper -->
    <div id="wrapper">
     <!-- navbar top -->
        
        <!-- end navbar top -->

        <!-- navbar side -->
        <?php include("files/adminheader.php"); ?> 
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <?php include("files/agentsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
       <div id="page-wrapper">
          
            
            
            <div class="row" style="width:1800px;">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            
            <div class="row">
                
                <div class="col-lg-6">
                
                <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>RECHARGE FORM
                            
                        </div>

                        
                       
                        <div class="panel-body">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#mobile-recharge" data-toggle="tab">MOBILE</a>
                                </li>
                                <li><a href="#dth-recharge" data-toggle="tab">DTH</a>
                                </li>
                                <li><a href="#postpaid-recharge" data-toggle="tab">POSTPAID</a>
                                </li>
                                
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="mobile-recharge">
                                <h4>Mobile Recahrge</h4>
                                <form id="frmrecahrge" name="frmrecahrge" method="post" action="<?php echo base_url()."Retailer/recharge_home"; ?>">
                                <input type="hidden" id="hidSubmitRecharge" name="hidSubmitRecharge" value="Success">
                                   <table border="0" class="table">
    									<tbody>
                                          <tr>
                                            <td >Mobile No :</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;" type="text" class="form-control" onKeyUp="seriessearch()" onBlur="seriessearch()" id="txtMobileNo" maxlength="40" name="txtMobileNo" placeholder="Enter Recharge Number." tabindex="3">
                                            </td>
                                          </tr>
                                          <tr>
                                            <td >Company :</td>
                                            <td align="left">    
                                              
                                            <select class="form-control" name="ddlOperator" style="width:300px;" onChange="SetParam()" placeholder="Select company name." tabindex="2" id="ddlOperator">
                                            <option value="0">--Select--</option>
                                            <?php
											$rsltmcompany = $this->db->query("select * from tblcompany where service_id = 1");
											foreach($rsltmcompany->result() as $row)
											{?>
												<option value="<?php echo $row->company_id; ?>"><?php echo $row->company_name; ?></option>
											<?php } ?>
                                            </select>	
                                            </td>
                                          </tr>
                                          <tr>
                                            <td >Amount :</td>
                                            <td align="left"><input type="text" style="width:300px;" class="form-control" id="txtAmount" maxlength="3" name="txtAmount" onKeyPress="return isNumeric(event);" placeholder="Enter recharge amount." ></td>
                                            </tr>
                                            <tr>
                                            <td >Transaction Password :</td>
                                            <td align="left"><input type="text" style="width:300px;" class="form-control" id="txtTxnPwd" maxlength="4" name="txtTxnPwd" onKeyPress="return isNumeric(event);" placeholder="Enter Transaction Password." ></td>
                                            </tr>
                                          <tr>
                                          <td></td>
                                          <td><input type="button" class="btn btn-success" value="Submit" id="btnRecharge" name="btnRecharge" tabindex="4" onClick="mobilesubmit()"></td></tr>
										</tbody>
									</table>
                                    <script language="javascript">
									function mobilesubmit()
									{
										if(validatemobile() & validateoperator() & validateamount())
										{
											document.getElementById("frmrecahrge").submit();
										}
										
									}
									function validatemobile()
									{
										var mob = document.getElementById("ddlOperator").value;
										if(mob == "")
										{
											return false;
										}
										else
										{
											return true;
										}
									}
									function validateoperator()
									{
										var mob = document.getElementById("txtMobileNo").value;
										if(mob == "")
										{
											$("#txtMobileNo").addClass("error");
											return false;
										}
										else
										{
											$("#txtMobileNo").removeClass("error");
											return true;
										}
									}
									function validateamount()
									{
										var mob = document.getElementById("txtAmount").value;
										if(mob == "")
										{
											return false;
										}
										else
										{
											return true;
										}
									}
									</script>
                                </form>
                                </div>
                                <div class="tab-pane fade" id="dth-recharge">
                                    <h4>DTH Recahrge</h4>
                                    <table border="0" class="table"><br>
    									<tbody>
                                          <tr>
                                            <td >Sub No :</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;" type="text" class="form-control" onKeyUp="seriessearch()" onBlur="seriessearch()" id="txtMobileNo" maxlength="40" name="txtMobileNo" placeholder="Enter Recharge Number." tabindex="3">
                                            </td>
                                          </tr>
                                          <tr>
                                            <td >Company :</td>
                                            <td align="left">    
                                              
                                            <select class="form-control" name="ddlOperator" style="width:300px;" onChange="SetParam()" placeholder="Select company name." tabindex="2" id="ddlOperator">
                                            <option value="0">--Select--</option>
                                            <?php
											$rsltmcompany = $this->db->query("select * from tblcompany where service_id = 2");
											foreach($rsltmcompany->result() as $row)
											{?>
												<option value="<?php echo $row->company_id; ?>"><?php echo $row->company_name; ?></option>
											<?php } ?>
                                            </select>	
                                            </td>
                                          </tr>
                                          <tr>
                                            <td >Amount :</td>
                                            <td align="left"><input type="text" style="width:300px;" class="form-control" id="txtAmount" maxlength="3" name="txtAmount" onKeyPress="return isNumeric(event);" placeholder="Enter recharge amount." ></td>
                                            </tr>
                                          <tr>
                                          <td></td>
                                          <td><input type="submit" class="btn btn-success" value="Submit" id="btnRecharge" name="btnRecharge" tabindex="4"></td></tr>
										</tbody>
									</table>
                                </div>
                                <div class="tab-pane fade" id="postpaid-recharge">
                                    <h4>Postpaid Recahrge</h4>
                                    <table border="0" class="table"><br>
    									<tbody>
                                          <tr>
                                            <td >Sub No :</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;" type="text" class="form-control" onKeyUp="seriessearch()" onBlur="seriessearch()" id="txtMobileNo" maxlength="40" name="txtMobileNo" placeholder="Enter Recharge Number." tabindex="3">
                                            </td>
                                          </tr>
                                          <tr>
                                            <td >Company :</td>
                                            <td align="left">    
                                              
                                            <select class="form-control" name="ddlOperator" style="width:300px;" onChange="SetParam()" placeholder="Select company name." tabindex="2" id="ddlOperator">
                                            <option value="0">--Select--</option>
                                            <?php
											$rsltmcompany = $this->db->query("select * from tblcompany where service_id = 3");
											foreach($rsltmcompany->result() as $row)
											{?>
												<option value="<?php echo $row->company_id; ?>"><?php echo $row->company_name; ?></option>
											<?php } ?>
                                            </select>	
                                            </td>
                                          </tr>
                                          <tr>
                                            <td >Amount :</td>
                                            <td align="left"><input type="text" style="width:300px;" class="form-control" id="txtAmount" maxlength="3" name="txtAmount" onKeyPress="return isNumeric(event);" placeholder="Enter recharge amount." ></td>
                                            </tr>
                                          <tr>
                                          <td></td>
                                          <td><input type="submit" class="btn btn-success" value="Submit" id="btnRecharge" name="btnRecharge" tabindex="4"></td></tr>
										</tbody>
									</table>
                                </div>
                                
                            </div>
                        </div>
                  

                    </div>
                        
                    </div>
                    <!--Pill Tabs   -->
                    
                     <!--End Pill Tabs   -->
                </div>
                
                <div class="col-lg-6">
                
                <div class="panel panel-default" style="padding-bottom:14px;">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SEARCH RECHARGE
                            
                        </div>

                        <div class="panel-body">
                         <form action="<?php echo base_url()."_Admin/recharge_home"; ?>" method="post" name="frmReport" id="frmReport">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <label>Number / Id</label>
                                            <input class="form-control" id="txtNumId" name="txtNumId" type="text" style="width:120px;" placeholder="Number / Id">
                                        </td>
                                    	<td valign="bottom">
                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                    <br>
                                    <?php
									if($lastrec->num_rows() == 1)
									{
										$recharge_id = $lastrec->row(0)->recharge_id;
										$company_name = $lastrec->row(0)->company_name;
										$recdate = $lastrec->row(0)->add_date;
										$mobile_no = $lastrec->row(0)->mobile_no;
										$amount = $lastrec->row(0)->amount;
										$recharge_status = $lastrec->row(0)->recharge_status;
										$operator_id = $lastrec->row(0)->operator_id;
									}
									else
									{
										$recharge_id = "";
										$company_name = "";
										$recdate = "";
										$mobile_no = "";
										$amount = "";
										$recharge_status = "";
										$operator_id = "";
									}
									
									 ?>
                                    <table class="table table-striped table-bordered table-hover">
                                    <tr style="border-top:1px solid">
                                    	<td>Recahrge Id : </td><td><?php echo $recharge_id; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Recahrge DateTime : </td><td><?php echo $recdate; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Operator name : </td><td><?php echo $company_name; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Mobile Number  : </td><td><?php echo $mobile_no; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Amount : </td><td><?php echo $amount; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Recahrge Status : </td><td><?php echo $recharge_status; ?></td>
                                    </tr>
                                    <tr>
                                    	<td>Transaction Id: </td><td><?php echo $operator_id; ?></td>
                                    </tr>
                                    </table>
                                    
                        </div>

                    </div>
                        
                    </div>
                    
                    <!--Pill Tabs   -->
                    
                     <!--End Pill Tabs   -->
                </div>
                
            </div>
            <div class="row">
                
                <div class="col-lg-12">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>RECHARGE LIST
                            
                        </div>

                        <div class="panel-body">
                           <div class="table-responsive">
                                <table class="table" border="1">
    <tr>  
    <th>Sr No</th>
    <th>Rec.Id</th>
     <th>Transaction Id</th>  
     <th >Rec. Date</th>
     
     <th >Company Name</th>
	 <th >Mobile No</th>    
	 <th >Amt</th>    
   	
	 <th >Rec.By</th>
   	 <th>Status</th> 
               
    </tr>
    <?php
		$rsltrecharge = $this->db->query("select recharge_id,mobile_no,amount,recharge_status,recharge_by,company_name,operator_id,tblrecharge.add_date from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.user_id = ?  order by recharge_id desc limit 7",array($this->session->userdata("AgentId")));
	 $totalRecharge = 0;	$i = count($rsltrecharge->result());foreach($rsltrecharge->result() as $result) 	{  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td ><?php echo $i; ?></td>
 <td ><?php echo $result->recharge_id; ?></td>
 
  
  
  
  <td><?php echo $result->operator_id; ?></td>
  
  
  
 <td><?php echo $result->add_date; ?></td>
 

 <td><?php echo $result->company_name; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>
 
 <td><?php echo $result->recharge_by; ?></td>
 <td>
 <?php if($result->recharge_status == 'Pending'){echo "<span class='orange'><a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Pending</a></span>";}
 if($result->recharge_status == 'Success')
 {
 	$totalRecharge += $result->amount;echo "<span class='green'><a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Success</a></span>";
 }
 if($result->recharge_status == 'Failure')
 {
 	echo "<span class='red'>
 <a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Failure</a></span>";
 }
 if($result->recharge_status == 'succes')
 {
 	echo $result->recharge_status;
 }
 
 ?></td>
  
 </tr>
		<?php 	
		$i--;} ?>
        <tr class="ColHeader" style="background-color:#CCCCCC;">  
        <th></th>  
    <th></th>  

    
     <th  > </th>
     <th > </th>
      <th > </th>
	 <th >Total </th>    
	 <th ><?php echo $totalRecharge; ?></th>    
   	 <th></th>    
	 <th > </th>
   	                    
    </tr>
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
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/siminta.js"></script>

</body>

</html>
