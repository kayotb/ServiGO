<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiGO - Tecnologia</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
        <li><a href="index_logado.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a></li>
        </div>
    </header>

    <main>
        <section class="services-section">
            <h1>Tecnologia</h1>
            <div class="services">
                <?php
                $services = [
                    "Desenvolvimento Web",
                    "Suporte Técnico",
                    "Consultoria em TI",
                    "Configuração de Rede",
                    "Desenvolvimento de Apps",
                    "Segurança da Informação",
                    "Recuperação de Dados",
                    "Manutenção de Computadores",
                    "Automação de Processos",
                    "Consultoria em Cloud"
                ];

                foreach ($services as $service) {
                    echo '<div class="service">
                            <form action="solicitacao_de_servico.php" method="GET">
                                <input type="hidden" name="servico_id" value="' . htmlspecialchars($service) . '">
                                <button type="submit">Solicitar ' . htmlspecialchars($service) . '</button>
                            </form>
                          </div>';
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
