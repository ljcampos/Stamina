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

	public function persona() {
		return $this->hasOne('Persona', 'persona_id', 'usuario_id');
	}

	public function convocatorias() {
		return $this->belongsToMany('Convocatoria', 'emprendedor_convocatoria', 'id_emprendedor', 'id_convocatoria');
	}
	
	public function calificacion () {
		return $this->hasMany('Calificacion', 'id_usuario', 'usuario_id');
	}

	public function mentor () {
		return $this->hasMany('Mentor', 'mentor_id', 'usuario_id');
	}

	public function emprendedorConvocatoria () {
		return $this->hasMany('EmprendedorConvocatoria', 'id_emprendedor', 'usuario_id');
	}

}