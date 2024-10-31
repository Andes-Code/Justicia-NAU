<?php
class Informes{
    private static array $mesesPDF = [
        "01" => "Enero",
        "02" => "Febrero",
        "03" => "Marzo",
        "04" => "Abril",
        "05" => "Mayo",
        "06" => "Junio",
        "07" => "Julio",
        "08" => "Agosto",
        "09" => "Septiembre",
        "10" => "Octubre",
        "11" => "Noviembre",
        "12" => "Diciembre"
    ];
    public static function mostrarInforme(array $informe, string $lapso='mensual'){
        if ($lapso=="mensual")
        {
            $fecha=self::$mesesPDF[substr($informe['fecha'],5,2)]." del ".substr($informe['fecha'],0,4);
            $info="mes";
            try{
                $promedioFirmas=round($informe["firmas"]/$informe["peticiones"],2);
            }catch (DivisionByZeroError $e){
                $promedioFirmas=0;
            }
            try{
                $porcentajeAnonimas=round($informe["anonimas"]*100/$informe["firmas"],2);
            }catch (DivisionByZeroError $e){
                $porcentajeAnonimas=0;
            }
            try{
                $porcentajePublicas=round($informe["publicas"]*100/$informe["firmas"],2);
            }catch (DivisionByZeroError $e){
                $porcentajePublicas=0;
            }
            try{
                $porcentajeRegistradas=intdiv(round($informe["registradas"]*100/$informe["firmas"],2),1);
            }catch (DivisionByZeroError $e){
                $porcentajeRegistradas=0;
            }
            try{
                $porcentajeAceptadas=round($informe["admitidas"]*100/$informe["peticiones"],0);
            }catch (DivisionByZeroError $e){
                $porcentajeAceptadas=0;
            }
            $usuarios=$informe["usuarios"];
            $peticiones=$informe["peticiones"];
            $bajas=$informe["bajas"];
            $admitidas=$informe["admitidas"];
            $noAdmitidas=$informe["noAdmitidas"];
            $exitosas=$informe["exitosas"];
            $firmas=$informe["firmas"];
            $registradas=$informe["registradas"];
            $noRegistradas=$informe["noRegistradas"];
            $publicas=$informe["publicas"];
            $anonimas=$informe["anonimas"];
            
        }
        else if ($lapso=="anual")
        {
            $fecha=$informe["fecha"];
            $info="año";
            try{
                $promedioFirmas=round($informe["firmas"]/$informe["peticiones"],2);
            }catch (DivisionByZeroError $e){
                $promedioFirmas=0;
            }
            try{
                $porcentajeAnonimas=round($informe["anonimas"]*100/$informe["firmas"],2);
            }catch (DivisionByZeroError $e){
                $porcentajeAnonimas=0;
            }
            try{
                $porcentajePublicas=round($informe["publicas"]*100/$informe["firmas"],2);
            }catch (DivisionByZeroError $e){
                $porcentajePublicas=0;
            }
            try{
                $porcentajeRegistradas=intdiv(round($informe["registradas"]*100/$informe["firmas"],2),1);
            }catch (DivisionByZeroError $e){
                $porcentajeRegistradas=0;
            }
            try{
                $porcentajeAceptadas=round($informe["admitidas"]*100/$informe["peticiones"],0);
            }catch (DivisionByZeroError $e){
                $porcentajeAceptadas=0;
            }
            $usuarios=$informe["usuarios"];
            $peticiones=$informe["peticiones"];
            $bajas=$informe["bajas"];
            $admitidas=$informe["admitidas"];
            $noAdmitidas=$informe["noAdmitidas"];
            $exitosas=$informe["exitosas"];
            $firmas=$informe["firmas"];
            $registradas=$informe["registradas"];
            $noRegistradas=$informe["noRegistradas"];
            $publicas=$informe["publicas"];
            $anonimas=$informe["anonimas"];

        }
        // $promedioFirmasNoRegistradas=round($informe["noRegistradas"]*100/$informe["firmas"],2);
        $div="
        <section class='modal-card-body'>
            <div class='content'>
                <h1>".$fecha."</h1>
                <p>Este {$info} se registraron: </p>
                <ul>
                    <li>{$usuarios} Usuarios</li>
                    <li>{$peticiones} Peticiones</li>
                    <li>{$firmas} Firmas</li>
                </ul>
                <h3>Peticiones</h3>
                <p>Respecto a las peticiones:</p>
                <ul>    
                    <li>{$bajas} fueron dadas de baja</li>
                    <li>{$noAdmitidas} quedaron sin admitir</li>
                    <li>{$admitidas} fueron aceptadas</li>
                    <li>{$exitosas} de las aceptadas lograron su objetivo</li>
                </ul>
                <h3>Firmas</h3>
                <p>Respecto a las firmas:</p>
                <ul>    
                    <li>{$registradas} son de usuarios registrados</li>
                    <li>{$noRegistradas} son de usuarios que no se registraron</li>
                    <li>{$publicas} son publicas</li>
                    <li>{$anonimas} son anonimas</li>
                </ul>
                <h3>Resumiendo</h3>
                <ul>    
                    <li>Se promediaron {$promedioFirmas} firmas por peticion</li>
                    <li>El {$porcentajeAnonimas}% de las firmas fueron anonimas y el {$porcentajePublicas}% públicas</li>
                    <li>{$porcentajeRegistradas} de cada 100 firmantes son usuarios registrados</li>
                    <li>Se aceptaron el {$porcentajeAceptadas}% de las peticiones</li>
                </ul>
            </div>
        </section>";
        return $div;

    }
    public static function compararInformes(array $informe1, array $informe2){
        $fecha1=(preg_match('/^\d{4}-(0[1-9]|1[0-2])$/',$informe1["fecha"])) ? self::$mesesPDF[substr($informe1['fecha'],5,2)]." del ".substr($informe1['fecha'],0,4) : $informe1["fecha"];
        $fecha2=(preg_match('/^\d{4}-(0[1-9]|1[0-2])$/',$informe2["fecha"])) ? self::$mesesPDF[substr($informe2['fecha'],5,2)]." del ".substr($informe2['fecha'],0,4) : $informe2["fecha"];
        // Seria valido cambiar algunos valores por porcentajes, por ejemplo las firmas publicas, que se compararian respecto al porcentaje y no la cantidad real
        try{
            $bajasAntes=round($informe1['bajas']*100/$informe1['peticiones'],2);
        }catch (DivisionByZeroError $e)
        {
            $bajasAntes=0;

        }
        try {
            $bajasAhora=round($informe2['bajas']*100/$informe2['peticiones'],2);
        } catch (DivisionByZeroError $e) {
            $bajasAhora=0;
        }
        try {
            $noAdmitidasAntes=round($informe1['noAdmitidas']*100/$informe1['peticiones'],2);
            
        } catch (DivisionByZeroError $e) {
            $noAdmitidasAntes=0;
        }
        try {
            $noAdmitidasAhora=round($informe2['noAdmitidas']*100/$informe2['peticiones'],2);
        } catch (DivisionByZeroError $e) {
            $noAdmitidasAhora=0;
        }
        try {
            $admitidasAntes=round($informe1['admitidas']*100/$informe1['peticiones'],2);
        } catch (DivisionByZeroError $e) {
            $admitidasAntes=0;
        }
        try {
            $admitidasAhora=round($informe2['admitidas']*100/$informe2['peticiones'],2);
        } catch (DivisionByZeroError $e) {
            $admitidasAhora=0;
        }
        try {
            $exitosasAntes=round($informe1['exitosas']*100/$informe1['peticiones'],2);
        } catch (DivisionByZeroError $e) {
            $exitosasAntes=0;
        }
        try {
            $exitosasAhora=round($informe2['exitosas']*100/$informe2['peticiones'],2);
        } catch (DivisionByZeroError $e) {
            $exitosasAhora=0;
        }
        try {
            $publicasAntes=round($informe1['publicas']*100/$informe1['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $publicasAntes=0;
        }
        try {
            $publicasAhora=round($informe2['publicas']*100/$informe2['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $publicasAhora=0;
        }
        try {
            $anonimasAntes=round($informe1['anonimas']*100/$informe1['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $anonimasAntes=0;
        }
        try {
            $anonimasAhora=round($informe2['anonimas']*100/$informe2['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $anonimasAhora=0;
        }
        try {
            $registradasAntes=round($informe1['registradas']*100/$informe1['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $registradasAntes=0;
        }
        try {
            $registradasAhora=round($informe2['registradas']*100/$informe2['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $registradasAhora=0;
        }
        try {
            $noRegistradasAntes=round($informe1['noRegistradas']*100/$informe1['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $noRegistradasAntes=0;
        }
        try {
            $noRegistradasAhora=round($informe2['noRegistradas']*100/$informe2['firmas'],2);
        } catch (DivisionByZeroError $e) {
            $noRegistradasAhora=0;
        }
        
        $div="
        <table class='table'>
            <thead>
                <tr>
                    <th></th>
                    <th><abbr title='{$fecha1}'>{$fecha1}</abbr></th>
                    <th><abbr title='{$fecha2}'>{$fecha2}</abbr></th>
                    <th><abbr title='porcentaje'>%</abbr></th>
                </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th><abbr title='{$fecha1}'>{$fecha1}</abbr></th>
                        <th><abbr title='{$fecha2}'>{$fecha2}</abbr></th>
                        <th><abbr title='porcentaje'>%</abbr></th>
                    </tr>
                </tfoot>
                <tbody>";

                if($informe1["peticiones"]>$informe2["peticiones"])
                {
                    $div.="
                    <tr>
                        <th>Peticiones</th>
                        <td>
                        {$informe1['peticiones']}
                        </td>
                        <td class='is-minus'>
                        {$informe2['peticiones']}
                        </td>
                        <td class='is-minus'>-".$informe1['peticiones']-$informe2['peticiones']."</td>
                    </tr>";
                }
                else if($informe1["peticiones"]<$informe2["peticiones"])
                {
                    $div.="
                    <tr>
                        <th>Peticiones</th>
                        <td>
                        {$informe1['peticiones']}
                        </td>
                        <td class='is-more'>
                        {$informe2['peticiones']}
                        </td>
                        <td class='is-more'>+".$informe2['peticiones']-$informe1['peticiones']."</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Peticiones</th>
                        <td>
                        {$informe1['peticiones']}
                        </td>
                        <td>
                        {$informe2['peticiones']}
                        </td>
                        <td>+".$informe2['peticiones']-$informe1['peticiones']."</td>
                    </tr>";
                }
                if($bajasAntes>$bajasAhora)
                {
                    $div.="
                    <tr>
                        <th>Bajas</th>
                        <td>
                        {$bajasAntes}% ({$informe1['bajas']})
                        </td>
                        <td class='is-more'>
                        {$bajasAhora}% ({$informe2['bajas']})
                        </td>
                        <td class='is-more'>-".$bajasAntes-$bajasAhora."%</td>
                    </tr>";
                }
                else if($bajasAntes<$bajasAhora)
                {
                    $div.="
                    <tr>
                        <th>Bajas</th>
                        <td>
                        {$bajasAntes}% ({$informe1['bajas']})
                        </td>
                        <td class='is-minus'>
                        {$bajasAhora}% ({$informe2['bajas']})
                        </td>
                        <td class='is-minus'>+".$bajasAhora-$bajasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Bajas</th>
                        <td>
                        {$bajasAntes}% ({$informe1['bajas']})
                        </td>
                        <td>
                        {$bajasAhora}% ({$informe2['bajas']})
                        </td>
                        <td>+".$bajasAhora-$bajasAntes."%</td>
                    </tr>";
                }
                if($noAdmitidasAntes>$noAdmitidasAhora)
                {
                    $div.="
                    <tr>
                        <th>No Admitidas</th>
                        <td>
                        {$noAdmitidasAntes}% ({$informe1['noAdmitidas']})
                        </td>
                        <td class='is-more'>
                        {$noAdmitidasAhora}% ({$informe2['noAdmitidas']})
                        </td>
                        <td class='is-more'>-".$noAdmitidasAntes-$noAdmitidasAhora."%</td>
                    </tr>";
                }
                else if($noAdmitidasAntes<$noAdmitidasAhora)
                {
                    $div.="
                    <tr>
                        <th>No Admitidas</th>
                        <td>
                        {$noAdmitidasAntes}% ({$informe1['noAdmitidas']})
                        </td>
                        <td class='is-minus'>
                        {$noAdmitidasAhora}% ({$informe2['noAdmitidas']})
                        </td>
                        <td class='is-minus'>+".$noAdmitidasAhora-$noAdmitidasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>No Admitidas</th>
                        <td>
                        {$noAdmitidasAntes}% ({$informe1['noAdmitidas']})
                        </td>
                        <td>
                        {$noAdmitidasAhora}% ({$informe2['noAdmitidas']})
                        </td>
                        <td>+".$noAdmitidasAhora-$noAdmitidasAntes."%</td>
                    </tr>";
                }
                if($admitidasAntes>$admitidasAhora)
                {
                    $div.="
                    <tr>
                        <th>Admitidas</th>
                        <td>
                        {$admitidasAntes}% ({$informe1['admitidas']})
                        </td>
                        <td class='is-minus'>
                        {$admitidasAhora}% ({$informe2['admitidas']})
                        </td>
                        <td class='is-minus'>-".$admitidasAntes-$admitidasAhora."%</td>
                    </tr>";
                }
                else if($admitidasAntes<$admitidasAhora)
                {
                    $div.="
                    <tr>
                        <th>Admitidas</th>
                        <td>
                        {$admitidasAntes}% ({$informe1['admitidas']})
                        </td>
                        <td class='is-more'>
                        {$admitidasAhora}% ({$informe2['admitidas']})
                        </td>
                        <td class='is-more'>+".$admitidasAhora-$admitidasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Admitidas</th>
                        <td>
                        {$admitidasAntes}% ({$informe1['admitidas']})
                        </td>
                        <td>
                        {$admitidasAhora}% ({$informe2['admitidas']})
                        </td>
                        <td>+".$admitidasAhora-$admitidasAntes."%</td>
                    </tr>";
                }
                if($exitosasAntes>$exitosasAhora)
                {
                    $div.="
                    <tr>
                        <th>Exitosas</th>
                        <td>
                        {$exitosasAntes}% ({$informe1['exitosas']})
                        </td>
                        <td class='is-minus'>
                        {$exitosasAhora}% ({$informe2['exitosas']})
                        </td>
                        <td class='is-minus'>-".$exitosasAntes-$exitosasAhora."%</td>
                    </tr>";
                }
                else if($exitosasAntes<$exitosasAhora)
                {
                    $div.="
                    <tr>
                        <th>Exitosas</th>
                        <td>
                        {$exitosasAntes}% ({$informe1['exitosas']})
                        </td>
                        <td class='is-more'>
                        {$exitosasAhora}% ({$informe2['exitosas']})
                        </td>
                        <td class='is-more'>+".$exitosasAhora-$exitosasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Exitosas</th>
                        <td>
                        {$exitosasAntes}% ({$informe1['exitosas']})
                        </td>
                        <td>
                        {$exitosasAhora}% ({$informe2['exitosas']})
                        </td>
                        <td>+".$exitosasAhora-$exitosasAntes."%</td>
                    </tr>";
                }
                if($informe1["usuarios"]>$informe2["usuarios"])
                {
                    $div.="
                    <tr>
                        <th>Usuarios Nuevos</th>
                        <td>
                        {$informe1['usuarios']}
                        </td>
                        <td class='is-minus'>
                        {$informe2['usuarios']}
                        </td>
                        <td class='is-minus'>-".$informe1['usuarios']-$informe2['usuarios']."</td>
                    </tr>";
                }
                else if($informe1["usuarios"]<$informe2["usuarios"])
                {
                    $div.="
                    <tr>
                        <th>Usuarios Nuevos</th>
                        <td>
                        {$informe1['usuarios']}
                        </td>
                        <td class='is-more'>
                        {$informe2['usuarios']}
                        </td>
                        <td class='is-more'>+".$informe2['usuarios']-$informe1['usuarios']."</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Usuarios Nuevos</th>
                        <td>
                        {$informe1['usuarios']}
                        </td>
                        <td>
                        {$informe2['usuarios']}
                        </td>
                        <td>+".$informe2['usuarios']-$informe1['usuarios']."</td>
                    </tr>";
                }
                if($informe1["firmas"]>$informe2["firmas"])
                {
                    $div.="
                    <tr>
                        <th>Firmas</th>
                        <td>
                        {$informe1['firmas']}
                        </td>
                        <td class='is-minus'>
                        {$informe2['firmas']}
                        </td>
                        <td class='is-minus'>-".$informe1['firmas']-$informe2['firmas']."</td>
                    </tr>";
                }
                else if($informe1["firmas"]<$informe2["firmas"])
                {
                    $div.="
                    <tr>
                        <th>Firmas</th>
                        <td>
                        {$informe1['firmas']}
                        </td>
                        <td class='is-more'>
                        {$informe2['firmas']}
                        </td>
                        <td class='is-more'>+".$informe2['firmas']-$informe1['firmas']."</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Firmas</th>
                        <td>
                        {$informe1['firmas']}
                        </td>
                        <td>
                        {$informe2['firmas']}
                        </td>
                        <td>+".$informe2['firmas']-$informe1['firmas']."</td>
                    </tr>";
                }
                if($publicasAntes>$publicasAhora)
                {
                    $div.="
                    <tr>
                        <th>Publicas</th>
                        <td>
                        {$publicasAntes}% ({$informe1['publicas']})
                        </td>
                        <td class='is-minus'>
                        {$publicasAhora}% ({$informe2['publicas']})
                        </td>
                        <td class='is-minus'>-".$publicasAntes-$publicasAhora."%</td>
                    </tr>";
                }
                else if($publicasAntes<$publicasAhora)
                {
                    $div.="
                    <tr>
                        <th>Publicas</th>
                        <td>
                        {$publicasAntes}% ({$informe1['publicas']})
                        </td>
                        <td class='is-more'>
                        {$publicasAhora}% ({$informe2['publicas']})
                        </td>
                        <td class='is-more'>+".$publicasAhora-$publicasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Publicas</th>
                        <td>
                        {$publicasAntes}% ({$informe1['publicas']})
                        </td>
                        <td>
                        {$publicasAhora}% ({$informe2['publicas']})
                        </td>
                        <td>+".$publicasAhora-$publicasAntes."%</td>
                    </tr>";
                }
                if($anonimasAntes>$anonimasAhora)
                {
                    $div.="
                    <tr>
                        <th>Anonimas</th>
                        <td>
                        {$anonimasAntes}% ({$informe1['anonimas']})
                        </td>
                        <td class='is-more'>
                        {$anonimasAhora}% ({$informe2['anonimas']})
                        </td>
                        <td class='is-more'>-".$anonimasAntes-$anonimasAhora."%</td>
                    </tr>";
                }
                else if($anonimasAntes<$anonimasAhora)
                {
                    $div.="
                    <tr>
                        <th>Anonimas</th>
                        <td>
                        {$anonimasAntes}% ({$informe1['anonimas']})
                        </td>
                        <td class='is-minus'>
                        {$anonimasAhora}% ({$informe2['anonimas']})
                        </td>
                        <td class='is-minus'>+".$anonimasAhora-$anonimasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Anonimas</th>
                        <td>
                        {$anonimasAntes}% ({$informe1['anonimas']})
                        </td>
                        <td>
                        {$anonimasAhora}% ({$informe2['anonimas']})
                        </td>
                        <td>+".$anonimasAhora-$anonimasAntes."%</td>
                    </tr>";
                }
                if($registradasAntes>$registradasAhora)
                {
                    $div.="
                    <tr>
                        <th>Registradas</th>
                        <td>
                        {$registradasAntes}% ({$informe1['registradas']})
                        </td>
                        <td class='is-minus'>
                        {$registradasAhora}% ({$informe2['registradas']})
                        </td>
                        <td class='is-minus'>-".$registradasAntes-$registradasAhora."%</td>
                    </tr>";
                }
                else if($registradasAntes<$registradasAhora)
                {
                    $div.="
                    <tr>
                        <th>Registradas</th>
                        <td>
                        {$registradasAntes}% ({$informe1['registradas']})
                        </td>
                        <td class='is-more'>
                        {$registradasAhora}% ({$informe2['registradas']})
                        </td>
                        <td class='is-more'>+".$registradasAhora-$registradasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>Registradas</th>
                        <td>
                        {$registradasAntes}% ({$informe1['registradas']})
                        </td>
                        <td>
                        {$registradasAhora}% ({$informe2['registradas']})
                        </td>
                        <td>+".$registradasAhora-$registradasAntes."%</td>
                    </tr>";
                }
                if($noRegistradasAntes>$noRegistradasAhora)
                {
                    $div.="
                    <tr>
                        <th>No Registradas</th>
                        <td>
                        {$noRegistradasAntes}% ({$informe1['noRegistradas']})
                        </td>
                        <td class='is-more'>
                        {$noRegistradasAhora}% ({$informe2['noRegistradas']})
                        </td>
                        <td class='is-more'>-".$noRegistradasAntes-$noRegistradasAhora."%</td>
                    </tr>";
                }
                else if($noRegistradasAntes<$noRegistradasAhora)
                {
                    $div.="
                    <tr>
                        <th>No Registradas</th>
                        <td>
                        {$noRegistradasAntes}% ({$informe1['noRegistradas']})
                        </td>
                        <td class='is-minus'>
                        {$noRegistradasAhora}% ({$informe2['noRegistradas']})
                        </td>
                        <td class='is-minus'>+".$noRegistradasAhora-$noRegistradasAntes."%</td>
                    </tr>";
                }
                else
                {
                    $div.="
                    <tr>
                        <th>No Registradas</th>
                        <td>
                        {$noRegistradasAntes}% ({$informe1['noRegistradas']})
                        </td>
                        <td>
                        {$noRegistradasAhora}% ({$informe2['noRegistradas']})
                        </td>
                        <td>+".$noRegistradasAhora-$noRegistradasAntes."%</td>
                    </tr>";
                }
        $div.="
                </tbody>
            </table>";
        return $div;

    }
    public static function getInformeAnual(int $ano) : bool|array {
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
                        SUBSTRING(mes, 1, 4) as fecha,  -- Extrae el año del campo mes
                        SUM(cantidadPeticiones) as peticiones,     
                        SUM(cantidadBajas) as bajas,          
                        SUM(cantidadAdmitidas) as admitidas,      
                        SUM(cantidadExitosas) as exitosas,       
                        SUM(cantidadNoAdmitidas) as noAdmitidas,    
                        SUM(cantidadUsuariosNuevos) as usuarios, 
                        SUM(cantidadFirmas) as firmas,         
                        SUM(cantidadRegistradas) as registradas,    
                        SUM(cantidadNoRegistradas) as noRegistradas,   
                        SUM(cantidadPublicas) as publicas,       
                        SUM(cantidadAnonimas) as anonimas        
                    FROM informe
                    WHERE SUBSTRING(mes, 1, 4) = :fecha
                    GROUP BY fecha";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":fecha"=>$ano
            ]);
            if ($result=$query->fetch()){
				return $result;
            }else{
				return FALSE;
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
    public static function getInforme(int $ano, string $mes) : bool|array {
        try{
            $conexion = BDconection::conectar("user");
            $sql = "SELECT 
            mes as fecha,
            cantidadPeticiones as peticiones,     
            cantidadBajas as bajas,          
            cantidadAdmitidas as admitidas,      
            cantidadExitosas as exitosas,       
            cantidadNoAdmitidas as noAdmitidas,    
            cantidadUsuariosNuevos as usuarios, 
            cantidadFirmas as firmas,         
            cantidadRegistradas as registradas,    
            cantidadNoRegistradas as noRegistradas,   
            cantidadPublicas as publicas,       
            cantidadAnonimas as anonimas        
            FROM informe
            WHERE mes = :fecha";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":fecha"=>"$ano-$mes"
            ]);
            if ($result=$query->fetch()){
				return $result;
            }else{
				return FALSE;
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
    private static function obtenerReporte(string $fecha, string $loc, string $prov, string $pais, string $tematica)
    {
        try{
            $conexion = BDconection::conectar("user");
            $sql = "CALL obtener_reporte(:pais, :prov, :loc, :tematica, :fecha)";
            $query=$conexion->prepare($sql);
            $query->execute([
                ":pais"=>$pais,
                ":prov"=>$prov,
                ":loc"=>$loc,
                ":tematica"=>$tematica,
                ":fecha"=>$fecha
            ]);
            if ($result=$query->fetch()){
                return $result;
            }
            return [];

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
    public static function generarReporte(string $fecha, string $localidad, string $tematica):string
    {
        [$loc,$prov,$pais]=explode(", ",$localidad);
        $reporte=self::obtenerReporte($fecha,$loc,$prov,$pais,$tematica);
        $div="";
        if (count($reporte)==4)
        {
            foreach ($reporte as $key=>$value)
            {
                $div.="$key: $value <br>";
            }
        }
        else
            return "No hay datos registrados para ese mes";
        return $div;
        
    }

}



?>