<?php
require "db.php";

$acao = isset($_GET["acao"]) ? trim($_GET["acao"]) : "";

if ($acao === "listar"){

    $sql = $pdo->prepare("SELECT id, id_usuario, titulo, descricao, status, data_criacao, data_limite FROM tarefas");
    $sql->execute();

    $bodyTarefas = "";
    while ($retorno = $sql->fetch(PDO::FETCH_ASSOC)) {
        
        $bodyTarefas .= "<tr>";
        $bodyTarefas .= "<td>" . $retorno['id'] . "</td>";
        $bodyTarefas .= "<td>" . $retorno['id_usuario'] . "</td>";
        $bodyTarefas .= "<td>" . $retorno['titulo'] . "</td>";
        $bodyTarefas .= "<td>" . $retorno['descricao'] . "</td>";
        $bodyTarefas .= "<td>" . $retorno['data_criacao'] . "</td>";
        $bodyTarefas .= "<td>" . $retorno['data_limite'] . "</td>";
        $bodyTarefas .= "<td>" . $retorno['status'] . "</td>";
        $bodyTarefas .= "</tr>";
    }

    echo $bodyTarefas;
}

if ($acao === "cadastrar"){
    $id_usuario = isset($_POST["id_usuario"]) ? trim($_POST["id_usuario"]) : "";
    $titulo = isset($_POST["titulo"]) ? trim($_POST["titulo"]) : "";
    $descricao = isset($_POST["descricao"]) ? trim($_POST["descricao"]) : "";
    $status = isset($_POST["status"]) ? trim($_POST["status"]) : "";
    $data_criacao = isset($_POST["data_criacao"]) ? trim($_POST["data_criacao"]) : "";
    $data_limite = isset($_POST["data_limite"]) ? trim($_POST["data_limite"]) : "";
    
    if ($id_usuario == "" || $titulo == "" || $descricao == "" || $status == "" || $data_criacao == "" || $data_limite == "") {
        http_response_code(400);
        echo "Preencha todos os campos.";
        exit;
    }

    $sql = $pdo->prepare("INSERT INTO tarefas (id_usuario, titulo, descricao, status, data_criacao, data_limite) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$id_usuario, $titulo, $descricao, $status, $data_criacao, $data_limite]);

    http_response_code(200);
    echo "OK";
}

?>