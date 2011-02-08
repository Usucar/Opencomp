<?php
$this->set('title_for_layout', '[Erreur] Méthode manquante !');
?>
<h2><?php printf(__('Méthode manquante dans %s', true), $controller); ?></h2>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('L\'action %1$s n\'est pas définie dans le contrôleur %2$s', true), '<em>' . $action . '</em>', '<em>' . $controller . '</em>'); ?>
</p>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('Créez %1$s%2$s dans le fichier : %3$s.', true), '<em>' . $controller . '::</em>', '<em>' . $action . '()</em>', APP_DIR . DS . 'controllers' . DS . Inflector::underscore($controller) . '.php'); ?>
</p>
<pre>
&lt;?php
class <?php echo $controller;?> extends AppController {

	var $name = '<?php echo $controllerName;?>';

<strong>
	function <?php echo $action;?>() {

	}
</strong>
}
?&gt;
</pre>