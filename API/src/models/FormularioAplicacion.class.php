<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class FormularioAplicacion extends Model {

	protected 	$table 		=	'formulario_aplicacion';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	true;

	public function relacionPreguntasFormularioAplicacion() {
		return $this->hasMany('Pregunta', 'id_seccion', 'id');
	}

}