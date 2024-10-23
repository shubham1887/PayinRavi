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
        <title>Bank Ledger</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
    
		
		 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
		
    </head>
    <body class="cm-no-transition cm-2-navbar">
       
       
        <div id="global">
	       
               <div class="panel panel-default">
                            <div class="panel-heading" style="font-size:20px;">SAHJANAND TRANSWORLD EXIM PVT LTD</div>
                            <div class="panel-heading" style="font-size:14px;">RAVIKANT LAXMANBHAI CHAVDA</div>
                            <div class="panel-body">
                                <div class="panel-heading" style="font-size:12px;">Account Ledger 1-Apr-2016 To 31-Mar-2017</div>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                        	
                                            <th>Date</th>
                                            <th>Particulars</th>
                                            <th>Vch Type</th>
                                            <th>Vch No</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
								$i=1;
								$total_credit = 0.00;
								$total_debit = 0.00;
									//print_r($data);exit;
									 foreach($data->result() as $row)
                                    {
                                    $total_credit += $row->Debit;
                                    $total_debit += $row->Credit;
                                    
                                    ?>
                                    <tr class="<?php echo $class; ?>">
                                          
                                            <td style="min-width:100px;"><?php echo date_format(date_create($row->add_date),'Y-m-d'); ?></td>
                                            <?php 
                                            if($row->Credit > 0)
                                            {?>
                                                <td><?php echo $row->particulars; ?></td>
                                                <td>Purchase</td>
                                                <td><?php echo $row->payment_id; ?></td>
                                            <?php }
                                            else
                                            {?>
                                                <td>To ICICI BANK</td>
                                                <td>PAYMENT - ICICI BANK</td>
                                                <td><?php echo $row->Id; ?></td>
                                                
                                            <?php }
                                            ?>
                                            <td><?php echo number_format($row->Debit,2,'.',','); ?></td>
                                            <td><?php echo number_format($row->Credit,2,'.',','); ?></td>
                                   			
                                            
                                        </tr>
                                    <?php $i++; } ?>
                                        
                                       <tr>
                                           <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Carried Over</th>
                                            
                                            <th><?php echo number_format($total_debit,2,'.',','); ?></th>
                                            <th><?php echo number_format($total_credit,2,'.',','); ?></th>
                                       </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="hidurl" value="<?php echo base_url()."Admin/bank_ledger"; ?>">
                                <script language="javascript">
								
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
									 $("#myModal").modal({"show":true});
									// span_id_#span_tdate_#span_withdraw_#span_deposit_#span_balance_#span_narration_
										document.getElementById("hidpopupid").value = id;
										document.getElementById("spanpopup_tdate").innerHTML = document.getElementById("span_tdate_"+id).innerHTML;
										document.getElementById("spanpopup_withdraw").innerHTML = document.getElementById("span_withdraw_"+id).innerHTML;
										document.getElementById("spanpopup_deposit").innerHTML = document.getElementById("span_deposit_"+id).innerHTML;
										document.getElementById("spanpopup_balance").innerHTML = document.getElementById("span_balance_"+id).innerHTML;
										document.getElementById("spanpopup_narration").innerHTML = document.getElementById("span_narration_"+id).innerHTML;
										
									 
									
								}
								
								</script>
                            </div>
                        </div>
            </div>
            
        </div>
     <!--<script src="../assets/js/lib/jquery-2.1.3.min.js"></script>-->
           <script src="../assets/js/jquery.mousewheel.min.js"></script>
        <script src="../assets/js/jquery.cookie.min.js"></script>
        <script src="../assets/js/fastclick.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/clearmin.min.js"></script>
    </body>
</html>