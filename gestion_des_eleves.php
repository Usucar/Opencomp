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
	printHead('Gestions des &eacute;l&egrave;ves');
?>
		<h2>Gestion des &eacute;l&egrave;ves</h2>
		<table>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Pr&eacute;nom</th>
					<th>sex</th>
					<th>Date de naissance</th>
					<th colspan="2">Actions</th>
				</tr>
			</thead>
			<tbody>
<?php
	$compteur = 0;
	$req = query("SELECT name, id FROM ".$db_prefix."classes ORDER BY name");
	if(mysql_num_rows($req))
	{
		while($data = mysql_fetch_assoc($req))
		{
?>
				<tr>
					<td colspan="6"><b><em><?php echo $data['name'];?></em></b></td>
				</tr>
<?php
			$req2 = query("SELECT * FROM ".$db_prefix."eleves_".formatnospec($data['name'])." ORDER BY name, surname");
			if(mysql_num_rows($req2))
			{
				while($data2 = mysql_fetch_assoc($req2))
				{
?>
				<tr>
					<td><?php echo $data2['name'];?></td>
					<td><?php echo $data2['surname'];?></td>
					<td><?php if($data2['sex'] ==1) echo '<img src="img/male.png" alt="gar&ccedill;on" />' ; else echo '<img src="img/female.png" alt="fille" />';?></td>
					<td><?php if($data2['birth'] != 0) echo date('d/m/Y',$data2['birth']); else echo 'inconnu';?></td>
					<td><a href="eleve.php?class=<?php echo $data['name'];?>&id=<?php echo $data2['id'];?>&action=edit"><img src="img/saisie.png" alt="Modifier" title="Modifier l'&eacute;l&egrave;ve" /></a></td>
					<td><a href="eleve.php?class=<?php echo $data['name'];?>&id=<?php echo $data2['id'];?>&action=delete"><img src="img/x.png" alt="Supprimer" title="Supprimer l'&eacute;l&egrave;ve" /></a></td>
				</tr>
<?php
				}
			}
			else
			{
?>
				<tr>
					<td colspan="5"><em>aucun &eacute;l&egrave;ve dans cette classe</em></td>
					<td><a href="eleve.php?action=edit&fillclass=<?php echo $data['id']?>"><img src="img/plus.png" alt="<?php echo ADD?>" title="<?php echo ADD_EL?>" /></a></td>
				</tr>
<?php
			}
		}
	}
	else
		$compteur++;
	$req = query("SELECT * FROM ".$db_prefix."elevessansclasse ORDER BY name, surname");
	if(mysql_num_rows($req))
	{
?>
				<tr>
					<td colspan="6"><b><em>&eacute;l&egrave;ves sans classe</em></b></td>
				<tr>
<?php
		while($data = mysql_fetch_assoc($req))
		{
?>
				<tr>
					<td><?php echo $data['name'];?></td>
					<td><?php echo $data['surname'];?></td>
					<td><?php if($data['sex'] ==1) echo '<img src="img/male.png" alt="garçon" />' ; else echo '<img src="img/female.png" alt="fille" />';?></td>
					<td><?php if($data['birth'] != 0) echo date('d/m/Y',$data['birth']); else echo 'inconnu';?></td>
					<td><a href="eleve.php?id=<?php echo $data['id'];?>&action=edit&class="><img src="img/saisie.png" alt="Modifier" title="Modifier l'&eacute;l&egrave;ve" /></a></td>
					<td><a href="eleve.php?id=<?php echo $data['id'];?>&action=delete&class="><img src="img/x.png" alt="Supprimer" title="Supprimer l'&eacute;l&egrave;ve" /></a></td>
				</tr>
<?php
		}
	}
	else
	{
		$compteur++;
		if($compteur == 2)
		{
?>
				<tr>
					<td colspan="6"><em>Aucun &eacute;l&egrave;ve existant, veuillez en cr&eacute;er d'abord!</em></td>
				</tr>
<?php
		}
	}
?>
			</tbody>
		</table>
		<form name="add" method="post" action="eleve.php?action=edit">
			<input type="submit" value="ajouter un &eacute;l&egrave;ve" />
		</form>
<?php
	include('foot.php');
?>
