<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    include 'conexao.php';

    // Defina o ID correspondente ao tipo de usuário 'cliente'
    $tipo_usuario_id = 1; // Assumindo que o ID do tipo 'cliente' é 1 na tabela tipos_usuario

    $query = "INSERT INTO usuarios (nome, email, telefone, endereco, senha, tipo_usuario_id, data_registro) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssi', $nome, $email, $telefone, $endereco, $senha, $tipo_usuario_id);

    if ($stmt->execute()) {
        // Inicie a sessão e defina as variáveis de sessão necessárias
        session_start();
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_nome'] = $nome;

        // Redirecione para a página de dashboard
        header("Location: cliente_dashboard.php");
        exit();
    } else {
        echo "<h2>Erro ao cadastrar: " . $stmt->error . "</h2>";
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
    <title>Cadastro de Cliente - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index.php"> <img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a>
    </header>
    
    <div class="container">
        <h2>Cadastrar Cliente</h2>
        <form action="cliente.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>
