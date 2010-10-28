<?php

class Competence extends AppModel
{
	var $displayField = 'libelle';

	var $hasMany = array('Item');        

	var $actsAs = array('Tree');

	var $validate = array(
		'libelle' => array(
			'rule'       => '/\S+/',
			'required'   => true,
			'allowEmpty' => false,
			'message'    => "Le libellé de la catégorie doit être renseigné."
		),
		'parent_id' => array(
			'rule'    => 'checkParadox',
			'on'      => 'update',
			'message' => "Une catégorie ne peut pas devenir sa propre fille !"
		)
	);

	/**
	 * Retourne faux si l'id est égal au nouvel id parent
	 *
	 * @param array $data Données à valider, en provenance du formulaire.
	 * @return boolean Faux si id == parent_id, vrai sinon.
	 */
	function checkParadox($data)
	{
		if(isset($this->data[$this->alias]['id']))
		{
			return $data['parent_id'] != $this->data[$this->alias]['id'];
		}
		return true;
	}
}

?>