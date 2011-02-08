<div class="pupils form">
<?php echo $this->Form->create('Pupil');?>
	<fieldset>
 		<legend><?php __('Edit Pupil'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nom');
		echo $this->Form->input('prenom');
		echo $this->Form->input('sexe');
		echo $this->Form->input('date-de-naissance');
		echo $this->Form->input('classroom_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Pupil.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Pupil.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pupils', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Classrooms', true), array('controller' => 'classrooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classroom', true), array('controller' => 'classrooms', 'action' => 'add')); ?> </li>
	</ul>
</div>