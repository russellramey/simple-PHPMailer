<?php
//If the form is submitted
if(isset($_POST['submit'])) {

	// Make sure to include PHPMailerAutoload.php
	require 'path/to/your/PHPMailerAutoload.php';

	// Create Error handling for required fields.
	// Check text input is not empty
	if(trim($_POST['textinputname']) == '') {
		$hasError = true;
	} else {
		$textinputname = trim($_POST['textinputname']);
	}
	
	//Check email format and is not empty
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%\'-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	// Repeat error handling for all required fields...


	//If there is no error, process the email
	if(!isset($hasError)) {
		
		// Initialize PHPMailer
		$submit = new PHPMailer;
		$submit->isSMTP();
		$submit->Host = 'SMTP HOST HERE';
		$submit->SMTPAuth = true;
		$submit->Username = 'USERNAME';
		$submit->Password = 'PASSWORD';
		$submit->SMTPSecure = 'tls';
		$submit->Port = 000;
		$submit->From = $email;
		$submit->FromName = 'YOUR FROM NAME';
		$submit->addAddress('RECIPIENT ADDRESS', 'RECIPIENT NAME');
		$submit->addReplyTo($email, 'YOUR REPLY NAME');
		$submit->isHTML(true);
		$submit->Subject = 'YOUR SUBJECT';
		$submit->Body = ' BODY TEXT VARIABLES GO HERE';

		// Check if mail has been sent
		if(!$submit->send()) {

			// If mail fails set Error to TRUE
			$hasError = true;

		} else {

			// Initialize new PHPMailer for Confirmation email
			$confirm = new PHPMailer;
			$confirm->isSMTP();
			$confirm->Host = 'SMTP HOST HERE';
			$confirm->SMTPAuth = true;
			$confirm->Username = 'USERNAME';
			$confirm->Password = 'PASSWORD';
			$confirm->SMTPSecure = 'tls';
			$confirm->Port = 000;
			$confirm->From = 'YOUR FROM EMAIL';
			$confirm->FromName = 'YOUR FROM';
			$confirm->addAddress($email, 'RECIPIENT NAME');
			$confirm->addReplyTo('YOUR REPLY EMAIL', 'YOUR REPLY NAME');
			$confirm->isHTML(true);
			$confirm->Subject = 'YOUR SUBJECT';
			$confirm->Body = 'CONFIRMATION EMAIL TEXT GOES HERE';
			$confirm->Send();

			// If email is sent set emailSent to TRUE
			$emailSent = true;
		}
		
	} // End IF
} ?>



<?php 
// If an error is found
if(isset($hasError)) {  ?>
	<div class="error">
		Sorry, there were errors on your submission. Please provide at minimum the information marked below.
	</div>
<?php } 
// If email is sent with no errors
if(isset($emailSent) && $emailSent == true) { ?>
	<div class="success">
		Your RSVP was successfully sent!<br />
	</div>
<?php } ?>
