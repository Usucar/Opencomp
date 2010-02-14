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
	if(!empty($_GET['name']))
	{
		$name = format($_GET['name']);
		if($_GET['action'] == 'delete')
			$action = "confirmSuppr";
		else if($_GET['action'] == 'confdelete' && $_POST['eleves'] == 'on')
		{
			header ("Refresh: 2;URL=gestion_des_classes.php");
			queryAndLog("DROP TABLE IF EXISTS ".$db_prefix."eleves_".formatnospec($name));
			queryAndLog("DELETE FROM ".$db_prefix."classes WHERE name='$name'");
			$action = "Suppr1";
		}
		else if($_GET['action'] == 'confdelete' && $_POST['eleves'] == NULL)
		{
			header ("Refresh: 2;URL=gestion_des_classes.php");
			$req = query("SELECT * FROM ".$db_prefix."eleves_".formatnospec($name));
			while($data = mysql_fetch_assoc($req))
			{
				$elname = $data['name'];
				$surname = $data['surname'];
				$sex = $data['sex'];
				$birth = $data['birth'];
				queryAndLog("INSERT INTO ".$db_prefix."elevessansclasse(id, name, surname, sex, birth) VALUES ('','$elname','$surname','$sex','$birth')");
			}
			queryAndLog("DROP TABLE IF EXISTS ".$db_prefix."eleves_".formatnospec($name));
			queryAndLog("DELETE FROM ".$db_prefix."classes WHERE name='$name'");
			$action = "Suppr2";
		}
		else
			$action = "Modif";
	}
	else if(!empty($_POST['name']) && !empty($_POST['oldname']) && !empty($_POST['level']))
	{
		$name = format($_POST['name']);
		$oldname = format($_POST['oldname']);
		$req = query("SELECT * FROM ".$db_prefix."classes WHERE name='$name'");
		if(!mysql_fetch_assoc($req))
		{
			$level = format($_POST['level']);
			$num_el = format($_POST['num_el']);
			$num_ev = format($_POST['num_ev']);
			$req = query("SELECT * FROM ".$db_prefix."classes WHERE name='$oldname'");
			$req2 = query("SELECT * FROM ".$db_prefix."eleves_".formatnospec($oldname));
			if(mysql_fetch_assoc($req) && mysql_fetch_assoc($req2))
			{
				queryAndLog("CREATE TABLE IF NOT EXISTS ".$db_prefix."eleves_".formatnospec($name)."(id INT not null AUTO_INCREMENT, name VARCHAR (50) not null, surname VARCHAR (50) not null, sex INT not null, birth BIGINT not null, PRIMARY KEY (id))");
				$req = query("SELECT * FROM ".$db_prefix."eleves_".formatnospec($oldname));
				while($data = mysql_fetch_assoc($req))
				{
					$elname = $data ['name']; $surname = $data['surname']; $sex = $data['sex']; $birth = $data['birth'];
					queryAndLog("INSERT INTO ".$db_prefix."eleves_".formatnospec($name)."(id, name, surname, sex, birth) VALUES('', '$elname','$surname', '$sex', '$birth')");
				}
				queryAndLog("DROP TABLE IF EXISTS ".$db_prefix."eleves_".formatnospec($oldname));
				queryAndLog("INSERT INTO ".$db_prefix."classes(id, name, level, nb_eleves, nb_evaluations) VALUES('', '$name','$level', '$num_el', '$num_ev')");
				queryAndLog("DELETE FROM ".$db_prefix."classes WHERE name='$oldname'");
				$action = "confModif";
			}
			else
				$action = "err1";
		}
		else
			$action = "err2";
		header ("Refresh: 2;URL=gestion_des_classes.php");
	}
	else
		header ("Refresh: 0;URL=gestion_des_classes.php");

	if($action == "Suppr1" || $action == "Suppr2" || $action == "confirmSuppr")
		printHead(TITLE_SUPPR.TITLE_CLASS.$_GET['name']);
	else
		printHead(TITLE_EDIT.TITLE_CLASS.$_GET['name']);
	if($action == 'confirmSuppr')
	{
?>
		<h3><?php echo THECLASS?> <?php echo $name;?> <?php echo CLASS_WILLBEDELETED?></h3>
		<form id="confdelete" method="POST" action="classe.php?name=<?php echo $name;?>&action=confdelete">
			<input type="checkbox" name="eleves" id="eleves" /><label for="eleves"><?php echo DELETEELEVETOO?></label><br />
			<input type="submit" value="<?php echo CONFIRM ?>" />
			<a href="gestion_des_classes.php"><?php echo GOBACK?></a>
		</form>
<?php
	}
	else if($action == 'Suppr1')
	{
?>

		<h3><?php echo THECLASS?> <?php echo $name;?> <?php echo CLASS_DEL1?></h3>
		<h6><?php echo CLASS_REDIR?></h6>
<?php
	}
	else if($action == 'Suppr2')
	{
?>
		<h3><?php echo THECLASS?> <?php echo $name;?> <?php echo CLASS_DEL2?></h3>
		<h6><?php echo CLASS_REDIR?></h6>
<?php
	}
	else if($action == 'confModif')
	{
?>
		<h3><?php echo CLASS_UPDATED?></h3>
		<h6><?php echo CLASS_REDIR?></h6>
<?php
	}
	else if($action == 'err1')
	{
?>
		<h3><?php echo CLASS_ERR1?></h3>
		<h6><?php echo CLASS_REDIR?></h6>
<?php
	}
	else if($action == 'err2')
	{
?>
		<h3><?php echo CLASS_ERR2_1?> <?php echo $oldname.' en '.$name;?> : <?php echo CLASS_ERR2_2?></h3>
		<h6><?php echo CLASS_REDIR?></h6>
<?php
	}
	else if($action == 'Modif')
	{
		$req = query("SELECT * FROM ".$db_prefix."classes WHERE name='$name'");
		if($data = mysql_fetch_assoc($req))
		{
?>
		<form id="editClass" name="editClass" method="post" action="classe.php?action=confModif" onsubmit="return check()">
			<fieldset>
				<legend><?php echo EDIT?> <?php echo $name;?> :</legend>
				<label for="name"><?php echo NAME?> : </label><input type="text" id="name" name="name" value="<?php echo $data['name'];?>"tabindex="10" /><br />
				<label for="level"><?php echo LEVEL?> : </label>
				<select name="level" id="level" tabindex="20">
					<option value="CP"<?php if($data['level'] == 'CP') echo ' selected="selected"';?>>CP</option>
					<option value="CE1"<?php if($data['level'] == 'CE1') echo ' selected="selected"';?>>CE1</option>
					<option value="CE2"<?php if($data['level'] == 'CE2') echo ' selected="selected"';?>>CE2</option>
					<option value="CM1"<?php if($data['level'] == 'CM1') echo ' selected="selected"';?>>CM1</option>
					<option value="CM2"<?php if($data['level'] == 'CM2') echo ' selected="selected"';?>>CM2</option>
				</select>
				<input type="hidden" name="num_ev" value="<?php echo $data['nb_evaluations']?>" />
				<input type="hidden" name="num_el" value="<?php echo $data['nb_eleves']?>" />
				<input type="hidden" name="oldname" value="<?php echo $name;?>" /><br />
				<em><?php echo CLASS_EDIT_NOTE?></em><br />
				<input type="submit" value="<?php echo OKBUTTON?>" /><input type="reset" value="<?php echo RESETBUTTON?>"/>
			</fieldset>
		</form>
		<script type="text/javascript" src="editClass.js"></script>
<?php
		}
	}
	include('foot.php');
?>
