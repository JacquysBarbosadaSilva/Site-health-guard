<?php
$title = "HealthGuard - Meu Perfil";
$userName = "Admin User";
$userEmail = "admin@healthguard.com";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/a2e0e9a66b.js" crossorigin="anonymous"></script>
</head>

<body class="dashboard-page">

    <?php
    include '../include/sidebar.php';
    ?>

    <div class="main-content-wrapper">
        <header class="topbar">
            <h1 class="page-title">Meu Perfil</h1>
        </header>

        <main class="content perfil-layout-flex">

            <div class="perfil-card-final">

                <div class="user-info-final">
                    <div class="progress-bar-final"></div>
                    <h2 class="user-name-final"><?= $userName ?></h2>
                </div>
                <div class="perfil-form-container-final">
                    <form class="perfil-form-final" action="#" method="POST">

                        <div class="form-group-final">
                            <label for="email-final">Email</label>
                            <input type="email" id="email-final" name="email" value="<?= $userEmail ?>" readonly
                                placeholder="victorkoba08@gmail.com">
                        </div>

                        <div class="form-group-final">
                            <label for="new-password-final">Alterar Senha</label>
                            <input type="password" id="new-password-final" name="new_password"
                                placeholder="Digite a nova senha">
                        </div>

                        <div class="form-group-final">
                            <label for="confirm-password-final">Confirmar Senha</label>
                            <input type="password" id="confirm-password-final" name="confirm_password"
                                placeholder="Confirme a nova senha">
                        </div>

                        <div class="form-actions-final">
                            <button type="submit" class="btn-confirm-final">Confirmar</button>
                            <button type="button" class="btn-sair-final">Sair</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <script src="../js/dashboard.js"></script>
</body>

</html>