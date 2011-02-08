<?php
$this->set('title_for_layout', '[Erreur] Table manquante dans la base de données !');
?>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('La table %1$s pour le modèle %2$s n\'a pas été trouvée dans la base de données.', true), '<em>' . $table . '</em>',  '<em>' . $model . '</em>'); ?>
</p>