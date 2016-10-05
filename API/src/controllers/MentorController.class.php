<?php

/**
* 
*/
class MentorController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
	);

	/**
	* 
	*/
	private $response = array(
		'code' 		=>	1,
		'data'		=>	array(),
		'message'	=>	''
	);

	/**
	* 
	*/
	private $attributes = array('cargo', 'descr');

	/**
	* 
	*/
	public function __construct($app = null)
	{
		$this->app = $app;
	}

	/**
	*
	*/
	public function getAll ()
	{
		
		$usuarios = Mentor::with('usuario')->with('persona')->get();

		$this->response['data'] = $usuarios;
		$this->response['message'] = 'Lista de mentores';
		
		return $this->response;
	}
}