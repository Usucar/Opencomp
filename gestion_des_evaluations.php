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
	printHead(MENU_EVALUATION);
?>
		<h2><?php echo MENU_EVALUATION?></h2>
<?php
	$req = query("SELECT name FROM ".$db_prefix."evaluations");
	if(mysql_num_rows($req))
	{
?>
		<table>
			<thead>
				<tr>
					<th>Evaluations</th>
					<th colspan="3">Actions</th>
				</tr>
			</thead>
			<tbody>
<?php
		$req = query("SELECT id, name FROM ".$db_prefix."classes WHERE nb_evaluations > 0");
		while($data = mysql_fetch_assoc($req))
		{
?>
				<tr>
					<td colspan="4"><h3><?php echo $data['name']?></h3></td>
				</tr>
<?php
			$req2 = query("SELECT name, id FROM ".$db_prefix."matieres ORDER BY name");
			while($data2 = mysql_fetch_assoc($req2))
			{
				if(mysql_num_rows(query("SELECT name FROM ".$db_prefix."evaluations WHERE id_class='".$data['id']."' AND id_matiere='".$data2['id']."'")))
				{
?>
				<tr>
					<td colspan="4"><b><?php echo $data2['name']?></b></td>
				</tr>
<?php
					$req3 = query("SELECT id, name FROM ".$db_prefix."evaluations WHERE id_class='".$data['id']."' AND id_matiere='".$data2['id']."' ORDER BY name");
					if(mysql_num_rows($req3))
					{
						while($data3 = mysql_fetch_assoc($req3))
						{
?>
				<tr>
					<td><?php echo $data3['name']?></td>
					<td><a href=""><img src="img/report_eval.png" alt="<?php echo EVAL_WRITE?>" title="<?php echo EVAL_WRITE?>" /></a></td>
					<td><a href=""><img src="img/saisie.png" alt="<?php echo EDIT?>" title="<?php echo EVAL_EDIT?>" /></a></td>
					<td><a href=""><img src="img/x.png" alt="<?php echo DEL?>" title="<?php echo EVAL_DEL?>" /></a></td>
				</tr>
<?php
						}
					}
				}
			}
		}
	}
	else
	{
?>
			<tbody>
				<tr>
					<td><?php echo NOEVAL?></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
		<form id="addeval" name="addeval" method="POST" action="evaluation.php?action=add">
			<input type="submit" value="<?php echo ADDEVAL?>" />
		</form>
<?php
	include('foot.php');
?>
