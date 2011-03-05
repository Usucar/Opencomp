<?php

echo $form->create('User', array('url'=>array('action'=>'login')));
echo $form->input('username',array('label' => 'Identifiant'));
echo $form->input('password',array('label' => 'Mot de passe'));
echo $form->end('Se connecter');

?>