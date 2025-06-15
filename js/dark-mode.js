function toggleDarkMode() {
  const body = document.body;
  const isDark = body.classList.toggle("dark-mode");

  localStorage.setItem("darkMode", isDark ? "enabled" : "disabled");

  const icon = document.querySelector("#dark-mode-toggle span");
  icon.className = isDark ? "fa-solid fa-sun" : "fa-solid fa-moon";
}

// Mantém o modo noturno ao recarregar a página
window.onload = function () {
  const darkMode = localStorage.getItem("darkMode");
  const icon = document.querySelector("#dark-mode-toggle span");

  if (darkMode === "enabled") {
    document.body.classList.add("dark-mode");
    icon.className = "fa-solid fa-sun";
  } else {
    icon.className = "fa-solid fa-moon";
  }
};
