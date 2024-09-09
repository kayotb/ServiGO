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

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar se todos os campos necessários foram preenchidos
    if (isset($_POST['titulo'], $_POST['descricao'], $_POST['preco'], $_POST['categoria_id'])) {
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $categoria_id = $_POST['categoria_id'];

        // Validar se os campos não estão vazios
        if (!empty($titulo) && !empty($descricao) && !empty($preco) && !empty($categoria_id)) {
            // Preparar a consulta para inserir o novo serviço
            $query = 'INSERT INTO servicos (titulo, descricao, preco, categoria_id, profissional_id) VALUES (?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $profissional_id = $_SESSION['user_id'];
                $stmt->bind_param('ssdii', $titulo, $descricao, $preco, $categoria_id, $profissional_id);

                if ($stmt->execute()) {
                    echo 'Serviço cadastrado com sucesso!';
                } else {
                    echo 'Erro ao cadastrar serviço: ' . $stmt->error;
                }

                $stmt->close();
            } else {
                echo 'Erro ao preparar a consulta: ' . $conn->error;
            }
        } else {
            echo 'Por favor, preencha todos os campos.';
        }
    } else {
        echo 'Campos necessários não foram enviados.';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Serviço - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index_logado.php"> 
            <img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;">
        </a>
    </header>

    <div class="container">
        <h1>Cadastrar Novo Serviço</h1>
        <form action="cadastrar_servico.php" method="post">
            <label for="titulo">Título do Serviço:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" required>

            <label for="categoria_id">Categoria:</label>
            <select id="categoria_id" name="categoria_id" required>
                <?php
                // Preencher o select com categorias
                $query_categoria = 'SELECT id, nome FROM categorias';
                $result_categoria = $conn->query($query_categoria);

                while ($categoria = $result_categoria->fetch_assoc()) {
                    echo '<option value="' . $categoria['id'] . '">' . htmlspecialchars($categoria['nome']) . '</option>';
                }
                ?>
            </select>

            <button type="submit">Cadastrar Serviço</button>
        </form>

        <a href="index_logado.php" class="button">Voltar</a>
    </div>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
