<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $mysqli = new mysqli('localhost', 'root', '', 'servigo');

    if ($mysqli->connect_error) {
        die("Falha na conexão: " . $mysqli->connect_error);
    }

    $query = "INSERT INTO usuarios (nome, email, telefone, endereco, senha, tipo) VALUES (?, ?, ?, ?, ?, 'cliente')";
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $mysqli->error);
    }

    $stmt->bind_param('sssss', $nome, $email, $telefone, $endereco, $senha);
    if ($stmt->execute()) {
        echo "<h2>Cliente cadastrado com sucesso!</h2>";
    } else {
        echo "<h2>Erro ao cadastrar cliente: " . $stmt->error . "</h2>";
    }

    $stmt->close();
    $mysqli->close();
}
?>
<a href="index.php">Voltar ao início</a>
