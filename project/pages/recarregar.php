<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['matricula'])) {
    header("location:login");
}
$val=[3,6,15,24,33,39,45,54,99];
$op=['pix','cartao'];
if(isset($_POST['recarga']) && isset($_POST['opcao'])){
    if(in_array($_POST['recarga'],$val) && in_array($_POST['opcao'],$op)){
        include "../config/db.php";
        $id = $my_Db_Connection->quote($_SESSION['matricula']);
        $sql_bus = "SELECT * FROM aluno WHERE matricula = " . $id;
        $bus = $my_Db_Connection->prepare($sql_bus);
        $bus->execute();
        $count = $bus->rowCount();
        if ($count == 1) {
            $result = $bus->fetch(PDO::FETCH_ASSOC);
            $valor=intval($result['valor'] + $_POST['recarga']);

            $forma = $my_Db_Connection->quote($_POST['opcao']);
            $my_Insert_Statement = $my_Db_Connection->prepare("update aluno set valor=:valo where matricula=:cod");
            $my_Insert_Statement->bindParam(':valo', $valor);
            $my_Insert_Statement->bindParam(':cod', $result['matricula']);
            if ($my_Insert_Statement->execute()) {
                $_SESSION['valor']=$valor;
                $my_Insert_Statement = $my_Db_Connection->prepare("insert into pagamento (valor,metodo,aluno_fk,data_recarga) values (:valor,:forma,:cod,:dt)");
                $my_Insert_Statement->bindParam(':valor', $_POST['recarga']);
                $my_Insert_Statement->bindParam(':forma', $_POST['opcao']);
                $my_Insert_Statement->bindParam(':cod', $id);
                $my_Insert_Statement->bindParam(':dt', date('Y-m-d'));
                header("location:home");
            } else {
                header("location:recarregar");
            }
        }
    }
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
            <option value="15">R$15,00</option>
            <option value="24">R$24,00</option>
            <option value="33">R$33,00</option>
            <option value="39">R$39,00</option>
            <option value="45">R$45,00</option>
            <option value="54">R$54,00</option>
            <option value="99">R$99,00</option>
        </select>
        <div style="display:flex; justify-content:center; align-items: center; ">
            <p style="padding:20px">forma de pagamento</p>
            <label for="opcao1">Pix</label>
            <input type="radio" name="opcao" id="opcao1" value="pix">
            <label for="opcao2">Cartão</label>
            <input type="radio" name="opcao" id="opcao2" value="cartao">
        </div>

            <section class="infos" style="white-space: nowrap;"><i class="fa-solid fa-wallet fa-2xl"></i> Data da Recarga:
                <?php echo "<p>" . date('d/m/Y') . "</p>"; ?>
            </section>
        <input type="submit" value="Recarregar">
        <a href="home">voltar</a>
    </form>
</body>

</html>