<?php

$this->pageTitle = "Ajouter";

if(!empty($this->data['Category']['id'])) {
	$this->pageTitle = "Modifier";
};

$this->pageTitle .= " une catégorie";

e($form->create('Competence', array('action' => 'edit')));
e($form->input('id'));
?>

<fieldset>
	<legend><?php e($this->pageTitle); ?></legend>

	<?php
	e($form->input('parent_id', array('label' => "Parent :", 'empty' => "Racine")));
	e($form->input('libelle', array('label' => "Nom de la catégorie :", 'maxLength' => '')));
	?>
</fieldset>

<?php e($form->end('Valider')); ?>

<p><?php e($html->link("Liste des catégories", 'index')); ?></p>