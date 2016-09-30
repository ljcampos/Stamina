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

	public function promedio () {
		return $this->hasMany('Promedio', 'id_emprendedor_convocatoria', 'id');
	}

	public function user () {
		return $this->belongsTo('User', 'usuario_id', 'id_emprendedor');
	}

	public function convocatorias() {
		return $this->belongsToMany('Convocatoria', 'emprendedor_convocatoria', 'id_emprendedor', 'id_convocatoria');
	}

}