<?php

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['matricula'])) {
    header("location:home");
}

if (
    isset($_POST['nome']) && $_POST['nome'] != ""
    && isset($_POST['matricula']) && $_POST['matricula'] != ""
    && isset($_POST['senha']) && $_POST['senha'] != ""
    && isset($_POST['re_senha']) && $_POST['re_senha'] != ""
    && $_POST['senha'] == $_POST['re_senha']
) {
    include "../config/db.php";
    $id = $my_Db_Connection->quote($_POST['matricula']);
    $nome = $my_Db_Connection->quote($_POST['nome']);
    $sql_bus = "SELECT * FROM aluno WHERE matricula = " . $id . " && nome=" . $nome;
    $bus = $my_Db_Connection->prepare($sql_bus);
    $bus->execute();
    if ($bus->rowCount() == 1) {
       
        $result = $bus->fetch(PDO::FETCH_ASSOC);
        if ($result['nome'] != $_POST['nome']) {
            die("nome invalido");
        }
        if (password_verify($_POST['senha'], $result['senha'])) {
            unset($result['senha']);
            $sql_bus = "select * from aluno inner join ticket on aluno.matricula = ticket.codigo_fk and aluno.matricula=" . $id ;
            $bus = $my_Db_Connection->prepare($sql_bus);
            $bus->execute();
            if ($bus->rowCount() == 1) {
                header("location:login");
                exit();
            }
            if (isset($_FILES['imagem_perfil']) && $_FILES['imagem_perfil']['error'] === UPLOAD_ERR_OK) {
                $img = $_FILES['imagem_perfil'];

                $tipo = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
                if ($tipo != "jpg" && $tipo != "png") {
                    die("formato de imagem nao permitida");
                }
                if ($img['error']) {
                    die("erro ao salvar imagem");
                }
                $locals = "./asset/imagens/gerarcartao/fotoperfil/" . $id."/";
                if (!is_dir($locals)) {
                    mkdir($locals, 0755);
                }
                $nome_img = uniqid();
                $locals = $locals . $nome_img . '.' . $tipo;
                $img_ok = move_uploaded_file($img['tmp_name'], $locals);

                if ($img_ok) {
                    $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO arquivos (local_arq,tipo,data_cria,aluno_fk) VALUES (:localar, :tp, :datc,:aluno)");
                    $my_Insert_Statement->bindParam(':localar', $locals);
                    $tpa ="imagem_perfil";
                    $my_Insert_Statement->bindParam(':tp', $tpa);
                    date_default_timezone_set('America/Sao_Paulo');
                    $data = new DateTime();
                    $data=$data->format('Y/m/d H:i');
                    $my_Insert_Statement->bindParam(':datc', $data);
                    $my_Insert_Statement->bindParam(':aluno', $result['matricula']);
                    $my_Insert_Statement->execute();
                } else {
                    die("erro ao salvar arquivo");
                }
            } else {
                die("nenhuma imagem enviada");
            }
            $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO ticket (codigo_fk) VALUES (:cod)");
            $my_Insert_Statement->bindParam(':cod', $result['matricula']);
            if ($my_Insert_Statement->execute()) {
                header("location:login");
                exit();
            } else {
                header("location:cadastro");
                exit();
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

    <form method="post" enctype="multipart/form-data" class="loginc" style="float:none;">
        <label for="nome" style="margin-bottom:5px;">Nome Completo :</label>
        <input type="text" name="nome" id="nome">
        <label for="matricula">Matricula :</label>
        <input type="text" name="matricula" id="matricula">
        <label for="senha">Senha :</label>
        <input type="password" name="senha" id="senha">
        <label for="re_senha">Confirma Senha :</label>
        <input type="password" name="re_senha" id="re_senha">
        <label for="imagem_perfil">imagem para o cartao:</label>
        <input type="file" name="imagem_perfil" id="imagem_perfil" accept="image/*">
        <input type="submit" value=" Pedir cartão ">
        <img src="http://localhost/ifticket/project/asset/imagens/gerarcartao/geracartao.php" alt="">

    </form>
</body>


</html>