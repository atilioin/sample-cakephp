<?php
class Liquidacion extends AppModel {

	var $name = 'Liquidacion';
	
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
			'Usuario' => array('className' => 'Empleado',
                                'foreignKey' => 'usuario_id',
                                'conditions' => '',
                                'fields' => '',
                                'order' => '',
                                'counterCache' => ''),
	);
	
	function afterFind($resultados, $primario) 
    {
        if ($primario)
        {
            
			foreach ($resultados as $clave => $valor) 
            {
                if ($valor['Liquidacion'])
                {
					$resultados[$clave]['TANGO'] = Configure::read('PREFIJO_TANGO').'_'.$valor['Liquidacion']['id']);
                }
            }
        }
        return $resultados;
    }
}
?>