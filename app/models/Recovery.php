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
}