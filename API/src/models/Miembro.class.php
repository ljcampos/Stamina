<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Miembro extends Model {

	protected 	$table 		=	'miembro';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	false;

	/*public function universidad() {
		 return $this->belongsTo('Universidad', 'universidad_id', 'universidad_id');
	}

	public function emprendedores() {
		return $this->belongsToMany('User', 'emprendedor_convocatoria', 'id_convocatoria', 'id_emprendedor');
	}

	public function persona () {
		return $this->belongsToMany('Persona', 'emprendedor_convocatoria', 'id_convocatoria', 'id_emprendedor');
	}*/

}