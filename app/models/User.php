<?php 

class User extends \HXPHP\System\Model
{
	static $validates_presence_of = array(
		array(
			'name',
			'message' => 'O nome é um campo obrigatório.'
			),
		array(
			'email',
			'message' => 'O e-mail é um campo obrigatório.'
			),
		array(
			'username',
			'message' => 'O usuário é um campo obrigatório.'
			),
		array(
			'password',
			'message' => 'A senha é um campo obrigatório.'
			)
	);

	static $validates_uniqueness_of = array(
		array(
			'username',
			'message' => 'O usuário já está cadastrado.'
			),
		array(
			'email',
			'message' => 'O email já está cadastrado.'
			)
	);
	public static function cadastrar(array $post){
		$callbackObj = new \stdClass;
		$callbackObj->user = NULL;
		$callbackObj->status = false;
		$callbackObj->errors = array();


		$role = Role::find_by_role('user');
		if(is_null($role)){
			array_push($callbackObj->errors, 'A regra de informada não existe. Informe o administrador do sistema');
			return $callbackObj;
		}
		$user_data = array( 
			'role_id' => $role->id,
			'status' => 1
		);

		$password = \HXPHP\System\Tools::hashHX($post['password']);
		$post = array_merge($post, $user_data, $password);
		$cadastrar = self::create($post);
		

		if($cadastrar->is_valid()){
			$callbackObj->user = $cadastrar;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();
		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);

		}
		return $callbackObj;
	}	
	public static function login(array $post){
		$callbackObj = new \stdClass;
		$callbackObj->user = NULL;
		$callbackObj->status = false;
		$callbackObj->code = NULL;


		$user = self::find_by_username($post['username']);
		if(!is_null($user)){
			$password = \HXPHP\System\Tools::hashHX($post['password'], $user->salt);
			if($user->status == 1){
				if(LoginAttempt::ExistemTentativas($user->id)){
					if($password['password'] === $user->password){
						$callbackObj->user = $user;
						$callbackObj->status = true;
						LoginAttempt::LimparTentativas($user->id);
					}else{
						LoginAttempt::RegistrarTentativa($user->id);
						$callbackObj->code = 'dados-incorretos';
					}
				}else{
					$callbackObj->code = 'usuario-bloqueado';
					$user->status = 0;
					$user->save(false);
				}
			}else{
				$callbackObj->code = 'usuario-bloqueado';
			}
		}else{
			$callbackObj->code = 'usuario-inexistente';
		}
		return $callbackObj;
	}
}