<?php

$id = $data['Competence']['id'];
?>
<?php e($data['Competence']['libelle']); ?> <?php e($html->link('Monter', 'move_up/'.$id)); ?>&nbsp;
<?php e($html->link('Descendre', 'move_down/'.$id)); ?>&nbsp;
<?php e($html->link("Modifier", 'edit/'.$id)); ?>&nbsp;
<?php e($html->link("Supprimer", 'delete/'.$id, null, "Etes-vous sûr ?")); ?>&nbsp;
<br />
<?php
foreach ($items as $i){
    if ($i['Items']['id-competence'] == $id)
    {
        echo $i['Items']['intitule'];
    }
}
?>