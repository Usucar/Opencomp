<?php

/*
 * ========================================================================
 * Copyright (C) 2010 Traullé Jean
 *
 * This file is part of Opencomp.
 *
 * Opencomp is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Opencomp. If not, see <http://www.gnu.org/licenses/>
 * ========================================================================
 */

require_once("../core/init.php");
require_once("../core/class/Form.class.php");

$extrajavascript = <<<extrajavascript
<script type='text/javascript'>

			function MajusculeEnDebutDeChaine(Obj){
				chaine=Obj.value
					Obj.value=chaine.substr(0,1).toUpperCase()+	chaine.substr(1,chaine.length).toLowerCase()}

		</script>
extrajavascript;

printHead('Gérer l\'équipe éducative', 'admin', 'extrajavascript', $dbprefixe, $bdd);


/******************************************************************
 * Si l'utilisateur a demandé gerer-equipe.php?ajouter_enseignant *
 *****************************************************************/

if (isset($_GET['ajouter_enseignant']))
{
    ?>

    <h3>Ajouter des enseignants à l'équipe éducative</h3>

    <p>Saisissez les informations concernant l'enseignant que vous souhaitez ajouter à l'équipe éducative.</p>

    <?php
    
    $ajouter_enseignant = new Form('gerer-equipe2.php?ajouter_enseignant');

    $ajouter_enseignant->input_text('nom', 'Nom : ', 'alpha_avec_accent', 'OnKeyUp="javascript:this.value=this.value.toUpperCase();"', '', '2', '50');
    $ajouter_enseignant->input_text('prenom', 'Prénom : ', 'alpha_avec_accent', 'OnKeyUp="MajusculeEnDebutDeChaine(this)"', '', '2', '50');
    $ajouter_enseignant->input_text('email', 'Email : ', 'email', '', '', '5', '100');
    $ajouter_enseignant->input_text('identifiant', 'Identifiant : ', 'alpha', '', '', '7', '25');
    $ajouter_enseignant->input_password('motdepasse', 'Mot de passe : ', '7', '25');
    $ajouter_enseignant->verification_input_password('motdepasse2', 'Confirmer le mot de passe : ', 'motdepasse');

    $ajouter_enseignant->submit('Ajouter cet enseignant');

    echo $ajouter_enseignant->getsecuredata('nom');

    if (isset($_POST['submit']) && !$ajouter_enseignant->iserrors())
    {
        //Attention, il faut penser à vérifier que l'utilisateur n'existe pas déjà dans la BDD !!

        //On définit un grain de sel pour l'utilisateur aléatoirement et on hâche le mot de passe.
        $graindesel = rand();
        $hashmotdepasse = sha1(($_POST['data_motdepasse']).$graindesel);

        $nom = $ajouter_enseignant->getsecuredata('nom');
        $prenom = $ajouter_enseignant->getsecuredata('prenom');
        $identifiant = $ajouter_enseignant->getsecuredata('identifiant');
        $email = $ajouter_enseignant->getsecuredata('email');

        //On ajoute le nouvel utilisateur à la BDD

        $bdd->exec("INSERT INTO ".$dbprefixe."enseignant (nom, prenom, identifiant, mot_de_passe, email, salt) VALUES ('$nom', '$prenom', '$identifiant', '$hashmotdepasse', '$email', '$graindesel');");

        $_SESSION['success'][] = 'L\'enseignant a été ajouté avec succès.';
        header('Location: gerer-equipe2.php');
    }

    $ajouter_enseignant->afficher_formulaire();  

}


/*******************************************************************
 * Si l'utilisateur a demandé gerer-equipe.php?modifier_enseignant *
 ******************************************************************/
elseif(isset($_GET['modifier_enseignant']))
{
	$requete = $bdd->query("SELECT * FROM " . $dbprefixe ."enseignant WHERE id=".$_GET['id']); // Requête SQL
	$resultat = $requete->fetch();

	if ($_GET['id']==1)
	{
		$_SESSION['error'][] = 'Il est impossible de modifier l\'administrateur !';
		header('Location: gerer-equipe.php');
        }

	if ($requete->rowCount() < 1)
	{
		$_SESSION['error'][] = 'L\'enseignant que vous souhaitez modifier n\'existe pas !';
		header('Location: gerer-equipe.php');
	}

	else
	{
		if ( (!empty ( $_POST['nom'] )) && (!empty ( $_POST['prenom'] )) && (!empty ( $_POST['identifiant'] )) && (!empty ( $_POST['email'] )) && (VerifierAdresseMail($_POST['email'])==1) )
		{
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$identifiant = $_POST['identifiant'];
			$email = $_POST['email'];

			// On met à jour l'utilisateur dans la BDD

			$id = $_GET['id'];
			$bdd->exec("UPDATE ".$dbprefixe."enseignant SET nom='$nom', prenom='$prenom', identifiant='$identifiant', email='$email' WHERE id='$id'");

			$_SESSION['success'][] = 'L\'enseignant a été mis à jour avec succès !';
			header('Location: gerer-equipe.php');
		}
		?>
		
			<h3>Modifier les informations concernant <?php echo $resultat['prenom'].' '.$resultat['nom']; ?></h3>
			<form method="post" id="form_ajouter_enseignant" action="gerer-equipe.php?modifier_enseignant&id=<?php echo $_GET['id']; ?>">
				<table>
					<tr>
						<td style="text-align:right;"><label for="nom">Nom :</label></td>
						<td><input type="text" size="25" name="nom" id="nom" value="<?php echo $resultat['nom']; ?>" style="border:1px solid #cacaca; " OnKeyUp="javascript:this.value=this.value.toUpperCase();" /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="prenom">Prénom :</label></td>
						<td><input type="text" size="25" name="prenom" id="prenom" value="<?php echo $resultat['prenom']; ?>" style="border:1px solid #cacaca;" OnKeyUp="MajusculeEnDebutDeChaine(this)" /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="pseudo">Email :</label><br /><br /></td>
						<td><input type="text" size="37" name="email" id="email" value="<?php echo $resultat['email']; ?>" style="border:1px solid #cacaca;" /><br /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="identifiant">Identifiant :</label></td>
						<td><input type="text" name="identifiant" id="identifiant" value="<?php echo $resultat['identifiant']; ?>" style="border:1px solid #cacaca;" /></td>
					</tr>
				</table>
				<input type="submit" id="modifier_un_enseignant" name="modifier_un_enseignant" value="Modifier cet enseignant" style="margin-top:15px; margin-bottom:15px;"/>
			</form>
		<?php

		echo '<pre>';
		print_r ($resultat);
		echo '</pre>';
	}


}

elseif(isset($_GET['supprimer_enseignant']))
{
	echo'On fait ce qu\'il faut pour supprimer le membre demandé !';
}

//Si aucun paramètre n'a été passé dans l'URL, alors on affiche la liste des enseignants.
else
{
	echo '<input type="button" value="Ajouter des enseignants" title="Ajouter des enseignants" class="ajouter" onclick="window.location=\'gerer-equipe.php?ajouter_enseignant\';"></input><p></p>';
	$requete = $bdd->query("SELECT * FROM " . $dbprefixe ."enseignant ORDER BY nom, prenom ASC"); // Requête SQL

	echo '<table style="width: 100%; border-collapse: collapse; border:1px solid black;">
				<tr style="background-color:#E6E6E6; border:1px solid black; height:30px; font-variant:small-caps;">
					<th style="border:1px solid black;">Prénom</th>
					<th style="border:1px solid black;">Nom</th>
					<th style="border:1px solid black;">Identifiant</th>
					<th style="border:1px solid black;">Courriel</th>
					<th style="border:1px solid black;">Actions</th>
				</tr>';
	while ($donnees = $requete->fetch())
	{
		echo '<tr><td style="border-right:1px solid black; padding:5px;">' . $donnees['prenom'] . '</td>';
		echo '<td style="border-right:1px solid black; padding:5px;">' . $donnees['nom'] . '</td>';
		echo '<td style="border-right:1px solid black; padding:5px;">' . $donnees['identifiant'] . '</td>';
		echo '<td style="border-right:1px solid black; padding:5px;">' . $donnees['email'] . '</td>';
		echo '<td width=200px; style="border-right:1px solid black; padding:5px;"><center><a href=gerer-equipe.php?modifier_enseignant&id=' . $donnees['id'] . '><img style="border:0px;" src="../style/img/user_edit.png"> Modifier</a> <a id="suppr'.$donnees['id'].'" href=gerer-equipe.php?supprimer_enseignant&id=' . $donnees['id'] . ' onclick="this.blur(); Modalbox.show($(\'attention'.$donnees['id'].'\'), {title: \'Êtes vous sûr(e) ?\', width: 600}); return false;"><img style="border:0px;" src="../style/img/user_delete.png"> Supprimer</a></td></tr></center>';	
		echo '<div id="attention'.$donnees['id'].'" style="display:none;"><p>Souhaitez vous réellement supprimer '.$donnees['prenom'].' '.$donnees['nom'].' ?</p><p class="bottomform" style="margin-left:0px; margin-right:0px;"><input type="button" value="Confirmer la suppression" onclick="window.location=\'gerer-equipe.php?supprimer_enseignant&id='.$donnees['id'].'\';" /> <input type=\'button\' value=\'Annuler\' onclick=\'Modalbox.hide()\' /></p></div>';
	}
		echo '</table></ br></ br>';
}

printFooter($bdd);

?>
