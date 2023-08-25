<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['matricula'])) {
    header("location:login");
}

define('WIDTH',323);
define('HEIGHT',208*2);


include "../../../../config/db.php";
$result= $_SESSION['matricula'];
$sql_bus = "SELECT local_arq FROM arquivos WHERE aluno_fk =". $result ."&& tipo='imagem_perfil'";
$bus = $my_Db_Connection->prepare($sql_bus);
$bus->execute();
if ($bus->rowCount() == 1) {
    $result = $bus->fetch(PDO::FETCH_ASSOC);
    $result=$result['local_arq'];
    $url=array_filter(explode('/',$result));
    $result=$url[4].'/'.$url[5].'/'.$url[6];
}else {
    $result='4.png';
}

$imagem = imagecreatetruecolor(WIDTH, HEIGHT);

$corFundo = imagecolorallocate($imagem, 0, 191, 99);

imagefill($imagem, 0, 0, $corFundo);

$logoif=imagecreatefrompng('3.png');
$fperfil=$result;
$selo=imagecreatefrompng( '5.png');
$qr=imagecreatefrompng('6.png');
$faixa=imagecreatefrompng('7.png');

$tipoMIME=exif_imagetype($fperfil);
if ($tipoMIME==IMAGETYPE_JPEG) {
    $fperfil=imagecreatefromjpeg($fperfil);
}else {
    if ($tipoMIME==IMAGETYPE_PNG) {
        $fperfil=imagecreatefrompng($fperfil);
    }else {
        die("erro ao carregar imagem");
    }
}


imagecopyresampled($imagem, $logoif, -90, -70, 0, 0,250, 250, 1011,637);

$width=imagesx($fperfil);
$height=imagesy($fperfil);
imagecopyresampled($imagem, $fperfil, 250, 30, 0, 0,50, 80, $width,$height);

imagecopyresampled($imagem, $selo, 190, 80, 0, 0,180, 180, 1011,637);
imagecopyresampled($imagem, $qr, 75, 210, 0, 0,180, 180, 1011,637);
imagecopyresampled($imagem, $faixa, 0, 290, 0, 0,500, 180, 1011,637);




$cortx=imagecolorallocate($imagem, 255, 255, 255);
$nome="Nome : ".((isset($_SESSION['nome'])) ? $_SESSION['nome'] : 'Nome');
$matricula="Codigo : ".((isset($_SESSION['matricula'])) ? $_SESSION['matricula'] : 'Matricula');
imagettftext($imagem, 10, 0, 30, 170,$cortx, 'BebasNeue-Regular.ttf',$nome);
imagettftext($imagem, 10, 0, 30, 150,$cortx, 'BebasNeue-Regular.ttf',$matricula);
header('Content-Type: image/png');

// Gerar a imagem PNG
imagepng($imagem);


// Liberar a memória usada pela imagem
imagedestroy($imagem);