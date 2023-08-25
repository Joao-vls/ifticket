<?php
if (!isset($_SESSION)) {
    session_start();
}
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

<body style="display:flex; justify-content:center; align-items: center; flex-wrap:wrap;">
    <header> <span></span>
        <h1> TICKET</h1>
        <nav><a href="#">Ajuda</a> <a href="#">Forum</a><a href="sair">Sair</a></nav>
    </header>
    <form method="post" class="loginc" style="float:none">
        <label for="frutas">Valor da recarga</label>
        <select name="recarga" id="recarga">
            <option value="3">R$3,00</option>
            <option value="6">R$6,00</option>
            <option value="10">R$10,00</option>
            <option value="25">R$25,00</option>
            <option value="30">R$30,00</option>
            <option value="35">R$35,00</option>
            <option value="40">R$45,00</option>
            <option value="50">R$50,00</option>
            <option value="100">R$100,00</option>
        </select>
        <div style="display:flex; justify-content:center; align-items: center; ">
            <p style="padding:20px">forma de pagamento</p>
            <label for="opcao1">Pix</label>
            <input type="radio" name="opcao" id="opcao1" value="opcao1">
            <label for="opcao2">Cartão</label>
            <input type="radio" name="opcao" id="opcao2" value="opcao2">
        </div>

            <section class="infos" style="white-space: nowrap;"><i class="fa-solid fa-wallet fa-2xl"></i> Data da Recarga:
                <?php echo "<p>" . date('d/m/Y') . "</p>"; ?>
            </section>
        <input type="submit" value="Recarregar">
        <a href="home">voltar</a>
    </form>
</body>

</html>