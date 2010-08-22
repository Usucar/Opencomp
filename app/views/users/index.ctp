<h1>Liste des utilisateurs</h1>

<?php echo $html->link('Ajouter un utilisateur',array('controller'=>'users', 'action'=>'edit')); ?>

<?php

echo '<p>'.$paginator->numbers().'</p><ul>';

echo 'Vous êtes connecté en tant que '.$session->read('Auth.User.username');

echo '<table>';

echo $html->tableHeaders(array(
    $paginator->sort('Prénom', 'User.prenom'),
    $paginator->sort('Nom', 'User.nom'),
    $paginator->sort('Identifiant', 'User.username'),
    $paginator->sort('Adresse de courriel', 'User.email'),
    'Modifier',
    'Supprimer'));

foreach ($listedesutilisateurs as $lstusr){
    
    $prenom = $lstusr['User']['prenom'];
    $nom = $lstusr['User']['nom'];
    $username = $lstusr['User']['username'];
    $email = $lstusr['User']['email'];
    $id = $lstusr['User']['id'];

    echo $html->tableCells(array(
    array($prenom, $nom, $username, $email,
        $html->image('user_edit.png', array(
            'alt' => 'Editer '.$prenom.' '.$nom,
            'url' => array('action' => 'edit',$id))),

        $html->image('user_delete.png', array(
            'onclick' => 'return confirm(\'Voulez vous vraiment supprimer cet utilisateur ?\');',
            'alt' => 'Supprimer '.$prenom.' '.$nom,
            'url' => array('action' => 'delete',$id)))
    ),
    ));
}

echo '</table>';

?>
