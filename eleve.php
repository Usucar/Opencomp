<?php
/*
 * ========================================================================
 * Copyright (C) 2008 Sadaoui Akim
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
	$action = "";
	if(!empty($_GET['class']) && $_GET['class'] != 'noclass')
	{
		$class = format($_GET['class']);
		$id = format($_GET['id']);
		$req = query("SELECT name, surname FROM ".$db_prefix."eleves_".formatnospec($class)." WHERE id='$id'");
		$temptitle = mysql_fetch_assoc($req);
		if($_GET['action'] == 'confedit')
		{
			if(!empty($_GET['id']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['newclass']))
			{	
				$name = format($_POST['name']);
				$surname = format($_POST['surname']);
				$newclass = format($_POST['newclass']);
				if($_POST['sex'])
					$sex = 1;
				else
					$sex = 0;
				if(!empty($_POST['birth']))
				{
					$date_array = explode("/", $_POST['birth']);
					if(strlen($date_array[0]) == 2 && strlen($date_array[1]) == 2 && strlen($date_array[2]) == 4 && $date_array[0] >= 01 && $date_array[0] <= 31 && $date_array[1] >= 01 && $date_array[1] <= 12 && $date_array[2] >= 190 && $date_array[2] <= 2100)
					{
						$birth = mktime(0, 0, 0, $date_array[1], $date_array[0], $date_array[2]);
						if($birth > time() || $birth == false || $birth == -1)
							$birth = 0;
					}
					else
						$birth = 0;
				}
				else
					$birth = 0;
				if($newclass == $class)
					queryAndLog("UPDATE ".$db_prefix."eleves_".formatnospec($newclass)." SET name='$name', surname='$surname', sex='$sex', birth='$birth' WHERE id='$id'");
				else if($newclass == 'noclass')
				{
					queryAndLog("DELETE FROM ".$db_prefix."eleves_".formatnospec($class)." WHERE id='$id'");
					queryAndLog("CREATE TABLE IF NOT EXISTS ".$db_prefix."elevessansclasse(id INT not null AUTO_INCREMENT, name VARCHAR (50) not null, surname VARCHAR (50) not null, sex INT not null, birth BIGINT not null, PRIMARY KEY (id))");
					queryAndLog("INSERT INTO ".$db_prefix."elevessansclasse(id, name, surname, sex, birth) VALUES ('', '$name', '$surname', '$sex', '$birth')");
				}
				else
				{
					queryAndLog("DELETE FROM ".$db_prefix."eleves_".formatnospec($class)." WHERE id='$id'");
					queryAndLog("CREATE TABLE IF NOT EXISTS ".$db_prefix."eleves_".formatnospec($newclass)."(id INT not null AUTO_INCREMENT, name VARCHAR (50) not null, surname VARCHAR (50) not null, sex INT not null, birth BIGINT not null, PRIMARY KEY (id))");
					queryAndLog("INSERT INTO ".$db_prefix."eleves_".formatnospec($newclass)."(id, name, surname, sex, birth) VALUES ('', '$name', '$surname', '$sex', '$birth')");
				}
			}
			header("Refresh: 2;URL=gestion_des_eleves.php");
		}
		else if($_GET['action'] == 'confdelete')
		{
			if(!empty($_GET['id']))
			{
				$req = query("SELECT name, surname FROM ".$db_prefix."eleves_".formatnospec($class)." WHERE id='$id'");
				$temptitle = mysql_fetch_assoc($req);
				$msg = $temptitle;
				queryAndLog("DELETE FROM ".$db_prefix."eleves_".formatnospec($class)." WHERE id='$id'");
				$req = query("SELECT nb_eleves FROM ".$db_prefix."classes WHERE name='$class'");
				$rep = mysql_fetch_assoc($req);
				$temp = $rep['nb_eleves'] - 1;
				queryAndLog("UPDATE ".$db_prefix."classes SET nb_eleves='$temp' WHERE name='$class'");
				$action = 'delete1';
			}
			else
			{
				queryAndLog("DELETE FROM ".$db_prefix."eleves_".formatnospec($class));
				queryAndLog("UPDATE ".$db_prefix."classes SET nb_eleves='0' WHERE name='$class'");
				$action = 'deleteall';
			}
			header("Refresh: 2;URL=gestion_des_eleves.php");
		}
	}
	else
	{
		$id = format($_GET['id']);
		$req = query("SELECT name, surname FROM ".$db_prefix."elevessansclasse WHERE id='$id'");
		$temptitle = mysql_fetch_assoc($req);
		if($_GET['action'] == 'confedit')
		{
			if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['newclass']))
			{
				$name = format($_POST['name']);
				$surname = format($_POST['surname']);
				$newclass = format($_POST['newclass']);
				if($_POST['sex'])
					$sex = 1;
				else
					$sex = 0;
				if(!empty($_POST['birth']))
				{
					$date_array = explode("/", $_POST['birth']);
					if(strlen($date_array[0]) == 2 && strlen($date_array[1]) == 2 && strlen($date_array[2]) == 4 && $date_array[0] >= 01 && $date_array[0] <= 31 && $date_array[1] >= 01 && $date_array[1] <= 12 && $date_array[2] >= 190 && $date_array[2] <= 2100)
					{
						$birth = mktime(0, 0, 0, $date_array[1], $date_array[0], $date_array[2]);
						if($birth > time() || $birth == false || $birth == -1)
							$birth = 0;
					}
					else
						$birth = 0;
				}
				else
					$birth = 0;
				if($newclass == 'noclass' && !empty($id))
					queryAndLog("UPDATE ".$db_prefix."elevessansclasse SET name='$name', surname='$surname', sex='$sex', birth='$birth' WHERE id='$id'");
				else if($newclass == 'noclass')
					queryAndLog("INSERT INTO ".$db_prefix."elevessansclasse(id, name, surname, sex, birth) VALUES ('', '$name', '$surname', '$sex', '$birth')");
				else
				{
					queryAndLog("DELETE FROM ".$db_prefix."elevessansclasse  WHERE id='$id'");
					queryAndLog("CREATE TABLE IF NOT EXISTS ".$db_prefix."eleves_".formatnospec($newclass)."(id INT not null AUTO_INCREMENT, name VARCHAR (50) not null, surname VARCHAR (50) not null, sex INT not null, birth BIGINT not null, PRIMARY KEY (id))");
					queryAndLog("INSERT INTO ".$db_prefix."eleves_".formatnospec($newclass)."(id, name, surname, sex, birth) VALUES ('', '$name', '$surname', '$sex', '$birth')");
				}
			}
			header("Refresh: 0;URL=gestion_des_eleves.php");
		}
		else if($_GET['action'] == 'confdelete')
		{
			if(!empty($_GET['id']))
			{
				$req = query("SELECT name, surname FROM ".$db_prefix."elevessansclasse WHERE id='$id'");
				$temptitle = mysql_fetch_assoc($req);
				$msg = $temptitle;
				queryAndLog("DELETE FROM ".$db_prefix."elevessansclasse WHERE id='$id'");
				$req = query("SELECT nb_eleves FROM ".$db_prefix."classes WHERE name='$class'");
				$rep = mysql_fetch_assoc($req);
				$temp = $rep['nb_eleves'] - 1;
				queryAndLog("UPDATE ".$db_prefix."classes SET nb_eleves='$temp' WHERE name='$class'");
				$action = 'delete1';
			}
			else
			{
				queryAndLog("DELETE FROM ".$db_prefix."elevessansclasse");
				queryAndLog("UPDATE ".$db_prefix."classes SET nb_eleves='0' WHERE name='$class'");
				$action = 'deleteall';
			}
			header("Refresh: 2;URL=gestion_des_eleves.php");
		}
	}


	if(($_GET['action'] == 'delete' && !empty($_GET['id'])) || $action == 'confdelete')
		printHead('Suppression de l\'&eacute;l&egrave;ve '.$temptitle['name'].' '.$temptitle['surname']);
	else if($_GET['action'] == 'delete' || $action == 'deleteall')
		printHead('Suppression des &eacute;l&egrave;ves de la classe '.$class);
	else if($_GET['action'] == 'edit' || $_GET['action'] == 'confedit')
		printHead('Edition de l\'&eacute;l&egrave;ve '.$temptitle['surname'].''.$temptitle['name']);
	else
		printHead('Redirection');
	if($_GET['action'] == 'delete')
	{
		if(!empty($_GET['class']))
		{
			if(!empty($_GET['id']))
			{
				$id = format($_GET['id']);
				$req = query("SELECT name, surname FROM ".$db_prefix."eleves_".formatnospec($class)." WHERE id='$id'");
				$rep = mysql_fetch_assoc($req);
?>
		<h3>L'&eacute;l&egrave;ve <?php echo $rep['surname'].' '.$rep['name']?> sera supprim&eacute;</h3>
		<form id="confdelete" method="POST" action="eleve.php?class=<?php echo $class;?>&action=confdelete&id=<?php echo $id;?>">
			<input type="submit" value="Confirmer" />
			<a href="gestion_des_eleves.php">Annuler</a>
		</form>
<?php
			}
			else
			{
?>
		<h3>Tous les &eacute;l&egrave;ves de la classe <?php echo $class;?> seront supprim&eacute;s</h3>
		<form id="confdelete" method="POST" action="eleve.php?class=<?php echo $class;?>&action=confdelete&id=">
			<input type="submit" value="Confirmer" />
			<a href="gestion_des_eleves.php">Annuler</a>
		</form>
<?php
			}
		}
		else
		{
			if(!empty($_GET['id']))
			{
				$id = format($_GET['id']);
				$req = query("SELECT name, surname FROM ".$db_prefix."elevessansclasse WHERE id='$id'");
				$rep = mysql_fetch_assoc($req);
?>
		<h3>L'&eacute;l&egrave;ve <?php echo $rep['surname'].' '.$rep['name']?> sera supprim&eacute;</h3>
		<form id="confdelete" method="POST" action="eleve.php?action=confdelete&id=<?php echo $id;?>&class=">
			<input type="submit" value="Confirmer" />
			<a href="gestion_des_eleves.php">Annuler</a>
		</form>
<?php
			}
			else
			{
?>
		<h3>Tous les &eacute;l&egrave;ves sans classe seront supprim&eacute;s</h3>
		<form id="confdelete" method="POST" action="eleve.php?action=confdelete&id=">
			<input type="submit" value="Confirmer" />
			<a href="gestion_des_eleves.php">Annuler</a>
		</form>
<?php
			}
		}
	}
	else if($_GET['action'] == 'edit')
	{
		if(!empty($class))
		{
			$req = query("SELECT * FROM ".$db_prefix."eleves_".formatnospec($class)." WHERE id='$id'");
?>
		<form id="edit" name="edit" method="post" action="eleve.php?id=<?php echo $id;?>&action=confedit&class=<?php echo $class?>">
<?php
		}
		else
		{
			$req = query("SELECT * FROM ".$db_prefix."elevessansclasse WHERE id='$id'");
?>
		<form id="edit" name="edit" method="post" action="eleve.php?id=<?php echo $id;?>&action=confedit&class=noclass">
<?php
		}
		$rep = mysql_fetch_assoc($req);
?>
			<fieldset>
				<legend><?php if(!empty($id)) echo 'Modifier'; else echo 'Cr&eacute;er un &eacute;l&egrave;ve';?> <?php echo $rep['surname'].' '.$rep['name'];?>:</legend>
				<label for="name">Nom : </label>
				<input type="text" id="name" name="name" value="<?php echo $rep['name'];?>" tabindex="10" /><br />
				<label for="surname">Pr&eacute;nom : </label>
				<input type="text" id="surname" name="surname" value="<?php echo $rep['surname'];?>" tabindex="20" /><br />
				<label for="sex">Sexe : </label>
				<select name="sex" id="sex" tabindex="30">
					<option value="1" <?php if($rep['sex']) echo 'selected="selected"';?>>Gar&ccedil;on</option>
					<option value="0" <?php if(!$rep['sex']) echo 'selected="selected"';?>>Fille</option>
				</select><br />
				<label for="newclass">Classe : </label>
				<select name="newclass" id="newclass" tabindex="40">
<?php
		$req = query("SELECT name, id, level, nb_eleves FROM ".$db_prefix."classes ORDER BY name");
		while ($data = mysql_fetch_assoc($req))
		{
?>
					<option value="<?php echo $data['name'];?>" <?php if($data['name'] == $class || $data['id'] == format($_GET['fillclass'])) echo 'selected="selected"'?>><?php echo $data['name'].' - '.$data['level'].' ('.$data['nb_eleves'].' &eacute;l&egrave;ves)';?> </option>
<?php
		}
?>
					<option value="noclass" <?php if(empty($_GET['class']) && $data['id'] == format($_GET['fillclass'])) echo 'selected="selected"';?>>&eacute;l&egrave;ves sans classe</option>
				</select><br />
				<label for="birth">Date de naissance : </label>
				<input type="text" name="birth" id="birth" value="<?php if($rep['birth'] != 0) echo date('d/m/Y',$rep['birth']);?>" tabindex="50" /><br />
				<input type="submit" value="Valider" /><input type="reset" />
		</form>
<?php
	}
	else if($_GET['action'] == 'confedit')
	{
?>
		<h3>Les modifications ont &eacute;t&eacute; appliqu&eacute;es avec succ&egrave;s</h3>
		<h6>Redirection vers Gestion des &eacute;l&egrave;ves dans 2 secondes...</h6>
<?php
	}
	else if($action == 'delete1')
	{
?>
		<h3>L'&eacute;l&egrave;ve <?php echo $msg['name'].' '.$msg['surname'];?> a &eacute;t&eacute; supprim&eacute;</h3>
		<h6>Redirection vers Gestion des &eacute;l&egrave;ves dans 2 secondes...</h6>
<?php
	}
	else if($action == 'deleteall')
	{
?>
		<h3>Tous les &eacute;l&egrave;ves de la classe <?php echo $class;?> ont &eacute;t&eacute; supprim&eacute;</h3>
		<h6>Redirection vers Gestion des &eacute;l&egrave;ves dans 2 secondes...</h6>
<?php
	}
	include('foot.php');
?>
