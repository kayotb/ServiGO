<?php
// Exibir erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

$user_id = $_SESSION['user_id'];

// Corrija a consulta SQL para usar a coluna correta da tabela 'servicos'
$query = "SELECT p.id, p.servico_id, s.titulo AS servico_nome, p.status, p.data_solicitacao 
          FROM pedidos p 
          JOIN servicos s ON p.servico_id = s.id 
          WHERE p.cliente_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Serviços - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index.php">
            <li><a href="index_logado.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a></li>
        </a>
    </header>
    
    <div class="container">
        <h1>Histórico de Serviços</h1>
        
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($pedido = $result->fetch_assoc()): ?>
                    <li>
                        <strong>Serviço:</strong> <?php echo htmlspecialchars($pedido['servico_nome']); ?><br>
                        <strong>Data da Solicitação:</strong> <?php echo htmlspecialchars($pedido['data_solicitacao']); ?><br>
                        <strong>Status:</strong> <?php echo htmlspecialchars($pedido['status']); ?><br>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não possui um histórico de serviços.</p>
        <?php endif; ?>
        
        <a href="cliente_dashboard.php" class="button">Voltar</a>
    </div>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
