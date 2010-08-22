<?php

class AppController extends Controller {

	var $components = array ('Auth','Session');

	function beforeFilter(){
		$this->Auth->authError = "Vous n'avez pas l'autorisation de consulter cette page ou votre session a expiré !";
		$this->Auth->loginError = "Les identifiants saisis sont incorrects !";
		$this->Auth->logoutRedirect = array('controller'=>'users', 'action'=>'login');
	}

}

?>