<?php

class User extends AppModel{
	
	var $name="User";

        var $validate = array(
		'username' => array(
			'rule' => array('minLength', 1),
                        'message' => 'Taille minimum de 1 caractère'
		),
                'passwrd' => array(
			'rule' => array('minLength', 6),
                        'required' => true,
                        'allowEmpty' => true,
                        'on'=>'update',
                        'message' => 'Ce champ est requis !'
		),
                'passwrd' => array(
			'rule' => array('minLength', 6),
                        'required' => true,
                        'allowEmpty' => false,
                        'on'=>'create',
                        'message' => 'Ce champ est requis !'
		),
                'passwrd2' => array(
			'rule' => 'checkPasswords',
                        'message' => 'Les mots de passe ne correspondent pas !'
		)               
	);

        function checkPasswords($data)
        {
            if ($this->data[$this->name]['passwrd'] == $this->data[$this->name]['passwrd2'])
                return true;
            else
                return false;
        }

        function beforeSave()
        {        
            // On indique que passwrd correspond en fait à password.
            $this->data[$this->alias]['password'] = $this->data[$this->alias]['passwrd'];

            // Si le champ password n'est pas vide, c'est qu'il a été modifié. Alors, on l'encrypte.
            if(!empty($this->data[$this->alias]['password']))
            {
                $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], null, true);
            }

            // Si on a récupéré un champ Id du formulaire, c'est que la personne est en train d'éditer un enregistrement.
            if (isset($this->data[$this->alias]['id']))
            {
                // Si le champ password n'a pas été complété, on fait en sorte de récupérer le hash à partir de la BDD
                if (empty($this->data[$this->alias]['password']))
                {
                    $utilisateur = $this->findById($this->data[$this->alias]['id']);
                    $passcrypte = $utilisateur[$this->alias]['password'];

                    $this->data[$this->alias]['password'] = $passcrypte;
                }
            }
            
        return true;
    }
}

?>