<?php
$title = "HealthGuard - Relatórios";
$freezerAtual = 1;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/a2e0e9a66b.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
</head>

<body class="dashboard-page">

    <?php
    include '../include/sidebar.php';
    ?>

    <div class="main-content-wrapper">
        <header class="topbar">
            <h1 class="page-title">Relatórios</h1>

            <button class="btn-action">Mudar Freezer</button>
        </header>

        <main class="content relatorios-layout">

            <section class="relatorio-status-card card-chart">
                <p class="freezer-status-relatorio">
                    Você está no Freezer <?= $freezerAtual ?>, deseja alterar para abaixar o relatório?
                </p>
            </section>

            <section class="chart-section card-chart">
                <h3>Registro de temperatura durante a semana</h3>
                <div class="chart-container-relatorios">
                    <canvas id="weeklyTempChart"></canvas>
                </div>
            </section>

            <section class="download-section card-chart">
                <h3>Selecione o período para recuperar os dados de temperatura</h3>
                <div class="download-buttons-grid">
                    <button class="btn-download" data-period="hoje">
                        <i class="fas fa-download"></i> Abaixar dados de hoje
                    </button>
                    <button class="btn-download" data-period="7dias">
                        <i class="fas fa-download"></i> Abaixar dados dos últimos 7 dias
                    </button>
                    <button class="btn-download" data-period="30dias">
                        <i class="fas fa-download"></i> Abaixar dados dos últimos 30 dias
                    </button>
                </div>
            </section>

        </main>
    </div>

    <div class="freezer-modal-overlay" id="freezerModalOverlay">
        <div class="freezer-modal">
            <h3 class="modal-title">Você deseja mudar para qual Freezer?</h3>
            <div class="freezer-options">
                <button class="freezer-item" data-freezer-id="1">
                    <i class="fas fa-snowflake freezer-icon"></i><span>Freezer 1</span>
                </button>
                <button class="freezer-item" data-freezer-id="2">
                    <i class="fas fa-snowflake freezer-icon"></i><span>Freezer 2</span>
                </button>
                <button class="freezer-item" data-freezer-id="3">
                    <i class="fas fa-snowflake freezer-icon"></i><span>Freezer 3</span>
                </button>
                <button class="freezer-item" data-freezer-id="4">
                    <i class="fas fa-snowflake freezer-icon"></i><span>Freezer 4</span>
                </button>
            </div>
            <div class="modal-actions">
                <button class="btn-confirm" id="confirmFreezer">Confirmar</button>
                <button class="btn-cancel" id="cancelFreezer">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>


    <script src="../js/dashboard.js"></script>
    <script>
        const ctxWeekly = document.getElementById('weeklyTempChart').getContext('2d');
        window.weeklyTempChart = new Chart(ctxWeekly, {
            type: 'bar',
            data: {
                labels: ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                datasets: [{
                    label: 'Temperatura Mínima (°C)',
                    data: [-5, -4, -6, -5, -7, -3, -4],
                    backgroundColor: '#87CEEB',
                    borderColor: '#4682B4',
                    borderWidth: 1
                },
                {
                    label: 'Temperatura Máxima (°C)',
                    data: [1, 2, 0, 1, -1, 3, 2],
                    backgroundColor: '#FF6347',
                    borderColor: '#CD5C5C',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
        document.querySelectorAll('.btn-download').forEach(button => {
            button.addEventListener('click', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: "success",
                        title: "Sucesso!",
                        text: "O relatório foi abaixado.",
                        confirmButtonColor: "#1ABC9C",
                        timer: 1500
                    });
                }
            });
        });

        document.querySelectorAll('.btn-download').forEach(button => {
            button.addEventListener('click', () => {

                const periodo = button.getAttribute('data-period');
                let freezerId = 1;
                const statusText = document.querySelector(".freezer-status-relatorio");
                if (statusText) {
                    const match = statusText.textContent.match(/Freezer (\d+)/);
                    if (match && match[1]) {
                        freezerId = match[1];
                    }
                }

                const downloadUrl = `generate_report.php?freezerId=${freezerId}&periodo=${periodo}`;

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: "success",
                        title: "Sucesso!",
                        text: "O relatório foi abaixado. O download iniciará em breve.",
                        confirmButtonColor: "#1ABC9C",
                        timer: 1500
                    });
                } else {
                    console.log(`Iniciando download do Freezer ${freezerId} para o período: ${periodo}`);
                }
                window.location.href = downloadUrl;
            });
        });
    </script>
</body>

</html>