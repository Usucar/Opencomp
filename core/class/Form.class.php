<?php

/*
 * ========================================================================
 * Copyright (C) 2010 Traullé Jean
 *
 * This file is part of Opencomp.
 *
 * Opencomp is free software; you can redistribute it and/or modify
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
 * with Opencomp. If not, see <http://www.gnu.org/licenses/>
 * ========================================================================
 */

class Form
{
	private $echo;
	private $errors = 0;
	private $tabaccessid;

	public function __construct()
	{
		echo '<form method="post" action="'.htmlentities($_SERVER['PHP_SELF']).'">';
	}



	/*  Cette fonction permet de créer un champ de type input text
	 *
	 *  Elle prend pour paramètre $field qui servira pour l'id et le name du champ
	 *  $lablel permet de définir le label du champ input text
	 *  $type permet de choisir le type de validation souhaité.
	 */
	public function input($field,$label,$type)
	{
		if (isset($_POST['submit']))
		{
			switch ($type)
			{
				case 'alpha':

				if (!preg_match("#^[[:alpha:]]{1,}$#", htmlspecialchars($_POST['data_'.$field])))
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
					$this->echo[] = $return;
					$this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" /> <em><span></span>Vous devez saisir une chaine alphabétique sans accent !</em></span><br />';

					$this->errors++;
				}

				else
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
					$this->echo[] = $return;
				}

				break;

                                case 'alpha_avec_accent':

				if (!preg_match("#^[a-zA-ZâêôûÄéÇàèÊùÌÍÎÏîÒÓÔÕÖÙÚÛÜàáâãäçèéêëìíîïñòóôõöùúûü]{1,}$#", htmlspecialchars($_POST['data_'.$field])))
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
					$this->echo[] = $return;
					$this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" /> <em><span></span>Vous devez saisir une chaine alphabétique !</em></span><br />';

					$this->errors++;
				}

				else
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
					$this->echo[] = $return;
				}

				break;

                                case 'numerique':

				if (!preg_match("#^[[:digit:]]{1,}$#", htmlspecialchars($_POST['data_'.$field])))
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
					$this->echo[] = $return;
					$this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" /> <em><span></span>Vous devez saisir une chaine numérique !</em></span><br />';

					$this->errors++;
				}

				else
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
					$this->echo[] = $return;
				}

				break;

                                
			}
		}
		else
		{
			$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" /><br />';
			$this->echo[] = $return;
		}
	}

	public function iserrors()
	{
		if ($this->errors != 0)
		{
			return true;
		}
	}

	public function submit($value)
	{
		$this->echo[] = '<input type="submit" name="submit" id="submit" value="'.$value.'" /></form>';
	}

	public function afficher_formulaire()
	{
		if ($this->iserrors())
		{
			echo '<ul style="margin-bottom:10px; padding:0px;"><li class="error" id="error">Des erreurs ont été détectées lors de la validation des données saisies dans le formulaire !</li></ul>';

			?>

			<script type='text/javascript'>

				window.setTimeout(function() {
					new Effect.Highlight('error', { startcolor: '#FFFFFF', endcolor: '#FFBDBD', restorecolor: '#FFE7E7',keepBackgroundImage: 'true' });
				}, 200);

				window.setTimeout(function() {
					new Effect.Fade('error');
				}, 10000);

			</script>

			<?php
		}

		foreach ($this->echo as $retour)
		{
			echo $retour;
		}
	}

}