<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'profissional') {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

$profissional_id = $_SESSION['user_id'];
$query = "SELECT s.*, sol.*, u.nome AS cliente_nome FROM solicitacoes sol
JOIN servicos s ON sol.servico_id = s.id
JOIN usuarios u ON sol.usuario_id = u.id
WHERE sol.profissional_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $profissional_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Pedidos - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Verificar Pedidos</h1>
    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($pedido = $result->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($pedido['nome']); ?></strong><br>
                        Cliente: <?php echo htmlspecialchars($pedido['cliente_nome']); ?><br>
                        Descrição: <?php echo htmlspecialchars($pedido['descricao']); ?><br>
                        Preço: R$ <?php echo number_format($pedido['preco'], 2, ',', '.'); ?><br>
                        Status: <?php echo htmlspecialchars($pedido['status']); ?><br>
                        <a href="aceitar_pedido.php?id=<?php echo $pedido['id']; ?>">Aceitar Pedido</a>
                        <a href="cancelar_pedido.php?id=<?php echo $pedido['id']; ?>">Cancelar Pedido</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Você não tem pedidos no momento.</p>
        <?php endif; ?>
        <a href="profissional_dashboard.php" class="button">Voltar</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
