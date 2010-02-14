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
	printHead('Gestion des classes');
	if(!empty($_POST['name']))
	{
		$name = format($_POST['name']);
		$req = query("SELECT name FROM ".$db_prefix."classes WHERE name='$name'");
		if(!mysql_num_rows($req))
		{
			$level = $_POST['level'];
			queryAndLog("INSERT INTO ".$db_prefix."classes(id, name, level, nb_eleves, nb_evaluations) VALUES('', '$name','$level', '0', '0')");
			if($_POST['nb_el'] >= 0 && $_POST['nb_el'] < 53)
			{
				queryAndLog("CREATE TABLE IF NOT EXISTS ".$db_prefix."eleves_".formatnospec($name)."(id INT not null AUTO_INCREMENT, name VARCHAR (50) not null, surname VARCHAR (50) not null, sex INT not null, birth BIGINT not null, PRIMARY KEY (id))");
				$count_nb_eleves = 0;
				for($i=1;$i<=$_POST['nb_el'];$i++)
				{
					if(!empty($_POST['name_eleve'.$i]) && !empty($_POST['surname_eleve'.$i]))
					{
						$elname = format($_POST['name_eleve'.$i]);
						$surname = format($_POST['surname_eleve'.$i]);
						if($_POST['sex_eleve'.$i] == 1)
							$sex = 1;
						else
							$sex = 0;
						if(!empty($_POST['birth_eleve'.$i]))
						{
							$date_array = explode("/", $_POST['birth_eleve'.$i]);
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
						queryAndLog("INSERT INTO ".$db_prefix."eleves_".formatnospec($name)."(id, name, surname, sex, birth) VALUES('', '$elname','$surname', '$sex', '$birth')");
						$count_nb_eleves++;
					}
				}
				queryAndLog("UPDATE ".$db_prefix."classes SET nb_eleves='$count_nb_eleves' WHERE name='$name'");
			}
		}
		else
			echo '<h6>Impossible d\'ajouter la classe car une autre classe porte d&eacute;j&agrave; ce nom</h6>';
	}
	$req = query("SELECT * FROM ".$db_prefix."classes ORDER BY name");
?>
		<h2>Gestions des Classes</h2>
		<table>
			<thead>
				<tr>
					<th>Nom de classe</th>
					<th>Niveau</th>
					<th>Nombre d'&eacute;l&egrave;ves</th>
					<th>Nombre d'&eacute;valuations</th>
					<th colspan="2">Actions</th>
				</tr>
			</thead>
			<tbody>
<?php
	if(mysql_num_rows($req))
	{
		while($data = mysql_fetch_assoc($req))
		{
?>
				<tr>
					<td><a href="classe.php?name=<?php echo $data['name'];?>"><?php echo $data['name'];?></a></td>
					<td><?php echo $data['level'];?></td>
					<td><?php echo $data['nb_eleves'];?></td>
					<td><?php echo $data['nb_evaluations'];?></td>
					<td><a href="classe.php?name=<?php echo $data['name'];?>"><img src="img/saisie.png" alt="Modifier" title="Modifier la classe" /></a></td>
					<td><a href="classe.php?name=<?php echo $data['name'];?>&action=delete"><img src="img/x.png" alt="Supprimer" title="Supprimer la classe" /></a></td>
				</tr>
<?php
		}
	}
	else
	{
?>
				<td colspan="6"><em>aucune classe existante dans la base de donn&eacute;es</em></td>
<?php
	}
?>
			</tbody>
		</table>
		<form id="formAdd" name="formAdd" method="post" action="gestion_des_classes.php" onsubmit="return check()">
			<input type="button" value="ajouter une classe" id="hiddener" />
			<div id="addClass" style="visibility: hidden;">
				<fieldset>
					<legend>Classe</legend>
					<label for="name">Nom de la classe : </label><input type="text" id="name" name="name" tabindex="10" /><span id="nameerror"></span><br />
					<label for="level">Niveau : </label>
					<select name="level" id="level" tabindex="20">
						<option value="CP" selected="selected">CP</option>
						<option value="CE1">CE1</option>
						<option value="CE2">CE2</option>
						<option value="CM1">CM1</option>
						<option value="CM2">CM2</option>
					</select><br />
					<label for="nb_el">Nombre d'&eacute;l&egrave;ves : </label><input type="text" id="nb_el" name="nb_el" value="0" size="2" /><input type="button" id="moreEl" value="+" /><input type="button" id="lessEl" value="-" /><br />
					<input type="button" id="show" value="Afficher" /><br />
				</fieldset>
				<fieldset>
					<legend>&eacute;l&egrave;ves : <em>vous pourrez toujours rajoutez des &eacute;l&egrave;ves par la suite</em></legend>
					<span id="eleves">
					</span>
				</fieldset>
				<input type="submit" value="Cr&eacute;er !" /><input type="reset" />
			</div>
		</form>	
		<script type="text/javascript" src="addClass.js"></script>
<?php
	include('foot.php');
?>
