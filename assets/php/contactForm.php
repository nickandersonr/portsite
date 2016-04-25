<?php

	// Contact
	$to = 'nick.anderson.r@gmail.com';
	$subject = 'Website Contact Form';

	if(isset($_POST['c_name']) && isset($_POST['c_email']) && isset($_POST['c_message'])){
		$name    = $_POST['c_name'];
		$from    = $_POST['c_email'];
		$message = $_POST['c_message'];

		if (mail($to, $subject, $message, $from)) {
			$result = array(
				'message' => 'Thanks for contacting me!',
				'sendstatus' => 1
				);
			echo json_encode($result);
		} else {
			$result = array(
				'message' => 'Sorry, something went wrong ¯\_(ツ)_/¯',
				'sendstatus' => 1
				);
			echo json_encode($result);
		}
	}

?>