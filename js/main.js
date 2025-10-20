// ==========================================================
// 1. CÓDIGO DE LOGIN (Execute APENAS se o elemento existir)
// ==========================================================

// Arquivo: js/main.js

document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault(); // Impede o envio tradicional do formulário (recarregamento)

      const email = document.getElementById("email").value;
      const senha = document.getElementById("senha").value;

      // Cria um FormData para enviar os dados como POST
      const formData = new FormData();
      formData.append("email", email);
      formData.append("senha", senha);

      try {
        // Requisição AJAX para o script PHP de processamento
        const response = await fetch("php/login_process.php", {
          method: "POST",
          body: formData, // Envia os dados
        });

        const data = await response.json();

        if (data.success) {
          // Login BEM-SUCEDIDO
          Swal.fire({
            icon: "success",
            title: "Sucesso!",
            text: data.message,
            timer: 1500,
            showConfirmButton: false,
          }).then(() => {
            // Redireciona para o dashboard após o sucesso
            window.location.href = "php/dashboard.php";
          });
        } else {
          // Login FALHOU
          Swal.fire({
            icon: "error",
            title: "Erro de Login",
            text: data.message,
          });
        }
      } catch (error) {
        console.error("Erro na requisição AJAX:", error);
        Swal.fire({
          icon: "error",
          title: "Erro de Conexão",
          text: "Não foi possível conectar ao servidor. Tente novamente.",
        });
      }
    });
  }
});
// ==========================================================
// 2. CÓDIGO DE RECUPERAÇÃO DE SENHA (Execute APENAS se os elementos existirem)
// ==========================================================

function nextStep(num) {
  document
    .querySelectorAll(".step")
    .forEach((s) => s.classList.remove("active"));

  const nextStepElement = document.getElementById("step" + num);
  if (nextStepElement) {
    nextStepElement.classList.add("active");
  }
}

function finalizar() {
  const senha1 = document.getElementById("senha1");
  const senha2 = document.getElementById("senha2");

  if (!senha1 || !senha2) {
    console.error("Campos de senha não encontrados.");
    return;
  }

  const valSenha1 = senha1.value;
  const valSenha2 = senha2.value;

  if (!valSenha1 || !valSenha2) {
    alert("Preencha todos os campos.");
    return;
  }

  if (valSenha1 !== valSenha2) {
    alert("As senhas não coincidem!");
    return;
  }

  alert("Senha redefinida com sucesso!");
  window.location.href = "../index.php";
}

// ==========================================================
// 3. CÓDIGO DA SIDEBAR (Hamburguer)
// ==========================================================

const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.getElementById("sidebar");
const sidebarOverlay = document.getElementById("sidebar-overlay");
const body = document.body;

if (menuToggle && sidebar && sidebarOverlay) {
  function toggleSidebar() {
    const isActive = sidebar.classList.toggle("active");
    sidebarOverlay.classList.toggle("active", isActive);

    if (window.innerWidth <= 1024) {
      body.classList.toggle("menu-open", isActive);
    }
  }

  menuToggle.addEventListener("click", toggleSidebar);
  sidebarOverlay.addEventListener("click", toggleSidebar);
  window.addEventListener("resize", () => {
    if (window.innerWidth > 1024 && sidebar.classList.contains("active")) {
      sidebar.classList.remove("active");
      sidebarOverlay.classList.remove("active");
      body.classList.remove("menu-open");
    }
  });
}
