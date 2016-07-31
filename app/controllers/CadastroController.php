<?php 

class CadastroController extends \HXPHP\System\Controller{
	public function __construct($configs){
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			true
		);
		$this->auth->redirectCheck(true);
	}

	public function cadastrarAction(){
		$this->view->setFile('index');		
		$this->request->setCustomFilters(array(
			'email' => FILTER_VALIDATE_EMAIL
			)
		);
		
		$post = $this->request->post();

		if(!empty($post)){
			$cadastrarUsuario = User::cadastrar($this->request->post());
			if($cadastrarUsuario->status === false){
				$this->load("Helpers\Alert", array(
					'danger',
					'Não foi cadastrado devido os erros conforme abaixo: ',
					$cadastrarUsuario->errors
					)
				);
			}else{
				$this->auth->login($cadastrarUsuario->user->id, $cadastrarUsuario->user->username);
			}
		}
	}
}