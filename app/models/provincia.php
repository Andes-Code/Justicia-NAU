<?php 
require_once "pais.php";
class Provincia{
	private Pais $pais;
	private string $nombre;

	public function __construct(Pais $pais, string $nombre) {
		$this->pais=$pais;
		$this->nombre=$nombre;
	}
	public function getNombre():string{
		return $this->nombre.", ".$this->pais->getNombre();
	}
		
}





?>