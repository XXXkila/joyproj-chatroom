<?php

class Mailer {
		
	public $mail;
	
	public $host		=	'mail.joyproj.com';
	public $userName	=	'forget@joyproj.com';
	public $password	=	'19921125';
	public $from		=	'forget@joyproj.com';
	public $fromName	=	'Joyproj聊天室';
	
	public function __construct() {
		$filepath = dirname(__FILE__) . '/PHPMailer/PHPMailerAutoload.php';
		require($filepath);
		$this->mail = new PHPMailer();
	}
	
	public function sendEmail($email, $subject, $body) {
		$mail = $this->mail;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = $this->host;
		$mail->Port = 25;
		$mail->SMTPAuth = true;
		$mail->Username = $this->userName;
		$mail->Password = $this->password;
		$mail->setFrom($this->from, $this->fromName);
		$mail->addAddress($email);
		$mail->Subject = $subject;
		$mail->Body = $body;
		if (!$mail->send()) {
			return $mail->ErrorInfo;
		}
		return true;
	}
	
}
