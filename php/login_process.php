<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = $_POST['senha'] ?? '';

$response = ['success' => false, 'message' => ''];
if ($email === 'admin@healthguard.com' && $senha === '123456') {
    
    $usuario_logado = [
        'nome' => 'Victor Koba', 
        'email' => $email 
    ];

    $_SESSION['logado'] = true;
    $_SESSION['user_name'] = $usuario_logado['nome'];
    $_SESSION['user_email'] = $usuario_logado['email'];

    $response['success'] = true;
    $response['message'] = 'Login realizado com sucesso! Redirecionando...';

} else {
    $response['message'] = 'Email ou senha inválidos.';
}

echo json_encode($response);
exit;
?>