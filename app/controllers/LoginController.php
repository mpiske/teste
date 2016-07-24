<?php 

class LoginController extends \HXPHP\System\Controller{
	public function logarAction(){
		$this->view->setFile('index');
		$post=$this->request->post();
	}
}