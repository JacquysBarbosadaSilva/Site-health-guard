<?php
$title = "HealthGuard - Gerenciar Usuários";


$users = [
    ['id' => 1, 'nome' => 'João Silva', 'email' => 'joao.s@email.com', 'senha' => '********', 'permissoes' => 'Admin'],
    ['id' => 2, 'nome' => 'Maria Oliveira', 'email' => 'maria.o@email.com', 'senha' => '********', 'permissoes' => 'Comum'],
    ['id' => 3, 'nome' => 'Pedro Santos', 'email' => 'pedro.s@email.com', 'senha' => '********', 'permissoes' => 'Comum'],
    ['id' => 4, 'nome' => 'Ana Costa', 'email' => 'ana.c@email.com', 'senha' => '********', 'permissoes' => 'Comum'],
];
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
            <h1 class="page-title">Gerenciar Usuários</h1>
        </header>

        <main class="content user-management-layout">

            <div class="user-table-container">
                <h2>Tabela de Usuários</h2>

                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Senha</th>
                            <th>Permissões</th>
                            <th>Operações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr data-user-id="<?= $user['id'] ?>" data-user-name="<?= htmlspecialchars($user['nome']) ?>"
                                data-user-email="<?= htmlspecialchars($user['email']) ?>"
                                data-user-perms="<?= htmlspecialchars($user['permissoes']) ?>">
                                <td><?= htmlspecialchars($user['nome']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['senha']) ?></td>
                                <td><?= htmlspecialchars($user['permissoes']) ?></td>
                                <td class="table-actions">
                                    <button class="btn-edit-user" data-user-id="<?= $user['id'] ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn-delete-user">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="info-user-card hidden" id="userInfoCard">
                <div class="card-header">
                    <h3>INFO USER</h3>
                </div>

                <div class="card-body">
                    <div class="avatar-user-placeholder">
                        <i class="fas fa-user-circle"></i>
                    </div>

                    <form id="editUserForm">
                        <div class="form-group-card">
                            <label for="editName">Nome</label>
                            <input type="text" id="editName" name="nome" value="" readonly>
                        </div>

                        <div class="form-group-card">
                            <label for="editEmail">Email</label>
                            <input type="email" id="editEmail" name="email" value="" readonly>
                        </div>

                        <div class="form-group-card">
                            <label for="editSenha">Senha</label>
                            <input type="password" id="editSenha" name="senha" placeholder="Alterar Senha" readonly>
                        </div>

                        <div class="form-actions-card">
                            <button type="button" class="btn-primary" id="btnEditSave">Editar</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <script src="../js/dashboard.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const tableContainer = document.querySelector('.user-table-container');
            const userInfoCard = document.getElementById('userInfoCard');
            const btnEditSave = document.getElementById('btnEditSave');
            const editForm = document.getElementById('editUserForm');

            let isEditing = false;
            let currentUserId = null;

            function displayUserInfo(userData) {

                document.getElementById('editName').value = userData.nome;
                document.getElementById('editEmail').value = userData.email;
                document.getElementById('editSenha').value = '';

                userInfoCard.classList.remove('hidden');

                isEditing = false;
                btnEditSave.textContent = 'Editar';
                btnEditSave.classList.remove('btn-success');
                btnEditSave.classList.add('btn-primary');

                document.querySelectorAll('#editUserForm input').forEach(input => {
                    input.setAttribute('readonly', true);
                });
            }

            tableContainer.addEventListener('click', (e) => {
                let targetRow = e.target.closest('tr');
                let targetButton = e.target.closest('.btn-edit-user');

                if (targetButton) {
                    targetRow = targetButton.closest('tr');
                } else if (!targetRow || e.target.closest('.btn-delete-user')) {
                    return;
                }

                const userId = targetRow.getAttribute('data-user-id');

                const userData = {
                    id: userId,
                    nome: targetRow.getAttribute('data-user-name'),
                    email: targetRow.getAttribute('data-user-email'),
                    senha: targetRow.getAttribute('data-user-perms') === 'Admin' ? 'admin_secret' : 'user_secret',
                    permissoes: targetRow.getAttribute('data-user-perms')
                };

                currentUserId = userId;
                displayUserInfo(userData);
            });

            btnEditSave.addEventListener('click', () => {
                if (!isEditing) {
                    isEditing = true;
                    btnEditSave.textContent = 'Salvar';
                    btnEditSave.classList.remove('btn-primary');
                    btnEditSave.classList.add('btn-success');

                    document.getElementById('editName').removeAttribute('readonly');
                    document.getElementById('editEmail').removeAttribute('readonly');
                    document.getElementById('editSenha').removeAttribute('readonly');
                    document.getElementById('editSenha').placeholder = 'Nova Senha (deixe vazio para não alterar)';

                } else {

                    const newName = document.getElementById('editName').value;
                    const newEmail = document.getElementById('editEmail').value;

                    const rowToUpdate = document.querySelector(`tr[data-user-id="${currentUserId}"]`);
                    if (rowToUpdate) {
                        rowToUpdate.querySelector('td:nth-child(1)').textContent = newName; // Nome
                        rowToUpdate.querySelector('td:nth-child(2)').textContent = newEmail; // Email

                        rowToUpdate.setAttribute('data-user-name', newName);
                        rowToUpdate.setAttribute('data-user-email', newEmail);
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Simulação',
                            text: `Usuário ${newName} (ID: ${currentUserId}) atualizado com sucesso!`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    isEditing = false;
                    btnEditSave.textContent = 'Editar';
                    btnEditSave.classList.remove('btn-success');
                    btnEditSave.classList.add('btn-primary');

                    document.querySelectorAll('#editUserForm input').forEach(input => {
                        input.setAttribute('readonly', true);
                    });
                    document.getElementById('editSenha').placeholder = 'Alterar Senha';

                }
            });

            document.querySelectorAll('.btn-delete-user').forEach(button => {
                button.addEventListener('click', (e) => {
                    const row = e.target.closest('tr');
                    const name = row.getAttribute('data-user-name');

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Simulação de Exclusão',
                            text: `Deseja realmente excluir o usuário ${name}?`,
                            showCancelButton: true,
                            confirmButtonColor: '#e74c3c',
                            cancelButtonColor: '#3b7e6e',
                            confirmButtonText: 'Sim, Excluir',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                row.remove();
                                userInfoCard.classList.add('hidden');
                            }
                        });
                    }
                });
            });

        });
    </script>
</body>

</html>