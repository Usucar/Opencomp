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

require_once('core/init.php');
require_once('library/php-local-browscap.php');

/*****************************************
*   SI la personne est déjà identifiée   *
*****************************************/

if (isset($_SESSION['pseudo']))
{
	//ET si elle a demandé à être déconnecté, alors on la déconnecte en détruisant la session
	if (isset($_GET['logout']))
	{
		//On enregistre sa déconnexion dans le journal, on détruit la session et on redirige vers le formulaire de connexion
		$date_de_deconnexion = date('Y-m-d H:i:s');
		$sessid = session_id();

		mysql_query("UPDATE " . $dbprefixe ."log SET end='$date_de_deconnexion', termine='oui' WHERE session_id='$sessid'") or die(mysql_error());

		unset($_SESSION);
		session_destroy();

		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

			<head>
				<title>Gnote | Identifiez vous ...</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link type="text/css" href="style/style.css" rel="stylesheet" />
			</head>

			<body class="identification">

				<form method="post" action="auth.php" class="identification">

					<div class="top_msg_error">

					<p class="icon_ok">Succès</p>
					</div>

					<div class="contenuform">
						<p class="infoform">
							Vous avez été déconnecté avec succès.<br /><br />

							Vous pouvez maintenant fermer cette page ou cet onglet.<br /><br />

							Si une autre personne souhaite se connecter à Gnote, il suffit de cliquer sur "S\'identifier de nouveau" !
						</p>
					</div>
					<p class="bottomform">
					<input type="button" value="S\'identifier de nouveau" ONCLICK="window.location=\'auth.php\';">
					</p>
				</form>

			</body>

		</html>' ;
		echo $message;
	}
	//SINON, elle n'a rien à faire sur cette page d'identification puisque elle est déjà identifiée
	else
	{
		//Si c'est l'admin, alors, on le redirige vers le dashboard-admin.php
		if ($_SESSION['pseudo'] == 'admin')
		{
			header('Location: admin/dashboard.php');
		}
		//SINON, c'est forcément un enseignant, on le redirige alors vers le dashboard-enseignant.php
		else
		{
			header('Location: enseignant/dashboard.php');
		}
	}
}

/****************************************************************
*   SINON SI la personne a complété les champs de forumalaire   *
****************************************************************/

elseif ( (!empty ( $_POST['pseudo'] )) && (!empty ( $_POST['motdepasse'] )) )
{
	/********************************************
	*   On définit la fonction verification()   *
	********************************************/

	function verification($pseudo,$motdepasse,$dbprefixe)
	{
		//Exécution de la requête
		//mysql_query("SET NAMES UTF8");
		$sql = mysql_query ("SELECT * FROM " . $dbprefixe ."enseignant WHERE identifiant='$pseudo'");
		$tableau = mysql_fetch_array ($sql);

		//On définit la fonction get_ip() qui permet d'obtenir l'adresse ip de l'internaute
		function get_ip()
		{
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

		//On définit des variables relatives à l'utilisateur pour les logs
		$ip = get_ip();
		$hote = gethostbyaddr($ip);
		$navigateur = get_browser_local();
		$navigateur = $navigateur->parent . ' - ' . $navigateur->platform;
		$datedeconnexion = date('Y-m-d H:i:s');

		if ( mysql_affected_rows()=='1') // Si le pseudo saisi existe, on passe à la suite
		{
			
			$sql2 = mysql_query ("SELECT * FROM " . $dbprefixe ."enseignant WHERE identifiant='$pseudo' AND mot_de_passe='$motdepasse'");
			$tableau2 = mysql_fetch_array ($sql2);

			if ( mysql_affected_rows()=='1') //Si le mot de passe est correct
			{
				//On regénère un id session et on sauvegarde les infos concernant l'utilisateur dans la session
				session_regenerate_id() ;
				$_SESSION['nomenseignant'] = $tableau['nom'];
				$_SESSION['prenomenseignant'] = $tableau['prenom'];
				$_SESSION['email'] = $tableau['email'];
				$_SESSION['derniere_connexion_echouee'] = $tableau['connectfail'];
				$_SESSION['pseudo'] = $pseudo ;

				//On marque la dernière connexion de l'utilisateur comme terminée
				//(dans le cas où la personne ne s'est pas déconnecté manuellement)
				mysql_query("UPDATE " . $dbprefixe ."log SET termine='oui' WHERE login='$pseudo' AND termine='non'") or die(mysql_error());

				//On inscrit la connexion dans le journal
				$sessid = session_id();

				mysql_query("INSERT INTO " . $dbprefixe . "log VALUES('', '$pseudo', '$datedeconnexion', '$sessid', '$ip', '$navigateur', '$hote', 'non', 'non', '')") or die(mysql_error());
				return TRUE;

			}
			else //Sinon, l'identifiant est correct mais pas le mot de passe, on log donc cela dans la BDD
			{
				mysql_query("INSERT INTO " . $dbprefixe ."log VALUES('', '$pseudo', '$datedeconnexion', 'nosess', '$ip', '$navigateur', '$hote', 'oui', 'oui', '')") or die(mysql_error());
				mysql_query("UPDATE " . $dbprefixe ."enseignant SET connectfail='oui' WHERE identifiant='$pseudo'") or die(mysql_error());
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	/**************************************************
	*   On teste le couple identifiant/mot de passe   *
	**************************************************/

	//On stocke les données du formulaire dans des variables
	$pseudo = mysql_real_escape_string($_POST['pseudo']);
	
	//On récupère le grain de sel de l'utilisateur
	$sql = mysql_query ("SELECT * FROM " . $dbprefixe ."enseignant WHERE identifiant='$pseudo'");
	$tableau = mysql_fetch_array ($sql);
	
	//On concatène le mot de passe et le grain de sel pour obtenir le mot de passe haché
	$motdepasse = mysql_real_escape_string($_POST['motdepasse']);
	$motdepasse = sha1($motdepasse.$tableau['salt']);
	
	//Si le couple identifiant/mot de passe saisi est valide
	if ( verification( $pseudo, $motdepasse, $dbprefixe ) )
	{
		//On redirige la personne vers le tableau de bord approprié (enseignant ou admin)
		if ($_SESSION['pseudo'] == 'admin')
		{
			header('Location: admin/dashboard.php');
		}
		else
		{
			header('Location: enseignant/dashboard.php');
		}
	}
	else	//Sinon, on averti l'utilisateur que le couple identifiant, mot de passe est erroné.
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

			<head>
				<title>Gnote | Identifiez vous ...</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link type="text/css" href="style/style.css" rel="stylesheet" />
			</head>

			<body class="identification">

				<form method="post" action="auth.php" class="identification">

					<div class="topform">

					<p class="topform_icon">Afin d\'utiliser Gnote, vous devez vous identifier.</p>
					</div>

					<div class="contenuform">
						<p class="infoform">
							Toute tentative de connexion échouée est notifiée, de manière détaillée, à l\'administrateur de cette application web.
						</p>
						<p>
							<label for="pseudo">Identifiant : </label>
							<input type="text" name="pseudo" id="pseudo" />
						</p>
						<p>
							<label for="motdepasse">Mot de passe : </label>
							<input type="password" name="motdepasse" id="motdepasse" />
						</p>
						<p style="color:red;">Le couple identifiant, mot de passe que vous avez saisi est incorrect !</p>
					</div>

					<p class="bottomform">
						<input type="submit" value="S\'identifier" name="submit" id="submit" />
					</p>

				</form>

			</body>

		</html>' ;
	}

}

/**********************************************************************
*   SINON SI la personne n'a pas complété les champs de forumalaire   *
**********************************************************************/

//Si les champs du formulaire ne sont pas tous remplis, c'est soit parce que la personne n'a pas encore rempli le formulaire de connexion ;
//soit parce qu'elle n'a pas rempli tous les champs. Dans un cas comme dans l'autre, on affiche alors le formulaire.
else
{
	//Si le formulaire a été validé, alors cela signifie que la personne n'a pas rempli tous les champs
	if (isset ( $_POST['submit'] ))
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

			<head>
				<title>Gnote | Identifiez vous ...</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link type="text/css" href="style/style.css" rel="stylesheet" />
			</head>

			<body class="identification">

				<form method="post" action="auth.php" class="identification">

					<div class="topform">

					<p class="topform_icon">Afin d\'utiliser Gnote, vous devez vous identifier.</p>
					</div>

					<div class="contenuform">
						<p class="infoform">
							Toute tentative de connexion échouée est notifiée, de manière détaillée, à l\'administrateur de cette application web.
						</p>

						<p>
							<label for="pseudo">Identifiant : </label>
							<input type="text" name="pseudo" id="pseudo" />
						</p>
						<p>
							<label for="motdepasse">Mot de passe : </label>
							<input type="password" name="motdepasse" id="motdepasse" />
						</p>
						<p style="color:red;">Il est nécessaire de completer tous les champs du formulaire !</p>
					</div>

					<p class="bottomform">
						<input type="submit" value="S\'identifier" name="submit" id="submit" />
					</p>

				</form>

			</body>

		</html>';
	}
	//Sinon, cela signifie que le formulaire n'a jamais été affiché, on affiche donc le formulaire
	else
	{
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

			<head>
				<title>Gnote | Identifiez vous ...</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link type="text/css" href="style/style.css" rel="stylesheet" />
			</head>

			<body class="identification">

				<form method="post" action="auth.php" class="identification">

					<div class="topform">

					<p class="topform_icon">Afin d'utiliser Gnote, vous devez vous identifier.</p>
					</div>

					<div class="contenuform">
						<p class="infoform">
							Toute tentative de connexion échouée est notifiée, de manière détaillée, à l'administrateur de cette application web.
						</p>
						<p>
							<label for="pseudo">Identifiant : </label>
							<input type="text" name="pseudo" id="pseudo" />
						</p>
						<p>
							<label for="motdepasse">Mot de passe : </label>
							<input type="password" name="motdepasse" id="motdepasse" />
						</p>
					</div>

					<p class="bottomform">
						<input type="submit" value="S'identifier" name="submit" id="submit" />
					</p>

				</form>

			</body>

		</html>

		<?php
	}
}

?>
