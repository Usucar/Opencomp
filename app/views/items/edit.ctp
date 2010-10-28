<?php
e($form->create('Item', array('action' => 'edit')));
e($form->input('id'));
e($form->select('competence_id', $competences, null, null, false));
e($form->input('intitule', array('label' => "Intitulé de la compétence :", 'maxLength' => '')));
e($form->end('Valider'));
?>
