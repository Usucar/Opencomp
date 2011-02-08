<div class="pupils index">
	<h2><?php __('Pupils');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('nom');?></th>
			<th><?php echo $this->Paginator->sort('prenom');?></th>
			<th><?php echo $this->Paginator->sort('sexe');?></th>
			<th><?php echo $this->Paginator->sort('date-de-naissance');?></th>
			<th><?php echo $this->Paginator->sort('classroom_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($pupils as $pupil):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $pupil['Pupil']['id']; ?>&nbsp;</td>
		<td><?php echo $pupil['Pupil']['nom']; ?>&nbsp;</td>
		<td><?php echo $pupil['Pupil']['prenom']; ?>&nbsp;</td>
		<td><?php echo $pupil['Pupil']['sexe']; ?>&nbsp;</td>
		<td><?php echo $pupil['Pupil']['date-de-naissance']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pupil['Classroom']['title'], array('controller' => 'classrooms', 'action' => 'view', $pupil['Classroom']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $pupil['Pupil']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $pupil['Pupil']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $pupil['Pupil']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pupil['Pupil']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Pupil', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Classrooms', true), array('controller' => 'classrooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Classroom', true), array('controller' => 'classrooms', 'action' => 'add')); ?> </li>
	</ul>
</div>