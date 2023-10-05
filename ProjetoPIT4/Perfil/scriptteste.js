// Obtém referências aos elementos do DOM
const inputFotoPerfil = document.getElementById("input-foto-perfil");
const imgPreview = document.getElementById("img-preview");
const btnConfirmar = document.getElementById("btn-confirmar");

// Event listener para o input de foto de perfil
inputFotoPerfil.addEventListener("change", function (event) {
  const file = event.target.files[0];

  if (file) {
    // Cria um objeto URL temporário para a pré-visualização da imagem
    const imgUrl = URL.createObjectURL(file);

    // Atualiza a imagem de pré-visualização e mostra o botão de confirmação
    imgPreview.src = imgUrl;
    imgPreview.style.display = "block";
    btnConfirmar.style.display = "inline-block";
  } else {
    // Limpa a pré-visualização e esconde o botão de confirmação
    imgPreview.src = "";
    imgPreview.style.display = "none";
    btnConfirmar.style.display = "none";
  }
});

// Event listener para o botão de confirmação
btnConfirmar.addEventListener("click", function () {
  // Envia o formulário para realizar o upload da foto de perfil
  const form = inputFotoPerfil.closest("form");
  form.submit();
});
