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

//Cette fonction permet de vérifier la validité d'une adresse email avec les expressions régulières
function VerifierAdresseMail($adresse)
		{
		   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
		   if(preg_match($Syntaxe,$adresse))
			  return true;
		   else
			 return false;
		}

//Cette fonction permet d'afficher l'en-tête de la page.
function printHead($title, $auth, $param, $dbprefixe, $bdd=null)
{
	$datefr = datefr();
	
	//On vérifie que la personne est identifiée si le paramètre $auth est renseigné
	if (isset($auth))
	{
		//Si la page demandée est réservée à l'administratateur et que le pseudo dans la session n'est pas égal à admin, alors, on renvoie la personne sur la page auth.php
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
		
		//Si la page demandée est réservée à un enseignant et que le pseudo dans la session est égal à admin, alors, on renvoie la personne sur la page auth.php
		elseif($auth == 'enseignant')
		{
			if ( isset( $_SESSION['pseudo'] ))
			{
				if ($_SESSION['pseudo'] == 'admin')
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
			<link  href="http://fonts.googleapis.com/css?family=Josefin+Sans+Std+Light:regular" rel="stylesheet" type="text/css" >
			<link rel="icon" type="image/png" href="../style/img/logo.png" />
			<script type="text/javascript" src="../library/js/prototype.js"></script>
			<script type="text/javascript" src="../library/js/scriptaculous.js?load=builder,effects"></script>
			<script type="text/javascript" src="../library/js/modalbox.js"></script>
			<script type="text/javascript; charset=utf-8" src="../library/js/CheckForm.js"></script>' . "\n";
	
	//Si on passe en paramètre de la fonction le terme 'extrajavascript', 
	//alors le contenu de la variable $extrajavascript définie 
	//avant l'appel de la fonction sera reproduit avant la fermeture de la balise head			
	if(!empty($param) AND $param == 'extrajavascript')
	{
		echo $GLOBALS['extrajavascript'] . "\n" . ' </head>';
	}
	else
	{
		echo "\n" . ' </head>';
	}

	//Si on a indiqué un paramètre
	if (!empty($param))
	{		
		//Et si ce paramètre est ifconnectfail
		if($param == 'ifconnectfail')
		{
			//On vérifie si la dernière connexion a été échouée ; si c'est le cas, on averti l'utilisateur avec body onload
			if ($_SESSION['derniere_connexion_echouee'] == 'oui')
			{
				$pseudo = $_SESSION['pseudo'];
				$bdd->exec("UPDATE " . $dbprefixe ."enseignant SET connectfail='non' WHERE identifiant='$pseudo'");
				$_SESSION['derniere_connexion_echouee'] = 'non';

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
			
			$pseudo = $_SESSION['pseudo'];
			
			// On affiche le menu correspondant au statut de la personne connectée
			if($pseudo == 'admin')
			{
				echo printMenuadmin();
			}
			else
			{
				echo printMenuenseignant();
			}			
			
			// Puis on affiche le titre de la page et (éventuellement) un avertissement sur la necessité de javascript.
			echo'<div id="corps" class="clearfix">
			<noscript><ul style="margin:0px; padding:0px;"><li class="error">Javascript est indispensable au bon fonctionnement de Opencomp et doit être activé dans votre navigateur ! <span style="float:right;"><small>Comment faire ?</small></span></li></ul></noscript>
			<h2>'.$title.'</h2>';
			
			// Si la variable de session error n'est pas vide, alors on la parcours et on affiche les éventuels messages d'erreur.
			if (isset($_SESSION['error']))
			{
				echo '<ul style="margin-bottom:10px; padding:0px;"><li class="error" id="error">';
				foreach($_SESSION['error'] as $msgflash)
				{
					echo $msgflash . '<br />'; 
				}
				
				?>
				
				<script type='text/javascript'>		
					
					
					window.setTimeout(function() {
						new Effect.Highlight('error', { startcolor: '#FFFFFF', endcolor: '#FFBDBD', restorecolor: '#FFE7E7',keepBackgroundImage: 'true' });
					}, 200);
					
					window.setTimeout(function() {
						new Effect.Fade('error');
					}, 10000);	
									
				</script>
				
				<?php
				
				echo '</li></ul>';
				unset($_SESSION['error']);
			}
			
			// Si la variable de session success n'est pas vide, alors on la parcours et on affiche les éventuels messages d'erreur.
			if (isset($_SESSION['success']))
			{
				echo '<ul style="margin-bottom:10px; padding:0px;"><li class="success" id="success">';
				foreach($_SESSION['success'] as $msgflash)
				{
					echo $msgflash . '<br />'; 
				}
				
				?>
				
				<script type='text/javascript'>		
					
					
					window.setTimeout(function() {
						new Effect.Highlight('success', { startcolor: '#FFFFFF', endcolor: '#BFFFC7', restorecolor: '#DFF9E3',keepBackgroundImage: 'true' });
					}, 200);
					
					window.setTimeout(function() {
						new Effect.Fade('success');
					}, 10000);	
									
				</script>
				
				<?php
				
				echo '</li></ul>';
				unset($_SESSION['success']);
			}			
}

// Cette fonction permet d'afficher le menu de navigation de l'administrateur
function printMenuadmin()
    {
        // tableaux contenant les liens d'accès et le texte à afficher
	$tab_menu_lien = array( "dashboard.php", "gerer-coordonnees.php", "gerer-equipe.php", "gerer-classes.php", "gerer-competences.php", "moncompte.php" );
	$tab_menu_texte = array( "Tableau de bord", "Coordonnées", "Équipe éducative", "Classes", "Socle de compétences", "Mon compte" );

	// informations sur la page
	$info = pathinfo($_SERVER['PHP_SELF']);

	$menu = "\n<div id=\"menu\">\n    <ul id=\"onglets\">\n";



	// boucle qui parcours les deux tableaux
	foreach($tab_menu_lien as $cle=>$lien)
	{
	    $menu .= "    <li";

	    // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
	        
	    if( $lien == 'moncompte.php' AND $info['basename'] != 'moncompte.php')
	        $menu .= " class=\"right\"";
	        
	    if( $info['basename'] == 'moncompte.php' AND $info['basename'] == $lien)
	        $menu .= " class=\"active right\"";
	    else 
	    {
			if( $info['basename'] == $lien )
	        $menu .= " class=\"active\"";
		}

	    $menu .= "><a href=\"" . $lien . "\">" . $tab_menu_texte[$cle] . "</a></li>\n";
	}

	$menu .= "</ul>\n</div>";

        // on renvoie le code xHTML
	return $menu;
    }

// Cette fonction permet d'afficher le menu de navigation de l'enseignant   
function printMenuenseignant()
    {
        // tableaux contenant les liens d'accès et le texte à afficher
	$tab_menu_lien = array( "#", "#", "#", "#", "#", "moncompte.php" );
	$tab_menu_texte = array( "Ceci", "sera", "le", "menu", "enseignant", "Mon compte" );

	// informations sur la page
	$info = pathinfo($_SERVER['PHP_SELF']);

	$menu = "\n<div id=\"menu\">\n    <ul id=\"onglets\">\n";



	// boucle qui parcours les deux tableaux
	foreach($tab_menu_lien as $cle=>$lien)
	{
	    $menu .= "    <li";

	    // si le nom du fichier correspond à celui pointé par l'indice, alors on l'active
	        
	    if( $lien == 'moncompte.php' AND $info['basename'] != 'moncompte.php')
	        $menu .= " class=\"right\"";
	        
	    if( $info['basename'] == 'moncompte.php' AND $info['basename'] == $lien)
	        $menu .= " class=\"active right\"";
	    else 
	    {
			if( $info['basename'] == $lien )
	        $menu .= " class=\"active\"";
		}

	    $menu .= "><a href=\"" . $lien . "\">" . $tab_menu_texte[$cle] . "</a></li>\n";
	}

	$menu .= "</ul>\n</div>";

        // on renvoie le code xHTML
	return $menu;
    }

//Cette fonction permet d'inclure le pied de page.
function printFooter($bdd)
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
		if ($bdd->count() == 0)
		{
			echo', aucune requête exécutée.</div>';
		}
		elseif ($bdd->count() == 1)
		{
			echo', 1 requête exécutée.</div>';
		}
		else
		{
			echo ', ' . $bdd->count() . ' requêtes exécutées.</div>';
		}

	//On referme les balises précédemment ouvertes
	echo'</div>
	</body>
	</html>';
}

?>
