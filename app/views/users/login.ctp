<?php

echo $form->create('User', array('url'=>array('action'=>'login')));
echo $form->input('username');
echo $form->input('password');
echo $form->end('M\'identifier');

?>