<?php

$id = $data['Competence']['id'];
?>
<?php e($data['Competence']['libelle']); ?> 
<?php e($html->image('up.png', array(
            'alt' => 'Monter',
            'url' => array('action' => 'move_up',$id)))); ?>&nbsp;
<?php e($html->image('down.png', array(
            'alt' => 'Descendre',
            'url' => array('action' => 'move_down',$id)))); ?>&nbsp;
<?php e($html->image('edit.png', array(
            'alt' => 'Modifier',
            'url' => array('action' => 'edit',$id)))); ?>&nbsp;
<?php e($html->image('delete.png', array(
            'onclick' => 'return confirm(\'Voulez vous vraiment supprimer cette catégorie de compétence ?\');',
            'alt' => 'Supprimer',
            'url' => array('action' => 'delete',$id)))); ?>&nbsp;
<br />
<?php

/**
 * On récupère depuis competences_controller l'ensemble des catégories de
 * compétences avec les compétences qui leurs sont associées sous forme de
 * tableau imbriqués.
 */

//debug($items);

if (isset ($items[$id]))
{
    echo '<ul class="sortable">';
    foreach ($items[$id] as $competence => $type)
    {
        switch ($type)
        {
            case 1:
            echo '<li>'.$competence.' (Instructions officielles)</li>';
            break;

            case 2:
            echo '<li>'.$competence.' (Compétence établissement)</li>';
            break;

            case 3:
            echo '<li>'.$competence.' (Compétence enseignant)</li>';
            break;

            default:
            echo '<li>'.$competence.'</li>';
        }
    }
    echo '</ul>';
}

?>