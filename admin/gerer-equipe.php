<?php

/*
 * ========================================================================
 * Copyright (C) 2010 Traullé Jean
 *
 * This file is part of Gnote.
 *
 * Gnote is free software; you can redistribute it and/or modify
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
 * with Gnote. If not, see <http://www.gnu.org/licenses/>
 * ========================================================================
 */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>Gnote | Gérer mon compte</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link type="text/css" href="../style/style.css" rel="stylesheet" />
			<script type="text/javascript; charset=utf-8" src="../library/js/CheckForm.js"></script>

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

		</head>

		<body>

			<div id="corps">

				<h2>Gérer l'équipe éducative</h2>

<?php
/*****************************************************************
 * Si l'utilisateur a demandé gerer-equipe.php?ajouter_enseignant *
 ****************************************************************/

if (isset($_GET['ajouter_enseignant']))
{
	if (isset($_POST['nombre_enseignant']))
	{
		$_POST['nombre_enseignant'] = htmlspecialchars($_POST['nombre_enseignant']);

		if (preg_match("#[0-9]#", $_POST['nombre_enseignant']))
		{
			if (($_POST['nombre_enseignant']) <= 0)
			{
				echo '<h3>Ajouter des enseignants à l\'équipe éducative</h3><form method="post" action="gerer-equipe.php?ajouter_enseignant"><p>Combien souhaitez vous ajouter d\'enseignant ?</p><input type="text" name="nombre_enseignant" size="2" maxlength="2" /> <input type="submit" value="OK" /></form>
			';
			}

			elseif (($_POST['nombre_enseignant']) == 1)
			{
				echo '<h3>Ajouter des enseignants à l\'équipe éducative</h3>
				<p>Saisissez les informations concernant l\'enseignant que vous souhaitez ajouter à l\'équipe éducative.</p>

				<form method="post" id="form_ajouter_enseignant" action="gerer-equipe.php?ajouter_enseignant">
				<table>
					<tr>
						<td style="text-align:right;><label for="nom">Nom :</label></td>
						<td><input type="text" size="25" name="nom" id="nom" style="border:1px solid #cacaca; " OnKeyUp="javascript:this.value=this.value.toUpperCase();" /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;><label for="prenom">Prénom :</label></td>
						<td><input type="text" size="25" name="prenom" id="prenom" style="border:1px solid #cacaca;" OnKeyUp="MajusculeEnDebutDeChaine(this)" /></td>
					</tr>
					<tr>
						<td style="text-align:right;><label for="pseudo">Email :</label><br /><br /></td>
						<td><input type="text" size="37" name="email" id="email" style="border:1px solid #cacaca;" /><br /><br /></td>
					</tr>
					<tr>
						<td style="text-align:right;"><label for="identifiant">Identifiant :</label></td>
						<td><input type="text" name="identifiant" id="identifiant" style="border:1px solid #cacaca;" /></td>
					</tr>
					<tr>
						<td style="text-align:right;><label for="motdepasse">Mot de passe :</label></td>
						<td><input type="password" name="motdepasse" id="motdepasse" style="border:1px solid #cacaca;" /></td>
					</tr>
					<tr>
						<td style="text-align:right;><label for="motdepasse2">Confirmez le&nbsp;&nbsp;<br />mot de passe :</label></td>
						<td><input type="password" name="motdepasse2" id="motdepasse2" style="border:1px solid #cacaca;" /></td>
					</tr>
				</table>
				<input type="submit" id="ajouter_un_enseignant" name="ajouter_un_enseignant" value="Ajouter cet enseignant" style="margin-top:15px; margin-bottom:15px;"/>
				</form>';
			}

			elseif (($_POST['nombre_enseignant']) >= 11)
			{
				echo '<h3>Ajouter des enseignants à l\'équipe éducative</h3><form method="post" action="gerer-equipe.php?ajouter_enseignant"><p>Combien souhaitez vous ajouter d\'enseignant ?</p><input type="text" name="nombre_enseignant" size="2" maxlength="2" /> <input type="submit" value="OK" /><p>Il n\'est possible d\'ajouter que 10 enseignants maximum par ajout !</p></form>
			';
			}
			elseif (($_POST['nombre_enseignant']) >= 2)
			{
				echo '<p>Vous souhaitez ajouter plusieurs enseignants</p>
			';
			}
		}
		else
		{
			echo '<h3>Ajouter des enseignants à l\'équipe éducative</h3><form method="post" action="gerer-equipe.php?ajouter_enseignant"><p>Combien souhaitez vous ajouter d\'enseignant ?</p><input type="text" name="nombre_enseignant" size="2" maxlength="2" /> <input type="submit" value="OK" /><p>Vous devez entrer un nombre entier.</p></form>';
		}
	}
	elseif (isset ( $_POST['ajouter_un_enseignant'] ))
	{
		echo'Le formulaire a été envoyé';
	}
	else
	{
		echo '<h3>Ajouter des enseignants à l\'équipe éducative</h3><form method="post" action="gerer-equipe.php?ajouter_enseignant"><p>Combien souhaitez vous ajouter d\'enseignant ?</p><input type="text" name="nombre_enseignant" size="2" maxlength="2" /> <input type="submit" value="OK" /></form>';
	}
}
else
{
	echo '<input type="button" value="Ajouter des enseignants" title="Ajouter des enseignants" class="ajouter" onclick="window.location=\'gerer-equipe.php?ajouter_enseignant\';"></input>';
}
?>

			</div>

		</body>

	</html>
