var addProductForm = document.querySelector('#add-product-form');
var uploadImages = document.querySelector('#upload-images');
var uploadImageGrid = document.querySelector('.upload-image-grid');
var resultMessage = document.querySelector('#result-message');

var draggedItem = null;

function handleDragStart(e) {
  draggedItem = this;
}

function handleDragOver(e) {
  e.preventDefault();
}

function handleDrop(e) {
  e.preventDefault();

  if(this !== draggedItem) {
    this.style.display = 'none';
    this.parentNode.insertBefore(draggedItem, this);
    setTimeout(() => {
      this.style.display = 'flex';
      draggedItem.style.display = 'flex';
    }, 0);

    for (let i = 0; i < uploadImageGrid.children.length; i++) {
      uploadImageGrid.children[i].id = i;
    }
  }
}

function addImage(i, src) {
  const image = document.createElement('img');
  image.src = src;
  const imageWrapper = document.createElement('div');
  imageWrapper.classList.add('upload-image-wrapper');
  image.alt = i;
  imageWrapper.draggable = true;
  imageWrapper.addEventListener('dragstart', handleDragStart);
  imageWrapper.addEventListener('dragover', handleDragOver);
  imageWrapper.addEventListener('drop', handleDrop);
  imageWrapper.id = i;

  imageWrapper.appendChild(image)
  uploadImageGrid.appendChild(imageWrapper);
}

function submitForm() {
  const images = uploadImages.files;
  console.log(images)

  var formData = new FormData(addProductForm);
  formData.append('action', 'add');
  formData.append('images', images);

  fetch('api/products.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    console.log(data);
    addProductForm.reset();
    uploadImageGrid.innerHTML = '';
    resultMessage.textContent = data;
  })
  .catch(error => console.error("Error: ", error));

}

function main() {
  if(uploadImages === null) {
    return;
  }

  uploadImages.addEventListener('change', () => {
    uploadImageGrid.innerHTML = '';
    const files = uploadImages.files;
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();
      reader.onload = function(e) {
        addImage(i, e.target.result);
      };
      reader.readAsDataURL(file);
    }
  })

  addProductForm.addEventListener('submit', (e) => {
    e.preventDefault();
    submitForm();
  });
}

main();
