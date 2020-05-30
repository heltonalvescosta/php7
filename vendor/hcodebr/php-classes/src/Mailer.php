<?php

namespace Hcode;

use Rain\Tpl;

class Mailer{
	
	const USERNAME = "suporte@softbel.com.br";
	const PASSWORD = "senha";
	const NAME_FROM = "SOFTBEL";
	
	private $mail;
	
	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{
        $config = array(
			"tpl_dir"   => $_SERVER["DOCUMENT_ROOT"] . "/views/email/",
			"cache_dir" => $_SERVER["DOCUMENT_ROOT"] . "/views-cache/",
			"debug"     => false
		);

		Tpl::configure($cofing);
		$tpl = new Tpl;
		
		foreach ($data as $key => $value){
		
			$tpl->assign($key, $value);
		}
		$html = $tpl->draw($tplName, true);
	       
		$this->mail = new \PHPMailer;

		$this->mail->isSMTP();

		$this->mail->SMTPDebug = 0;  /* 0 sem debug  2 com debug*/

		$this->mail->Debugoutput = 'html';

		$this->mail->host = 'ssmtp.gmail.com';

		$this->mail->Port = 587;

		$this->mail->SMTPSecure = 'tls';

		$this->mail->SMTPAuth = true;

		$this->mail->Username = Mailer::USERNAME;

		$this->mail->Password = Mailer::PASSWORD;

		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

		$this->mail->addAddress($toAddress, $toName);

		$this->mail->Subject = $subject;

		$this->mail->msgHTML($html);

		$this->mail->AltBody = 'This is plain-text message body';

	}
	
	public function send(){

		if ($this->mail->send()){
	
		echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		echo "Mail enviado";
		}
		
	}
	
	
}
?>
