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
	printHead('Installation script', $menu = 0);
?>
		<h1>Creating table :</h1>
		<h2><?php echo $db_prefix;?>classes......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'classes (id INT not null AUTO_INCREMENT, name VARCHAR (255) not null, level VARCHAR (3) not null, nb_eleves INT not null, nb_evaluations INT not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>elevessansclasse......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'elevessansclasse (id INT not null AUTO_INCREMENT, name VARCHAR (255) not null, surname VARCHAR (255) not null, sex INT not null, birth BIGINT not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>matieres.......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'matieres (id INT not null AUTO_INCREMENT, name VARCHAR (255) not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>sous_matieres......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'sous_matieres (id INT not null AUTO_INCREMENT, name VARCHAR (255) not null, id_parent INT not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>evaluations......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'evaluations (id INT not null AUTO_INCREMENT, name VARCHAR (255) not null, id_class INT not null, id_matiere INT not null, term INT not null, nb_comp INT not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>eval_result......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'eval_result (id INT not null AUTO_INCREMENT, id_eval INT not null, name VARCHAR (255) not null, surname VARCHAR (255) not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>eval_comp_link......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'eval_comp_link (id INT not null AUTO_INCREMENT, id_eval INT not null, id_comp INT not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>eval_comp......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'eval_comp (id INT not null AUTO_INCREMENT, id_sous_matiere INT not null, text BLOB not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
	<h2><?php echo $db_prefix;?>eval_comp_result......
<?php
	queryAndLog('CREATE TABLE IF NOT EXISTS '.$db_prefix.'eval_comp_result (id INT not null AUTO_INCREMENT, id_result INT not null, id_comp INT not null, value CHAR (1) not null, PRIMARY KEY (id))');
	echo 'done';
?></h2>
<?php
	include('foot.php');
?>
