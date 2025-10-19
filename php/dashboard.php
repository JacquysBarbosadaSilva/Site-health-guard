<?php
$title = "HealthGuard - Dashboard"; // Define um título para a página
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
</head>

<body class="dashboard-page">

    <?php
    include '../include/sidebar.php';
    ?>

    <div class="main-content-wrapper">
        <header class="topbar">
            <button class="hamburger" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">Gerenciamento de Temperatura</h1>

            <button class="btn-action">Mudar Freezer</button>
        </header>

        <main class="content dashboard-layout">

            <section class="info-column">

                <div class="main-card current-temp">
                    <p class="freezer-status">Você está visualizando a temperatura do Freezer 1</p>
                    <span class="temp-display">
                        8<span class="unit">°C</span>
                    </span>
                    <p class="status-indicator safe">Status: Normal</p>
                    <div class="last-update">Atualizado: 11:45:21</div>
                </div>

                <div class="card-grid">
                    <div class="data-card">
                        <i class="fas fa-clock icon-info"></i>
                        <h4>Últimas 24h</h4>
                        <p>Máxima: 10°C</p>
                        <p>Mínima: 5°C</p>
                    </div>
                    <div class="data-card">
                        <i class="fas fa-calendar-alt icon-info"></i>
                        <h4>Últimos 7 dias</h4>
                        <p>Máxima: 12°C</p>
                        <p>Mínima: 3°C</p>
                    </div>
                    <div class="data-card full-width">
                        <i class="fas fa-exclamation-triangle icon-warning"></i>
                        <h4>Alertas Recentes</h4>
                        <p>Nenhuma anomalia registrada.</p>
                    </div>
                </div>
            </section>

            <section class="chart-column">

                <div class="chart-container card-chart">
                    <h3>Temperatura registrada nas últimas 24 horas</h3>
                    <canvas id="tempChart24h"></canvas>
                </div>

                <div class="data-table card-chart">
                    <h3>Todas as temperaturas registradas</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Horário</th>
                                <th>Temperatura</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>11:45</td>
                                <td>8°C</td>
                                <td><span class="tag tag-normal">Normal</span></td>
                            </tr>
                            <tr>
                                <td>11:30</td>
                                <td>8°C</td>
                                <td><span class="tag tag-normal">Normal</span></td>
                            </tr>
                            <tr>
                                <td>02:00</td>
                                <td>15°C</td>
                                <td><span class="tag tag-alert">Alerta</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </section>
        </main>
    </div>

    <div class="freezer-modal-overlay" id="freezerModalOverlay">
        <div class="freezer-modal">
            <h3 class="modal-title">Você deseja mudar para qual Freezer?</h3>
            
            <div class="freezer-options">
                <button class="freezer-item" data-freezer-id="1">
                    <i class="fas fa-snowflake freezer-icon"></i>
                    <span>Freezer 1</span>
                </button>
                
                <button class="freezer-item" data-freezer-id="2">
                    <i class="fas fa-snowflake freezer-icon"></i>
                    <span>Freezer 2</span>
                </button>

                <button class="freezer-item" data-freezer-id="3">
                    <i class="fas fa-snowflake freezer-icon"></i>
                    <span>Freezer 3</span>
                </button>
            </div>
            
            <div class="modal-actions">
                <button class="btn-confirm" id="confirmFreezer">Confirmar</button>
                <button class="btn-cancel" id="cancelFreezer">Cancelar</button>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <script src="../js/dashboard.js" defer></script>
    <script>
        // Código para inicializar o Chart.js
        const ctx = document.getElementById('tempChart24h').getContext('2d');
        window.tempChart24h = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['00h', '03h', '06h', '09h', '12h', '15h', '18h', '21h'],
                datasets: [{
                    label: 'Temperatura (°C)',
                    data: [5, 6, 7, 8, 9, 7, 6, 5],
                    borderColor: '#1ABC9C',
                    backgroundColor: 'rgba(26, 188, 156, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: { display: true, text: 'Temperatura (°C)' }
                    }
                }
            }
        });
    </script>
</body>

</html>