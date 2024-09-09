<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'profissional') {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT nome, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Profissional - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index.php"> <img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a>
    </header>
    
    <div class="container">
        <h1>Perfil do Profissional</h1>
        
        <form action="atualizar_perfil_profissional.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Deixe em branco para manter a senha atual">
            
            <input type="submit" value="Atualizar Perfil">
        </form>
        
        <a href="profissional_dashboard.php" class="button">Voltar</a>
    </div>
    
    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
