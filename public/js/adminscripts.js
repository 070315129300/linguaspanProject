//Open the modal
function openModals(modalId) {
    const modals = document.getElementById(modalId);
    if (modals) {
        modals.style.display = 'flex';
    }
}

// Close the modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}
// Attach close functionality to the close button
document.getElementById('sentcloseModal').onclick = function () {
    closeModal('sentModal');
};

// Attach close functionality to the close button
document.getElementById('closeModal').onclick = function () {
    closeModal('loginModal');
};


// Close modal when clicking outside the modal content
window.onclick = function (event) {
    const modal = document.getElementById('loginModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};
function ActionModal(event) {
    const modal = document.getElementById('actionModal');
    const trigger = event.target; // The clicked element

    // Get the position of the trigger
    const rect = trigger.getBoundingClientRect();
    const offsetX = 10; // Horizontal offset
    const offsetY = 6;  // Vertical offset

    // Position the s
    modal.style.left = `${rect.left + offsetX}px`;
    modal.style.top = `${rect.bottom + offsetY}px`;
    modal.style.display = 'block';
}

// Close modal when clicking outside
document.addEventListener('click', function (e) {
    const modal = document.getElementById('actionModal');
    if (!modal.contains(e.target) && !e.target.matches('.action-buttons')) {
        modal.style.display = 'none';
    }
});

//  dynamic reusable model

function openModal(action, userId, userName) {
    const modal = document.getElementById('dynamicModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const confirmButton = document.getElementById('confirmButton');

    // Set modal content based on the action
    switch (action) {
        case 'suspend':
            modalTitle.textContent = 'Suspend Admin';
            modalMessage.textContent = `Are you sure you want to suspend ${userName}?`;
            confirmButton.onclick = () => performAction('suspend', userId);
            break;
        case 'delete':
            modalTitle.textContent = 'Delete Admin';
            modalMessage.textContent = `Are you sure you want to delete admin ${userName}?`;
            confirmButton.onclick = () => performAction('delete', userId);
            break;
        case 'assign-role':
            modalTitle.textContent = 'Assign Role';
            modalMessage.innerHTML = `
                <label for="roleSelect">Select Role:</label>
                <select id="roleSelect">
                    <option value="transcriber">Transcriber</option>
                    <option value="translator">Translator</option>
                </select>
            `;
            confirmButton.onclick = () => {
                const role = document.getElementById('roleSelect').value;
                performAction('assign-role', userId, role);
            };
            break;
        case 'make-admin':
            modalTitle.textContent = 'Make Admin';
            modalMessage.textContent = `Are you sure you want to make ${userName} an admin?`;
            confirmButton.onclick = () => performAction('make-admin', userId);
            break;
        case 'approve':
            modalTitle.textContent = 'approve Admin';
            modalMessage.textContent = `Are you sure you want to make ${userName} an admin?`;
            confirmButton.onclick = () => performAction('approve admin', userId);
            break;
        default:
            modalTitle.textContent = 'Action';
            modalMessage.textContent = `Performing ${action} for ${userName}`;
            confirmButton.onclick = () => performAction(action, userId);
    }

    modal.style.display = 'flex';
}

function closeModals() {
    const modal = document.getElementById('dynamicModal');
    modal.style.display = 'none';
}

