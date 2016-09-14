<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Estado extends Model {

	protected 	$table 		=	'cat_estado';
	protected 	$primaryKey =	'estado_id';
	public 		$timestamps =	true;

	/*public function users () {
		return $this->hasMany('User', 'role_id');
	}*/
}