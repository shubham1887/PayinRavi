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
        <title>Debtor List</title>
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
                                            	<select id="ddldebtor" name="ddldebtor" class="form-control" style="width:120px">
		                                            <option value="0">Select</option>
                                                   
                                            	<?php
												
													$debtors = $this->db->query("select * from tbldebtors order by Name");
													foreach($debtors->result() as $rdc)
													{?>
														<option value="<?php echo $rdc->Id; ?>"><?php echo $rdc->Name; ?></option>
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
               <span class="label label-success" style="font-size:18px;">Total Deposits : <?php echo $totaldeposit; ?></span>
                            <div class="panel-heading">Tables</div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <caption>with <code>.table-bordered</code> and <code>.table-hover</code></caption>
                                    <thead>
                                        <tr>
                                        	<th>Id</th>
                                            <th>Name</th>
                                            <th>Opening Outstanding Date</th>
                                            <th>Opening Outstanding</th>
                                           
                                            <th>TotalBalance</th>
                                            <th>TotalRevert</th>
                                            <th>Total Payment</th>
                                            <th>Total Cash</th>
                                             <th>Current Outstanding</th>
                                          
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
                                    
                                          
                                            <td id="tdremark_<?php echo $row->Id; ?>"><?php echo $row->Id; ?></td>
                                             <td id="transaction_date_<?php echo $row->Id; ?>"><?php echo $row->Name; ?></td>
                                   			<td><?php echo $row->opening_date; ?></td>
                                            <td id="Id_<?php echo $row->Id; ?>"><?php echo $row->opening_outstanding; ?></th>
                                           
                                            <td id="Withdrawal_<?php echo $row->Id; ?>"><?php echo $row->totalcredit; ?></td>
                                            <td id="Withdrawal_<?php echo $row->Id; ?>"><?php echo $row->totaldebit; ?></td>
                                             <td id="Withdrawal_<?php echo $row->Id; ?>"><?php echo $row->totaldeposit; ?></td>
                                             <td id="Withdrawal_<?php echo $row->Id; ?>"><?php echo $row->received_cash; ?></td>
                                             <td id="Withdrawal_<?php echo $row->Id; ?>"><?php echo (($row->totaldeposit + $row->received_cash - ($row->totalcredit - $row->totaldebit - $row->opening_outstanding))); ?></td>
                                            

                                            
                                            
                                            
                                        </tr>
                                    <?php $i++; } ?>
                                        
                                       
                                    </tbody>
                                </table>
                                <input type="hidden" id="hidurl" value="<?php echo base_url()."Admin/bank_ledger"; ?>">
                               
                            </div>
                        </div>
            </div>
            <footer class="cm-footer"><span class="pull-left">Connected as John Smith</span><span class="pull-right">&copy; PAOMEDIA SARL</span></footer>
        </div>
        <script src="../assets/js/lib/jquery-2.1.3.min.js"></script>
        <script src="../assets/js/jquery.mousewheel.min.js"></script>
        <script src="../assets/js/jquery.cookie.min.js"></script>
        <script src="../assets/js/fastclick.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/clearmin.min.js"></script>
    </body>
</html>