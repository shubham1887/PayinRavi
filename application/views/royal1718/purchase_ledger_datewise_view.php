<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-clearmin.min.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/roboto.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/material-design.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/small-n-flat.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
        <title>Datewise Purchase Ledger</title>
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
    
        <script language="javascript">
		$('document').ready(function(){
		  $('#li_Purchase').addClass("pre-open");
		 });
		 </script>
		 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#txtFromDate,#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
  } );
  </script>
    </head>
    <body class="cm-no-transition cm-2-navbar">
        <?php include("files/adminheader.php"); ?>
        
        <div id="global">
	        <div class="container-fluid">
               <div class="panel panel-default">
                            <div class="panel-heading">Search Filters</div>
                            <div class="panel-body">
                            <form id="frmsearch" name="frmsearch" action="" method="post">
                                <table class="table">
                                   
                                    <thead>
                                        <tr>
                                        	
                                            <th><input type="text" id="txtFromDate" value="<?php echo $from; ?>" name="txtFromDate" placeholder="Select Date" class="form-control"></th>
                                            <th><input type="text" id="txtToDate" value="<?php echo $to; ?>" name="txtToDate" placeholder="Select Date" class="form-control"></th>
                                            <th>
                                            	<select id="ddlcreditor" name="ddlcreditor" class="form-control" style="width:120px;">
                                                	<option value="ALL">ALL</option>
                                                	  <?php
												
													$creditors = $this->db->query("select * from tblcreditors order by Name");
													foreach($creditors->result() as $rcc)
													{?>
														<option value="<?php echo $rcc->Id; ?>"><?php echo $rcc->Name; ?></option>
													<?php }
												
												 ?>
                                                </select>
                                            </th>
                                           
											<th><input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary"></th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                                </form>
                                
                            </div>
                        </div>
            </div>
            <div class="container-fluid">
            <style>
			.row1
			{
				background-color:#FEDDD8;
			}
			.row2
			{
				background-color:#CDF3D2;
			}
			</style>
               <div class="panel panel-default">
               	<span class="label label-success" style="font-size:18px;">Credit : <?php echo $totalcredit;  ?></span> || <span style="font-size:18px;" class="label label-danger">Debit : <?php echo $totaldebit;  ?></span>
                            <div class="panel-heading" style="width:16px;font-weight:bold">ROYAL BALANCE</div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <caption>with <code>.table-bordered</code> and <code>.table-hover</code></caption>
                                    <thead>
                                        <tr>
                                        	
                                            <th>Id</th>
                                            <th>DateTime</th>
                                            <th>Name</th>
                                            <th>Cr ( + )</th>
                                            <th>Dr ( - )</th>
                                            
                                            <th>Remark</th>
                                            <th>Description</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
								$i=1;
									//print_r($data);exit;
									 foreach($data->result() as $row)
                                    {
									$class = "";
									
									
									?>
                                    <tr class="<?php echo $class; ?>">
                                           
                                            <td id="tdremark_<?php echo $row->Id; ?>"><?php echo $row->payment_id; ?></td>
                                            
                                   			<td><?php echo $row->Ew_add_date; ?></td>
                                            <td id="transaction_date_<?php echo $row->Id; ?>"><?php echo $row->CreditorName; ?></td>
                                            <td id="Withdrawal_<?php echo $row->Id; ?>"><?php echo $row->credit_amount; ?></td>
                                            <td id="Deposit_<?php echo $row->Id; ?>"><?php echo $row->debit_amount; ?></td>
                                            
                                            <td id="Narration_<?php echo $row->Id; ?>"><?php echo $row->remark; ?></td>
                                            <td id="Narration_<?php echo $row->Id; ?>"><?php echo $row->description; ?></td>

                                            
                                            
                                            
                                        </tr>
                                    <?php $i++; } ?>
                                        
                                       
                                    </tbody>
                                </table>
                                <input type="hidden" id="hidurl" value="<?php echo base_url()."Admin/bank_ledger"; ?>">
                                <script language="javascript">
								$( document ).ready(function() {
									document.getElementById("ddlType").value = '<?php echo $ddlType; ?>';
								});
								function updateform(id,cls)
								{
									var did = document.getElementById("ddldebtorcreditor_"+id).value;
									var remark = document.getElementById("txtRemark_"+id).value;
									
									$.ajax({
											url:document.getElementById("hidurl").value,
											data:{"Id":id,"did":did,"class":cls,"Remark":remark},
											cache:false,
											type:'POST',
											success:function(html)
											{
												document.getElementById("DebtorName_").innerHTML = html;
											}
									});	
								}
								function enablefields(id)
								{
									 if(document.getElementById("btnen_"+id).value == "SHOW")
									 {
									 	document.getElementById("btnen_"+id).value = "Hide";
										
										
										 
										 document.getElementById("ddlcreddeb_"+id).style.display = 'table-cell';
										 document.getElementById("tdremark_"+id).style.display = 'table-cell';
										 document.getElementById("btnperact_"+id).style.display = 'table-cell';
									 }
									 else
									 {
									 	document.getElementById("btnen_"+id).value = "SHOW";
										
									
										
										 document.getElementById("ddlcreddeb_"+id).style.display = 'none';
										 document.getElementById("tdremark_"+id).style.display = 'none';
										 document.getElementById("btnperact_"+id).style.display = 'none';
									 }
									
								}
								
								</script>
                            </div>
                        </div>
            </div>
            <footer class="cm-footer"><span class="pull-left">Connected as John Smith</span><span class="pull-right">&copy; PAOMEDIA SARL</span></footer>
        </div>
        <!--<script src="../assets/js/lib/jquery-2.1.3.min.js"></script>-->
           <script src="../assets/js/jquery.mousewheel.min.js"></script>
        <script src="../assets/js/jquery.cookie.min.js"></script>
        <script src="../assets/js/fastclick.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/clearmin.min.js"></script>
    </body>
</html>