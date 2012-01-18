<?php
class AusentesController extends AppController {

	var $uses=array("Ausente");
	var $name = 'Ausentes';
	var $helpers = array('Html','Javascript');

    function porempleadoyperiodo($empleado_id,$mes,$anio)
	{
		if ($empleado_id)
		{
			$inicioMes = "$anio-$mes-01";
			$finMes = "$anio-$mes-31";
			$this->Ausente->Behaviors->attach('Containable');
			$ausentes=$this->Ausente->find('all',array('conditions'=>array('Ausente.deduce'=>1,'Ausente.empleado_id'=>$empleado_id, 'Ausente.fecha >='=>$inicioMes, 'Ausente.fecha <='=>$finMes),'contain'=>array('Uen')));
			$this->set(compact("ausentes"));
			$this->layout='json/default';
		}
	}
	
}
?>