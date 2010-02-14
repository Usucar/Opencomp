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
		$name = format($_POST['name']);
		$class = format($_POST['class']);
		$subject = format($_POST['subject']);
		$nb_comp = format($_POST['nb_comp']);
		switch($_GET['action'])
		{
			case add:
				printHead(ADDEVAL);
				addeval();
				break;
			case confadd:
				printHead(ADDEVAL);
				confeval($name, $class, $subject, $nb_comp);
				break;
			case confadd2:
				printHead(ADDEVAL);
				lastconfeval($name, $nb_comp);
				break;
			default:
				header("Location: gestion_des_evaluations.php");
				break;
		}
	}
	else
		header("Location: gestion_des_evaluations.php");
	include('foot.php');


	function lastconfeval($name, $nb_comp)
	{
		include("configs.php");
		$id_eval = mysql_fetch_assoc(query("SELECT id FROM ".$db_prefix."evaluations WHERE name='$name'"));
		$id_eval = $id_eval['id'];
		for($i = 1;$i <= $nb_comp;$i++)
		{
			if(format($_POST['C'.$i]) == 'othercomp')
			{
				$id_sousmatiere_comp = format($_POST['subsubject'.$i]);
				$text = format($_POST['Cother'.$i]);
				$req = query("SELECT id FROM ".$db_prefix."eval_comp WHERE id_sous_matiere='$id_sous_matiere' AND text='$text'");
				if(mysql_num_rows($req))
					$id_comp = mysql_fetch_array($req);
				else
				{
					queryAndLog("INSERT INTO ".$db_prefix."eval_comp(id, id_sous_matiere, text) VALUES ('', '$id_sous_matiere', '$text')");
					$id_comp = $last_insert_id;
				}
				queryAndLog("INSERT INTO ".$db_prefix."eval_comp_link(id, id_eval, id_comp) VALUES ('', '$id_eval', '$id_comp')");
			}
			else if(mysql_num_rows(query("SELECT * FROM ".$db_prefix."eval_comp WHERE id='C".$i."'")))
				queryAndLog("INSERT INTO ".$db_prefix."eval_comp_link(id, id_eval, id_comp) VALUES ('', '$id_eval', 'C".$i."')");
		}
		header ("Refresh: 2;URL=gestion_des_evaluations.php");
?>
			<h3><?php echo EVAL_ADDED?><h3>
			<h6><?php echo EVAL_REDIR?></h6>
<?php
	}


	function confeval($name, $class, $subject, $nb_comp)
	{
		$term = format($_POST['term']);
		include("configs.php");
		if(mysql_num_rows(query("SELECT name FROM ".$db_prefix."evaluations WHERE name='$name'")))
		{
?>
			<h3><?php echo EVAL_NAME_UNDISP?></h3>
			<h6><?php echo EVAL_GOBACK?></h6>
<?php
			header("Refresh: 2;URL=evaluation.php?action=add&name=$name&class=$class&subject=$subject&nb_comp=$nb_comp");
			return -1;
		}
		queryAndLog("INSERT INTO ".$db_prefix."evaluations(id, name, id_class, id_matiere, term, nb_comp) VALUES ('', '$name', '$class', '$subject', '$term', '$nb_comp')");
		$req = query("SELECT nb_evaluations FROM ".$db_prefix."classes WHERE id='$class'");
		$nb_evaluations = mysql_fetch_assoc($req);
		$nb_evaluations = $nb_evaluations['nb_evaluation'] + 1;
		queryAndLog("UPDATE ".$db_prefix."classes SET nb_evaluations='$nb_evaluations' WHERE id='$class'");
?>
			<script type="text/javascript" src="addComp.js"></script>
			<form id="confadd" name="confadd" method="post" action="evaluation.php?action=confadd2">
<?php
		for($i = 1; $i <= $nb_comp; $i++)
		{
?>
				<label for="C<?php echo $i?>">C<?php echo $i?> : </label>
				<select name="C<?php echo $i?>" id="C<?php echo $i?>" tabindex="<?php echo $i*10-1?>" onchange="toggleVisibility('C<?php echo $i?>', 'newComp<?php echo $i?>');">
<?php
			$req = query("SELECT id, name FROM ".$db_prefix."sous_matieres WHERE id_parent='$subject'");
			if(mysql_num_rows($req))
			{
				$req2 = query("SELECT id, text FROM ".$db_prefix."eval_comp");
				if(mysql_num_rows($req2))
				{
					while($data = mysql_fetch_assoc($req))
					{
?>
					<optgroup label="<?php echo $data['name']?>">
<?php
						while($data2 = mysql_fetch_assoc($req2))
						{
?>
							<option value="<?php echo $data2['id']?>"><?php echo substr($data2['text'],0,10)."..."?></option>
<?php
						}
?>
					</optgroup>
<?php
					}
				}
			}
?>
					<option value="othercomp" selected="selected"><em><?php echo NEW_COMP?> : </em></option>
				</select>
				<span id="newComp<?php echo $i?>" style="visibility: vivible;">
					<textarea name="Cother<?php echo $i?>" rows="2" cols="50" tabindex="<?php echo $i*10?>"></textarea>
					<label for="subsubject<?php echo $i?>"><?php echo SUBSUBJECT?></label>
					<select name="subsubject<?php echo $i?>" id="subsubject<?php echo $i?>" tabindex="<?php echo $i*10+1?>">
<?php
			$req2 = query("SELECT id, name FROM ".$db_prefix."sous_matieres WHERE id_parent='$subject'");
			if(mysql_num_rows($req2))
			{
				while($data = mysql_fetch_assoc($req2))
				{
?>
						<option value="<?php echo $data['id']?>"><?php echo $data['name']?></option>
<?php
				}
			}
?>
					</select><br />
				</span>
<?php
		}
?>
				<input type="submit" value="<?php echo OKBUTTON?>" /><input type="reset" value="<?php echo RESETBUTTON?>" /><input type="hidden" name="name" value="<?php echo $name?>" /><input type="hidden" name="nb_comp" value="<?php echo $nb_comp?>" />
		</form>
<?php
		return 0;
	}


	function addeval()
	{
		include("configs.php");
		$name = format($_GET['name']);
		$class = format($_GET['class']);
		$subject = format($_GET['subject']);
		$nb_comp = format($_GET['nb_comp']);
		$req1 = query("SELECT id, name FROM ".$db_prefix."classes ORDER BY name");
		$req2 = query("SELECT id, name FROM ".$db_prefix."matieres ORDER BY name");
		if(mysql_num_rows($req1) && mysql_num_rows($req2))
		{
?>
			<form id="addeval" name="addeval" method="post" action="evaluation.php?action=confadd">
				<fieldset>
					<legend><?php echo ADDEVAL?></legend>
					<label for="name"><?php echo NAME?> : </label>
					<input type="text" value="<?php $name?>" id="name" name="name" tabindex="10" /><br />
					<label for="term"><?php echo TERM?> : </label>
					<select name="term" id="term" tabindex="15">
						<option value="1"><?php echo FIRST_TERM?></option>
						<option value="2"><?php echo SECOND_TERM?></option>
						<option value="3"><?php echo THIRD_TERM?></option>
					</select><br />
					<label for="class"><?php echo CLASSEVALUATED?> : </label>
					<select name="class" id="class" tabindex="20">
<?php
			while($data = mysql_fetch_assoc($req1))
			{
?>
						<option value="<?php echo $data['id']?>"<?php if($data['id'] == $class) echo ' selected="selected"'?>><?php echo $data['name']?></option>
<?php
			}
?>
					</select><br />
					<label for="subject"><?php echo SUBJECT?> : </label>
					<select name="subject" id="subject" tabindex="30">
<?php
			while($data = mysql_fetch_assoc($req2))
			{
?>
						<option value="<?php echo $data['id']?>"<?php if($data['id'] == $subject) echo ' selected="selected"'?>><?php echo $data['name']?></option>
<?php
			}
?>
					</select><br />
					<label for="nb_comp"><?php echo NBCOMP?> : </label>
					<input type="text" id="nb_comp" name="nb_comp" value="<?php echo $nb_comp?>" tabindex="50" /><br />
					<input type="submit" value="<?php echo OKBUTTON?>" /><input type="reset" value="<?php echo RESETBUTTON?>" />
				</fieldset>
			</form>
<?php
		}
		elseif(!mysql_num_rows($req1))
		{
?>
			<h3><?php echo EVAL_NOCLASS?></h3>
			<h6><?php echo EVAL_REDIR?></h6>
<?php
			return -1;
		}
		else
		{
?>
			<h3><?php echo EVAL_NOSUBJECT?></h3>
			<h6><?php echo EVAL_REDIR?></h6>
<?php
			return -2;
		}
		return 0;
	}
?>
