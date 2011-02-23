<div class="classrooms view">
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classroom['Classroom']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classroom['Classroom']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classroom['Classroom']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div id="menu">
	<h3><?php __('Opérations sur cette classe'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editer cette classe', true), array('action' => 'edit', $classroom['Classroom']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Supprimer cette classe', true), array('action' => 'delete', $classroom['Classroom']['id']), null, sprintf(__('Êtes vous sûr de vouloir supprimer # %s?', true), $classroom['Classroom']['id'])); ?> </li>
        </ul>        
        <h3><?php __('Gérer les classes'); ?></h3>
	<ul>
                <li><?php echo $this->Html->link(__('Lister les classes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nouvelle classe', true), array('action' => 'add')); ?> </li>
        </ul>        
        <h3><?php __('Gérer les élèves'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lister les élèves', true), array('controller' => 'pupils', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nouvel élève', true), array('controller' => 'pupils', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<?php if (!empty($classroom['Pupil'])):?>
        <h3><?php __('Eleves appartenant à cette classe');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Nom'); ?></th>
		<th><?php __('Prénom','Prenom'); ?></th>
		<th><?php __('Sexe'); ?></th>
		<th><?php __('Date de naissance','Date-de-naissance'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($classroom['Pupil'] as $pupil):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pupil['nom'];?></td>
			<td><?php echo $pupil['prenom'];?></td>
			<td><?php echo $pupil['sexe'];?></td>
			<td><?php echo $pupil['date-de-naissance'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Voir', true), array('controller' => 'pupils', 'action' => 'view', $pupil['id'])); ?>
				<?php echo $this->Html->link(__('Editer', true), array('controller' => 'pupils', 'action' => 'edit', $pupil['id'])); ?>
				<?php echo $this->Html->link(__('Supprimer', true), array('controller' => 'pupils', 'action' => 'delete', $pupil['id']), null, sprintf(__('Êtes vous sûr de vouloir supprimer # %s?', true), $pupil['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
