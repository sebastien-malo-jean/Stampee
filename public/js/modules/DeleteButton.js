export function DeleteButton() {
  console.log("Connexion à DeleteButton.js réussie !");
  let thumbnailPictures = document.querySelectorAll(
    ".stampCard__gallery-thumbnails--picture"
  );
  for (let i = 0; i < thumbnailPictures.length; i++) {
    console.log(thumbnailPictures[i]);
    let deleteButton = document.createElement("div");
    deleteButton.classList.add("stampCard__gallery-thumbnails--delete");
    deleteButton.innerHTML = `<p class="stampCard__gallery-thumbnails--deleteText">X</p>`;
    thumbnailPictures[i].appendChild(deleteButton);
  }
}
