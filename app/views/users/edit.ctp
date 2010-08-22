<?php

echo $form->create('User',array(
    'url'=>array(
        'action'=>'edit'
        )
    )
);

echo $form->input('User.prenom', array('label'=>'Prénom'));
echo $form->input('User.nom', array('label'=>'Nom'));
echo $form->input('User.email', array('label'=>'Adresse de courriel'));
echo $form->input('User.username', array('label'=>'Nom d\'utilisateur'));

if (!empty($this->data['User']['id']))
{
    echo '{i} Pour ne pas modifier le mot de passe, laissez les champs blancs';
}

echo $form->input('User.passwrd', array('label'=>'Mot de passe', 'type'=>'password'));
echo $form->input('User.passwrd2', array('label'=>'Mot de passe', 'type'=>'password'));
echo $form->hidden('User.id');

$options=array('enseignant'=>'Enseignant','admin'=>'Administrateur');
echo $form->input('User.role', array('label'=>'Statut', 'options'=>$options));


echo $form->end('Envoyer');

?>
