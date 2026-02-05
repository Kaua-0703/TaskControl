<?php
session_start();
require "db.php";

$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";

if ($email == "" || $senha == "") {
    http_response_code(400);
    echo "Preencha email e senha.";
    exit;
}

$sql = $pdo->prepare("
    SELECT id, nome, email, senha, admin
    FROM usuario
    WHERE email = ?
    LIMIT 1
");
$sql->execute([$email]);
$retorno = $sql->fetch(PDO::FETCH_ASSOC);

if (!$retorno) {
    http_response_code(401);
    echo "Usuário ou senha inválidos.";
    exit;
}

if (!password_verify($senha, $retorno["senha"])) {
    http_response_code(401);
    echo "Usuário ou senha inválidos.";
    exit;
}

$_SESSION["usuario_id"]    = $retorno["id"];
$_SESSION["usuario_nome"]  = $retorno["nome"];
$_SESSION["usuario_email"] = $retorno["email"];
$_SESSION["usuario_admin"] = $retorno["admin"];

echo "OK";
