<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'profissional') {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>ID do serviço inválido!</h2>";
    exit();
}

$servico_id = $_GET['id'];

$query = "SELECT * FROM servicos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $servico_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h2>Serviço não encontrado!</h2>";
    exit();
}

$servico = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';

    $update_query = "UPDATE servicos SET nome = ?, descricao = ?, preco = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param('ssdi', $nome, $descricao, $preco, $servico_id);

    if ($stmt_update->execute()) {
        echo "<h2>Serviço atualizado com sucesso!</h2>";
    } else {
        echo "<h2>Erro ao atualizar o serviço!</h2>";
    }

    $stmt_update->close();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Editar Serviço</h1>
    <form action="editar_servico.php?id=<?php echo htmlspecialchars($servico_id); ?>" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($servico['nome'] ?? ''); ?>" required>
        <br>
        
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($servico['descricao'] ?? ''); ?></textarea>
        <br>
        
        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" value="<?php echo htmlspecialchars($servico['preco'] ?? '0.00'); ?>" required>
        <br>
        
        <input type="submit" value="Atualizar Serviço">
    </form>
    <a href="profissional_dashboard.php">Voltar</a>
</body>
</html>
