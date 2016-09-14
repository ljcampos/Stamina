<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Permission extends Model {

	protected 	$table 		=	'permiso';
	protected 	$primaryKey =	'permiso_id';
	public 		$timestamps =	true;

	public function roles () {
		return $this->belongsTo('Role', 'rol_id');
	}
}