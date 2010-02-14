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
	
//General
define('VERSION','-0.4~r2');
define('DEF','Gnote - Gestion de r&eacute;sultats scolaires par naviguateur');
define('CONFIRM','Confimer');
define('GOBACK','Annuler');
define('NAME','Nom');
define('LEVEL','Niveau');
define('OKBUTTON','Valider');
define('RESETBUTTON','Effacer');
define('ADD','Ajouter');
define('EDIT','Modifier');
define('DEL','Supprimer');
//menu.php
define('MENU_CLASS','Gestion des classes');
define('MENU_PUPIL','Gestion des &eacute;l&egrave;ves');
define('MENU_COMP','Gestion des Comp&eacute;tences');
define('MENU_EVALUATION','Gestion des &eacute;valuations');
//classe.php
define('TITLE_SUPPR','Suppression');
define('TITLE_EDIT','Edition');
define('TITLE_CLASS','de la classe');
define('THECLASS','La classe');
define('CLASS_WILLBEDELETED','sera supprim&eacute;e !');
define('DELETEELEVETOO','Supprimer les &eacute;l&egrave;ves &eacute;galement');
define('CLASS_DEL1','et tout ses &eacute;l&egrave;ves ont &eacute;t&eacute; supprim&eacute;s !');
define('CLASS_DEL2','a &eacute;t&eacute; supprim&eacute;e !');
define('CLASS_UPDATED','La classe a &eacute;t&eacute; mise &agrave; jour !');
define('CLASS_ERR1','Impossible de trouver les informations sur la classe &agrave; &eacute;diter, la base de donn&eacute;es est peut-&ecirc;tre corrompue ?');
define('CLASS_ERR2_1','Impossible de renommer');
define('CLASS_ERR2_2','une classe porte d&eacute;j&agrave; ce nom !');
define('CLASS_REDIR','Redirection Vers Gestion des Classes dans 2 secondes...');
define('CLASS_EDIT_NOTE','Note : tous les &eacute;l&egrave;ves et les &eacute;valuations seront conser&eacute;s m&ecirc;me si la classe change de nom');
//gestion_des_eleves.php
define('ADD_EL','Ajouter un &eacute;l&egrave;ve');
//gestion_des_matieres.php
define('SUBJECT_ADD','Ajouter une mati&egrave;re');
define('SUBSUBJECT_ADD','Ajouter une sous-mati&egrave;re');
define('SUBJECT_DEL','Supprimer la mati&egrave;re');
define('SUBSUBJECT_DEL','Supprimer la sous-mati&egrave;re');
//competences.php
define('ADDCOMP','Ajouter une comp&eacute;tence');
define('COMP','Comp&eacute;tence');
define('COMP_EXIST','Une comp&eacute;tence porte d&eacute;j&agrave; ce nom pour cette sous-mati&egrave;re !');
define('COMP_REDIR','Redirection vers Gestion des comp&eacute;tences dans 2 secondes...');
define('SUBSUBJECT_UNKNOW','Cette sous-mati&egrave;re n\'existe pas !');
define('COMP_GOBACK','Retour en arri&egrave;re dans 2 secondes...');
define('COMP_ADDED','Comp&eacute;tence ajout&eacute;e !');
define('NO_SUBJECT','Pas de mati&egrave;re existante, veuillez en cr&eacute;er d\'abord !');
define('NO_SUBSUBJECT','Pas de sous-mati&egrave;re existante, veuillez en cr&eacute;er d\'abord !');
//gestion_des_evaluations.php
define('ADDEVAL','Ajouter une &eacute;valuations');
define('NOEVAL','Aucune &eacute;valuation dans la base de donn&eacute;e, veuillez en cr&eacute;er une d\'abord !');
define('EVAL_EDIT','Modifier l\'&eacute;valuation');
define('EVAL_WRITE','Rentrer les r&eacute;sultats de l\'&eacute;valuation');
define('EVAL_DEL','Supprimer l\'&eacute;valuation');
//evaluation.php
define('TERM','Trimestre');
define('FIRST_TERM','premier trimestre');
define('SECOND_TERM','second trimestre');
define('THIRD_TERM','troisi&egrave;me trimestre');
define('CLASSEVALUATED','Classe ayant pass&eacute;e l\'&eacute;valuation');
define('SUBJECT','Mati&egrave;re');
define('SUBSUBJECT','Sous-mati&egrave;re');
define('NBCOMP','Nombre de comp&eacute;tence');
define('EVAL_REDIR','Redirection vers Gestion des &eacute;valuations dans 2 secondes...');
define('EVAL_GOBACK','Retour en arri&egrave;re dans 2 secondes...');
define('EVAL_ADDED','Evaluation cr&eacute;&eacute; avec succ&egrave;es');
define('EVAL_NOCLASS','Aucune classe dans la base de don&eacute;e, veuillez en cr&eacute;er une d\'abord !');
define('EVAL_NOSUBJECT','Aucune mati&egrave;re dans la base de don&eacute;e, veuillez en cr&eacute;er une d\'abord !');
define('EVAL_NAME_UNDISP','Une &eacute;valuation porte d&eacute;j&agrave; ce nom !');
define('NEW_COMP','Nouvelle comp&eacute;tence');
?>
