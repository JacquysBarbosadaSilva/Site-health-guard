<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthGuard - Login</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="login-page">
    <div class="container">
        <div class="login-card">
            <div class="logo">
                <h1>HealthGuard</h1>
            </div>

            <h2>Entre na sua conta</h2>

            <form id="loginForm">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="seuemail@exemplo.com">

                <label for="senha">Senha</label>
                <input type="password" id="senha" placeholder="************">

                <button class="button-login" type="submit">Login</button>

                <a href="php/redefinir.php" class="esqueceu">Esqueceu a senha?</a>
            </form>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>

</html>