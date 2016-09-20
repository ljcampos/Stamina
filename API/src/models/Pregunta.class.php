<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Pregunta extends Model {

	protected 	$table 		=	'pregunta_formulario_aplicacion';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	true;

	public function seccion() {

	}

	public function users () {
		return $this->belongsToMany('User', 'rol_usuario', 'rol_id', 'user_id');
	}

	public function permisos () {
		return $this->belongsToMany('Permission', 'permiso_rol', 'rol_id', 'permiso_id');
	}
}