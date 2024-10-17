<?php 

class Pais{
	private string $nombre;

	public function __construct(string $nombre) {
		$this->nombre=$nombre;
	}
	public function getNombre():string{
		return $this->nombre;
	}	
}


?>