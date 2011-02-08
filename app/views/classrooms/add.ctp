<div class="classrooms form">
<?php echo $this->Form->create('Classroom');?>
	<fieldset>
 		<legend><?php __('Add Classroom'); ?></legend>
	<?php
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Classrooms', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Pupils', true), array('controller' => 'pupils', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pupil', true), array('controller' => 'pupils', 'action' => 'add')); ?> </li>
	</ul>
</div>