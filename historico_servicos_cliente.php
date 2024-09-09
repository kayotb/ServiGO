<?php
session_start();
include 'conexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Consultar histórico de serviços do cliente
$query = "SELECT id, categoria, status, data_solicitacao 
          FROM solicitacoes 
          WHERE user_id = ? 
          ORDER BY data_solicitacao DESC";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('i', $user_id);  // 'i' indica que o parâmetro é um inteiro
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        die("Erro ao executar a consulta: " . $stmt->error);
    }
} else {
    die("Erro ao preparar a consulta: " . $conn->error);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Serviços</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Histórico de Serviços</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Data da Solicitação</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['data_solicitacao']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum serviço encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    </div>
        <a href="index_logado.php">Voltar</a>
    </div>
    
</body>
</html>
