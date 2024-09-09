<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profissional_id = $_POST['profissional_id'];
    $servico_id = $_POST['servico_id'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $query = "INSERT INTO pedidos (cliente_id, profissional_id, servico_id, descricao, preco) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iiiss', $_SESSION['user_id'], $profissional_id, $servico_id, $descricao, $preco);

    if ($stmt->execute()) {
        echo "<h2>Pedido realizado com sucesso!</h2>";
    } else {
        echo "<h2>Erro ao realizar o pedido!</h2>";
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
    <title>Solicitar Pedido - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Solicitar Pedido</h1>
    <form action="solicitar_pedido.php" method="post">
        <label for="profissional_id">Profissional:</label>
        <select id="profissional_id" name="profissional_id" required>
            <?php
            $query = "SELECT id, nome FROM usuarios WHERE tipo = 'profissional'";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['nome']}</option>";
            }
            ?>
        </select>
        <br>

        <label for="servico_id">Serviço:</label>
        <select id="servico_id" name="servico_id" required>
            <?php
            $query = "SELECT id, nome FROM servicos";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['nome']}</option>";
            }
            ?>
        </select>
        <br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea>
        <br>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" required>
        <br>

        <input type="submit" value="Enviar Pedido">
    </form>
    <a href="cliente_dashboard.php">Voltar</a>
</body>
</html>
