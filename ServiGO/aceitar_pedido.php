<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'profissional') {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>ID do pedido inválido!</h2>";
    exit();
}

$pedido_id = $_GET['id'];

$query = "UPDATE pedidos SET status = 'aceito' WHERE id = ? AND profissional_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $pedido_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo "<h2>Pedido aceito com sucesso!</h2>";
} else {
    echo "<h2>Erro ao aceitar o pedido!</h2>";
}

$stmt->close();
$conn->close();
?>
<a href="profissional_dashboard.php">Voltar</a>
