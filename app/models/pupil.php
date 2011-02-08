<?php
class Pupil extends AppModel {
	var $name = 'Pupil';
	var $displayField = 'nom';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Classroom' => array(
			'className' => 'Classroom',
			'foreignKey' => 'classroom_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>