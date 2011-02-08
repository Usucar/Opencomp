<?php
$this->set('title_for_layout', '[Erreur] Vue manquante !');
?>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('La vue pour %1$s%2$s n\'a pas été trouvée.', true), '<em>' . $controller . 'Controller::</em>', '<em>' . $action . '()</em>'); ?>
</p>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('Créez le fichier : %s', true), $file); ?>
</p>