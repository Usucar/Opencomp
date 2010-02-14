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
	include("commons.php");
	if(!empty($_GET['action']))
	{
		switch($_GET['action'])
		{
			case add:
				printHead(ADDCOMP);
				addcomp();
				break;
			case confadd:
				$name = format($_POST['name']);
				$subsubject = format($_POST['subsubject']);
				printHead(ADDCOMP);
				confadd($name, $subsubject);
				break;
			default:
				header("Location: gestion_des_matieres.php");
				break;
		}
	}
	else
		header("Location: gestion_des_matieres.php");
	include('foot.php');

	function confadd($name, $subsubject)
	{
		include("configs.php");
		if(mysql_num_rows(query("SELECT * FROM ".$db_prefix."eval_comp WHERE id_sous_matiere='$subsubject' AND text='$name'")))
		{
			header("Refresh: 2;URL=competences?action=add&subsubject=$subsubject&name=$name");
?>
			<h3><?php echo COMP_EXIST?></h3>
			<h6><?php echo COMP_GOBACK?></h6>
<?php
			return -1;
		}
		if(mysql_num_rows(query("SELECT id FROM ".$db_prefix."sous_matieres WHERE id='$subsubject'")))
		{
			queryAndLog("INSERT INTO ".$db_prefix."eval_comp(id, id_sous_matiere, text) VALUES ('', '$subsubject', '$name')");
			header("Refresh: 2;URL=gestion_des_matieres.php");
?>
			<h3><?php echo COMP_ADDED?></h3>
			<h6><?php echo COMP_REDIR?></h6>
<?php
		}
		else
		{
			header("Refresh: 2;URL=competences?action=add&subsubject=$subsubject&name=$name");
?>
			<h3><?php echo SUBSUBJECT_UNKNOW?></h3>
			<h6><?php echo COMP_GOBACK?></h6>
<?php
			return -2;
		}
?>
<?php
		return 0;
	}

	function addcomp()
	{
		include("configs.php");
		$req = query("SELECT name, id FROM ".$db_prefix."matieres ORDER BY name");
		if(mysql_num_rows($req))
		{
			$req2 = query("SELECT * FROM ".$db_prefix."sous_matieres");
			if(mysql_num_rows($req2))
			{
?>
			<form id="addcomp" name="addcomp" method="post" action="competences.php?action=confadd">
				<fieldset>
					<legend><?php echo ADDCOMP?></legend>
					<label for="name"><?php echo COMP?> : </label>
					<textarea name="name" id="name" rows="2" cols="50" tabindex="10"><?php echo format($_GET['name'])?></textarea><br />
					<label for="subsubject"><?php echo SUBSUBJECT?> : </label>
					<select name="subsubject" id="subsubject" tabindex="20">
<?php
				while($data = mysql_fetch_assoc($req))
				{
					$req2 = query("SELECT name, id FROM ".$db_prefix."sous_matieres WHERE id_parent='".$data['id']."' ORDER BY name");
					if(mysql_num_rows($req2))
					{
?>
						<optgroup label="<?php echo $data['name']?>">
<?php
						while($data2 = mysql_fetch_assoc($req2))
						{
?>
							<option value="<?php echo $data2['id']?>"<?php if($data2['id'] == $_GET['subsubject']) echo ' selected=selected'?>><?php echo $data2['name']?></option>
<?php
						}
?>
						</optgroup>
<?php
					}
				}
?>
					</select>
					<input type="submit" value="<?php echo OKBUTTON?>" /><input type="reset" value="<?php echo RESETBUTTON?>" />
				</fieldset>
			</form>
<?php
			}
			else
			{
			header("Refresh: 2;URL=gestion_des_matieres.php");
?>
			<h3><?php echo NO_SUBSUBJECT?></h3>
			<h6><?php echo COMP_REDIR?></h6>
<?php
				return -2;
			}
		}
		else
		{
			header("Refresh: 2;URL=gestion_des_matieres.php");
?>
			<h3><?php echo NO_SUBJECT?></h3>
			<h6><?php echo COMP_REDIR?></h6>
<?php
			return -1;
		}
		return 0;
	}
?>
