<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Opencomp | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		//echo $this->Html->css('cake.generic');
                echo $this->Html->css('opencomp.generic');
                  
		echo $scripts_for_layout;
	?>
</head>
<body>
    
    <div id="wrap">
                
        <div id="en_tete">

                <img class="logo_entete" src="img/logo.png" alt="logo" />

                <div class="titre_entete">Opencomp</div>
                <div class="description_entete">Gestion de r&eacute;sultats scolaires par navigateur<span class ="description_entete" style="font-size:x-small">et bien plus encore !</span></div>

                <div class="info-connect_entete">

                    <?php
                    function datefr()
                    {
                            $jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
                            $mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
                            $datefr = $jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y");
                            return "Nous sommes le ". $datefr;
                    }
                    ?>
                    <span style="float:right;"><?php echo datefr(); ?></span><br />
                    <div style="padding-top:5px;">Bienvenue, <?php echo $session->read('Auth.User.prenom').' '. $session->read('Auth.User.nom') ?> | <?php echo $html->link('Se déconnecter',array('controller'=>'users', 'action'=>'logout')) ?></div>
                </div>

        </div>
        
        <div id="corps" class="clearfix">

            <h2><?php echo $title_for_layout; ?></h2>

            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $content_for_layout; ?>
            
            
        </div>
    </div>

    <div id="footer">
        <p style='position:relative; top:7px; left:10px;'>Opencomp est distribué sous licence <a href ='http://www.april.org/gnu/gpl_french.html'>GNU/GPL</a>.<br /><a href='http://zolotaya.isa-geek.com/redmine/projects/gnote'>Forge du projet Opencomp</a> - <a href='http://zolotaya.isa-geek.com/redmine/projects/gnote/issues/new'>rapporter une anomalie</a></p><div style='float:right; position:relative; bottom:18px; right:10px;'>Page générée en $tps seconde requêtes exécutées.</div>

    </div>
    
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>