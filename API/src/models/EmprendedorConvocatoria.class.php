<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class EmprendedorConvocatoria extends Model {

	protected 	$table 		=	'emprendedor_convocatoria';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	false;

	public function respuestaEmprendedor () {
		return $this->hasMany('Respuesta', 'id_emprendedor_convocatoria' , 'id');
	}

}