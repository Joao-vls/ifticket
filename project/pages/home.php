<?php

if (!isset($_SESSION)) {
    session_start();
}
//echo password_hash("123456",PASSWORD_DEFAULT);
if (!isset($_SESSION['matricula'])) {
    header("location:login");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFticket</title>
    <link rel="stylesheet" href="./project/asset/css/style.css">
    <script src="./project/asset/js/js.js"></script>
    <script src="https://kit.fontawesome.com/9f72a03fbd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header> <span></span>
        <h1> TICKET</h1>
        <nav><a href="#">Ajuda</a> <a href="#">Forum</a><a href="sair">Sair</a></nav>
    </header>
<div style="right: 0" class="image">
    <img id="generatedImage" src="http://localhost/ifticket/project/asset/imagens/gerarcartao/geracartao.php" alt="Imagem Gerada">
    <button id="downloadButton">Baixar Cartão</button>
</div>
<div class="info_reca">
    <section class="infos" ><i class="fa-solid fa-wallet fa-2xl"></i> Saldo da conta:
        <?php echo "<p>".$_SESSION['valor']."</p>"; ?>
    </section>
    <a href="recarregar"><i class="fa-regular fa-address-card fa-2xl"></i> Recarregar</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var downloadButton = document.getElementById('downloadButton');
        downloadButton.addEventListener('click', function() {
            var generatedImage = document.getElementById('generatedImage');
            var url = generatedImage.src;
            var link = document.createElement('a');
            link.href = url;
            link.download = 'imagem_gerada.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>
</body>

</html>