<?php

echo $form->create('User',array(
    'url'=>array(
        'action'=>'edit'
        )
    )
);

echo $form->input('User.prenom', array('label'=>__('Prénom',true)));
echo $form->input('User.nom', array('label'=>__('Nom',true)));
echo $form->input('User.email', array('label'=>__('Adresse de courriel',true)));
echo $form->input('User.username', array('label'=>__('Nom d\'utilisateur',true)));

?>

<div class="input password required">
    <label for="UserPasswrd">Mot de passe</label>
    <input id="UserPasswrd" type="password" name="data[User][passwrd]">
    <?php
        //Si la personne modifie actuellement un utilisateur existant,
        //on indique la marche à suivre pour ne pas modifier le mot de passe.
        if (!empty($this->data['User']['id']))
        {
            echo $html->div('info-message', __('Pour conserver le mot de passe actuel, laissez les champs blancs',true));
        }
    ?>
</div>

<?php

echo $form->input('User.passwrd2', array('label'=>__('Confirmez le mot de passe',true), 'type'=>'password'));
echo $form->hidden('User.id');

$options=array('enseignant'=>__('Enseignant',true),'admin'=>__('Administrateur',true));
echo $form->input('User.role', array('label'=>__('Statut',true), 'options'=>$options));


echo $form->end(__('Envoyer',true));

?>
