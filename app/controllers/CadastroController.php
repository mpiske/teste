<?php 

class CadastroController extends \HXPHP\System\Controller{
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
			}
		}
	}
}