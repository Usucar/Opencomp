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
?>
		<div id="menu">
			<div id="sousmenuD">
				<a href="gestion_des_classes.php"><?php echo MENU_CLASS?></a>
				<div class="linkD">
					<ul>
<?php
	$req = query('SELECT name FROM '.$db_prefix.'classes');
	$i = 0;
	while($data = mysql_fetch_assoc($req))
	{
		$i++;
?>
						<li>
							<a href="classe.php?name=<?php echo $data['name'];?>"><?php echo $data['name'];?></a>
						</li>
<?php
	}
?>
					</ul>
				</div>
			</div>
			<div class="sousmenu">
				<a href="gestion_des_eleves.php"><?php echo MENU_PUPIL?></a>
			</div>
			<div class="sousmenu">
				<a href="gestion_des_matieres.php"><?php echo MENU_COMP?></a>
			</div>
			<div class="sousmenu">
				<a href="gestion_des_evaluations.php"><?php echo MENU_EVALUATION?></a>
			</div>
		</div>
		<div id="content">
