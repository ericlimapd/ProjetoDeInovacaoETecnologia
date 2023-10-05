const btnAvatar = document.getElementById("change-avatar-btn");
const regiaoFlag = document.getElementById("regiao-flag");
const patenteImg = document.getElementById("patente");
const eloImg = document.getElementById("elo");
const tooltip = document.getElementById("tooltip");
const nivelInput = document.getElementById("nivel-input");
let popup = document.getElementById("popup");

let isTooltipVisible = false;

btnAvatar.addEventListener("mouseenter", () => {
  tooltip.style.display = "block";
  isTooltipVisible = true;
  tooltip.textContent = "Alterar avatar";
});

btnAvatar.addEventListener("mousemove", (event) => {
  const x = event.clientX + 20;
  const y = event.clientY + 10;

  tooltip.style.left = x + "px";
  tooltip.style.top = y + "px";
});

btnAvatar.addEventListener("mouseleave", () => {
  isTooltipVisible = false;
  tooltip.style.display = "none";
});

if (eloImg) {
  eloImg.addEventListener("mouseenter", () => {
    const tooltipText = getEloTooltipText(eloImg.src);
    showTooltip(eloImg, tooltipText);
  });
}

if (patenteImg) {
  patenteImg.addEventListener("mouseenter", () => {
    const tooltipText = getPatenteTooltipText(patenteImg.src);
    showTooltip(patenteImg, tooltipText);
  });
}

if (regiaoFlag) {
  regiaoFlag.addEventListener("mouseenter", () => {
    const tooltipText = getRegiaoTooltipText(regiaoFlag.src);
    showTooltip(regiaoFlag, tooltipText);
  });
}

function showTooltip(element, text) {
  tooltip.style.display = "flex";
  isTooltipVisible = true;
  tooltip.textContent = text;

  element.addEventListener("mousemove", (event) => {
    const x = event.clientX + 20;
    const y = event.clientY + 10;

    tooltip.style.left = x + "px";
    tooltip.style.top = y + "px";
  });

  element.addEventListener("mouseleave", () => {
    isTooltipVisible = false;
    tooltip.style.display = "none";
  });
}

function getRegiaoTooltipText(imageUrl) {
  if (imageUrl.includes("brasil.png")) {
    return "Brasil";
  } else if (imageUrl.includes("las.png")) {
    return "América do Sul";
  } else if (imageUrl.includes("bolivia.png")) {
    return "Bolivia";
  } else if (imageUrl.includes("chile.png")) {
    return "Chile";
  } else if (imageUrl.includes("paraguai.png")) {
    return "Paraguai";
  } else if (imageUrl.includes("venezuela.png")) {
    return "Venezuela";
  } else {
    return "";
  }
}

function getEloTooltipText(imageUrl) {
  if (imageUrl.includes("ferro.png")) {
    return "Ferro";
  } else if (imageUrl.includes("bronze.png")) {
    return "Bronze";
  } else if (imageUrl.includes("lol_prata1.png")) {
    return "Prata I";
  } else if (imageUrl.includes("lol_prata2.png")) {
    return "Prata II";
  } else if (imageUrl.includes("lol_prata3.png")) {
    return "Prata III";
  } else if (imageUrl.includes("lol_prata4.png")) {
    return "Prata IV";
  } else if (imageUrl.includes("csgo_ouro1.png")) {
    return "Ouro I";
  } else if (imageUrl.includes("csgo_ouro2.png")) {
    return "Ouro II";
  } else if (imageUrl.includes("csgo_ouro3.png")) {
    return "Ouro III";
  } else if (imageUrl.includes("csgo_ouro4.png")) {
    return "Ouro IV";
  } else if (imageUrl.includes("platina.png")) {
    return "Platina";
  } else if (imageUrl.includes("diamante.png")) {
    return "Diamante";
  } else if (imageUrl.includes("mestre.png")) {
    return "Mestre";
  } else if (imageUrl.includes("gmestre.png")) {
    return "Grão-Mestre";
  } else if (imageUrl.includes("desafiante.png")) {
    return "Desafiante";
  } else {
    return "";
  }
}

function getPatenteTooltipText(imageUrl) {
  if (imageUrl.includes("csgo_prata1.png")) {
    return "Prata I";
  } else if (imageUrl.includes("csgo_prata2.png")) {
    return "Prata II";
  } else if (imageUrl.includes("csgo_prata3.png")) {
    return "Prata III";
  } else if (imageUrl.includes("csgo_prata4.png")) {
    return "Prata IV";
  } else if (imageUrl.includes("prataelite.png")) {
    return "Prata de Elite";
  } else if (imageUrl.includes("prataelitem.png")) {
    return "Prata de Elite Mestre";
  } else if (imageUrl.includes("csgo_ouro1.png")) {
    return "Ouro I";
  } else if (imageUrl.includes("csgo_ouro2.png")) {
    return "Ouro II";
  } else if (imageUrl.includes("csgo_ouro3.png")) {
    return "Ouro III";
  } else if (imageUrl.includes("csgo_ouro4.png")) {
    return "Ouro IV";
  } else if (imageUrl.includes("ak1.png")) {
    return "Mestre Guardião I";
  } else if (imageUrl.includes("ak2.png")) {
    return "Mestre Guardião II";
  } else if (imageUrl.includes("akx.png")) {
    return "Mestre Guardião Elite";
  } else if (imageUrl.includes("xerife.png")) {
    return "Distinto Mestre Guardião";
  } else if (imageUrl.includes("aguia1.png")) {
    return "Águia Lendária I";
  } else if (imageUrl.includes("aguia2.png")) {
    return "Águia Lendária II";
  } else if (imageUrl.includes("supremo.png")) {
    return "Mestre Supremo de Primeira Classe";
  } else if (imageUrl.includes("global.png")) {
    return "Global Elite";
  } else {
    return "";
  }
}

function openPopup() {
  popup.classList.add("open-popup");
}

function closePopup() {
  popup.classList.remove("open-popup");
}

function mascaraNivel(input) {
  if (input.validity.rangeUnderflow) {
    input.value = input.min;
  } else if (input.validity.rangeOverflow) {
    input.value = input.max;
  }
}
