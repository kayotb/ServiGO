<?php
session_start();
include 'conexao.php'; // Certifique-se de que o caminho está correto

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha
    $tipo_usuario_id = 2; // ID do tipo "profissional"

    // Inserir o novo profissional no banco de dados
    $query = "INSERT INTO usuarios (nome, email, telefone, senha, tipo_usuario_id, data_registro) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $senha, $tipo_usuario_id);

    if ($stmt->execute()) {
        // Captura o ID do usuário recém-cadastrado
        $novo_usuario_id = $conn->insert_id;

        // Iniciar a sessão e salvar as informações do usuário
        $_SESSION['user_id'] = $novo_usuario_id;
        $_SESSION['user_nome'] = $nome;
        $_SESSION['user_tipo'] = 'profissional'; // Atribui o tipo de usuário "profissional"

        // Redireciona para o dashboard do profissional após o sucesso
        header("Location: profissional_dashboard.php");
        exit(); // Garante que o script pare após o redirecionamento
    } else {
        echo "Erro ao cadastrar profissional: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Profissional - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index_logado_profissional.php"> <img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a>
    </header>
    
    <div class="container">
        <h2>Cadastrar Profissional</h2>
        <form action="profissional.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
    
    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
