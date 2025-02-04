export function DeleteButton() {
  console.log("Connexion à DeleteButton.js réussie !");
  let thumbnailPictures = document.querySelectorAll(
    ".stampCard__gallery-thumbnails--picture"
  );
  //   for (let i = 0; i < thumbnailPictures.length; i++) {
  //     console.log(thumbnailPictures[i]);
  //     let deleteButton = document.createElement("div");
  //     deleteButton.classList.add("stampCard__gallery-thumbnails--delete");
  //     deleteButton.innerHTML = `<form action="\{\{ base \}\}/deleteImage" method="POST">
  //                                 <input type="hidden" name="imageToDelete" value="${thumbnailPictures[i].firstElementChild.src}">
  //                                 <button type="submit" class="stampCard__gallery-thumbnails--delete-button">
  //                                 <i class="fas fa-trash-alt"></i>
  //                                 </button>
  //                                 </form>`;
  //     thumbnailPictures[i].appendChild(deleteButton);
  //   }
}
