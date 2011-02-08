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

?>

<div class="input password required">
    <label for="UserPasswrd">Mot de passe</label>
    <input id="UserPasswrd" type="password" name="data[User][passwrd]">
    <?php
        //Si la personne modifie actuellement un utilisateur existant,
        //on indique la marche à suivre pour ne pas modifier le mot de passe.
        if (!empty($this->data['User']['id']))
        {
            echo $html->div('info-message', 'Pour conserver le mot de passe actuel, laissez les champs blancs');
        }
    ?>
</div>

<?php

echo $form->input('User.passwrd2', array('label'=>'Confirmez le mot de passe', 'type'=>'password'));
echo $form->hidden('User.id');

$options=array('enseignant'=>'Enseignant','admin'=>'Administrateur');
echo $form->input('User.role', array('label'=>'Statut', 'options'=>$options));


echo $form->end('Envoyer');

?>
