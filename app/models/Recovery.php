<?php 

class Recovery extends \HXPHP\System\Model
{
	public static function validar($user_email){
		$user_exists = User::find_by_email($user_email);
		$callbackObj = new \stdClass;
		$callbackObj->user = NULL;
		$callbackObj->code = NULL;
		$callbackObj->status = FALSE;
		if(!is_null($user_exists)){
			$callbackObj->status = true;
			$callbackObj->user = $user_exists;

			self::delete_all(array(
				'conditions' => array(
					'user_id = ?',
					$user_exists->id
					)
				)
			);
		}else{
			$callbackObj->code = 'nenhum-usuario-encontrado';
		}
		return $callbackObj;
	}
	public static function validarToken($token){
		$callbackObj = new \stdClass;
		$callbackObj->user = NULL;
		$callbackObj->code = NULL;
		$callbackObj->status = FALSE;
		$callbackObj->name = NULL;
		$busca = self::find_by_token($token);
		if(!is_null($busca)){
			$user = User::find_by_id($busca->user_id);
			$callbackObj->user = $busca->user_id;
			$callbackObj->status = TRUE;
			$callbackObj->name = $user->name;
		}else{
			$callbackObj->code = 'token-invalido';
		}
		return $callbackObj;
	}

	public static function redefinirSenha($token){
		var_dump($token);
	}
	public static function limpar($user_id){
		return self::delete_all(array(
			'conditions' => array(
					'user_id = ?',
					$user_id
				)
			)
		);
	}
}