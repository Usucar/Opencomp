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
	printHead(MENU_COMP);
?>
		<h2><?php echo MENU_COMP?></h2>
		<table>
<?php
	$req = query("SELECT * FROM ".$db_prefix."matieres ORDER BY name");
	if(mysql_num_rows($req))
	{
?>
			<thead>
				<tr>
					<th><?php echo NAME?></th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
<?php
		while($data = mysql_fetch_assoc($req))
		{
?>
				<tr>
					<td><b><em><?php echo $data['name'];?></em></b></td>
					<td><a href="matiere.php?action=delm&id=<?php echo $data['id'];?>"><img src="img/x.png" alt="<?php echo DEL?>" title="<?php echo SUBJECT_DEL?>" /></a></td>
				</tr>
<?php
			$req2 = query("SELECT * FROM ".$db_prefix."sous_matieres WHERE id_parent='".$data['id']."' ORDER BY name");
			if(mysql_num_rows($req2))
			{
				while($data2 = mysql_fetch_assoc($req2))
				{
?>
				<tr>
					<td><?php echo $data2['name'];?></td>
					<td><a href="matiere.php?action=delsm&id=<?php echo $data2['id'];?>"><img src="img/x.png" alt="<?php echo DEL?>" title="<?php echo SUBSUBJECT_DEL?>" /></a></td>
				</tr>
<?php
				}
			}
			else
			{
?>
				<tr>
					<td><em>Aucune sous-mati&egrave;re associ&eacute;e &agrave; cette mati&egrave;re</em></td>
					<td><a href="matiere.php?sousmatiere=1&matiere=<?php echo $data['id']?>"><img src="img/plus.png" alt="<?php echo ADD?>" title="<?php echo SUBSUBJECT_ADD?>" /></a></td>
				</tr>
<?php
			}
		}
	}
	else
	{
?>
			<tbody>
				<tr>
					<td><b><em>Aucune mati&egrave;re existante, veuillez en cr&eacute;er une d'abord</em></b></td>
					<td><a href="matiere.php"><img src="img/plus.png" alt="<?php echo ADD?>" title="<?php echo SUBSUBJECT_ADD?>" /></a></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
		<form id="addmatiere" name="addmatiere" method="POST" action="matiere.php">
			<input type="submit" value="<?php echo SUBJECT_ADD?>" />
			<input type="button" value="<?php echo SUBSUBJECT_ADD?>" onClick="self.location.href='matiere.php?sousmatiere=1'" />
			<input type="button" value="<?php echo ADDCOMP?>" onClick="self.location.href='competences.php?action=add'" />
		</form>
<?php
	include('foot.php');
?>
	</body>
</html>
