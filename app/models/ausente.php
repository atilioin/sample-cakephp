<?php
class Ausente extends AppModel {

	var $name = 'Ausente';

	var $belongsTo = array(
			'Empleado' => array('className' => 'Empleado',
								'foreignKey' => 'empleado_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'counterCache' => ''),
			'Uen' => array('className' => 'Uen',
								'foreignKey' => 'uen_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'counterCache' => ''),
	);

}
?>