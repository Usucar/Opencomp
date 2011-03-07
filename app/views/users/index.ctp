<?php echo $html->link(__('Ajouter un utilisateur',true),array('controller'=>'users', 'action'=>'edit')); ?>

<?php

echo '<p>'.$paginator->numbers().'</p>';

echo '<table>';

echo $html->tableHeaders(array(
    $paginator->sort(__('Prénom',true), 'User.prenom'),
    $paginator->sort(__('Nom',true), 'User.nom'),
    $paginator->sort(__('Identifiant',true), 'User.username'),
    $paginator->sort(__('Adresse de courriel',true), 'User.email'),
    __('Modifier',true),
    __('Supprimer',true)));

foreach ($listedesutilisateurs as $lstusr){
    
    $prenom = $lstusr['User']['prenom'];
    $nom = $lstusr['User']['nom'];
    $username = $lstusr['User']['username'];
    $email = $lstusr['User']['email'];
    $id = $lstusr['User']['id'];

    echo $html->tableCells(array(
    array($prenom, $nom, $username, $email,
        $this->Html->link(
            $this->Html->image("user_edit.png", array("alt" => __('Editer',true).' '.$prenom.' '.$nom)), 
            array(
                'controller' => 'users',
                'action' => 'edit',
                $id
                ),
            array('escape'=>false)),
        
        $this->Html->link(
            $this->Html->image("user_delete.png", array("alt" => __('Supprimer',true).' '.$prenom.' '.$nom)), 
            array(
                'controller' => 'users',
                'action' => 'delete',
                $id
                ),
            array('escape'=>false),
            __('Êtes-vous sûr de vouloir supprimer',true).' '.$prenom.' '.$nom)
    ),
    ));
}

echo '</table>';

?>
