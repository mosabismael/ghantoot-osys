<?php
	ini_set("SMTP","smtp.gmail.com" );
	ini_set("smtp_port","465" );
	// If you need to use a username and password
	$to = "xyz@somedomain.com";
	$subject = "This is subject";
	
	$message = "<b>This is HTML message.</b>";
	$message .= "<table><tr><td>This is headline.</td></tr></table>";
	
	$header = "From:abc@somedomain.com \r\n";
	$header .= "Cc:afgh@somedomain.com \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";
	
	$retval = mail ($to,$subject,$message,$header);
	
	if( $retval == true ) {
		echo "Message sent successfully...";
		}else {
		echo "Message could not be sent...";
	}
?>