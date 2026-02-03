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
                            <button class='btn btn-danger btn-sm'
                                onclick='excluirUsuario(\"{$retorno['id']}\")'>
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

    $id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

    if ($id <= 0) {
        http_response_code(400);
        echo "ID inválido";
        exit;
    }

    $sql = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
    $sql->execute([$id]);

    echo "OK";
}
?>