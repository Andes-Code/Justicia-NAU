<?php 

require_once 'tematica.php';
require_once 'encuesta.php';

class Abarca{
	private int $puestoInt;
	private Encuesta $encuesta;
	private Tematica $tematica;

	public function __construct(int $puestoInt, Encuesta $encuesta, Tematica $tematica){
		$this->puestoInt=$puestoInt;
		$this->encuesta=$encuesta;
		$this->tematica=$tematica;
	}
	// public function getInfo():string{
	// 	return ""
	// }
}



?>