<?php 

class Encuesta{
	private int $nro;
	private string $fecha;

	public function __construct(int $nro, string $fecha){
		$this->nro=$nro;
		$this->fecha=$fecha;
	}
	public function getNro(){
		return $this->nro;
	}
	public function getFecha(){
		return $this->fecha;
	}
}


?>