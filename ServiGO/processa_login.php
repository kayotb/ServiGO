<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    include 'conexao.php';

    $query = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_tipo'] = $user['tipo'];
            $_SESSION['user_nome'] = $user['nome'];

            if ($user['tipo'] == 'cliente') {
                header('Location: cliente_dashboard.php');
            } else {
                header('Location: profissional_dashboard.php');
            }
            exit();
        } else {
            echo "<h2>Senha incorreta!</h2>";
        }
    } else {
        echo "<h2>Usuário não encontrado!</h2>";
    }

    $stmt->close();
    $conn->close();
}
?>
