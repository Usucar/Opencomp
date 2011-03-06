<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>		
		<?php echo 'Opencomp | '.$title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
                echo $this->Html->css('opencomp.generic');
		echo $this->Html->css('cake.auth');
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
			<div id="content">
                            
                            <div id="logo"><h1>Opencomp</h1></div>

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $content_for_layout; ?>
			

		</div>
		<div id="baspage">
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>