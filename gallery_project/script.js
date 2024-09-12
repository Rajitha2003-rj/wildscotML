document
  .getElementById("photoForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(this);

    fetch("upload.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          addPhotoToList(data.photoPath, data.photoId);
        } else {
          alert("Failed to upload photo.");
        }
      });
  });

function addPhotoToList(photoPath, photoId) {
  const photoList = document.getElementById("photoList");
  const photoItem = document.createElement("div");
  photoItem.className = "photo-item";
  photoItem.innerHTML = `
        <img src="${photoPath}" alt="Photo ${photoId}">
        <div class="operations">
            <button class="delete" onclick="deletePhoto(${photoId})">Delete</button>
            <button class="update" onclick="updatePhoto(${photoId})">Update</button>
        </div>
    `;
  photoList.appendChild(photoItem);
}

function deletePhoto(photoId) {
  if (confirm("Are you sure you want to delete this photo?")) {
    fetch(`delete.php?id=${photoId}`, {
      method: "GET",
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          location.reload();
        } else {
          alert("Failed to delete photo.");
        }
      });
  }
}

function updatePhoto(photoId) {
  const newPhoto = prompt("Enter new photo URL:");
  if (newPhoto) {
    fetch("update.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: photoId, photo: newPhoto }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          location.reload();
        } else {
          alert("Failed to update photo.");
        }
      });
  }
}
