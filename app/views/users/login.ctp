<?php

echo $form->create('User', array('url'=>array('action'=>'login')));
echo $form->input('username',array('label' => __('Identifiant',true)));
echo $form->input('password',array('label' => __('Mot de passe',true)));
echo $form->end(__('Se connecter',true));

?>