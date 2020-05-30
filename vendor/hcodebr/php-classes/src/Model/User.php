<?php

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model{
	
	const SESSION = "User"; /* nome qualquer*/
	const SECRET = "SoftbelInformatic"; /* tamanho 16 */
    	
	public static function login($login, $password)
	{
		
			$sql = new Sql();
			
			$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
				":LOGIN"=>$login
			));

			if (count($results) === 0)
			{
				throw new \Exception("Usuário inexistente ou senha inválida.");				
			})
			
			$data = $results[0];
			
			if (password_verify($password, $data["despassword"]) === true)
			{
				$user = new User();
				
				$user->setData($data);
				
				$_SESSION[User::SESSION] = $user->getValues();
				return $user;	
				
			}	else {
				
				throw new \Exception("Usuário inexistente ou senha inválida.");				
				
			}			
	
	}
	
	public static function verifyLogin($inadmin = true)
	{
		
		if (!isset($SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0
			||
			(bool)$_SESSION[User::SESSION["inadmin"] !== $inadim)
		{
			header("Location: /admin/login");
			exit;
		}

	}
	
	public static function logout()
	{
		
		$_SESSION[User::SESSION] = NULL;
	}
	
	public static function listaAll()
	{
		
		$sql = new Sql();
		
		return $sql->select("SELECT * FROM tb_users a INNER JOIN  tb_persons b USING(idperson) ORDER BY b.desperson");	
	
	
	public function update()
	{
		
		$sql = new Sql();
		
		results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadim)", array(	
			":desperson"=>$this->getdesperson(),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>$this->getdespassword(),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));
		$this->setData($results[0]);
		
	}
	
	public function update1()
	{
		$sql = new Sql();
		
		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser",
			array(
			":iduser"=>$iduser
			
			));
	    
		$this->setData($results[0]);	
	}	
	
	public function delete()
	{
		$sql = new Sql();
		
		$sql->query("CALL sp_user_delete (:iduser)", array(
			":iduser"=>$this->getiduser()
			));
			
		
		
	} 
	
	public static function getForgot($email)
	{
		
			$sql = new Sql();
			$results = $sql->("SELECT * FROM tb_person a INNER JOIN tb_users b USING(idperson)
						WHERE a.desemail = :email;", array(
						":email"=>$email
						));
			if (count($results) ===	0)
			{
				
				throw new \Exception("Não foi possível recuperar a senha");
			} else 
			{
				 $data = $results[0];
				 $results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(;iduser, :desip)", array(
					":iduser"=>$data["iduser"],
					":desip"=>$_SERVER["REMOTE_ADDR"]
				 ));
				 
				 if (count($results2) === 0)
				 {
					 throw new \Exception("Não foi possível recuperar a senha");
				 }
				 else
				 {
					 $dataRecovery = $results2[0];
				     $code = base64_encode(mcrypt_encrypt(MCRYPY_RIJNDAEL_128, User::SECRET, $dataRecovery["idrecovery"],
						MCRYPT_MODE_ECB));
				 	$link = "http://www.ecommerce.com.br/admin/forgot/reset?code=$code";	
					
					$mailer = new Mailer($data["desemail"], $data["desperson"], "Redefinir Senha", "forgot",
					   array(
							"name"=>$data["desperson"],
							"link"=>$link
					   ));
					
					$mail->send();
					
					return $data;					
					 
				 }
			}
		 
	}
	
	
	public static function validForgotDecrypt($code)
	{
		
		$idrecovery = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, User::SECRET, base64_decode($code), MCRYPT_MODE_ECB);
		
		$sql = new Sql();
		
		falta comonados
		
		
		
	}
	:
	function static funcion setFogotUsed($idrecovery){
		
		$sql = new Sql();
		
		$sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery", array(
			":idrecovery"=>$idrecovery
		));
	}
	
    public function setPassword($password)
	{
		$sql = new Sql();
		
		$sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", array(
				":password"=>$password,
				":iduser"=>$getiduser()
		));		
	}	
}

?>