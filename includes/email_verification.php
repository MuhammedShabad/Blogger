<?php
	session_start();
	$email=$_SESSION['email'];
	$pwd=$_SESSION['pwd'];
	$hash=$_SESSION['hash'];
	$base_url = "http://localhost/blog/logsignup/";
	$mail_body = "
		<p>Hi ".$_SESSION['fname']."</p>
		<p>Thanks for Registration. Your Password id ".$pwd.", This password will work only after your email verification.</p>
		<p>Please Open this link to verify your email address- <a href='".$base_url."activation.php?activation_code=".$hash."'>Click here</a></p>
		<p>Best Regards,<br><br>BlogOwRite</p>
	";
	require 'src/PHPMailer.php';
	require 'src/SMTP.php';
	require 'src/Exception.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	try {
	    	//Server settings
	    //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
	    $mail->isSMTP();
	    $mail->Host="smtp.gmail.com";                                      // Set mailer to use SMTP
	    //$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = '';                 // SMTP username
	    $mail->Password = '';                           // SMTP password
	    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 465;                                    // TCP port to connect to
	    $mail->setFrom('rishabhrathi75@gmail.com');
	    $mail->addAddress($email);
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Email Verification';
	    $mail->Body    = $mail_body;
	    $mail->send();
	    echo 'Message has been sent';

	} catch (Exception $e) {
	    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}	
?>
