<?php
if (!isset($_SESSION)) {
    session_start();
}

//echo password_hash("123456",PASSWORD_DEFAULT);
// if (isset($_SESSION['matricula'])) {
//     header("location:home");
// }

if (
    isset($_POST['identificador']) && $_POST['identificador'] != ""
    && isset($_POST['senha']) && $_POST['senha'] != ""
) {
include "../config/db.php";

    $usr = array();

    $usr['usuario'] = $my_Db_Connection->quote($_POST['identificador']);
    $usr['senha'] = $_POST['senha'];
    $sql_bus = "select * from aluno where matricula=" . $usr['usuario'] . "and possui_ti=1";
    $bus = $my_Db_Connection->prepare($sql_bus);
    $bus->execute();
    $count = $bus->rowCount();
    if ($count == 1) {
        $result = $bus->fetch(PDO::FETCH_ASSOC);
        if (password_verify($usr['senha'], $result['senha'])) {
            unset($result['senha']);
            $_SESSION = array_merge($_SESSION, $result);
            //die(print_r($_SESSION));
            //$_SESSION['id_s']=uniqid().'s'.rand(1,1000).'s'.uniqid();
            // date_default_timezone_set('America/Sao_Paulo');
            //$data = new DateTime();
            //$data = $data->format('Y/m/d H:i');
            // $bus = $my_Db_Connection->prepare("UPDATE users join info_users on users.id_nome=info_users.user_id_nome SET info_users.login_date = :lda WHERE users.id_nome= :id");
            //$bus->bindParam(':lda', $data);
            // $bus->bindParam(':id', $result['id_nome']);
            //if ($bus->execute()) {
            header( "location:home");
            exit();
            // } else {
            //   header("location:login.php");
            //   exit();
            // }
        }
    } else {
        header("Refresh: 0");
        exit();
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
</head>

<body>
    <header> <span></span>
        <h1> TICKET</h1>
        <nav><a href="#">Ajuda</a> <a href="#">Forum</a></nav>
    </header>
    <form method="post" class="loginc">
        <label for="identificador">Numero da matricula :</label>
        <input type="text" name="identificador" id="identificador">
        <label for="senha">senha :</label>
        <input type="password" name="senha" id="senha">
        <input type="submit" value="Entrar">
        <a href="home">Esqueceu senha?</a>
    </form>
    <div class="image">
        <img src="./project/asset/imagens/1.png" alt="">
        <img src="./project/asset/imagens/2.png" alt="">
        <a href="cadastro">Solicitar cartão</button>
    </div>
</body>

</html>
