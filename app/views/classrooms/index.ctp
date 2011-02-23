<div class="classrooms index">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Classe','title');?></th>
			<th><?php echo $this->Paginator->sort('Date de création','created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($classrooms as $classroom):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $classroom['Classroom']['title']; ?>&nbsp;</td>
		<td><?php echo $classroom['Classroom']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $classroom['Classroom']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $classroom['Classroom']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $classroom['Classroom']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $classroom['Classroom']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Classroom', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Pupils', true), array('controller' => 'pupils', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pupil', true), array('controller' => 'pupils', 'action' => 'add')); ?> </li>
	</ul>
</div>