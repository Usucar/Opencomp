<?php

e($form->create('Competence', array('action' => 'edit')));
e($form->input('id'));
?>

<fieldset>
	<legend><?php e($title_for_layout); ?></legend>

	<?php
	e($form->input('parent_id', array('label' => __('Catégorie parente',true), 'empty' => __('Racine',true))));
	e($form->input('libelle', array('label' => __('Nom de la catégorie',true), 'maxLength' => '')));
	?>
</fieldset>

<?php e($form->end(__('Valider',true))); ?>

<p><?php e($html->link(__('Afficher la liste des catégories',true), 'index')); ?></p>