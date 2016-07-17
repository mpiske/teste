<?php 

class CadastroController extends \HXPHP\System\Controller{
	public function cadastrarAction(){
		$this->view->setFile('index');
		//$username = $this->request->post('username');
		//echo $username;
		//var_dump($this->request->post());
		$this->request->setCustomFilters(array(
			'email' => FILTER_VALIDATE_EMAIL
			)
		);
		$cadastrarUsuario = User::cadastrar($this->request->post());

		var_dump($this->request->post());


		//Gerar senha
		
		//Obter role_id
		
	}

}