<?php
session_start();
include 'conexao.php';

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['user_id']) || $_SESSION['tipo_usuario_id'] != 2) {
    header("Location: login.php");
    exit();
}

// Inicializar variáveis para mensagens
$message = null;
$error = false;

// Atualizar status da solicitação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    // Preparar e executar a atualização do status
    $query = "UPDATE solicitacoes SET status = ? WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();
        $stmt->close();
        $message = "Status atualizado com sucesso!";
    } else {
        $error = true;
        $message = "Erro ao atualizar status.";
    }
}

// Consultar todas as solicitações
$query = "SELECT solicitacoes.id, usuarios.nome, usuarios.telefone, solicitacoes.categoria, solicitacoes.status, 
          solicitacoes.descricao, solicitacoes.endereco, solicitacoes.data_solicitacao, 
          solicitacoes.forma_pagamento 
          FROM solicitacoes 
          JOIN usuarios ON solicitacoes.user_id = usuarios.id 
          ORDER BY solicitacoes.data_solicitacao DESC";
$result = $conn->query($query);

// Fechar a conexão com o banco de dados após todas as consultas
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #2c3e50;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            color: #fff;
            border-radius: 4px;
        }
        .message.success {
            background-color: #27ae60;
        }
        .message.error {
            background-color: #e74c3c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        select, button {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            font-size: 14px;
            cursor: pointer;
        }
        button {
            background-color: #2c3e50;
            color: #fff;
        }
        button:hover {
            background-color: #34495e;
        }
        footer {
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index_logado.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px;"></a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <h1>Painel Administrativo</h1>

            <?php if (isset($message)): ?>
                <div class="message <?php echo isset($error) ? 'error' : 'success'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Cliente</th>
                        <th>Telefone</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Descrição</th>
                        <th>Endereço</th>
                        <th>Data</th>
                        <th>Forma de Pagamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($row['endereco']); ?></td>
                            <td><?php echo htmlspecialchars($row['data_solicitacao']); ?></td>
                            <td><?php echo htmlspecialchars($row['forma_pagamento']); ?></td>
                            <td class="actions">
                                <form action="" method="POST">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <select name="status">
                                        <option value="pendente" <?php echo $row['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                                        <option value="em andamento" <?php echo $row['status'] == 'em andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                                        <option value="concluído" <?php echo $row['status'] == 'concluído' ? 'selected' : ''; ?>>Concluído</option>
                                        <option value="cancelado" <?php echo $row['status'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                    </select>
                                    <button type="submit">Atualizar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    
    <footer>
        &copy; 2024 ServiGO - Todos os direitos reservados.
    </footer>
</body>
</html>
