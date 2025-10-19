// ==========================================================
// 1. CÓDIGO DE LOGIN (Execute APENAS se o elemento existir)
// ==========================================================

const loginForm = document.getElementById("loginForm");

if (loginForm) {
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const senha = document.getElementById("senha").value.trim();

    if (email === "" || senha === "") {
      if (typeof Swal !== "undefined") {
        Swal.fire({
          icon: "warning",
          title: "Campos obrigatórios",
          text: "Por favor, preencha todos os campos antes de continuar.",
          confirmButtonColor: "#1ABC9C",
        });
      } else {
        alert("Por favor, preencha todos os campos antes de continuar.");
      }
      return;
    }

    if (email === "admin@healthguard.com" && senha === "1234") {
      if (typeof Swal !== "undefined") {
        Swal.fire({
          icon: "success",
          title: "Login bem-sucedido!",
          text: "Bem-vindo ao sistema HealthGuard!",
          confirmButtonColor: "#1ABC9C",
        }).then(() => {
          window.location.href = "php/dashboard.php";
        });
      } else {
        window.location.href = "php/dashboard.php";
      }
    } else {
      if (typeof Swal !== "undefined") {
        Swal.fire({
          icon: "error",
          title: "Credenciais inválidas",
          text: "Email ou senha incorretos. Tente novamente.",
          confirmButtonColor: "#1ABC9C",
        });
      } else {
        alert("Email ou senha incorretos. Tente novamente.");
      }
    }
  });
}

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