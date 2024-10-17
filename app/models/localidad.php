<?php 
require_once 'Provincia.php';

class Localidad{
	private Provincia $provincia;
	private string $nombre;
	private string $estado;

	public function __construct(Provincia $provincia, string $nombre, string $estado){
		$this->provincia=$provincia;
		$this->nombre=$nombre;
		$this->estado=$estado;
	}
	public function getNombre(): string{
		return ucwords($this->nombre.', '.$this->provincia->getNombre());
	}
	public function getProvincia(): Provincia{
		return $this->provincia;
	}
	public function mostrarLocalidadAdmin(): string {
		if ($this->estado==0){
			$localidad="
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
						<!--div class='dropdown-item'>
							<p>
							
							</p>
						</div-->
						<hr class='dropdown-divider' />
						<a class='dropdown-item admitir-localidad' data-target='{$this->getNombre()}'> Admitir </a>
						<a class='dropdown-item combinar-localidad' data-target='{$this->getNombre()}'> Combinar con </a>
						<a class='dropdown-item eliminar-localidad' data-target='{$this->getNombre()}'> Eliminar </a>
					</div>
				</div>
			</div>";
		}
		else if ($this->estado==1){
			$localidad="
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
						<!--div class='dropdown-item'>
							<p>
							
							</p>
						</div-->
						<hr class='dropdown-divider' />
						<a class='dropdown-item' href='search.php?search={$this->getNombre()}'>Ver peticiones</a>
					</div>
				</div>
			</div>";
		}
		return $localidad;
	}
	public function enlaceCombinarLocalidad(): string {
		if ($this->estado==1){
			$localidad="
					<button class='button is-dark confirmar-combinar-localidad' data-target='{$this->getNombre()}'>
						<span>{$this->getNombre()}</span>
					</button>";
		}
		return $localidad;
	}
}






?>