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
			array('username','email'),
			'message' => 'Usuário/e-mail já cadastrado')
	);
	public static function cadastrar(array $post){
		$objUser = new \stdClass;
		$objUser->user = NULL;
		$objUser->status = false;
		$objUser->erros = array();


		$role = Role::find_by_role('user');
		if(is_null($role)){
			array_push($objUser->errors, 'A regra de usuário não existe.');
			return $objUser;
		}
		$post = array_merge($post, 
			array(
			'role_id' => $role->id,
			'status' => 1
			)
		);
		$password = \HXPHP\System\Tools::hashHX($post['password']);
		$post = array_merge($post, $password);
		$cadastrar = self::create($post);
		if($cadastrar->is_valid()){
			$objUser->user = $cadastrar;
			$objUser->status = true;
			return $objUser;
		}

		//Caso continue a execução o cadastro não foi efetuado no BD
		//Exibir mensagem de erro
		$errors = $cadastrar->errors->get_raw_errors();
		//var_dump($cadastrar->errors->get_raw_errors());
		foreach ($errors as $field => $message) {
			array_push($objUser->errors, $message[0])
		}
		return $objUser;
	}	
}