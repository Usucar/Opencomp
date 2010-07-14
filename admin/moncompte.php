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

include("../core/init.php");

printHead('Gérer mon compte', 'auth', '', $dbprefixe);

			/********************************************************************
			* On affiche les informations personnelles de la personne connectée *
			* ainsi qu'un champ pour modifier son email							*
			********************************************************************/
			echo'<h3>Informations personnelles</h3>
			<p>Si certaines de vos informations personnelles sont incorrectes, veuillez contacter l\'administrateur qui se chargera d\'effectuer les modifications nécessaires.</p>


			<form method="post" action="moncompte.php">
			<table>
				<tr>
					<td style="text-align:right;">Identifiant Gnote :</td>
					<td>' . $_SESSION['pseudo'] . '</td>
				</tr>
				<tr>
					<td style="text-align:right;">Prénom :</td>
					<td>' . $_SESSION['prenomenseignant'] . '</td>
				</tr>
				<tr>
					<td style="text-align:right;">Nom :</td>
					<td>' . $_SESSION['nomenseignant'] . '</td>
				</tr>
				<tr>
					<td style="text-align:right;">Email :</td>';

					// Si la personne n'a pas modifié son email, alors on affiche celui stocké dans la session.
                    if (!isset ($_POST['email']))
                    {
					    echo '<td><input type="text" name="email" id="email" size="30" value="' . $_SESSION['email'] . '" /></td>';
                    }

                    // Sinon, on définit la fonction VerifierAdresseMail(), on récupère le nouveau mail saisi, puis, on vérifie si l'adresse est bonne. Si c'est le cas, on fait un update dans la BDD et on met à jour la variable de session email ; sinon on indique à l'utilisateur que l'adresse doit être de la forme adresse@fournisseur.tld
					else
					{
						function VerifierAdresseMail($nouveauemail)
						{
						   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
						   if(preg_match($Syntaxe,$nouveauemail))
								return true;
						   else
								return false;
						}
						$pseudo = $_SESSION['pseudo'];
						$nouveauemail = mysql_real_escape_string($_POST['email']);
						if (VerifierAdresseMail($nouveauemail))
						{
							db_query("UPDATE " . $dbprefixe ."enseignant SET email='$nouveauemail' WHERE identifiant='$pseudo'") or die(mysql_error());
							$_SESSION['email'] = $nouveauemail;
							echo '<td><input type="text" name="email" id="email" size="30" value="' . $_SESSION['email'] . '" /></td>';
						}
						else
						{
							echo '<td><input type="text" name="email" id="email" size="30" value="' . $_SESSION['email'] . '" /><br /><span style="color:red;">L\'adresse saisie doit être de la forme adresse@fournisseur.tld</span></td>';
						}
					}

				echo '</tr>
				<tr>
					<td style="text-align:right;">Statut :</td>
					<td>';

						if ($_SESSION['pseudo'] != 'admin')
						{
							echo 'Enseignant';
						}
						else
						{
							echo 'Administrateur';
						}

					echo '</td>
				</tr>
			</table>
			<p><input type="submit" value="Sauvegarder les modification" style="margin-top:15px; margin-bottom:15px;"/></p>
			</form>

			<hr />';

			/****************************************************************
			* On affiche le journal des connexions de la personne connectée *
			****************************************************************/

			if ( isset($_POST['depuis']) && !empty($_POST['depuis']) )
			{
				$dureejournal = $_POST['depuis'];
			}
			else
			{
				$dureejournal = 'dix dernières connexions';
			}
?>
			<h3>Journal des <?php echo $dureejournal ?></h3>
			<p>Cette section liste les dernières connexions effectuées sur votre compte.</p>
				<ul>
					<li>Les lignes en rouge indiquent une tentative de connexion échouée avec un mot de passe erroné.</li>
					<li>Les lignes en orange indiquent une session pour laquelle vous ne vous êtes pas déconnecté correctement.</li>
					<li>Les lignes en noir indiquent une session close normalement.</li>
					<li>Les lignes en vert indiquent la session en cours.</li>
				</ul>
<?
			//Message d'information sur les sessions
?>
				<div id="attention" style="display:none;">
					<div style="text-align:justify; font-family: Verdana,Arial,sans-serif; font-size: 0.70em; margin-left:20px; margin-right:20px;">
						<p>Le message "Session non terminée" peut s'afficher pour plusieurs raisons :</p>
						<ul>
							<li>Dans le cas ou vous avez fermé votre navigateur sans cliquer d'abord sur le lien "Se déconnecter" situé en haut, à droite.</li>
							<li>Dans le cas ou vous avez initié une autre session sur un autre ordinateur sans fermer la première avec le lien "Se déconnecter".</li>
						</ul>
						<p>Dans tous les cas, ce message ne devrait pas apparaître. Vous DEVEZ vous déconnecter manuellement pour des raisons de sécurité !</p>
					</div>
					<p class="bottomform">
						<input type='button' value='Promis, je ferai attention la prochaine fois !' onclick='Modalbox.hide()' />
					</p>
                </div>
<?

			//On définit la fonction Convertirdate() qui convertit la date du format de la base de donnée (0000-00-00 00:00:00) vers un format lisible par l'utilisateur (00/00/0000 à 00 h 00)
			function Convertirdate($chaine_date)
			{
				$array_timestamp = explode(' ', $chaine_date); // On sépare le timestamp en date/heure

				$chaine_date = $array_timestamp['0'];
				$chaine_heure = $array_timestamp['1'];


				$array_date = explode('-', $chaine_date); // On sépare la date en jour/mois/année

				$jour = $array_date['2'];
				$mois = $array_date['1'];
				$annee = $array_date['0'];


				$array_heure = explode(':', $chaine_heure); // On sépare l'heure en heure/minute

				$heure = $array_heure['0'];
				$minute = $array_heure['1'];

				echo $jour . '/' . $mois . '/' . $annee . ' &agrave; ' . $heure . ' h ' . $minute;
			}

			$pseudo = $_SESSION['pseudo'];

			//On sélectionne les logs de la personne connectée que l'on tri par ordre décroissant.
			if ( isset($_POST['depuis']) && !empty($_POST['depuis']) )
			{
				switch ($_POST['depuis'])
				{
					case 'dix dernières connexions':
					$requete = db_query("SELECT * FROM " . $dbprefixe ."log WHERE login='$pseudo' ORDER BY start DESC LIMIT 10");
					break;

					case 'connexions depuis une semaine':
					$requete = db_query("SELECT * FROM " . $dbprefixe ."log WHERE login='$pseudo' AND (TO_DAYS(NOW()) - TO_DAYS(start)) < 7 ORDER BY start DESC");
					break;

					case 'connexions depuis quinze jours':
					$requete = db_query("SELECT * FROM " . $dbprefixe ."log WHERE login='$pseudo' AND (TO_DAYS(NOW()) - TO_DAYS(start)) < 15 ORDER BY start DESC");
					break;

					case 'connexions depuis un mois':
					$requete = db_query("SELECT * FROM " . $dbprefixe ."log WHERE login='$pseudo' AND (TO_DAYS(NOW()) - TO_DAYS(start)) < 31 ORDER BY start DESC");
					break;

					case 'connexions depuis le début':
					$requete = db_query("SELECT * FROM " . $dbprefixe ."log WHERE login='$pseudo' ORDER BY start DESC");
					break;
				}
			}
			else
			{
				$requete = db_query("SELECT * FROM " . $dbprefixe ."log WHERE login='$pseudo' ORDER BY start DESC LIMIT 10"); // Requête SQL
			}

			//Pour afficher les logs d'aujourd'hui :
			//SELECT * FROM log WHERE login='$pseudo' AND (TO_DAYS(NOW()) - TO_DAYS(start)) < 1 ORDER BY start DESC

			//On affiche tout ce beau petit monde dans un joli tableau avec une boucle ;)
			echo '<table style="width: 100%; border-collapse: collapse; border:1px solid black;">
				<tr style="background-color:#E6E6E6; border:1px solid black; height:30px; font-variant:small-caps;">
					<th style="border:1px solid black;">D&eacute;but Session</th>
					<th style="border:1px solid black;">Fin Session</th>
					<th style="border:1px solid black;">Adresse IP et nom de la machine cliente</th>
					<th style="border:1px solid black;">Navigateur &amp; Système d\'exploitation</th>
				</tr>';

			while ($donnees = mysql_fetch_array($requete) )
			{
				//On détermine
				//les couleurs :si erreur de mot de passe, ligne en rouge et en gras
				//				si pas d'erreur de mot de passe et si la session n'est pas terminée, ligne en vert
				//				si pas d'erreur de mot de passe et si session terminée mais pas de date de fin, ligne orange
				//				sinon, ligne noire
				if ($donnees['erreur_mdp'] == "oui")
				{
				$couleur = 'color: red; font-weight:bold;';
				}
				elseif ($donnees['erreur_mdp'] == "non")
				{
					if ($donnees['termine'] == "non")
					{
						$couleur = 'color: green;';
					}
					elseif ($donnees['termine'] == "oui" AND $donnees['end'] == "0000-00-00 00:00:00")
					{
						$couleur = 'color: orange;';
					}
					else
					{
					$couleur = '';
					}
				}

				echo '<tr style="border-top-style:none; border-bottom-style:none; ' . $couleur . '"><td style="border-right:1px solid black; padding:5px;">'; echo Convertirdate($donnees['start']); echo '</td>';

					echo '<td style="border-right:1px solid black; padding:5px;">';

						if ($donnees['end'] == "0000-00-00 00:00:00" AND $donnees['erreur_mdp'] == "non" AND $donnees['termine'] == "oui")
						{
							echo 'Session non termin&eacute;e <input type="button" value="?" onclick="Modalbox.show($(\'attention\'), {title: \'Information sur les sessions\', width: 500});" />';
						}
						elseif ($donnees['end'] == "0000-00-00 00:00:00" AND $donnees['erreur_mdp'] == "non")
						{
							echo 'Session non termin&eacute;e';
						}
						elseif ($donnees['end'] == "0000-00-00 00:00:00" AND $donnees['erreur_mdp'] == "oui")
						{
							echo Convertirdate($donnees['start']);
						}
						else
						{
							echo Convertirdate($donnees['end']);
						}
					echo '</td>

					<td style="border-right:1px solid black; padding:5px;">' . $donnees['ip'] . ' - ' . $donnees['referer'] . '</td>

					<td style="padding:5px;">' . $donnees['user_agent'] . '</td>
				</tr>';

			}

			echo '</table>';
			?>

		<form method="post" action="moncompte.php">
			<p>
			<label for="depuis">Afficher les :</label>
			<select name="depuis" id="depuis">
			<?php
			if ( isset($_POST['depuis']) && !empty($_POST['depuis']) )
			{
				switch ($_POST['depuis'])
				{
					case 'dix dernières connexions':
					echo'<option selected="selected">dix dernières connexions</option>
						<option>connexions depuis une semaine</option>
						<option>connexions depuis quinze jours</option>
						<option>connexions depuis un mois</option>
						<option>connexions depuis le début</option>';
					break;

					case 'connexions depuis une semaine':
					echo'<option>dix dernières connexions</option>
						<option selected="selected">connexions depuis une semaine</option>
						<option>connexions depuis quinze jours</option>
						<option>connexions depuis un mois</option>
						<option>connexions depuis le début</option>';
					break;

					case 'connexions depuis quinze jours':
					echo'<option>dix dernières connexions</option>
						<option>connexions depuis une semaine</option>
						<option selected="selected">connexions depuis quinze jours</option>
						<option>connexions depuis un mois</option>
						<option>connexions depuis le début</option>';
					break;

					case 'connexions depuis un mois':
					echo'<option>dix dernières connexions</option>
						<option >connexions depuis une semaine</option>
						<option>connexions depuis quinze jours</option>
						<option selected="selected">connexions depuis un mois</option>
						<option>connexions depuis le début</option>';
					break;

					case 'connexions depuis le début':
					echo'<option>dix dernières connexions</option>
						<option>connexions depuis une semaine</option>
						<option>connexions depuis quinze jours</option>
						<option>connexions depuis un mois</option>
						<option selected="selected">connexions depuis le début</option>';
					break;
				}
			}
			else
			{
				echo'<option selected="selected">dix dernières connexions</option>
					<option>connexions depuis une semaine</option>
					<option>connexions depuis quinze jours</option>
					<option>connexions depuis un mois</option>
					<option>connexions depuis le début</option>';
			}
			?>
			</select>
			<input type="submit" value="Go" />
			</p>
		</form>
		</div>

<?php
printFooter();
?>
