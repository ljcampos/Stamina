<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Promedio extends Model{
	
	protected 	$table 		=	'promedio_calificacion_respuesta_formulario_aplicacion';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	true;

	public function user() {
		return $this->belongsTo('EmprendedorConvocatoria', 'id_emprendedor_convocatoria', 'id');
	}
}