<?php 

class Destino{
	private string $nombre;
	private string $descr;
	private string $estado;

	public function __construct(string $nombre, string $descr, string $estado) {
		$this->nombre=$nombre;
		$this->descr=$descr;
		$this->estado=$estado;
	}
	public function getNombre():string{
		return ucwords($this->nombre);
	}
	public function esValido():bool{
		return $this->estado==1;
	}
	public function getDescripcion():string{
		return ucfirst($this->descr);
	}
	public function enlaceCombinarDestino():string{
		if ($this->estado==1){
			$destino="
					<button class='button is-dark confirmar-combinar-destino' data-target='{$this->getNombre()}'>
						<span>{$this->getNombre()}</span>
					</button>";
		}
		return $destino;
	}
	public function mostrarDestinoAdmin():string{
		if ($this->estado==0){
			$destino="
			<div class='dropdown is-hoverable'>
				<div class='dropdown-trigger'>
					<button class='button' aria-haspopup='true' aria-controls='dropdown-menu4'>
						<span>{$this->getNombre()}</span>
						<span class='icon is-small'>
							<i class='fas fa-angle-down' aria-hidden='true'></i>
						</span>
					</button>
				</div>
				<div class='dropdown-menu' id='dropdown-menu4' role='menu'>
					<div class='dropdown-content'>
						<div class='dropdown-item'>
							<p>
							{$this->descr}
							</p>
						</div>
						<hr class='dropdown-divider' />
						<a class='dropdown-item admitir-destino' data-target='{$this->getNombre()}'> Admitir </a>
						<a class='dropdown-item combinar-destino' data-target='{$this->getNombre()}'> Combinar con </a>
						<a class='dropdown-item eliminar-destino' data-target='{$this->getNombre()}'> Eliminar </a>
					</div>
				</div>
			</div>";
		}
		else if ($this->estado==1){
			$destino="
			<div class='dropdown is-hoverable'>
				<div class='dropdown-trigger'>
					<button class='button' aria-haspopup='true' aria-controls='dropdown-menu4'>
						<span>{$this->getNombre()}</span>
						<span class='icon is-small'>
							<i class='fas fa-angle-down' aria-hidden='true'></i>
						</span>
					</button>
				</div>
				<div class='dropdown-menu' id='dropdown-menu4' role='menu'>
					<div class='dropdown-content'>
						<div class='dropdown-item'>
							<p>
							{$this->descr}
							</p>
						</div>
						<hr class='dropdown-divider' />
						<a class='dropdown-item' href='search.php?search={$this->getNombre()}'>Ver peticiones</a>
					</div>
				</div>
			</div>";
		}
		return $destino;
	}
	// public function __set(string $atr, mixed $value){

	// }	
}

// $a = new Destino("Gobernador de San Juan","Politica-gobierno");
// echo $a->getNombre()."<br>";
// echo $a->getArea();




?>