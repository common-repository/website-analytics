<?php
	
	class Mosite_Messages
	{

		const SUPPORT_FORM_VALUES				= "Please submit your query along with email.";
		const SUPPORT_FORM_SENT					= "Thanks for getting in touch! We shall get back to you shortly.";
        const INVALID_PHONE                     = 'Please enter a valid phone number';
        const NONCE_ERROR						= 'Nonce error';
        const PASS_LENGTH						= 'Choose a password with minimum length 6.';
        const PASS_MISMATCH						= 'Password and Confirm Password do not match.';
		const REQUIRED_FIELDS					= 'Please enter all the required fields';
		const RESET_PASS						= 'You password has been reset successfully and sent to your registered email. Please check your mailbox.';
		const REG_SUCCESS						= 'Your account has been retrieved successfully.';
		const INVALID_CREDENTIALS               = 'Invalid Credentials.';




     

		public static function showMessage($message , $data=array())
		{
			$message = constant( "self::".$message );
		    foreach($data as $key => $value)
		    {
		        $message = str_replace("{{" . $key . "}}", $value , $message);
		    }
		    return $message;
		}

	} new Mosite_Messages();

?>