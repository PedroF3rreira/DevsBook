<?php 
namespace src\handles;

use \src\models\User;

/**
 * classe responsavel pelo gerenciamento de login 
 */
class LoginHandler
{
	/*
	*método faz verificação de token e sessão de usuario
	*@access public
	*@return User
	*/
	public static function checkLogin()
	{
		if(!empty($_SESSION['token'])){
			
			$token = $_SESSION['token'];

			$data = User::select()->where('token', $token)->one();

			if($data){

				$loggedUser = new User();
				$loggedUser->id = $data['id'];
				$loggedUser->name = $data['name'];
				$loggedUser->avatar = $data['avatar'];

				return $loggedUser;
			}

		}
		return false;
	}
	/* 
	 * verifica se email e password estão corretos 
	 * e retorna um token de para o usuario e faz um update
	 * na tabela uauario no campo token
	 * */
	public static function verifyLogin($email, $password)
	{
		$user = User::select()
               ->where('email', $email)
           ->one();
            
        if($user){
            if(password_verify($password, $user['password'])){

            	$token = md5(time().rand(0,999).time());

            	User::update()
	            	->set('token', $token)
	            	->where('email', $email)
            	->execute();

            	return $token;
            }
        }

        return false;
	}

	/*
	 * função verifica se email já existe
	 * @return bolean
	 * 
	 */
	public function emailExists($email)
	{
		$user = User::select()->where('email', $email)->one();

		return $user?true:false;
	}

	/*
	* função adiciona um novo usuário 
	* 
	*/
	public function addUser($name, $email, $password, $birthdate)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		
		$token = md5(time().rand(0,999).time());

		User::insert([
			'name' => $name,
			'email' => $email,
			'password' => $hash,
			'birthdate' => $birthdate,
			'avatar' => 'default.jpg',
			'cover' => 'cover.jpg',
			'token' => $token
		])
		->execute();

		return $token;
	}
}