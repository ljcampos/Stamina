<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Convocatoria extends Model {

	protected 	$table 		=	'convocatoria';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	true;

	public function universidad() {
		 return $this->belongsTo('Universidad', 'universidad_id', 'universidad_id');
	}

	/*public function roles() {
		return $this->belongsToMany('Role', 'rol_usuario', 'user_id', 'rol_id');
	}*/

}