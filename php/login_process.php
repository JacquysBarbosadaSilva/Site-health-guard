<?php
// Arquivo: php/login_process.php

// 1. INICIA A SESSÃO
session_start();

// Define que a resposta será JSON
header('Content-Type: application/json');

// Garante que é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
    exit;
}

// 2. Recebe os dados do AJAX
// Usa filter_input para sanitizar a entrada
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = $_POST['senha'] ?? ''; // Senha não sanitizada, será hashada/verificada

$response = ['success' => false, 'message' => ''];

// 3. LÓGICA DE VERIFICAÇÃO DE LOGIN E BANCO DE DADOS
// =========================================================================
// !!! SUBSTITUA ESTA SIMULAÇÃO PELA SUA LÓGICA REAL DE VERIFICAÇÃO DE BD !!!
// =========================================================================

// Simulação de credenciais válidas e busca de dados do usuário
if ($email === 'victorkoba08@gmail.com' && $senha === '123456') {
    
    // Supondo que você BUSCOU O NOME E EMAIL DO USUÁRIO NO BANCO DE DADOS
    $usuario_logado = [
        'nome' => 'Victor Koba', 
        'email' => $email 
    ];

    // Cria a Sessão
    $_SESSION['logado'] = true;
    $_SESSION['user_name'] = $usuario_logado['nome'];
    $_SESSION['user_email'] = $usuario_logado['email'];

    $response['success'] = true;
    $response['message'] = 'Login realizado com sucesso! Redirecionando...';

} else {
    // Caso a senha ou email estejam incorretos
    $response['message'] = 'Email ou senha inválidos.';
}

// 4. RETORNA A RESPOSTA JSON para o JavaScript
echo json_encode($response);
exit;
?>