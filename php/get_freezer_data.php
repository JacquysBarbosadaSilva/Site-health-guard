<?php
// Arquivo: php/get_freezer_data.php
// Responsável por receber o ID do Freezer via POST (AJAX) e retornar os dados correspondentes em JSON.

// Define o cabeçalho para indicar que a resposta é um JSON
header('Content-Type: application/json');

// Garante que a requisição é do tipo POST (segurança básica)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
    exit;
}

// Obtém o corpo da requisição JSON (enviado pelo JavaScript via fetch/POST)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$freezerId = $data['freezerId'] ?? null;

if (!$freezerId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do Freezer não fornecido.']);
    exit;
}

// =====================================================
// SIMULAÇÃO DE DADOS (Substitua esta seção pela sua lógica de Banco de Dados)
// =====================================================

$freezerData = [
    '1' => [
        'freezer_id' => 1,
        'current_temp' => 8,
        'status' => 'Normal',
        'last_24h' => ['max' => 10, 'min' => 5],
        'chart_data' => [ // Dados para a página Dashboard (24h)
            'labels' => ['00h', '03h', '06h', '09h', '12h', '15h', '18h', '21h'],
            'temps' => [5, 6, 7, 8, 9, 7, 6, 5]
        ],
        'report_data' => [ // Dados para a página Relatórios (Semanal)
            'labels' => ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
            'temps_min' => [-5, -4, -6, -5, -7, -3, -4],
            'temps_max' => [1, 2, 0, 1, -1, 3, 2]
        ]
    ],
    '2' => [
        'freezer_id' => 2,
        'current_temp' => 14, // Temperatura de Alerta
        'status' => 'Alerta',
        'last_24h' => ['max' => 15, 'min' => 8],
        'chart_data' => [
            'labels' => ['00h', '03h', '06h', '09h', '12h', '15h', '18h', '21h'],
            'temps' => [8, 10, 12, 14, 15, 13, 11, 9]
        ],
        'report_data' => [
            'labels' => ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
            'temps_min' => [0, 2, 4, 3, 1, 5, 4],
            'temps_max' => [8, 10, 12, 11, 9, 13, 12]
        ]
    ],
    '3' => [
        'freezer_id' => 3,
        'current_temp' => 2,
        'status' => 'Normal',
        'last_24h' => ['max' => 4, 'min' => -1],
        'chart_data' => [
            'labels' => ['00h', '03h', '06h', '09h', '12h', '15h', '18h', '21h'],
            'temps' => [-1, 0, 1, 2, 3, 2, 1, 0]
        ],
        'report_data' => [
            'labels' => ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
            'temps_min' => [-10, -9, -12, -10, -11, -8, -9],
            'temps_max' => [-5, -4, -7, -5, -6, -3, -4]
        ]
    ],
    '4' => [
        'freezer_id' => 4,
        'current_temp' => 6,
        'status' => 'Normal',
        'last_24h' => ['max' => 8, 'min' => 4],
        'chart_data' => [
            'labels' => ['00h', '03h', '06h', '09h', '12h', '15h', '18h', '21h'],
            'temps' => [4, 5, 6, 7, 8, 7, 6, 5]
        ],
        'report_data' => [
            'labels' => ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
            'temps_min' => [-1, -2, -3, -1, -4, 0, -1],
            'temps_max' => [3, 4, 2, 5, 1, 6, 4]
        ]
    ],
];

// =====================================================
// FIM DA SIMULAÇÃO
// =====================================================

// Verifica se o ID do freezer existe no array de dados
if (isset($freezerData[$freezerId])) {
    // Retorna os dados como JSON
    echo json_encode($freezerData[$freezerId]);
} else {
    // Retorna um erro 404 se o ID não for encontrado
    http_response_code(404);
    echo json_encode(['error' => 'Dados do Freezer não encontrados.']);
}
?>