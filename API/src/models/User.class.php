<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class User extends Model {

	protected 	$table 		=	'usuario';
	protected 	$primaryKey =	'usuario_id';
	public 		$timestamps =	true;

	public function status() {
		 return $this->belongsTo('Status', 'estatus_id', 'estatus_id');
	}

	public function roles() {
		return $this->belongsToMany('Role', 'rol_usuario', 'user_id', 'rol_id');
	}

}