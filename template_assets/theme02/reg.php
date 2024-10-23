<?php


$to=",ganeshgodse12@gmail.com";
	date_default_timezone_set('Asia/Calcutta'); 

	$name=($_POST['name']);
	$phone=($_POST['phone']);
        $email=($_POST['email']);
	$service=($_POST['service']);
        $message=($_POST['textarea']);
        $cdate=date('d-M-Y h:i:s') ;

	$message = "
			<table width='500' border='1' cellpadding='2'> 
			<tr><td><b>Registration</b></td><td><b>New User Registred</b></td></tr>
				<tr><td width='100'>Name</td><td width='400'>$name</td></tr>
				<tr><td>Contact No. :</td><td>$phone</td></tr>
                <tr><td>Email Id</td><td>$email</td></tr>  
                <tr><td>Selected Service</td><td>$service</td></tr>  				
                <tr><td>Comments :</td><td>$message</td></tr>
				<tr><td>Date & Time</td><td>$cdate</td></tr>				
			</table>" ; 

		$headers.= "MIME-Version: 1.0\r\n";
		$headers.= "Content-type: text/html; ";
		$headers.= "charset=iso-8859-1\r\n";
		$headers.= "From: $email";
		$subject = "One New Registration - From: PayuOnline";

		$mail=mail( $to, $subject, $message, $headers );
	if($mail){	
header("location:contact.html?method=post&msg=msg_success");
echo "Success";
}
else{//header("location:contact.php?method=post&msg=msg_fail");
echo "Failed";
}

/*
if (isset($_POST["email"])) {
    $ToEmail = 'sagarplad@gmail.com';
    $EmailSubject = 'Tailormade Enquiry from website';
    $mailheader = "From:".$_POST["email"]."\n";
    $mailheader.= "Reply-To:".$_POST["email"]."\n";
    $mailheader.= "Content-type: text/html; charset=iso-8859-1\n";
    $MESSAGE_BODY. = "Name:".$_POST["name"]."\n";
    $MESSAGE_BODY.= "Tour places:".$_POST["tour"]."\n";
	$MESSAGE_BODY. = "Contact No Mobile:".$_POST["mobile"]."\n";
	$MESSAGE_BODY. = "Contact No Residence:".$_POST["residence"]."\n";
    $MESSAGE_BODY.= "Email:".$_POST["email"]."\n";
	$MESSAGE_BODY. = "No of Persons:- child".$_POST["Child"]."\n";
    $MESSAGE_BODY.= "infant:".$_POST["infant"]."\n";
	$MESSAGE_BODY. = "Adult:".$_POST["Adult"]."\n";
    $MESSAGE_BODY.= "Travel date:".$_POST["TravelDate"]."\n";
	$MESSAGE_BODY. = "Duration:".$_POST["Duration"]."\n";
    $MESSAGE_BODY.= "journey:".$_POST["journey"]."\n";
	$MESSAGE_BODY. = "Vehicle:".$_POST["Vehicle"]."\n";
    $MESSAGE_BODY.= "hotel:".$_POST["hotel"]."\n";
	$MESSAGE_BODY.= "food:".$_POST["food"]."\n";
    $MESSAGE_BODY.= "Comment:".nl2br($_POST["comment"])."\r\n";
    mail($ToEmail, $EmailSubject, $mailheader, $MESSAGE_BODY) or die ("Sorry..Your mail can't send right now please try again..!");*/
?>
//Your message was sent our oprator will contact you soon..thank you..!
<?php

//} 
//else 
//{
?>

<?php

//};
?>