<?php
$this->set('title_for_layout', '[Erreur] Contrôleur manquant !');
?>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('%s n\'a pas été trouvé.', true), '<em>' . $controller . '</em>'); ?>
</p>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('Créez la classe %s ci-dessous dans le fichier : %s', true), '<em>' . $controller . '</em>', APP_DIR . DS . 'controllers' . DS . Inflector::underscore($controller) . '.php'); ?>
</p>
<pre>
&lt;?php
class <?php echo $controller;?> extends AppController {

	var $name = '<?php echo $controllerName;?>';
}
?&gt;
</pre>