<?php
/**
* 
*/
use Illuminate\Database\Eloquent\Model as Model;

class Calificacion extends Model {
	
	protected 	$table 		=	'calificacion_respuesta_pregunta_formulario_aplicacion';
	protected 	$primaryKey =	'id';
	public 		$timestamps =	true;

	public function respuesta (){
		return $this->belongsTo('Respuesta', 'id_respuesta', 'id');
	}
	
	public function user() {
		return $this->belongsTo('User', 'id_usuario', 'usuario_id');
	}
	
}
