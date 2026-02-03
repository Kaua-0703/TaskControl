<?php
require "db.php";

$acao = isset($_GET["acao"]) ? trim($_GET["acao"]) : "";

if ($acao === "listar") {

    $sql = $pdo->prepare("SELECT id, nome, email, admin FROM usuario");
    $sql->execute();

    $bodyUsuarios = "";

    while ($retorno = $sql->fetch(PDO::FETCH_ASSOC)) {

        $bodyUsuarios .= "<tr>";
        $bodyUsuarios .= "<td>{$retorno['id']}</td>";
        $bodyUsuarios .= "<td>{$retorno['nome']}</td>";
        $bodyUsuarios .= "<td>{$retorno['email']}</td>";
        $bodyUsuarios .= "<td class='text-end'>" . ($retorno['admin'] ? "Sim" : "Não") . "</td>";

        $bodyUsuarios .= "<td class='text-end'>
                            <button class='btn btn-warning btn-sm me-1'
                                onclick='editarUsuario({$retorno['id']})'>
                                Editar
                            </button>
                            <button class='btn btn-danger btn-sm'
                                onclick='excluirUsuario({$retorno['id']})'>
                                Excluir
                            </button>
                         </td>";

        $bodyUsuarios .= "</tr>";
    }

    echo $bodyUsuarios;
    exit;
}

if ($acao === "cadastrar"){
    $nome = isset($_POST["nome"]) ? trim($_POST["nome"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";
    $admin = isset($_POST["admin"]) && $_POST["admin"] === "true" ? 1 : 0;

    if ($nome == "" || $email == "" || $senha == "") {
        http_response_code(400);
        echo "Preencha nome, email e senha.";
        exit;
    }

    $hashSenha = password_hash($senha, PASSWORD_DEFAULT);

    $sql = $pdo->prepare("INSERT INTO usuario (nome, email, senha, admin) VALUES (?, ?, ?, ?)");
    $sql->execute([$nome, $email, $hashSenha, $admin]);

    http_response_code(200);
    echo "OK";
}

if ($acao === "excluir") {

    $id = isset($_POST["id"]) ? (int)$_POST["id"] : "";

    if ($id <= 0) {
        http_response_code(400);
        echo "ID inválido";
        exit;
    }

    $sql = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
    $sql->execute([$id]);

    echo "OK";
}

if ($acao === "buscar") {

    $id = intval($_POST["id"]);

    $sql = $pdo->prepare("SELECT id, nome, email, admin FROM usuario WHERE id = ?");
    $sql->execute([$id]);

    echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
    exit;
}


if ($acao === "atualizar") {

    $id = intval($_POST["id"]);
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $admin = $_POST["admin"] === "true" ? 1 : 0;

    $sql = $pdo->prepare(
        "UPDATE usuario SET nome = ?, email = ?, admin = ? WHERE id = ?"
    );

    $sql->execute([$nome, $email, $admin, $id]);

    echo "OK";
    exit;
}


?>