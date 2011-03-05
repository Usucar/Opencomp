<?php
class Item extends AppModel {
    
    var $name="Item";
    var $belongsTo = array('Competence');
    
    //Avec ces deux règles de validation,
    //on s'assure que tous les champs sont complétés
    var $validate = array(           
                'competence_id' => array(
                    'rule' => array('notEmpty'),
                    'required' => true,
                    'allowEmpty' => false,
                    'message' => 'Séléctionnez la compétence à laquelle se rattache cet item'
                ),
                'intitule' => array(
                    'rule' => array('notEmpty'),
                    'required' => true,
                    'allowEmpty' => false,
                    'message' => 'Vous devez compléter ce champ !'
                )
    );

}
?>

