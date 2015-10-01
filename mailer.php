<?php
// simple_mailer.php

function mailer_header()
{
?>
<html>
<head><title>E-Mailer</title><link rel="meta" href="http://henrytaunt-footsteps.co.uk/labels.rdf" type="application/rdf+xml" title="ICRA labels" />
<meta http-equiv="pics-Label" content='(pics-1.1 "http://www.icra.org/pics/vocabularyv03/" l gen true for "http://henrytaunt-footsteps.co.uk" r (n 0 s 0 v 0 l 0 oa 0 ob 0 oc 0 od 0 oe 0 of 0 og 0 oh 0 c 0) gen true for "http://www.henrytaunt-footsteps.co.uk" r (n 0 s 0 v 0 l 0 oa 0 ob 0 oc 0 od 0 oe 0 of 0 og 0 oh 0 c 0))' />
</head>
<body>
<?php
}

function mailer_footer()
{
?>
</body>
</html>
<?php
}

function error_message($msg)
{
	mailer_header();
	echo "<script>alert(\"Error: $msg\"); history.go(-1)</script>";
	mailer_footer();
	exit();
}

function user_message($msg,$frm_type)
{
	global $area_id;
	mailer_header();
	echo "<script>alert(\"$msg\"); self.location.href=\"thanks.htm?area_id=$area_id&frm_type=$frm_type\"</script>";
	mailer_footer();
	exit();
}

function send_contact()
{
	global $realname, $company, $address, $address2, $address3, $postcode, $country;
	global $telephone, $email, $comments;

//	$mail_to="comment@henrytaunt-footsteps.co.uk"
	$mail_to="comment@henrytaunt-footsteps.co.uk";
	$mail_subject="Henry Taunt Footsteps support";
	$mail_body="\tCONTACT DETAILS\n\nFeedback from Henry Taunt Footsteps website:\n\n";
	$mail_body.=$realname."\n".$company."\n"; 
	$mail_body.=$address."\n".$address2."\n".$address3."\n".$postcode."\n".$country."\n\n"; 
	$mail_body.="Phone - ".$telephone."\n"."E-mail - ".$email."\n\n"; 
	$mail_body.="Comments:"."\n".$comments."\n\n"; 
	
	$mail_parts["mail_to"] = $mail_to;
	$mail_parts["mail_subject"] = $mail_subject;
	$mail_parts["mail_body"] = $mail_body;

	if(my_mail($mail_parts))
		user_message("You have just successfully sent to INVC an e-mail titled '$mail_subject'.",2);
	else
		error_message("An unknown error occurred while attempting to send an e-mail titled '$mail_subject'.");
}


function my_mail($mail_parts)
{
	$mail_to=$mail_parts["mail_to"];
	$mail_from=$mail_parts["mail_from"];
	$mail_reply_to=$mail_parts["mail_reply_to"];
	$mail_cc=$mail_parts["mail_cc"];
	$mail_bcc=$mail_parts["mail_bcc"];
	$mail_subject=$mail_parts["mail_subject"];
	$mail_body=$mail_parts["mail_body"];

	if(empty($mail_to)) error_message("Empty To field!");
	if(empty($mail_subject)) error_message("Empty Subject field!");
	if(empty($mail_body)) error_message("Empty Body!");

	$mail_to = str_replace(";", ",", $mail_to);
	$mail_headers = ' ';

	if(!empty($mail_from)) $mail_headers .= "From: $mail_from\n";
	if(!empty($mail_reply_to)) $mail_headers .= "Reply_to: $mail_reply_to\n";
	if(!empty($mail_cc)) $mail_headers .= "Cc: ".str_replace(";", ",", $mail_cc)."\n";
	if(!empty($mail_bcc)) $mail_headers .= "Bcc: ".str_replace(";", ",", $mail_bcc)."\n";

	$mail_subject = stripslashes($mail_subject);
	$mail_body = stripslashes($mail_body);

	return mail($mail_to, $mail_subject, $mail_body);

}

//*** This is the bit that does the work. Everything above is a function.
//
// To save the hassle of rewriting this the incoming POST variables are assigned to globals
$realname=$_POST['realname'];
$company=$_POST['company'];
$address=$_POST['address'];
$address2=$_POST['address2'];
$address3=$_POST['address3'];
$postcode=$_POST['postcode'];
$country=$_POST['country'];
$telephone=$_POST['telephone'];
$email=$_POST['email'];
$comments=$_POST['comments'];

send_contact();

?>
