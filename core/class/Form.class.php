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



	/**
         * Cette méthode permet de créer un champ de type input text et de le vérifier
         * 
         * @param string $field Nom du champ
         * @param string $label Nom du label (optionel)
         * @param string $type Type du champ à choisir parmi 'alpha','alpha_avec_accent', 'numerique'
         * @param int $longueur_mini Longueur minimale de la chaîne de caractères
         * @param int $longueur_maxi Longueur maximale de la chaîne de caractères
	 */
	public function input($field,$label,$type,$longueur_mini,$longueur_maxi)
	{
		if (isset($_POST['submit']))
		{
			switch ($type)
			{
				case 'alpha':

				if (!preg_match('#^[[:alpha:]]{'.$longueur_mini.','.$longueur_maxi.'}$#', htmlspecialchars($_POST['data_'.$field])))
				{
					if(!empty ($label))
                                        {
                                            $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                                        }
                                        $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
					$this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" /> <em><span></span>Vous devez saisir une chaine alphabétique sans accent d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

					$this->errors++;
				}

				else
				{
                                    if(!empty ($label))
                                    {
                                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                                    }

                                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
				}

				break;

                                case 'alpha_avec_accent':

				if (!preg_match('#^[a-zA-ZâêôûÄéÇàèÊùÌÍÎÏîÒÓÔÕÖÙÚÛÜàáâãäçèéêëìíîïñòóôõöùúûü]{'.$longueur_mini.','.$longueur_maxi.'}$#', htmlspecialchars($_POST['data_'.$field])))
				{
                                        if(!empty ($label))
                                        {
                                            $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                                        }
                                    
                                        $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
					$this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" /> <em><span></span>Vous devez saisir une chaine alphabétique d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

					$this->errors++;
				}

				else
				{
                                    if(!empty ($label))
                                    {
                                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                                    }

                                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
				}

				break;

                                case 'numerique':

				if (!preg_match('#^[[:digit:]]{'.$longueur_mini.','.$longueur_maxi.'}$#', htmlspecialchars($_POST['data_'.$field])))
				{
					if(!empty ($label))
                                        {
                                            $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                                        }
                                    
                                        $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
					$this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" /> <em><span></span>Vous devez saisir une chaine numérique d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

					$this->errors++;
				}

				else
				{
                                    if(!empty ($label))
                                    {
                                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                                    }
                                        
                                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
				}

				break;

                                
			}
		}
		else
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" /><br />';
		}
	}



        /**
         * Cette méthode permet de savoir si des erreurs ont été rencontrés lors de la validation du formulaire. Elle retourne donc true si c'est le cas.
	 */
	public function iserrors()
	{
		if ($this->errors != 0)
		{
			return true;
		}
	}

	/**
         * Cette méthode permet d'afficher le bouton submit et de clore le formulaire en fermant la balise <form>
         *
         * @param string $value Valeur du bouton submit
	 */
        public function submit($value)
	{
		$this->echo[] = '<input type="submit" name="submit" id="submit" value="'.$value.'" /></form>';
	}


	/**
         * Cette méthode permet d'afficher le formulaire après avoir vérifié si celui ci comportait des erreurs dans le cas ou le formulaire aurait déjà été envoyé.
         * Si c'est le cas, on affiche une alerte avant d'afficher le formulaire !
	 */
	public function afficher_formulaire()
	{
            //On vérifie d'abord si il y a eu des erreurs dans le cas ou le formulaire aurait déjà été envoyé.
            //Si c'est le cas, on affiche une alerte
            if ($this->iserrors())
            {
		echo '<ul style="margin-bottom:10px; padding:0px;"><li class="error" id="error">Des erreurs ont été détectées lors de la validation des données saisies dans le formulaire !</li></ul>';

                ?>

                <script type='text/javascript'>

		window.setTimeout(function()
                {
                    new Effect.Highlight('error', { startcolor: '#FFFFFF', endcolor: '#FFBDBD', restorecolor: '#FFE7E7',keepBackgroundImage: 'true' });
		}, 200);

		window.setTimeout(function()
                {
                    new Effect.Fade('error');
		}, 10000);

		</script>

		<?php
            }

            //Puis on affiche la vue stockée dans la variable echo à l'utilisateur
            foreach ($this->echo as $retour)
            {
		echo $retour;
            }
	}

}