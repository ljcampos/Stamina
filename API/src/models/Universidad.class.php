<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Universidad extends Model {

	protected 	$table 		=	'universidad';
	protected 	$primaryKey =	'universidad_id';
	public 		$timestamps =	true;

	public function user() {
		return $this->belongsTo('User', 'usuario_id', 'usuario_id');
	}

	public function convocatorias() {
		return $this->hasMany('Convocatoria', 'universidad_id', 'universidad_id');
	}

}