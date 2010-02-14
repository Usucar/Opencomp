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

include("../core/init.php");

if (isset ($_SESSION['pseudo']))
{
	if ($_SESSION['pseudo'] == 'admin')
	{
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
			<head>
				<title>Gnote | Tableau de bord administrateur</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link type="text/css" href="style/demo.css" rel="stylesheet" />
				<link type="text/css" href="style/style.css" rel="stylesheet" />
				<script type="text/javascript" src="library/js/jquery.js"></script>
				<script type="text/javascript" src="library/js/jquery-ui.js"></script>
				<script type="text/javascript">
				$(function() {
					$("#dialog").dialog({
						width: 650,
						height: 450,
						bgiframe: true,
						modal: true,
						buttons: {
							Fermer: function() {
								$(this).dialog('close');
							}
						}
					});
				});

				$(function() {
					$("#erreur").dialog({
						width: 350,
						bgiframe: true,
						modal: true,
						buttons: {
							Fermer: function() {
								$(this).dialog('close');
							}
						}
					});
				});
				</script>
			</head>
			<body>
			<?php
			include("header.php");

			/* LA SUITE DE LA PAGE ADMIN ICI */

			?>
			</body>
			</html>
			<?php
			if (isset($_GET['welcome-panel']))
			{
			?>
				<div id="dialog" title="Centre de démarrage">
					<p>
						<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
						Vous êtes connecté en tant qu'administrateur de l'application.<br />
						N'oubliez pas de vous déconnecter lorsque vous avez terminé !
					</p>
					<p>
						Que souhaitez vous faire ?
					</p>

				</div>
			<?php
			}
	}
	else
	{
		header('Refresh: 0; url=auth.php');
		exit();
	}
}
else
	{
		header('Refresh: 0; url=auth.php');
		exit();
	}
?>
