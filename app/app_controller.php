<?php

class AppController extends Controller {
        
        var $helpers = array('Session', 'Ajax', 'Html', 'Js' => 'Jquery');
	var $components = array ('Auth','Session');
        

	function beforeFilter(){
		$this->Auth->authError = "<strong class='title_erreur'>Erreur</strong><div class='message_texte'>Vous n'avez pas l'autorisation de consulter cette page ou votre session a expiré !</div>";
		$this->Auth->loginError = "<strong class='title_erreur'>Erreur</strong><div class='message_texte'>Les identifiants saisis sont incorrects !</div>";
		$this->Auth->logoutRedirect = array('controller'=>'users', 'action'=>'login');
	}

}

?>