<?php

/**
* 
*/
use Illuminate\Database\Capsule\Manager as DB;

class Connection
{
	public static function conecting()	
	{
		$fileName = __DIR__ . '/../config/conf.db.ini';
		$config		=	parse_ini_file($fileName);
		$connection = new DB;
		$connection->addConnection($config);
		$connection->setAsGlobal();
		$connection->bootEloquent();
		return $connection;
	}

	public static function getConnection () {

		$fileName 	= __DIR__ . '/../config/conf.db.ini';
		$config		=	parse_ini_file( $fileName );
		$connection = new DB;
		$connection->addConnection( $config );
		$connection->setAsGlobal();
		$connection->bootEloquent();

		return $connection;			
	}
}