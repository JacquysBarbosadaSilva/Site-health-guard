<?php
// Arquivo: php/duvidas.php
// Página de Dúvidas Frequentes com estrutura de Acordeão.

$title = "HealthGuard - Dúvidas Frequentes";
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
    // Inclui a sidebar
    include '../include/sidebar.php';
    ?>

    <div class="main-content-wrapper">
        <header class="topbar">
            <button class="hamburger" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">Dúvidas Frequentes</h1>
        </header>

        <main class="content duvidas-layout">

            <div class="duvidas-card">

                <div class="duvidas-actions">
                    <button class="btn-adicionar-faq" id="btnAddFaq">
                        <i class="fas fa-plus"></i> Adicionar Card
                    </button>
                </div>

                <h2 class="duvidas-title">Dúvidas Frequentes</h2>

                <div class="accordion-container" id="faqContainer">

                    <div class="accordion-item">
                        <button class="accordion-header">
                            O que cada funcionalidade do aplicativo faz?
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Relatórios: permite gerar e baixar relatórios diários, semanais ou mensais das
                                temperaturas dos freezers. Gerenciamento de temperatura: exibe a temperatura atual e o
                                histórico recente; para detalhes mais completos, recomenda-se baixar os relatórios.
                                Gerenciamento de usuários: para os administradores, terá essa opção de gerenciar os
                                outros usuários comuns.</p>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>

    <div class="modal-overlay hidden" id="addFaqModalOverlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Adicionar Nova FAQ</h3>
                <button class="modal-close-btn" id="modalCloseBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="addFaqForm">
                <div class="modal-body">

                    <div class="form-group-modal">
                        <label for="faqTitulo">Título (Pergunta)</label>
                        <input type="text" id="faqTitulo" name="titulo" placeholder="Ex: Qual é a temperatura ideal?"
                            required>
                    </div>

                    <div class="form-group-modal">
                        <label for="faqDescricao">Descrição (Resposta)</label>
                        <textarea id="faqDescricao" name="descricao" rows="5"
                            placeholder="Insira a resposta detalhada aqui..." required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-confirm-modal">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <script src="../js/dashboard.js"></script>
    <script>
        // Lógica do Acordeão (Accordion)
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const content = item.querySelector('.accordion-content');

                // Fecha todos os outros itens
                document.querySelectorAll('.accordion-item.active').forEach(activeItem => {
                    if (activeItem !== item) {
                        activeItem.classList.remove('active');
                        activeItem.querySelector('.accordion-content').style.maxHeight = null;
                    }
                });

                // Alterna o estado do item clicado
                item.classList.toggle('active');

                if (item.classList.contains('active')) {
                    // Abre o conteúdo
                    content.style.maxHeight = content.scrollHeight + "px";
                } else {
                    // Fecha o conteúdo
                    content.style.maxHeight = null;
                }
            });
        });

        // Arquivo: php/duvidas.php (Dentro da tag <script> no final)

        // ... (Lógica do Acordeão) ...

        // ==========================================================
        // LÓGICA DO MODAL DE ADICIONAR FAQ
        // ==========================================================
        const btnAddFaq = document.getElementById('btnAddFaq');
        const modalOverlay = document.getElementById('addFaqModalOverlay');
        const modalCloseBtn = document.getElementById('modalCloseBtn');
        const addFaqForm = document.getElementById('addFaqForm');
        const faqContainer = document.getElementById('faqContainer');

        function openModal() {
            modalOverlay.classList.remove('hidden');
            // Força o display: flex para centralizar
            modalOverlay.style.display = 'flex';
        }

        function closeModal() {
            modalOverlay.classList.add('hidden');
            // Limpa o formulário ao fechar
            addFaqForm.reset();
        }

        // Evento para abrir o modal
        btnAddFaq.addEventListener('click', openModal);

        // Eventos para fechar o modal (Botão X e Clique no Overlay)
        modalCloseBtn.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });

        // Evento de Simulação de Envio do Formulário
        addFaqForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const titulo = document.getElementById('faqTitulo').value;
            const descricao = document.getElementById('faqDescricao').value;

            // 1. Cria o novo item do Acordeão (Visual)
            const newItemHTML = `
        <div class="accordion-item new-item">
            <button class="accordion-header">
                ${titulo}
                <i class="fas fa-chevron-down toggle-icon"></i>
            </button>
            <div class="accordion-content">
                <p>${descricao}</p>
            </div>
        </div>
    `;

            // 2. Adiciona o novo item ao topo do container
            faqContainer.insertAdjacentHTML('afterbegin', newItemHTML);

            // 3. Re-anexa o listener de clique para o novo item
            const newItem = faqContainer.querySelector('.new-item');
            if (newItem) {
                // Encontra o novo cabeçalho e aplica o listener do acordeão
                const newHeader = newItem.querySelector('.accordion-header');
                newHeader.addEventListener('click', function () {
                    const item = this.parentElement;
                    const content = item.querySelector('.accordion-content');

                    document.querySelectorAll('.accordion-item.active').forEach(activeItem => {
                        if (activeItem !== item) {
                            activeItem.classList.remove('active');
                            activeItem.querySelector('.accordion-content').style.maxHeight = null;
                        }
                    });

                    item.classList.toggle('active');

                    if (item.classList.contains('active')) {
                        content.style.maxHeight = content.scrollHeight + "px";
                    } else {
                        content.style.maxHeight = null;
                    }
                });

                // Remove a classe temporária
                newItem.classList.remove('new-item');
            }

            // 4. Feedback e Fechar Modal
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: "success",
                    title: "Card Adicionado!",
                    text: "A nova dúvida foi adicionada visualmente.",
                    confirmButtonColor: "#1ABC9C",
                    timer: 1500
                });
            }

            closeModal();
        });
    </script>
</body>

</html>