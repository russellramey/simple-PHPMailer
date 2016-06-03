<?php
//If the form is submitted
if(isset($_POST['submit'])) {

	// include your PHPMailerAutoload.php
	require 'path/to/your/PHPMailerAutoload.php';

	// Create Error handling for required fields.
	// Check text input is not empty
	if(trim($_POST['textinputname']) == '') {
		$hasError = true;
	} else {
		$textinputname = trim($_POST['textinputname']);
	}
	
	//Check email valid email format
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%\'-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	/* Repeat error handling for all required fields...
	if(trim($_POST['textinputname2']) == '') {
		$hasError = true;
	} else {
		$textinputname2 = trim($_POST['textinputname2']);
	}
	*/


	//If there is no error, process the email
	if(!isset($hasError)) {
		
		// Initialize PHPMailer
		$submit = new PHPMailer;
		// Set connection to use SMTP
		$submit->isSMTP();
		$submit->Host = 'SMTP HOST HERE';
		$submit->SMTPAuth = true;
		$submit->Username = 'USERNAME';
		$submit->Password = 'PASSWORD';
		$submit->SMTPSecure = 'tls';
		$submit->Port = 000;
		// Set from email address & name
		$submit->From = $email;
		$submit->FromName = 'YOUR FROM NAME';
		// Set to(recipient) address & name
		$submit->addAddress('RECIPIENT ADDRESS', 'RECIPIENT NAME');
		// Set reply address
		$submit->addReplyTo($email, 'YOUR REPLY NAME');
		// Set content typ to HTML
		$submit->isHTML(true);
		// Set suject
		$submit->Subject = 'YOUR SUBJECT';
		// Set body of email
		$submit->Body = 'BODY TEXT VARIABLES FROM ABOVE CAN GO HERE';

		// Check if mail has been sent
		if(!$submit->send()) {
			// If mail fails set Error to TRUE
			$hasError = true;
		} else {

			// Initialize new PHPMailer for Confirmation email
			$confirm = new PHPMailer;
			// Set connection to use SMTP
			$confirm->isSMTP();
			$confirm->Host = 'SMTP HOST HERE';
			$confirm->SMTPAuth = true;
			$confirm->Username = 'USERNAME';
			$confirm->Password = 'PASSWORD';
			$confirm->SMTPSecure = 'tls';
			$confirm->Port = 000;
			// Set from email address & name
			$confirm->From = 'YOUR FROM EMAIL';
			$confirm->FromName = 'YOUR FROM';
			// Set to(recipient) address & name
			// will most likly be user submitted email
			$confirm->addAddress($email, 'RECIPIENT NAME');
			$confirm->addReplyTo('YOUR REPLY EMAIL', 'YOUR REPLY NAME');
			$confirm->isHTML(true);
			// Set suject
			$confirm->Subject = 'YOUR SUBJECT';
			// Set body of email
			$confirm->Body = 'CONFIRMATION EMAIL TEXT GOES HERE';
			// Send confirmation email
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
		<p>Error message(s) here</p>
	</div>
<?php } 
// If email is sent with no errors
if(isset($emailSent) && $emailSent == true) { ?>
	<div class="success">
		<p>Thank you message here</p>
	</div>
<?php } ?>
