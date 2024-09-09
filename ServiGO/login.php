<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']);
    $tipo_usuario = $_POST['tipo_usuario']; // Tipo de usuário: 'cliente' ou 'profissional'

    if ($email && $senha && in_array($tipo_usuario, ['cliente', 'profissional'])) {
        include 'conexao.php';

        // Determina a tabela de usuários e o campo de tipo
        $tabela_usuario = $tipo_usuario === 'cliente' ? 'clientes' : 'profissionais';

        // Consulta para verificar o usuário na tabela apropriada
        $query = "SELECT * FROM usuarios WHERE email = ? AND tipo_usuario_id = (SELECT id FROM tipos_usuario WHERE tipo = ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . $conn->error);
        }

        $stmt->bind_param('ss', $email, $tipo_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_tipo'] = $tipo_usuario;
                $_SESSION['user_nome'] = $user['nome'];

                $redirect_page = $tipo_usuario === 'profissional' ? 'profissional_dashboard.php' : 'cliente_dashboard.php';
                header('Location: ' . $redirect_page);
                exit();
            } else {
                $error = "Senha incorreta!";
            }
        } else {
            $error = "Usuário não encontrado!";
        }

        $stmt->close();
        $conn->close();
    } else {
        $error = "Por favor, insira um email, senha e selecione o tipo de usuário válidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="tipo_usuario">Tipo de Usuário:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="">Selecione...</option>
                <option value="cliente">Cliente</option>
                <option value="profissional">Profissional</option>
            </select>

            <button type="submit">Entrar</button>

            <div class="form-footer">
                <a href="esqueci_senha.php">Esqueceu sua senha?</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
