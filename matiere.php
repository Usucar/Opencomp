<?php
/*Copyright (C) 2008 Sadaoui Akim
 *
 * This program is free software; you can redistribute it and/or modify
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
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 * ========================================================================
 */
	include ("commons.php");
	$action = '';
	if(!empty($_GET['id']) && !empty($_GET['refresh']))
	{
		$id = format($_GET['id']);
		if($_GET['action'] == 'confdelm')
		{
			queryAndLog("DELETE FROM ".$db_prefix."matieres WHERE id='$id'");
			queryAndLog("DELETE FROM ".$db_prefix."sous_matieres WHERE id_parent='$id'");
		}
		else if($_GET['action'] == 'confdelsm')
			queryAndLog("DELETE FROM ".$db_prefix."sous_matieres WHERE id='$id'");
		else
			$action = 'error404';
		header ("Refresh: 2;URL=gestion_des_matieres.php");
	}
	if(!empty($_POST['name']))
	{
		if($_GET['sousmatiere'])
		{
			$id = format($_POST['parent']);
			$req = query("SELECT * FROM ".$db_prefix."matieres WHERE id='$id'");
			if(mysql_num_rows($req))
			{
				$name = format($_POST['name']);
				$req = query("SELECT * FROM ".$db_prefix."sous_matieres WHERE name='$name' and id_parent='$id'");
				if(!mysql_num_rows($req))
				{
					queryAndLog("INSERT INTO ".$db_prefix."sous_matieres (id, name, id_parent) VALUES ('', '$name', '$id')");
					$action = 'success1';
				}
				else
					$action = 'error3';
			}
			else
				$action = 'error2';
		}
		else
		{
			$name = format($_POST['name']);
			$req = query("SELECT * FROM ".$db_prefix."matieres WHERE name='$name'");
			if(!mysql_num_rows($req))
			{
				queryAndLog("INSERT INTO ".$db_prefix."matieres(id, name) VALUES ('', '$name')");
				if($_POST['nb_sous'] > 0 && $_POST['nb_sous'] < 51)
				{
					$req = query("SELECT id FROM ".$db_prefix."matieres WHERE name='$name'");
					$id = mysql_fetch_assoc($req);
					$id = $id['id'];
					$nb_sous = format($_POST['nb_sous']);
					while($nb_sous > 0)
					{
						$name = format($_POST['name_sous'.$nb_sous*10]);
						$req = query("SELECT * FROM ".$db_prefix."sous_matieres WHERE id_parent='$id' and name='$name'");
						if(!mysql_num_rows($req))
							queryAndLog("INSERT INTO ".$db_prefix."sous_matieres(id, name,id_parent) VALUES ('', '$name', '$id')");
						$nb_sous --;
					}
				}
				$action = 'success2';
			}
			else
				$action = 'error1';
		}
		header ("Refresh: 2;URL=gestion_des_matieres.php");
	}
	if(ereg("(conf)?(del)(s)?(m)", $_GET['action']))
		printHead('Suppression de mati&egrave;res/sous mati&egrave;res');
	else
		printHead('Ajout de mati&egrave;res/sous mati&egrave;res');
	if($_GET['action'] == 'delsm' || $_GET['action'] == 'delm')
	{
?>
		<h3>La <?php if($_GET['action'] == 'delsm') echo 'sous-';?>mati&egrave;re sera supprim&eacute;e</h3>
		<form id="confdelete" method="POST" action="matiere.php?action=confdel<?php if($_GET['action'] == 'delsm') echo 's';?>m&id=<?php echo $_GET['id'];?>&refresh=1">
			<input type="submit" value="Confirmer" />
			<a href="gestion_des_matieres.php">Annuler</a>
		</form>
<?php
	}
	else if($_GET['action'] == 'confdelm')
	{
?>
		<h3>Mati&egrave;re supprim&eacute;e avec succ&egrave:s</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else if($_GET['action'] == 'confdelsm')
	{
?>
		<h3>Sous-mati&egrave;re supprim&eacute;e avec succ&egrave:s</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else if($action == 'error1')
	{
?>
		<h3>Erreur : une mati&egrave;re porte d&eacute;j&agrave; ce nom</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else if($action == 'error2')
	{
?>
		<h3>Erreur : Aucune mati&egrave;re parente s&eacute;lectionn&eacute;e</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else if($action == 'error3')
	{
?>
		<h3>Erreur : une sous mati&egrave;re de ce nom existe d&eacute;j&agrave; pour cette mati&egrave;re</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else if($action == 'success1')
	{
?>
		<h3>Sous mati&egrave;re ajout&eacute;e avec succ&egrave;s</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else if($action == 'success2')
	{
?>
		<h3>Mati&egrave;re ajout&eacute;e avec succ&egrave;s</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else if($_GET['sousmatiere'])
	{
?>
		<form id="formAdd" class="formAdd" method="POST" action="matiere.php?sousmatiere=1">
			<fieldset>
				<label for="name">Nom de la sous-mati&egrave;re : </label><input type="text" id="name" name="name" tabindex="10" /><br />
				<label for="parent">Mati&egrave;re parente : </label><select id="parent" name="parent">
<?php
		$req = query("SELECT * FROM ".$db_prefix."matieres ORDER BY name");
		if(mysql_num_rows($req))
		{
			while($data = mysql_fetch_assoc($req))
			{
?>
					<option value="<?php echo $data['id'];?>"<?php if($_GET['matiere'] == $data['id']) echo ' selected="selected"'?>><?php echo $data['name'];?></option>
<?php
			}
		}
?>
				</select><br />
				<input type="submit" value="Cr&eacute;er !" /><input type="reset" />
			</fieldset>
		<script type="text/javascript" src="addMatiere.js"></script>
<?php
	}
	else if($action == 'error404')
	{
?>
		<h3>Erreur, action introuvable</h3>
		<h6>Redirection vers Gestions des mati&egrave;res dans 2 secondes...</h6>
<?php
	}
	else
	{
?>
		<form id="formAdd" class="formAdd" method="POST" action="matiere.php">
			<fieldset>
				<legend>Mati&egrave;re</legend>
				<label for="name">Nom de la mati&egrave;re : </label><input type="text" id="name" name="name" tabindex="10" /><br />
				<label for="nb_el">Associer des sous-mati&egrave;res : </label><input type="text" id="nb_sous" name="nb_sous" value="0" size="2" /><input type="button" id="moreSous" value="+" /><input type="button" id="lessSous" value="-" /><br />
				<input type="button" id="show" value="Afficher" /><br />
			</fieldset>
			<fieldset>
				<legend>Sous-mati&egrave;res : <em>vous pourrez toujours rajoutez des sous-mati&egrave;res par la suite</em></legend>
				<span id="sousmatieres">
				</span>
			</fieldset>
			<input type="submit" value="Cr&eacute;er !" /><input type="reset" />
			<script type="text/javascript" src="addMatiere.js"></script>
		</form>
<?php
	}
	include('foot.php');
?>
