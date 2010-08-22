<?php

class UtilisateursController extends AppController{
	
	var $name = 'Utilisateurs';
	
	function index(){
	
	$listedesutilisateurs = $this->Utilisateur->find('all',array(
			'fields'=> array ('nom','prenom')
		));
		$this->set('listedesutilisateurs', $listedesutilisateurs);
		}
	
	}

?>