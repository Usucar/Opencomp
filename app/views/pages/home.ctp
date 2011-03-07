<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if (Configure::read() == 0):
	$this->cakeError('error404');
endif;
?>
<h2><?php echo sprintf(__('Notes de version de CakePHP %s.', true), Configure::version()); ?></h2>
<a href="http://cakephp.org/changelogs/1.3.7"><?php __('Lire les notes de version'); ?> </a>
<?php
if (Configure::read() > 0):
	Debugger::checkSecurityKeys();
endif;
?>
<p>
	<?php
		if (is_writable(TMP)):
			echo '<span class="notice success">';
				__('Votre répertoire tmp est inscriptible.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				__('Votre répertoire tmp N\'EST PAS inscriptible.');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$settings = Cache::settings();
		if (!empty($settings)):
			echo '<span class="notice success">';
					printf(__('Le %s est utilisé pour la mise en cache. Pour changer la configuration, modifier APP/config/core.php ', true), '<em>'. $settings['engine'] . 'Engine</em>');
			echo '</span>';
		else:
			echo '<span class="notice">';
					__('Votre cache ne fonctionne PAS. Vérifier les paramètres dans APP/config/core.php');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$filePresent = null;
		if (file_exists(CONFIGS.'database.php')):
			echo '<span class="notice success">';
				__('Votre fichier de configuration de la base de donnée est présent.');
				$filePresent = true;
			echo '</span>';
		else:
			echo '<span class="notice">';
				__('Votre fichier de configuration de la base de donnée N\'EST PAS présent.');
				echo '<br/>';
				__('Renommez config/database.php.default vers config/database.php');
			echo '</span>';
		endif;
	?>
</p>
<?php
if (isset($filePresent)):
	if (!class_exists('ConnectionManager')) {
		require LIBS . 'model' . DS . 'connection_manager.php';
	}
	$db = ConnectionManager::getInstance();
	@$connected = $db->getDataSource('default');
?>
<p>
	<?php
		if ($connected->isConnected()):
			echo '<span class="notice success">';
	 			__('Cake est en mesure de se connecter à la base de données.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				__('Cake N\'EST PAS en mesure de se connecter à la base de données.');
			echo '</span>';
		endif;
	?>
</p>
<?php endif;?>

<h3><?php __('Pour commencer'); ?></h3>
<p>
	<?php
		echo $this->Html->link(
			__('Documentation CakePHP 1.3', true),
			'http://book.cakephp.org/fr',
			array('target' => '_blank', 'escape' => false)
		);
	?>
</p>
<p>
	<?php
		echo $this->Html->link(
			__('Le tutoriel du blog en 15 minutes', true),
			'http://book.cakephp.org/fr/view/1528/Le-tutoriel-du-blog-CakePHP',
			array('target' => '_blank', 'escape' => false)
		);
	?>
</p>
<p>
	<?php
		echo $this->Html->link(
			__('[Grafikart.fr] Un ensemble de tutoriels concernant CakePHP réalisés par un développeur Freelance', true),
			'http://www.grafikart.fr/tutoriels/category/cakephp',
			array('target' => '_blank', 'escape' => false)
		);
	?>
</p>

<h3><?php __('En savoir plus à propos de Cake'); ?></h3>
<p>
<?php __('CakePHP est un framework de développement rapide pour PHP qui fournit une architecture extensible pour développer, maintenir et déployer des applications. Utilisant des motifs de conception bien connus tels MVC et ORM ainsi que le paradigme "convention plutôt que configuration", CakePHP réduit les coûts de développement et aide les développeurs à écrire moins de code.'); ?>
</p>
<p>
<?php __('Notre but premier est de fournir un framework structuré qui permette aux utilisateurs PHP de tous niveaux de développer rapidement des applications web robustes, sans perdre en flexibilité.'); ?>
</p>