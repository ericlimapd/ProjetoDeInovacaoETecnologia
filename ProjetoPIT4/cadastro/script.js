function mascaraNivel(input) {
    if (input.validity.rangeUnderflow) {
      input.value = input.min;
    } else if (input.validity.rangeOverflow) {
      input.value = input.max;
    }
  }

function exibirFormularioJogo() {
    var jogoSelect = document.getElementById("jogo");
    var cadastroLOL = document.getElementById("cadastro-lol");
    var cadastroCSGO = document.getElementById("cadastro-csgo");

    if (jogoSelect.value === "lol") {
        cadastroLOL.style.display = "flex";
        cadastroCSGO.style.display = "none";
    } else if (jogoSelect.value === "csgo") {
        cadastroLOL.style.display = "none";
        cadastroCSGO.style.display = "flex";
    } else {
        cadastroLOL.style.display = "none";
        cadastroCSGO.style.display = "none";
    }
}

// Chama a função quando a seleção do jogo for alterada
document.getElementById("jogo").addEventListener("change", exibirFormularioJogo);
