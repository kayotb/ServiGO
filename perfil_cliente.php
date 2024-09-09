<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $query = "UPDATE usuarios SET nome=?, email=?, senha=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nome, $email, $senha, $user_id);

    if ($stmt->execute()) {
        $_SESSION['user_nome'] = $nome;
        echo "Informações atualizadas com sucesso!";
    } else {
        echo "Erro ao atualizar informações: " . $conn->error;
    }
}

$query = "SELECT nome, email FROM usuarios WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nome_atual, $email_atual);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Cliente - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index.php"> 
        <li><a href="index_logado.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a></li>
        </a>
    </header>
    
    <div class="container">
        <h1>Atualizar Informações do Perfil</h1>
        <form action="perfil_cliente.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_atual); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_atual); ?>" required>
            
            <label for="senha">Nova Senha:</label>
            <input type="password" id="senha" name="senha" required>
            
            <input type="submit" value="Atualizar">
        </form>
        <a href="cliente_dashboard.php" class="button">Voltar</a>
    </div>
</body>
</html>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>

<?php
$conn->close();
?>
