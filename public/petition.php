<?php

use Dompdf\Dompdf;

require_once "../app/dompdf/autoload.inc.php";
require_once "../app/phpqrcode/qrlib.php";
require_once "../app/init.php";
require_once "../core/init.php";

session_start();
$app = new App();

$dompdf = new Dompdf(['enable_remote'=> true]);
if (!isset($_GET) || !isset($_GET["numero"])){
    exit();
}
$nroPet=intval($_GET["numero"]);
if ($nroPet<=0){
    exit();
}
$peticion=Peticiones::getPeticionByNumero($nroPet);
if (!$peticion->estaTerminada()){
    exit();
}

if (isset($_GET["mode"]) && $_GET["mode"]=="verificar")
{
    $app->verificarDatosPDF($nroPet);
    exit();
}

$arregloPeticion=$peticion->getDatosEnArreglo();
$comentarios=Firmas::comentariosPDF($nroPet);
$fechaUltimaFirma=Firmas::ultimaFirma($nroPet);
$fechaUltimaFirma=substr($fechaUltimaFirma,8,2)."/".substr($fechaUltimaFirma,5,2)."/".substr($fechaUltimaFirma,0,4);
$tituloDocumento="Petición N° ". $nroPet." - Proyecto Change";



// comienzo buffer imagen
ob_start();

$qr_content = $app->getDirectorioDeTrabajo()."/petition.php?numero={$nroPet}&mode=verificar";
$qr_file = 'qrcode.png';
QRcode::png($qr_content, null,'L',4,2);
$image_data = ob_get_contents();

ob_end_clean();

$base64_image = base64_encode($image_data);
$qrimg="<img src='data:image/png;base64,{$base64_image}' alt='QR code'>";

// comienzo buffer PDF
ob_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloDocumento ?></title>
    <link rel="stylesheet" href="<?php echo $app->getDirectorioDeTrabajo()?>/css/pdf.css">
</head>
<body>
    <div class="content"> 
        <div class="titulo">
            <?php echo $arregloPeticion["titulo"]?>
        </div>
        <div class="fecha">
            <?php echo $arregloPeticion["fechaCreacion"]?>
        </div>
        <div class="localidad">
            <?php echo $arregloPeticion["localidad"]; ?>
        </div>
        <div class="destino">
            <p>La petición creada por el usuario <strong><?php echo ucwords($arregloPeticion["nombre"]) ?></strong>, correo: <?php echo strtolower($arregloPeticion["correo"]) ?>, dice lo siguiente:</p>
            <p><?php echo $arregloPeticion["destino"]; ?></p>
        </div>
        <div class="cuerpo">
            <?php echo $arregloPeticion["cuerpo"]; ?>
        </div>
        <div class="imagenes">
            <?php
            if (count($arregloPeticion["imagenes"])>0) echo "<p>El reclamo en cuestión, está acompañado de la(s) siguiente(s) imágen(es)</p>";
            foreach ($arregloPeticion["imagenes"] as $imagen)
            {
                echo "<div class='image-div'><img src='{$app->getDirectorioDeTrabajo()}/images/{$imagen->showImagen()}' alt=''></div>";
            }

            ?> 
        </div>
        <div class="objetivo">
            <?php
                echo "<p>Esta petición, cuyo objetivo de firmas era <strong>{$arregloPeticion["objFirmas"]}</strong> cuenta con <strong>{$arregloPeticion['firmas']}</strong> firmas, obteniendo la última el día {$fechaUltimaFirma}</p>";
            ?>
        </div>
        <div class="firmas-cont">
            <?php
            if (count($comentarios)>0)
            {
                echo "<p>Los firmantes de la misma, comentaron cosas como: </p>";
                echo " <div class='firmas'> ";
                foreach ($comentarios as $firma)
                {
                    echo $firma;
                }
                echo "</div>";
            } 
            ?> 
        </div>
        <div class="info">
            <div id="link">
                Puedes corroborar los datos de esta peticion en <a href="<?php echo $qr_content?>"><?php echo $qr_content?></a>, o escaneando el siguiente QR
            </div>
            <div id="qrcode">
                <?php echo $qrimg; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$a=ob_get_contents();
ob_end_clean();
$dompdf->loadHtml($a);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($tituloDocumento, array("Attachment" => false));


?>