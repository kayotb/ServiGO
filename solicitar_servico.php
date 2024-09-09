<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] != 'cliente') {
        echo "<h2>Acesso não autorizado!</h2>";
        exit();
    }

    $cliente_id = $_SESSION['user_id'];
    $profissional_id = $_POST['profissional_id'] ?? null;
    $servico_id = $_POST['servico_id'] ?? null;
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? null;

    include 'conexao.php';

    if ($profissional_id === null || $servico_id === null || $preco === null) {
        echo "<h2>Por favor, preencha todos os campos.</h2>";
        exit();
    }

    $query = "INSERT INTO pedidos (cliente_id, profissional_id, servico_id, descricao, preco, data_solicitacao) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo "<h2>Erro na preparação da consulta: " . $conn->error . "</h2>";
        exit();
    }

    $stmt->bind_param('iiiss', $cliente_id, $profissional_id, $servico_id, $descricao, $preco);

    if ($stmt->execute()) {
        echo "<h2>Solicitação de serviço enviada com sucesso!</h2>";
    } else {
        echo "<h2>Erro ao enviar a solicitação: " . $stmt->error . "</h2>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Serviço - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Solicitar Serviço</h2>
        <form action="solicitar_servico.php" method="post">
            <label for="profissional_id">Profissional:</label>
            <select name="profissional_id" id="profissional_id" required>
                <!-- Preencher com opções reais do banco de dados -->
                <option value="1">Profissional 1</option>
                <option value="2">Profissional 2</option>
            </select><br><br>

            <label for="servico_id">Serviço:</label>
            <select name="servico_id" id="servico_id" required>
                <!-- Preencher com opções reais do banco de dados -->
                <option value="1">Serviço 1</option>
                <option value="2">Serviço 2</option>
            </select><br><br>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao"></textarea><br><br>

            <label for="preco">Preço:</label>
            <input type="number" name="preco" id="preco" step="0.01" required><br><br>

            <input type="submit" value="Enviar Solicitação">
        </form>
    </div>
</body>
</html>
