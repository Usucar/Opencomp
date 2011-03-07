<?php

$id = $data['Competence']['id'];
?>
<?php e($data['Competence']['libelle']); ?> 
<?php e($html->image('up.png', array(
            'alt' => __('Monter',true),
            'url' => array('action' => 'move_up',$id)))); ?>&nbsp;
<?php e($html->image('down.png', array(
            'alt' => __('Descendre',true),
            'url' => array('action' => 'move_down',$id)))); ?>&nbsp;
<?php e($html->image('edit.png', array(
            'alt' => __('Modifier',true),
            'url' => array('action' => 'edit',$id)))); ?>&nbsp;
<?php e($html->image('delete.png', array(
            'onclick' => 'return confirm(\'Voulez vous vraiment supprimer cette catégorie de compétence ?\');',
            'alt' => __('Supprimer',true),
            'url' => array('action' => 'delete',$id)))); ?>&nbsp;
<br />
<?php

/**
 * On récupère depuis competences_controller l'ensemble des catégories de
 * compétences avec les compétences qui leurs sont associées sous forme de
 * tableau imbriqués.
 */

if (isset ($itemsType[$id]))
{
    echo '<div class="maj"></div>';
    echo '<ul class="sortable">';
    foreach ($itemsType[$id] as $competence => $type)
    {
        switch ($type)
        {
            case 1:
            echo '<li id ="item_'.$itemsPlace[$id][$competence].'">'.$competence.' '.__('Instructions officielles',true).'</li>';
            break;

            case 2:
            echo '<li id ="item_'.$itemsPlace[$id][$competence].'">'.$competence.' '.__('Item établissement',true).'</li>';
            break;

            case 3:
            echo '<li id ="item_'.$itemsPlace[$id][$competence].'">'.$competence.' '.__('Item enseignant',true).'</li>';
            break;

            default:
            echo '<li id ="item_'.$itemsPlace[$id][$competence].'">'.$competence.'</li>';
        }
    }
    echo '</ul>';
    echo '<form action="" method="post">'; 
    echo '<input type="hidden" name="sortable" />';
    echo '</form>';
}

?>