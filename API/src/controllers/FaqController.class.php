<?php
/**
* 
*/
class FaqController extends Controller
{
	static $routes = array(
		'save' 		=>	'save'
	);

	private $DIRECTORY = __DIR__ . '/../../uploads/faq/';
	private $MIME = 'application/pdf';
	private $MAX_FILE_UPLOAD = 1572864;

	/**
	* 
	*/
	private $response = array(
		'code' 		=>	1,
		'data'		=>	'',
		'message'	=>	''
	);

	/**
	* 
	*/
	public function __construct($app = null)
	{
	}

	/**
	* 
	*/
	public function save()
	{
		if (!empty($_FILES) && $_FILES['file']['error'] === 0)
		{
			if ($_FILES['size'] <= $this->MAX_FILE_UPLOAD) 
			{
				$recurso 	= finfo_open(FILEINFO_MIME_TYPE);
				$mime 		=	finfo_file($recurso, $_FILES['file']['tmp_name']);

				if ($this->MIME === $mime)
				{
					$nombre_archivo = 'FAQ.pdf';
					$fichero_subido = $this->DIRECTORY . $nombre_archivo;

					if (file_exists($fichero_subido)) { unlink($fichero_subido); }

					if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido))
					{	
						$this->response['code'] = 1;
						$this->response['data'] = $fichero_subido;
						$this->response['message'] = 'Archivo guardado correctamente.';
					}		
				}
				else { $this->response['code'] = 5; $this->response['message'] = 'El archivo debe ser de tipo PDF.'; }
			}
			else {$this->response['message'] = 'Debe enviar un archivo de 1.5MB.';}
		}

		return $this->response;
	}
}