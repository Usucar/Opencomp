<?php

$this->pageTitle = "Arborescence des catégories";

echo $tree->generate(
	$categories,
	array('element' => 'competences_index')
);
?>