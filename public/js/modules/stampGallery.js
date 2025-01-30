export function showStampGallery() {
  console.log("Connexion à stampGallery.js réussie !");
  document.addEventListener("DOMContentLoaded", () => {
    // Récupérer l'image principale et toutes les vignettes
    const mainImage = document.getElementById("main_img");
    const thumbnails = document.querySelectorAll(
      ".stampCard__gallery-thumbnails--img"
    );

    // Ajouter un écouteur d'événement pour chaque vignette
    thumbnails.forEach((thumbnail) => {
      thumbnail.addEventListener("click", function () {
        // Lorsque la vignette est cliquée, on change l'image principale
        mainImage.src = thumbnail.src;
      });
    });
  });
}
