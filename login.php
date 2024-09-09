<?php
session_start();
include 'conexao.php';

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepare a consulta para verificar o email e a senha
    $query = "SELECT id, nome, senha, tipo_usuario_id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $nome, $hashed_password, $tipo_usuario_id);
        $stmt->fetch();

        // Verifique a senha
        if (password_verify($senha, $hashed_password)) {
            // Autentique o usuário e defina as variáveis de sessão
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_nome'] = $nome;
            $_SESSION['tipo_usuario_id'] = $tipo_usuario_id;

            // Redirecione com base no tipo de usuário
            if ($tipo_usuario_id == 2) { // Supondo que 2 é o ID do tipo 'administrador'
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index_logado.php");
            }
            exit();
        } else {
            $error = "Senha incorreta!";
        }
    } else {
        $error = "Email não encontrado!";
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
    <title>Login - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a>
    </header>
    
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="post">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <input type="submit" value="Entrar">
        </form>
    </div>
</body>
</html>
