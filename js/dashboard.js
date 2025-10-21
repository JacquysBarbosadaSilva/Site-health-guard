document.addEventListener("DOMContentLoaded", function () {
  // ==========================================================
  // 1. CÓDIGO DA SIDEBAR (Hamburguer)
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

  // ==========================================================
  // 2. FUNÇÃO PARA ATUALIZAR O DASHBOARD (Após requisição AJAX)
  // ==========================================================

  function updateDashboard(data) {
    const isRelatoriosPage = document.querySelector(
      ".freezer-status-relatorio"
    );

    if (isRelatoriosPage) {
      // ==========================================================
      // LÓGICA PARA A PÁGINA DE RELATÓRIOS
      // ==========================================================

      const freezerStatusText = document.querySelector(
        ".freezer-status-relatorio"
      );
      if (freezerStatusText) {
        freezerStatusText.innerHTML = `Você está no **Freezer ${data.freezer_id},** deseja alterar para abaixar o relatório?`;
      }

      // ATUALIZAR GRÁFICO SEMANAL
      if (window.weeklyTempChart && data.report_data) {
        window.weeklyTempChart.data.datasets[0].data =
          data.report_data.temps_min;
        window.weeklyTempChart.data.datasets[1].data =
          data.report_data.temps_max;
        window.weeklyTempChart.data.labels = data.report_data.labels;
        window.weeklyTempChart.update();
      }
    } else {
      // ==========================================================
      // LÓGICA PARA A PÁGINA DE DASHBOARD (Gerenciamento)
      // ==========================================================

      const freezerStatusText = document.querySelector(".freezer-status");
      const tempDisplay = document.querySelector(".temp-display");
      const statusIndicator = document.querySelector(".status-indicator");

      if (freezerStatusText) {
        freezerStatusText.textContent = `Você está visualizando a temperatura do Freezer ${data.freezer_id}`;
      }
      if (tempDisplay) {
        tempDisplay.innerHTML = `${data.current_temp}<span class="unit">°C</span>`;
      }
      if (statusIndicator) {
        statusIndicator.textContent = `Status: ${data.status}`;
        const statusClass =
          data.status.toLowerCase() === "alerta" ? "alert" : "safe";
        statusIndicator.className = `status-indicator ${statusClass}`;
      }

      const card24h_max = document.querySelector(
        ".data-card:nth-child(1) p:nth-child(2)"
      );
      const card24h_min = document.querySelector(
        ".data-card:nth-child(1) p:nth-child(3)"
      );

      if (card24h_max && card24h_min) {
        card24h_max.textContent = `Máxima: ${data.last_24h.max}°C`;
        card24h_min.textContent = `Mínima: ${data.last_24h.min}°C`;
      }

      if (window.tempChart24h && data.chart_data) {
        window.tempChart24h.data.datasets[0].data = data.chart_data.temps;
        window.tempChart24h.data.labels = data.chart_data.labels;
        window.tempChart24h.update();
      }

      const tableBody = document.querySelector(".data-table tbody");
      const tagClass =
        data.status.toLowerCase() === "alerta" ? "tag-alert" : "tag-normal";

      if (tableBody) {
        tableBody.innerHTML = `
                    <tr>
                        <td>${new Date().toLocaleTimeString()}</td>
                        <td>${data.current_temp}°C</td>
                        <td><span class="tag ${tagClass}">${
          data.status
        }</span></td>
                    </tr>
                    <tr>
                        <td>11:45</td>
                        <td>${data.last_24h.min}°C</td>
                        <td><span class="tag tag-normal">Normal</span></td>
                    </tr>
                `;
      }
    }
  }

  // ==========================================================
  // 3. CÓDIGO DO MODAL DE SELEÇÃO DE FREEZER
  // ==========================================================

  const btnMudarFreezer = document.querySelector(".btn-action");
  const freezerModalOverlay = document.getElementById("freezerModalOverlay");
  const freezerItems = document.querySelectorAll(".freezer-item");
  const btnConfirm = document.getElementById("confirmFreezer");
  const btnCancel = document.getElementById("cancelFreezer");
  let selectedFreezerId = null;

  if (btnMudarFreezer && freezerModalOverlay && btnConfirm && btnCancel) {
    function toggleFreezerModal(show) {
      if (show) {
        freezerModalOverlay.classList.add("active");
        freezerItems.forEach((item) => item.classList.remove("selected"));
        selectedFreezerId = null;
      } else {
        freezerModalOverlay.classList.remove("active");
      }
    }

    btnMudarFreezer.addEventListener("click", () => {
      toggleFreezerModal(true);
    });

    btnCancel.addEventListener("click", () => {
      toggleFreezerModal(false);
    });

    freezerModalOverlay.addEventListener("click", (e) => {
      if (e.target === freezerModalOverlay) {
        toggleFreezerModal(false);
      }
    });

    freezerItems.forEach((item) => {
      item.addEventListener("click", () => {
        freezerItems.forEach((i) => i.classList.remove("selected"));
        item.classList.add("selected");
        selectedFreezerId = item.getAttribute("data-freezer-id");
      });
    });

    btnConfirm.addEventListener("click", async () => {
      if (selectedFreezerId) {
        try {
          const response = await fetch("get_freezer_data.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ freezerId: selectedFreezerId }),
          });

          if (!response.ok) {
            throw new Error(
              "Erro ao carregar dados do servidor. Status: " + response.status
            );
          }

          const data = await response.json();
          updateDashboard(data);

          if (typeof Swal !== "undefined") {
            Swal.fire({
              icon: "success",
              title: "Freezer Alterado",
              text: `Visualizando dados do Freezer ${selectedFreezerId}.`,
              confirmButtonColor: "#1ABC9C",
              timer: 1500,
            });
          }

          toggleFreezerModal(false);
        } catch (error) {
          console.error("Falha na requisição AJAX:", error);
          if (typeof Swal !== "undefined") {
            Swal.fire({
              icon: "error",
              title: "Erro de Conexão",
              text: "Não foi possível carregar os dados do Freezer. Verifique o console.",
              confirmButtonColor: "#e74c3c",
            });
          } else {
            alert(
              "Não foi possível carregar os dados do Freezer. Tente novamente."
            );
          }
        }
      } else {
        alert("Por favor, selecione um Freezer.");
      }
    });
  }
});
