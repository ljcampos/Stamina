<?php

/**
* 
*/
class Controller
{
	protected $app;
	protected $capsule;

	public function callAction($action, $params = null)
	{
		if (array_key_exists($action, static::$routes))
		{
			$capsule = Connection::conecting();
			$this->capsule = $capsule;
			$method = static::$routes[$action];
			return $this->$method($params);
		}
		else 
		{
			$this->notFound();
		}
	}

	public function notFound()
	{
		echo 'Accion no encontrada';
	}
}
