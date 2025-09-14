/**
 * Light Switch @version v0.2.0
 */
(function () {
  const lightSwitch = document.getElementById('lightSwitch');
  if (!lightSwitch) {
    return;
  }

  // Função para alternar o modo escuro
  function toggleDarkMode() {
    // Alterna a classe no body
    document.body.classList.toggle('dark-mode');

    // Determina o estado atual
    const isDarkMode = document.body.classList.contains('dark-mode');

    // Envia o estado para o servidor para salvar no cookie
    fetch('includes/darkMode.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'toggle_dark_mode=1'
    })
      .then(response => response.json())
      .then(data => {
        if (data.status !== 'success') {
          console.error('Erro ao salvar o estado do modo escuro.');
        }
      })
      .catch(error => console.error('Erro:', error));
  }

  // Adiciona o listener de evento ao switch
  lightSwitch.addEventListener('change', toggleDarkMode);
})();

// Acessibility
function fonte(e) {
  let elemento = $("body");
  let fonte = elemento.css('font-size');

  if (e == 'a') {
    elemento.css("fontSize", parseInt(fonte) + 1);
  } else if ('d') {
    elemento.css("fontSize", parseInt(fonte) - 1);
  }
}