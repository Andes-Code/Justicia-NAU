<?php 

class Tematica{
	private string $nombre;
	private string $descr;
	private int $estado;

	public function __construct(string $nombre, string $descr, string $estado) {
		$this->nombre=$nombre;
		$this->descr=$descr;
		$this->estado=$estado;
	}
	public function getNombre():string{
		return $this->nombre;
	}
	public function getDescr():string{
		return $this->descr;
	}
	public function mostrarTematicaAdmin(): string {
		if ($this->estado==0){
			$tematica="
			<div class='dropdown is-hoverable'>
				<div class='dropdown-trigger'>
					<button class='button' aria-haspopup='true' aria-controls='dropdown-menu4'>
						<span>{$this->nombre}</span>
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
						<a class='dropdown-item admitir-tematica' data-target='{$this->nombre}'> Admitir </a>
						<a class='dropdown-item combinar-tematica' data-target='{$this->nombre}'> Combinar con </a>
						<a class='dropdown-item eliminar-tematica' data-target='{$this->nombre}'> Eliminar </a>
					</div>
				</div>
			</div>";
		}
		else if ($this->estado==1){
			$tematica="
			<div class='dropdown is-hoverable'>
				<div class='dropdown-trigger'>
					<button class='button' aria-haspopup='true' aria-controls='dropdown-menu4'>
						<span>{$this->nombre}</span>
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
						<a class='dropdown-item' href='search.php?search={$this->nombre}'>Ver peticiones</a>
					</div>
				</div>
			</div>";
		}
		return $tematica;
	}
	public function enlaceCombinarTematica(): string {
		if ($this->estado==1){
			$tematica="
					<button class='button is-dark confirmar-combinar-tematica' data-target='{$this->nombre}'>
						<span>{$this->nombre}</span>
					</button>";
		}
		return $tematica;
	}
	// public function __set(string $atr, mixed $value){

	// }	
}


if (__FILE__==get_included_files()[0]){
	// $a = new Tematica("Inseguridad","Delincuencia, miedo");
	// echo $a->getNombre()."<br>";
	// echo $a->getDescr();
}




?>