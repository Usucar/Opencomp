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

$extrajavascript = <<<extrajavascript
<script type='text/javascript'>

			function MajusculeEnDebutDeChaine(Obj){
				chaine=Obj.value
					Obj.value=chaine.substr(0,1).toUpperCase()+	chaine.substr(1,chaine.length).toLowerCase()}

			var check1;
				window.onload = function()
				{
					check1 = new CheckForm("form_ajouter_enseignant");
					check1.addReg("nom","text","alpha","blur","Vous devez compléter ce champ avec des lettres",[1,20]);
					check1.addReg("prenom","text","alpha","blur","Vous devez compléter ce champ avec des lettres",[1,20]);
					check1.addReg("email","text","email","blur","Vous devez inscrire une adresse de type adresse@fournisseur.tld",[1,50]);
					check1.addReg("identifiant","text","alphanum","blur","Vous devez compléter ce champ avec des chiffres et des lettres",[1,20]);
					check1.addReg("motdepasse","password","required","blur","Vous devez compléter ce champ au moins 5 caractères",[5,20]);
					check1.addReg("motdepasse2","password","required","blur","Les mots de passe ne correspondent pas",'','',['motdepasse']);
				}


 			</script>
extrajavascript;

printHead('Gérer l\'équipe éducative', 'admin', 'extrajavascript', $dbprefixe);

?>

<?php
/******************************************************************
 * Si l'utilisateur a demandé gerer-equipe.php?ajouter_enseignant *
 *****************************************************************/

if (isset($_GET['ajouter_enseignant']))
{		
	if (isset ( $_POST['ajouter_un_enseignant'] ))	
	{	
		$_SESSION['donneessaisies'] = $_POST;
		$donneessaisies = $_SESSION['donneessaisies'];
		
		function VerifierAdresseMail($adresse)
		{
		   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
		   if(preg_match($Syntaxe,$adresse))
			  return true;
		   else
			 return false;
		}
		
		if ( (!empty ( $_POST['nom'] )) && (!empty ( $_POST['prenom'] )) && (!empty ( $_POST['motdepasse'] )) && (!empty ( $_POST['identifiant'] )) && (!empty ( $_POST['email'] )) && ($_POST['motdepasse'] == $_POST['motdepasse2']) && (VerifierAdresseMail($_POST['email'])==1) )
		{
			//On définit un grain de sel pour l'utilisateur aléatoirement et on hâche le mot de passe.
			$graindesel = rand();
			$hashmotdepasse = sha1(mysql_real_escape_string($_POST['motdepasse']).$graindesel);

			$nom = mysql_real_escape_string($_POST['nom']);
			$prenom = mysql_real_escape_string($_POST['prenom']);
			$identifiant = mysql_real_escape_string($_POST['identifiant']);
			$email = mysql_real_escape_string($_POST['email']);

			//On ajoute le nouvel utilisateur à la BDD
			
			mysql_query("INSERT INTO ".$dbprefixe."enseignant (nom, prenom, identifiant, mot_de_passe, email, salt) VALUES ('$nom', '$prenom', '$identifiant', '$hashmotdepasse', '$email', '$graindesel');");
			
			echo 'L\'utilisateur a été correctement ajouté !';
		}
		else
		{
			/*echo '<pre>';
			print_r($donneessaisies);
			echo '</pre>';*/
			
			if ( (empty ( $_POST['nom'] )) OR (empty ( $_POST['prenom'] )) OR (empty ( $_POST['motdepasse'] )) OR (empty ( $_POST['identifiant'] )) OR (empty ( $_POST['email'] )) )
			{
				$remplirtousleschamps = 'Il est nécessaire de compéter tous les champs du formulaire <br />';
			}
			if ( ($_POST['motdepasse'] != $_POST['motdepasse2']) )
			{
				$correspondancemotdepasse = 'Les mots de passe saisis ne correspondent pas <br />';
			}
			if ( (VerifierAdresseMail($_POST['email'])!=1) )
			{
				$mailincorrect = 'L\'adresse de courriel saisie est incorrecte. <br />';
			}
			
			?>
				<h3>Ajouter des enseignants à l'équipe éducative</h3>
				
				<ul style="margin:0px; padding:0px;">
								
				<?php
				if (isset ($remplirtousleschamps))
				{
					echo '<li class="error">'.$remplirtousleschamps.'</li>';
				}
				if (isset ($correspondancemotdepasse))
				{
					echo '<li class="error">'.$correspondancemotdepasse.'</li>';
				}
				if (isset ($mailincorrect))
				{
					echo '<li class="error">'.$mailincorrect.'</li>';
				}
				?>
				</ul>
				
				<p>Saisissez les informations concernant l'enseignant que vous souhaitez ajouter à l'équipe éducative.</p>

				<form method="post" id="form_ajouter_enseignant" action="gerer-equipe.php?ajouter_enseignant">
				<table>
					<tr>
						<td style="text-align:right;"><label for="nom">Nom :</label></td>
						<td><input type="text" size="25" name="nom" id="nom" value="<?php echo $donneessaisies['nom']; ?>" style="border:1px solid #cacaca; " OnKeyUp="javascript:this.value=this.value.toUpperCase();" /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="prenom">Prénom :</label></td>
						<td><input type="text" size="25" name="prenom" id="prenom" value="<?php echo $donneessaisies['prenom']; ?>" style="border:1px solid #cacaca;" OnKeyUp="MajusculeEnDebutDeChaine(this)" /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="pseudo">Email :</label><br /><br /></td>
						<td><input type="text" size="37" name="email" id="email" value="<?php echo $donneessaisies['email']; ?>" style="border:1px solid #cacaca;" /><br /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="identifiant">Identifiant :</label></td>
						<td><input type="text" name="identifiant" id="identifiant" value="<?php echo $donneessaisies['identifiant']; ?>" style="border:1px solid #cacaca;" /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="motdepasse">Mot de passe :</label></td>
						<td><input type="password" name="motdepasse" id="motdepasse" style="border:1px solid #cacaca;" /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="motdepasse2">Confirmez le&nbsp;&nbsp;<br />mot de passe :</label></td>
						<td><input type="password" name="motdepasse2" id="motdepasse2" style="border:1px solid #cacaca;" /></td>
					</tr>
				</table>
				<input type="submit" id="ajouter_un_enseignant" name="ajouter_un_enseignant" value="Ajouter cet enseignant" style="margin-top:15px; margin-bottom:15px;"/>
				</form>
				<?php
		}
	}
	
	else
	{
				?>
				<h3>Ajouter des enseignants à l'équipe éducative</h3>
				<p>Saisissez les informations concernant l'enseignant que vous souhaitez ajouter à l'équipe éducative.</p>

				<form method="post" id="form_ajouter_enseignant" action="gerer-equipe.php?ajouter_enseignant">
				<table>
					<tr>
						<td style="text-align:right;"><label for="nom">Nom :</label></td>
						<td><input type="text" size="25" name="nom" id="nom" style="border:1px solid #cacaca; " OnKeyUp="javascript:this.value=this.value.toUpperCase();" /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="prenom">Prénom :</label></td>
						<td><input type="text" size="25" name="prenom" id="prenom" style="border:1px solid #cacaca;" OnKeyUp="MajusculeEnDebutDeChaine(this)" /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="pseudo">Email :</label><br /><br /></td>
						<td><input type="text" size="37" name="email" id="email" style="border:1px solid #cacaca;" /><br /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="identifiant">Identifiant :</label></td>
						<td><input type="text" name="identifiant" id="identifiant" style="border:1px solid #cacaca;" /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="motdepasse">Mot de passe :</label></td>
						<td><input type="password" name="motdepasse" id="motdepasse" style="border:1px solid #cacaca;" /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="motdepasse2">Confirmez le&nbsp;&nbsp;<br />mot de passe :</label></td>
						<td><input type="password" name="motdepasse2" id="motdepasse2" style="border:1px solid #cacaca;" /></td>
					</tr>
				</table>
				<input type="submit" id="ajouter_un_enseignant" name="ajouter_un_enseignant" value="Ajouter cet enseignant" style="margin-top:15px; margin-bottom:15px;"/>
				</form>
				<?php
	}
}

elseif(isset($_GET['modifier_enseignant']))
{	
	$requete = db_query("SELECT * FROM " . $dbprefixe ."enseignant WHERE id=".$_GET['id']); // Requête SQL
	$resultat = mysql_fetch_assoc($requete);
	
	if ($_GET['id']==1)
	{
		$_SESSION['error'] = 'Il est impossible de modifier l\'administrateur !';
		header('Location: gerer-equipe.php');	
	}
		
	if (mysql_num_rows($requete) < '1' )
	{
		$_SESSION['error'] = 'L\'enseignant que vous souhaitez modifier n\'existe pas !';
		header('Location: gerer-equipe.php');	
	}
	
	else
	{
		if ( (!empty ( $_POST['nom'] )) && (!empty ( $_POST['prenom'] )) && (!empty ( $_POST['identifiant'] )) && (!empty ( $_POST['email'] )) && (VerifierAdresseMail($_POST['email'])==1) )
		{
			$nom = mysql_real_escape_string($_POST['nom']);
			$prenom = mysql_real_escape_string($_POST['prenom']);
			$identifiant = mysql_real_escape_string($_POST['identifiant']);
			$email = mysql_real_escape_string($_POST['email']);

			//On met à jour l'utilisateur dans la BDD
			
			$id = $_GET['id'];
			mysql_query("UPDATE ".$dbprefixe."enseignant SET nom='$nom', prenom='$prenom', identifiant='$identifiant', email='$email' WHERE id='$id'") or die(mysql_error());
			
			$_SESSION['success'] = 'L\'enseignant a été mis à jour avec succès !';
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
	$requete = db_query("SELECT * FROM " . $dbprefixe ."enseignant ORDER BY nom, prenom ASC"); // Requête SQL
	
	echo '<table style="width: 100%; border-collapse: collapse; border:1px solid black;">
				<tr style="background-color:#E6E6E6; border:1px solid black; height:30px; font-variant:small-caps;">
					<th style="border:1px solid black;">Prénom</th>
					<th style="border:1px solid black;">Nom</th>
					<th style="border:1px solid black;">Identifiant</th>
					<th style="border:1px solid black;">Courriel</th>
					<th style="border:1px solid black;">Actions</th>
				</tr>';
	while ($donnees = mysql_fetch_array($requete) )
	{
		echo '<tr><td style="border-right:1px solid black; padding:5px;">' . $donnees['prenom'] . '</td>';
		echo '<td style="border-right:1px solid black; padding:5px;">' . $donnees['nom'] . '</td>';
		echo '<td style="border-right:1px solid black; padding:5px;">' . $donnees['identifiant'] . '</td>';
		echo '<td style="border-right:1px solid black; padding:5px;">' . $donnees['email'] . '</td>';
		echo '<td width=200px; style="border-right:1px solid black; padding:5px;"><center><a href=gerer-equipe.php?modifier_enseignant&id=' . $donnees['id'] . '><img style="border:0px;" src="../style/img/user_edit.png"> Modifier</a> <a id="suppr'.$donnees['id'].'" href=gerer-equipe.php?supprimer_enseignant&id=' . $donnees['id'] . ' onclick="this.blur(); Modalbox.show($(\'attention'.$donnees['id'].'\'), {title: \'Êtes vous sûr(e) ?\', width: 600}); return false;"><img style="border:0px;" src="../style/img/user_delete.png"> Supprimer</a></td></tr></center>';	
		echo '<div id="attention'.$donnees['id'].'" style="display:none;"><p>Souhaitez vous réellement supprimer cet enseignant ?</p><p class="bottomform" style="margin-left:0px; margin-right:0px;"><input type="button" value="Confirmer la suppression" onclick="window.location=\'gerer-equipe.php?supprimer_enseignant&id='.$donnees['id'].'\';" /> <input type=\'button\' value=\'Annuler\' onclick=\'Modalbox.hide()\' /></p></div>';
	}
		echo '</table></ br></ br>';
}

printFooter();

?>
