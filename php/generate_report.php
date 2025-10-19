<?php
// Arquivo: php/generate_report.php
// Script responsável por receber os parâmetros e forçar o download de um relatório.

// 1. Receber Parâmetros
$freezerId = $_GET['freezerId'] ?? 1; // Padrão 1 se não for fornecido
$periodo = $_GET['periodo'] ?? 'hoje'; // Padrão 'hoje'

// 2. Lógica de Geração do Arquivo (Simulação)
$fileName = "Relatorio_Freezer_{$freezerId}_{$periodo}_" . date('Ymd_His') . ".csv";
$content = "Período;Temperatura Máxima;Temperatura Mínima\n";

// Simulação de dados com base no período
switch ($periodo) {
    case '7dias':
        $content .= "Ultimos 7 dias;10°C;0°C\n";
        break;
    case '30dias':
        $content .= "Ultimos 30 dias;15°C;-5°C\n";
        break;
    case 'hoje':
    default:
        $content .= "Hoje;8°C;4°C\n";
        break;
}
$content .= "Dados do Freezer {$freezerId}: Relatório gerado com sucesso.\n";

// 3. Headers para Forçar o Download
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Pragma: no-cache');
header('Expires: 0');

// 4. Saída do Conteúdo
echo $content;
exit;

?>