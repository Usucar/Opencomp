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

//Cette fonction permet d'obtenir le temps en millièmes de secondes
function get_microtime()
{
	list($tps_usec, $tps_sec) = explode(" ",microtime());
	return ((float)$tps_usec + (float)$tps_sec);
}

//On stocke dans une variable globale le temps au début du chargement de la page
$GLOBALS['tps_start'] = get_microtime();

//Cette fonction permet d'afficher la date au format français complet c-a-d par exemple Vendredi 13 Février 2009
function datefr()
{
	$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
	$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
	$datefr = $jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y");
	return "Nous sommes le ". $datefr;
}

//Cette fonction permet de compter le nombre de requêtes mysql exécutées pour la page
function db_query($sql)
{
	global $nb_requete;
	$nb_requete++;
	return mysql_query($sql);

}

//Cette fonction permet d'afficher l'en-tête de la page.
function printHead($title, $auth, $param, $dbprefixe)
{
	$datefr = datefr();

	if (isset($auth))
	{
		if($auth == 'admin')
		{
			if ( isset( $_SESSION['pseudo'] ))
			{
				if ($_SESSION['pseudo'] != 'admin')
				{
					header('Location: ../auth.php');
					exit();
				}
			}
			else
			{
				header('Location: ../auth.php');
				exit();
			}
		}

		elseif($auth == 'enseignant')
		{
			if ( isset( $_SESSION['pseudo'] ))
			{
				if ($_SESSION['pseudo'] = 'admin')
				{
					header('Location: ../auth.php');
					exit();
				}
			}
			else
			{
				header('Location: ../auth.php');
				exit();
			}
		}
	}

	echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>Opencomp | ' . $title . '</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link type="text/css" href="../style/style.css" rel="stylesheet" />
			<link type="text/css" href="../style/modalbox.css" rel="stylesheet" />
			<link rel="icon" type="image/png" href="../style/img/logo.png" />
			<script type="text/javascript" src="../library/js/prototype.js"></script>
			<script type="text/javascript" src="../library/js/scriptaculous.js?load=builder,effects"></script>
			<script type="text/javascript" src="../library/js/modalbox.js"></script>
		</head>' . "\n";

	//Si on a indiqué un paramètre
	if (!empty($param))
	{
		//Et si ce paramètre est ifconnectfail
		if($param = 'ifconnectfail')
		{
			//On vérifie si la dernière connexion a été échouée ; si c'est le cas, on averti l'utilisateur avec body onload
			if ($_SESSION['derniere_connexion_echouee'] == 'oui')
			{
				$pseudo = $_SESSION['pseudo'];
				mysql_query("UPDATE " . $dbprefixe ."enseignant SET connectfail='non' WHERE identifiant='$pseudo'") or die(mysql_error());
				//$_SESSION['derniere_connexion_echouee'] = 'non';

				echo'<body onload="Modalbox.show($(\'attention\'), {title: \'Attention !\', width: 500});">
				<div id="attention" style="display:none;"><p>Il y a eu une ou plusieurs tentatives de connexions &eacute;chou&eacute;es &agrave; votre compte depuis votre derni&egrave;re visite. Si vous avez commis une erreur lors de la saisie de votre mot de passe, il n\'y a pas d\'inqui&eacute;tudes &agrave; avoir. Dans le cas contraire, nous vous sugg&eacute;rons de consulter le Journal des connexions de votre compte ...</p><p class="bottomform" style="margin-left:0px; margin-right:0px;"><input type="button" value="Consulter le journal des connexions" onclick="window.location=\'moncompte.php\';" /> <input type=\'button\' value=\'Fermer\' onclick=\'Modalbox.hide()\' /></p></div>';
			}
			else
			{
				echo'<body>';
			}
		}
	}
	//Sinon, on affiche un body simple
	else
	{
		echo'<body>';
	}
		//Puis on affiche l'en-tête
		echo'<div id="wrap">
		<div id="en_tete"><img class="logo_entete" src="../style/img/logo.png" alt="logo" />

				<div class="titre_entete">Opencomp</div>
				<div class="description_entete">Gestion de r&eacute;sultats scolaires par navigateur<span class ="description_entete" style="font-size:x-small">et bien plus encore !</span></div>

				<div class="info-connect_entete">
					<span style="float:right;">' . $datefr . '</span><br />
					<div style="padding-top:5px;">Bienvenue, ' .$_SESSION['prenomenseignant'] . ' ' . $_SESSION['nomenseignant'] . ' | <a href="../auth.php?logout" style="background-image: url(\'../style/img/deco.png\'); background-repeat: no-repeat; padding-left:20px;"> Se d&eacute;connecter</a></div>
				</div>
			</div>';
			echo printMenu();
			echo'<div id="corps" class="clearfix">
			<noscript><ul style="margin:0px; padding:0px;"><li class="error">Javascript est indispensable au bon fonctionnement de Opencomp et doit être activé dans votre navigateur ! <span style="float:right;"><small>Comment faire ?</small></span></li></ul></noscript>';
}

function printMenu()
    {
        // tableaux contenant les liens d'accès et le texte à afficher
	$tab_menu_lien = array( "dashboard.php", "gerer-coordonnees.php", "gerer-equipe.php", "gerer-classes.php", "gerer-competences.php" );
	$tab_menu_texte = array( "Tableau de bord", "Coordonnées", "Équipe éducative", "Classes", "Socle de compétences" );

	// informations sur la page
	$info = pathinfo($_SERVER['PHP_SELF']);

	$menu = "\n<div id=\"menu\">\n    <ul id=\"onglets\">\n";



	// boucle qui parcours les deux tableaux
	foreach($tab_menu_lien as $cle=>$lien)
	{
	    $menu .= "    <li";

	    // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
	    if( $info['basename'] == $lien )
	        $menu .= " class=\"active\"";

	    $menu .= "><a href=\"" . $lien . "\">" . $tab_menu_texte[$cle] . "</a></li>\n";
	}

	$menu .= "</ul>\n</div>";

        // on renvoie le code xHTML
	return $menu;
    }

//Cette fonction permet d'inclure le pied de page.
function printFooter()
{
	//On referme les balises précédemment ouvertes
	echo'</div>
	</div>
	<div id="footer">';

	//On récupère le temps de début de chargement
	$tps_start = $GLOBALS['tps_start'];
	//On obtient le temps de fin de chargement avec get_microtime();
	$tps_end = get_microtime();
	//On calcule le temps de génération de la page par soustraction ; on spécifie que l'on ne veut que 4 chiffres après la virgule.
	$tps = round($tps_end - $tps_start, 4);

	//On affiche le pied de page
	echo "<p style='position:relative; top:7px; left:10px;'>Opencomp est distribué sous licence <a href ='http://www.april.org/gnu/gpl_french.html'>GNU/GPL</a>.<br /><a href='http://zolotaya.isa-geek.com/redmine/projects/gnote'>Forge du projet Opencomp</a> - <a href='http://zolotaya.isa-geek.com/redmine/projects/gnote/issues/new'>rapporter une anomalie</a></p><div style='float:right; position:relative; bottom:18px; right:10px;'>Page générée en $tps seconde";

		//Petite attention de langage sur le singulier/pluriel.
		if (!isset ($GLOBALS['nb_requete']))
		{
			echo', aucune requête exécutée.</div>';
		}
		elseif ($GLOBALS['nb_requete'] == 1)
		{
			echo', 1 requête exécutée.</div>';
		}
		else
		{
			echo ', ' . $GLOBALS['nb_requete'] . ' requêtes exécutées.</div>';
		}

	//On referme les balises précédemment ouvertes
	echo'</div>
	</body>
	</html>';
}

?>
