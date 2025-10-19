<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthGuard - Redefinir senha</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="rd-page">
    <div class="rd-container">
        <div class="rd-card">
            <h1 class="rd-logo">HealthGuard</h1>

            <!-- Etapa 1 -->
            <div class="step active" id="step1">
                <h2>Redefinir senha</h2>
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="seuemail@exemplo.com">
                <p class="info">Insira seu e-mail para receber um código para redefinir sua senha.</p>
                <button onclick="nextStep(2)">Enviar código</button>
            </div>

            <!-- Etapa 2 -->
            <div class="step" id="step2">
                <h2>Inserir código</h2>
                <label for="codigo">Código</label>
                <input type="text" id="codigo" placeholder="************">
                <p class="info">Insira o código recebido no seu e-mail.</p>
                <button onclick="nextStep(3)">Confirmar</button>
                <span class="voltar" onclick="nextStep(1)">← Voltar</span>
            </div>

            <!-- Etapa 3 -->
            <div class="step" id="step3">
                <h2>Criar nova senha</h2>
                <label for="senha1">Senha nova</label>
                <input type="password" id="senha1" placeholder="************">
                <label for="senha2">Confirmar senha nova</label>
                <input type="password" id="senha2" placeholder="************">
                <button onclick="finalizar()">Confirmar</button>
                <span class="voltar" onclick="nextStep(2)">← Voltar</span>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>
