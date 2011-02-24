<?php
echo $form->create('Item',array(
    'url'=>array(
        'action'=>'edit'
        )
    )
);

echo $form->input('Item.id');
echo $form->label('Item.competence_id','Compétence rattachée à cet Item :');
echo $form->select('Item.competence_id', $competences, null, null);
echo $form->error('Item.competence_id');
echo $form->input('Item.intitule', array('label' => "Intitulé de l'Item :"));
echo $form->end('Valider');
?>
