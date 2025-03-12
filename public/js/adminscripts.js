
// Attach close functionality to the close button
document.getElementById('sentcloseModal').onclick = function () {
    closeModal('sentModal');
};

// close functionality to the close button
document.getElementById('closeModal').onclick = function () {
    closeModal('loginModal');
};

function ActionModal(event) {
    const modal = document.getElementById('actionModal');
    const trigger = event.currentTarget; // Get the clicked element

    // Get user ID, full name, and page identifier
    const userId = trigger.getAttribute('data-user-id');
    const fullName = trigger.getAttribute('data-full-name');
    const page = trigger.getAttribute('data-page'); // Identify the page

    // Get the position of the trigger
    const rect = trigger.getBoundingClientRect();
    const offsetX = 10; // Horizontal offset
    const offsetY = 6;  // Vertical offset

    // Position the modal
    modal.style.left = `${rect.left + offsetX}px`;
    modal.style.top = `${rect.bottom + offsetY}px`;
    modal.style.display = 'block';

    let modalContent = '';

    // Determine modal content based on the page
    if (page === 'users') {
        modalContent = `
            <div class="modal-content">
                <p onclick="openModal('suspend', '${userId}', '${fullName}')">Suspend ${fullName}</p>
                <p onclick="openModal('viewmore', '${userId}', '${fullName}')">View More ${fullName}</p>
                <p onclick="openModal('assign-role', '${userId}', '${fullName}')">Assign Role</p>
                <p onclick="openModal('activate-admin', '${userId}', '${fullName}')">Activate ${fullName}</p>
                <p onclick="openModal('reset-password', '${userId}', '${fullName}')">Reset Password ${fullName}</p>
            </div>
        `;
    } else if (page === 'roles') {
        modalContent = `
            <div class="modal-content">
        <p><a href="${window.location.origin}/permission" class="href_black">Role & Permissions</a></p>
                <p onclick="openModal('suspend', '${userId}', '${fullName}')">Suspend ${fullName}</p>
                <p onclick="openModal('activate-admin', '${userId}', '${fullName}')">Activate ${fullName}</p>
            </div>
        `;
    }else if (page === 'reward') {
        modalContent = `
            <div class="modal-content">
                    <p onclick="openModal('reward', '${userId}', '${fullName}')">Reward ${fullName}</p>
               </div>
        `;
    } else if (page === 'approvals') {
        modalContent = `
            <div class="modal-content">
                <p onclick="openModal('approve', '${userId}', '${fullName}')">Approve ${fullName}</p>
                <p onclick="openModal('reject', '${userId}', '${fullName}')">Reject ${fullName}</p>
                <p onclick="openModal('view-edit', '${userId}', '${fullName}')">View & Edit</p>
                <p onclick="openModal('flag', '${userId}', '${fullName}')">Flag ${fullName}</p>
            </div>
        `;
    } else {
        modalContent = `
            <div class="modal-content">
                <p onclick="openModal('enable')">Enable</p>
                <p onclick="openModal('delete')">Disable</p>
                <p onclick="openModal('assign-role')">Set Priority Level</p>
                <p onclick="openModal('activate-admin')">Delete</p>
            </div>
        `;
    }

    // Update the modal content dynamically
    modal.innerHTML = modalContent;
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
            modalTitle.textContent = 'Suspend';
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
                    <option value="translator">Admin</option>
                </select>
            `;
            confirmButton.onclick = () => {
                const role = document.getElementById('roleSelect').value;
                performAction('assignrole', userId, role);
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
            confirmButton.onclick = () => performAction('approve-admin', userId);
            break;
        case 'reset-password':
            modalTitle.textContent = 'Reset Password';
            modalMessage.textContent = `Are you sure you want to reset ${userName} password?`;
            confirmButton.onclick = () => performAction('resetpassword', userId);
            break;
        case 'activate-admin':
            modalTitle.textContent = 'Reset Password';
            modalMessage.textContent = `Are you sure you want activate ${userName}?`;
            confirmButton.onclick = () => performAction('activateadmin', userId);
            break;

        case 'viewmore':
            modalTitle.textContent = 'View more';
            modalMessage.textContent = `username ${userName}`;
            confirmButton.onclick = () => closeModals('', userId);
            break;
        default:
            modalTitle.textContent = 'Action';
            modalMessage.textContent = `Performing ${action} for ${userName}`;
            confirmButton.onclick = () => performAction(action, userId);
    }

    modal.style.display = 'flex';
}


function performAction(action, userId, role = null) {
    console.log(`performAction triggered - Action: ${action}, User ID: ${userId}, Role: ${role}`);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found! Make sure the meta tag is correctly set in your Blade file.');
        return;
    }
    const data = { action };
    if (role) data.role = role; // Only add role if it's needed

    const url = `/admin/${action}/${userId}`; // Include userId in the URL
        console.log(url)
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':csrfToken,
        },
        body: JSON.stringify(data),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Server Response:', data);
            alert(data.message);
            closeModals();
            location.reload(); // Reload to reflect changes
        })
        .catch(error => console.error('Error:', error));
}


function closeModals() {
    const modal = document.getElementById('dynamicModal');
    modal.style.display = 'none';
}



// to get csv files
function exportTableToCSV() {
    let table = document.querySelector(".user-mgt-table");
    let rows = Array.from(table.rows);
    let csvContent = "";

    rows.forEach(row => {
        let cols = Array.from(row.cells).map(cell => cell.innerText);
        csvContent += cols.join(",") + "\n";
    });

    let blob = new Blob([csvContent], { type: "text/csv" });
    let link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "users_data.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


