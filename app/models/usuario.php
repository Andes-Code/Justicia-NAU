<?php 

class Usuario{
	private string $correo;
	private ?string $nombreUsuario;
	private int $sancion;
	private bool $verificado;
	private string $imagen;
	private int $valoracion;
	private Rol $rol;
	/**
	 * (string correo, int sancion, bool verificado)
	 */
	public function __construct(string $correo, ?string $nombreUsuario, int $sancion, bool $verificado, string $imagen, int $valoracion, Rol $rol){
		$this->correo=$correo;
		$this->nombreUsuario=$nombreUsuario;
		$this->sancion=$sancion;
		$this->verificado=$verificado;
		$this->imagen=$imagen;
		$this->valoracion=$valoracion;
		$this->rol=$rol;
		// $this->verificar();
	}
	public function getCorreo():string{
		return $this->correo;
	}
	public function getRol():string{
		return $this->rol->getNombre();
	}
    public function opciones():array{
        return $this->rol->opciones();
    }
	public function getNombre():string{
		return $this->nombreUsuario;
	}
	public function mostrarImagen(){
		return $this->imagen;
	}
	public function mostrarPerfil(string $usuarioVisitante='',string $tipoUsuario){
		$peticiones=$this->getPeticiones();
		$usuario = "
		<div class='perfil'>
			<div class='presentacion'>
				<div class='imagen'>
					<img class='js-modal-trigger' data-target='{$this->imagen}' src='images/profiles/{$this->imagen}'>
				</div>
                <div id='{$this->imagen}' class='modal'>
                    <div class='modal-background'></div>
                    <div class='modal-content'>
                        <p class='image'>
                        <img src='images/profiles/{$this->imagen}'>
                        </p>
                    </div>
                    <button class='modal-close is-large' aria-label='close'></button>
                </div>
				<div class='info'>
					<div class='nombre'>
						<p>{$this->nombreUsuario}</p>
						<p>{$this->correo}</p>
					</div>
					<!--div class='numeros'>
						<div class='cantidad-peticiones'>".
						count($peticiones)
						."<br>peticiones
						</div>
						<div class='cantidad-firmas'>".
						$this->cantidadFirmas()
						."<br>peticiones firmadas
						</div>
						<div class='valoracion'>".
						$this->valoracion
						."<br>valoracion
						</div-->
                        <nav class='level is-mobile'>
                            <div class='level-item has-text-centered'>
                                <div>
                                    <p class='heading'>Peticiones</p>
                                    <p class='title'>".count($peticiones)."</p>
                                </div>
                            </div>
                            <div class='level-item has-text-centered'>
                                <div>
                                    <p class='heading'>Peticiones firmadas</p>
                                    <p class='title'>".$this->cantidadFirmas()."</p>
                                </div>
                            </div>
                            <div class='level-item has-text-centered'>
                                <div>
                                    <p class='heading'>Valoracion</p>
                                    <p class='title'>".$this->valoracion."</p>
                                </div>
                            </div>
                        </nav>
					</div>
				</div>
			</div>
			<div class='peticiones'>";

			foreach($peticiones as $peticion){
                if ($tipoUsuario=="correo")
				    $usuario.= $peticion->mostrarPeticion(Firmas::firmaExiste($peticion->getNumero(),$usuarioVisitante,"correo"));
                else if ($tipoUsuario=="ip")
                    $usuario.= $peticion->mostrarPeticion(Firmas::firmaExiste($peticion->getNumero(),$usuarioVisitante,"ip"));
			}

		$usuario.= "
			</div>
		</div>
		";
		return $usuario;
	}
	public function getPeticiones():array{
		try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT nroPet 
            FROM peticion
            WHERE correo=:correo
			AND estado>=0";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":correo"=>$this->correo
            ]);
            if ($result=$query->fetchAll()){
				$peticiones=[];
				foreach ($result as $numero){
					array_push($peticiones,Peticiones::getPeticionByNumero($numero["nroPet"]));
				}
				return $peticiones;
                // return new Usuario($result["correo"],$result["nombre"],$result["sancion"],$result["verificado"],$result["imagen"]);
            }else{
				return [];
				echo "No se han publicado peticiones";
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
	}
	public function cantidadFirmas():int{
		try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT COUNT(*) as cantidad 
            FROM firma
            WHERE correo=:correo";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":correo"=>$this->correo
            ]);
            if ($result=$query->fetch()){
				return $result["cantidad"];
                // return new Usuario($result["correo"],$result["nombre"],$result["sancion"],$result["verificado"],$result["imagen"]);
            }else{
                return 0;
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
	}
	public function sumarValoracion(int $cantidad):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE usuario 
                SET valoracion=valoracion+:cantidad
                WHERE correo=:correo";
            $query=$conexion->prepare($sql);
            if ($query->execute([
                ":correo"=>$this->correo,
                ":cantidad"=>$cantidad
            ])){
                return TRUE;
            }else{
                return FALSE;
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
	}
	public function sancionar(int $cantidad):bool{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "UPDATE usuario 
                SET sancion=sancion+:cantidad
                WHERE correo=:correo";
            $query=$conexion->prepare($sql);
            if ($query->execute([
                ":correo"=>$this->correo,
                ":cantidad"=>$cantidad
            ])){
                return TRUE;
            }else{
                return FALSE;
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
	public function misIntereses():string{
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
                nombreTem
                FROM interesa 
                WHERE correo=:correo";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":correo"=>$this->correo
            ]);
            if ($result=$query->fetchAll()){
                $div="<div class='field' id='caja-tematicas'>";
                $form="<form id='preferencias-form' class='hidden'><input type='hidden' name='default'>";
                foreach ($result as $tematica)
                {
                    $div.= "<button value='".$tematica['nombreTem']."' class='button is-light interes' type='button'>".$tematica['nombreTem']."</button>";
                    $form.="<input name='tematicas[]' class='input' type='hidden' value='".$tematica['nombreTem']."' id='".$tematica['nombreTem']."'>";
                }
                $div.="</div>";
                $form.="</form>";
                $div.=$form;
                return $div;
            }else{
                return "<div class='field' id='caja-tematicas'></div><form id='preferencias-form' class='hidden'><input type='hidden' name='default'></form>";
                // app::renderUsuarioNoEncontrado($correo)
            }

        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
	public function guardarIntereses(array $tematicas){
        try{
            $conexion = BDconection::conectar("user");
            $sql="DELETE FROM interesa
                WHERE correo=:correo";
            $query=$conexion->prepare($sql); 
            $query->execute([":correo"=>$this->correo]);
            $sql = "INSERT INTO interesa (correo, nombreTem)
                    SELECT :correo, :tematica
                    FROM tematica
                    WHERE nombreTem = :tematica0
                    AND NOT EXISTS 
                        (SELECT 1 
                        FROM interesa 
                        WHERE correo=:correo0 
                        AND nombreTem=:tematica1)";
            $query=$conexion->prepare($sql);
            foreach ($tematicas as $tematica)
            {
                $tematica=filter_var($tematica,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $query->execute([
                    ":correo"=>$this->correo,
                    ":tematica"=>$tematica,
                    ":tematica0"=>$tematica,
                    ":correo0"=>$this->correo,
                    ":tematica1"=>$tematica
                ]);
            }
            return;
            // return "ok";
        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
	public function misPeticionesFinalizadas(){
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
                    nroPet,
                    titulo
                    FROM peticion
                    WHERE correo=:correo
                    AND estado=1";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":correo"=>$this->correo
            ]);
            if ($result=$query->fetchAll())
            {
                $html="";
                foreach ($result as $peticion)
                {
                    $html.="
                    <a href='petition.php?numero={$peticion['nroPet']}'>
                        <div>
                            <span class='span'>{$peticion['titulo']}</span>
                        </div>
                    </a>";
                }
                return $html;
            }else
            {
                return "<span class='span'>Aun no has alcanzado el objetivo en ninguna peticion</span>";
            }
            
            // return "ok";
        }catch (PDOException $e) {
            // Log error message
            error_log('Database error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        } catch (Exception $e) {
            // Log error message
            error_log('General error: ' . $e->getMessage());
            // Show user-friendly message
            echo $e->getMessage();
            echo 'Lo sentimos, ha ocurrido un problema. Por favor, inténtelo de nuevo más tarde.';
        }
    }
    public function datosAdmin() : string {
        $div="<div class='dropdown is-hoverable'>
				<div class='dropdown-trigger'>
					<button class='button' aria-haspopup='true' aria-controls='dropdown-menu4'>
						<span>{$this->correo}</span>
						<span class='icon is-small'>
							<i class='fas fa-angle-down' aria-hidden='true'></i>
						</span>
					</button>
				</div>
				<div class='dropdown-menu' id='dropdown-menu4' role='menu'>
					<div class='dropdown-content'>
						<div class='dropdown-item'>
							<p>
							{$this->nombreUsuario}
							</p>
						</div>
						<hr class='dropdown-divider' />
						<div class='dropdown-item'>
                            <p>
                                Rol: ".strtoupper($this->rol->getNombre())."
                            </p>
							<p>
							    Valoración: {$this->valoracion}
							</p>
                            <p>
                                Sanción: {$this->sancion}
                            </p>
						</div>

						<!--hr class='dropdown-divider' />
						<a href='options.php?mode=admin&page=enviarCorreo&user={$this->correo}' class='dropdown-item enviar-correo' data-target='{$this->correo}'> Enviar correo </a>
						<hr class='dropdown-divider' />
						<div class='dropdown-item sancionar' data-target='{$this->correo}'> 
                            <div class='field has-addons'>
                                <input type='number' class='input' name='value-sancion' id='value-sancion'>
                                <button type='button' class='button'>sancionar</button>
                            </div>    
                            <!--Sancionar >
                        </div-->
                            <hr class='dropdown-divider' />
                        ";
        if ($this->rol->getNombre() == "admin")
        {
            $div.="
                        <a class='dropdown-item give-user' data-target='{$this->correo}'> Hacer usuario </a>
                        <a class='dropdown-item give-moder' data-target='{$this->correo}'> Hacer moderador </a>";
        }
        if ($this->rol->getNombre() == "moderador")
        {
            $div.="
                        <a class='dropdown-item give-user' data-target='{$this->correo}'> Hacer usuario </a>
                        <a class='dropdown-item give-admin' data-target='{$this->correo}'> Hacer administrador </a>";
        }
        if ($this->rol->getNombre() == "user")
        {
            $div.="
                        <a class='dropdown-item give-moder' data-target='{$this->correo}'> Hacer moder </a>
                        <a class='dropdown-item give-admin' data-target='{$this->correo}'> Hacer administrador </a>";
        }
						
					$div.="</div>
				</div>
			</div>";

        return $div;
        
    }











	/**el envio del mail no esta funcionando (falta probar en linux) */
	// protected function verificar(){
	// 	$numero=rand(0,999999);
	// 	$cad="";
	// 	for ($i=0;$i<(6-strlen($numero));$i++){
	// 		$cad.="0";
	// 	}
	// 	$cad.=$numero;		
	// 	$a=mail($this->correo, "VERIFICACION DE CORREO", $cad);
	// 	if($a){
	// 		echo "succed";
	// 	}else echo "failed";
	// }
}

// $a = new Usuario("santigimenez.20020817@gmail.com",0,false);



?>