<h1>Liste des utilisateurs</h1>

<?php

foreach($listedesutilisateurs as $enregistrementutilisateur){
	echo "<p>".$enregistrementutilisateur['Utilisateur']['prenom']." ".$enregistrementutilisateur['Utilisateur']['nom']."</p>" ;
}
?>