<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'profissional') {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

// Consultar os serviços oferecidos pelo profissional
$query_servicos = "SELECT * FROM servicos WHERE id IN (SELECT servico_id FROM profissionais_servicos WHERE profissional_id = ?)";
$stmt_servicos = $conn->prepare($query_servicos);
if ($stmt_servicos) {
    $stmt_servicos->bind_param('i', $_SESSION['user_id']);
    $stmt_servicos->execute();
    $result_servicos = $stmt_servicos->get_result();
} else {
    $result_servicos = null;
}

// Consultar os pedidos do profissional
$query_pedidos = 'SELECT pedidos.id, usuarios.nome AS cliente_nome, servicos.titulo AS servico_nome, pedidos.descricao AS descricao, servicos.preco, pedidos.status
                  FROM pedidos
                  JOIN usuarios ON pedidos.cliente_id = usuarios.id
                  JOIN servicos ON pedidos.servico_id = servicos.id
                  WHERE pedidos.profissional_id = ?';
$stmt_pedidos = $conn->prepare($query_pedidos);
if ($stmt_pedidos) {
    $stmt_pedidos->bind_param('i', $_SESSION['user_id']);
    $stmt_pedidos->execute();
    $result_pedidos = $stmt_pedidos->get_result();
} else {
    $result_pedidos = null;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Profissional - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index_logado.php"> 
            <img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;">
        </a>
    </header>

    <div class="container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_nome']); ?>!</h1>
        <p>Esta é a sua área de profissional. Aqui você pode gerenciar seus serviços, visualizar pedidos e muito mais.</p>

        <div class="dashboard-buttons">
            <button><a href="perfil_profissional.php">Perfil</a></button>
            <button><a href="agendar_servico.php">Agendar Serviço</a></button>
            <button><a href="cadastrar_servico.php">Cadastrar Novo Serviço</a></button>
            <button><a href="historico_servicos_profissional.php">Histórico de Serviços</a></button>
        </div>

        <h2>Serviços Oferecidos</h2>
        <?php if ($result_servicos && $result_servicos->num_rows > 0): ?>
            <ul>
                <?php while ($servico = $result_servicos->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($servico['titulo']); ?> - <a href="editar_servico.php?id=<?php echo $servico['id']; ?>">Editar</a></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não cadastrou serviços.</p>
        <?php endif; ?>

        <h2>Pedidos</h2>
        <?php if ($result_pedidos && $result_pedidos->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pedido = $result_pedidos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['cliente_nome']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['servico_nome']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['descricao']); ?></td>
                            <td><?php echo number_format($pedido['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($pedido['status']); ?></td>
                            <td>
                                <a href="aceitar_pedido.php?id=<?php echo $pedido['id']; ?>">Aceitar</a>
                                <a href="cancelar_pedido.php?id=<?php echo $pedido['id']; ?>">Cancelar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Você não tem pedidos no momento.</p>
        <?php endif; ?>

        <div class="navigation-buttons">
            <a href="index_logado_profissional.php" class="button">Voltar</a>
        </div>
    </div>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>

<?php
if ($stmt_servicos) {
    $stmt_servicos->close();
}

if ($stmt_pedidos) {
    $stmt_pedidos->close();
}

$conn->close();
?>
