// utils.js
// --- FUNCIONES DE UTILIDAD ---

function createPetCard(pet) {
    const card = document.createElement('div');
    card.classList.add('pet-card');
    card.innerHTML = `
        <img src="${pet.imagen}" alt="${pet.nombre}">
        <h3>${pet.nombre}</h3>
        <p><strong>Raza:</strong> ${pet.raza} | <strong>Edad:</strong> ${pet.edad}</p>
        <button class="adopt-btn" data-pet-id="${pet.id}" data-pet-name="${pet.nombre}">Adoptar</button>
    `;
    return card;
}

function attachAdoptButtonEvents(adopcionModal, count) {
    const adoptButtons = document.querySelectorAll(".adopt-btn");
    const modalTitle = document.getElementById("modal-pet-name");
    const inputMascota = document.getElementById("mascotaSeleccionada");

    adoptButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const petId = btn.dataset.petId;
            const petName = btn.dataset.petName;
            modalTitle.textContent = petName;
            inputMascota.value = petId;
            adopcionModal.show();
            count++;
        });
    });
}
