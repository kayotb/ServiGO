<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $servico = $_POST['servico'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $area_atuacao = $_POST['area_atuacao'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $mysqli = new mysqli('localhost', 'root', '', 'servigo');

    if ($mysqli->connect_error) {
        die("Falha na conexão: " . $mysqli->connect_error);
    }

    $query = "INSERT INTO usuarios (nome, email, telefone, servico, descricao, preco, area_atuacao, senha, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'profissional')";
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $mysqli->error);
    }

    $stmt->bind_param('ssssssss', $nome, $email, $telefone, $servico, $descricao, $preco, $area_atuacao, $senha);
    if ($stmt->execute()) {
        echo "<h2>Profissional cadastrado com sucesso!</h2>";
    } else {
        echo "<h2>Erro ao cadastrar profissional: " . $stmt->error . "</h2>";
    }

    $stmt->close();
    $mysqli->close();
}
?>
<a href="index.php">Voltar ao início</a>
