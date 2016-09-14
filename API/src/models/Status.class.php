<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Status extends Model {

	protected 	$table 		=	'cat_estatus';
	protected 	$primaryKey =	'estatus_id';
	public 		$timestamps =	true;

	public function users () {
		return $this->hasMany('User', 'estatus_id', 'estatus_id');
	}
}