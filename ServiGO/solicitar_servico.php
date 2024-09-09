<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id_servico = $_GET['id'];

    // Buscar os detalhes do serviço
    $sql = "SELECT * FROM servicos_oferecidos WHERE id = $id_servico";
    $result = $conn->query($sql);
    $servico = $result->fetch_assoc();
} else {
    die("Serviço não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Serviço</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Solicitar Serviço: <?php echo $servico['nome_servico']; ?></h1>

    <form action="processar_solicitacao.php" method="POST">
        <input type="hidden" name="id_servico" value="<?php echo $servico['id']; ?>">
        
        <label for="nome_cliente">Seu Nome:</label>
        <input type="text" id="nome_cliente" name="nome_cliente" required>

        <label for="descricao">Descreva o que precisa ser feito:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <button type="submit">Enviar Solicitação</button>
    </form>
</body>
</html>
