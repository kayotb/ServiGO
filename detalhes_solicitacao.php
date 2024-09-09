<?php
session_start();
include 'conexao.php'; // Conexão com o banco de dados

// Verifique se o ID da solicitação foi passado como parâmetro
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Use intval para garantir que o ID seja um número inteiro

    // Preparar a consulta para obter os detalhes da solicitação
    $query = "SELECT * FROM solicitacoes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifique se a solicitação foi encontrada
    if ($result->num_rows === 1) {
        $solicitacao = $result->fetch_assoc();
    } else {
        echo "<p>Solicitação não encontrada.</p>";
        exit();
    }
    
    $stmt->close();
} else {
    echo "<p>ID da solicitação não especificado ou inválido.</p>";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Solicitação</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detalhes-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .detalhes-container h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #333;
        }
        .detalhes-container p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group .form-control {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="detalhes-container">
        <h2>Detalhes da Solicitação</h2>
        
        <!-- Exibe as informações da solicitação -->
        <p><strong>Nome do Cliente:</strong> <?php echo htmlspecialchars($solicitacao['nome_cliente'] ?? 'Não disponível'); ?></p>
        <p><strong>Categoria:</strong> <?php echo htmlspecialchars($solicitacao['categoria'] ?? 'Não disponível'); ?></p>
        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($solicitacao['descricao'] ?? 'Não disponível'); ?></p>
        <p><strong>Endereço:</strong> <?php echo htmlspecialchars($solicitacao['endereco'] ?? 'Não disponível'); ?></p>
        <p><strong>Data:</strong> <?php echo htmlspecialchars($solicitacao['data'] ?? 'Não disponível'); ?></p>
        <p><strong>Forma de Pagamento:</strong> <?php echo htmlspecialchars($solicitacao['forma_pagamento'] ?? 'Não disponível'); ?></p>
        
        <!-- Formulário para atualizar o status -->
        <form action="atualizar_status.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($solicitacao['id']); ?>">
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="Pendente" <?php echo ($solicitacao['status'] === 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Em Andamento" <?php echo ($solicitacao['status'] === 'Em Andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                    <option value="Concluído" <?php echo ($solicitacao['status'] === 'Concluído') ? 'selected' : ''; ?>>Concluído</option>
                    <option value="Cancelado" <?php echo ($solicitacao['status'] === 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Atualizar Status</button>
            </div>
        </form>
    </div>
</body>
</html>
