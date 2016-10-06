<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Respuesta extends Model {

	protected 	$table 		=	'respuesta_pregunta_formulario_aplicacion';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	false;

	public function pregunta () {
		return $this->belongsTo('Pregunta', 'id_pregunta', 'id');
	}

	public function emprendedor () {
		return $this->belongsTo('EmprendedorConvocatoria', 'id_emprendedor_convocatoria', 'id');
	}

	public function calificacion () {
		return $this->hasMany('Calificacion', 'id_respuesta', 'id');
	}

}