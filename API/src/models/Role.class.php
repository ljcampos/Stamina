<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Role extends Model {

	protected 	$table 		=	'rol';
	protected 	$primaryKey =	'rol_id';
	public 		$timestamps =	true;

	public function users () {
		return $this->belongsToMany('User', 'rol_usuario', 'rol_id', 'user_id');
	}

	public function permisos () {
		return $this->belongsToMany('Permission', 'permiso_rol', 'rol_id', 'permiso_id');
	}
}