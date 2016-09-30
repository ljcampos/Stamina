<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Mentor extends Model {

	protected 	$table 		=	'mentor';
	protected 	$primaryKey =	'mentor_id';
	public 		$timestamps =	false;

	public function usuario () {
		return $this->belongsTo('User', 'usuario_id', 'mentor_id');
	}

}