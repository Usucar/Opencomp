<SCRIPT language="Javascript">

alert("Voici un message d\'alerte!");

</SCRIPT>

<?php
// Connexion a la BDD
try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=localhost;dbname=opencomp', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Requete de mise a jour
foreach ($_GET['item'] as $position => $item) 
{
    $req = $bdd->prepare('UPDATE items SET place = :position WHERE id = :item');
	$req->execute(array(
		'position' => $position,
		'item' => $item
	));
}

?>
