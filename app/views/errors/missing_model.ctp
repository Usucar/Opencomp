<?php
$this->set('title_for_layout', '[Erreur] Modèle manquant !');
?>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('<em>%s</em> n\'a pas été trouvé.', true), $model); ?>
</p>
<p class="error">
	<strong><?php __('Erreur'); ?> : </strong>
	<?php printf(__('Créez la classe %s dans le fichier : %s', true), '<em>' . $model . '</em>', APP_DIR . DS . 'models' . DS . Inflector::underscore($model) . '.php'); ?>
</p>
<pre>
&lt;?php
class <?php echo $model;?> extends AppModel {

	var $name = '<?php echo $model;?>';

}
?&gt;
</pre>