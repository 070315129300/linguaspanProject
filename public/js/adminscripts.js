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
    const trigger = event.currentTarget; // Get the clicked element

    // Get user ID and full name from the clicked action button
    const userId = trigger.getAttribute('data-user-id');
    const fullName = trigger.getAttribute('data-full-name');

    // Get the position of the trigger
    const rect = trigger.getBoundingClientRect();
    const offsetX = 10; // Horizontal offset
    const offsetY = 6;  // Vertical offset

    // Position the modal
    modal.style.left = `${rect.left + offsetX}px`;
    modal.style.top = `${rect.bottom + offsetY}px`;
    modal.style.display = 'block';

    // Update the modal content dynamically
    modal.innerHTML = `
        <div class="modal-content">
            <p onclick="openModal('suspend', '${userId}', '${fullName}')">Suspend ${fullName}</p>
            <p onclick="openModal('delete', '${userId}', '${fullName}')">View More ${fullName}</p>
            <p onclick="openModal('assign-role', '${userId}', '${fullName}')">Assign Role</p>
            <p onclick="openModal('activate-admin', '${userId}', '${fullName}')">Deactivate ${fullName}</p>
            <p onclick="openModal('reset-password', '${userId}', '${fullName}')">Reset Password ${fullName}</p>
        </div>

        <div class="modal-content">

<!--        //for role page-->
         <p><a href="{{ url('permission') }}" class="href_black">Role & Permissions</a></p>
              <p onclick="openModal('suspend', '${userId}', '${fullName}')">Suspend ${fullName}</p>
             <p onclick="openModal('delete', '${userId}', '${fullName}')">View More ${fullName}</p>
            <p onclick="openModal('activate-admin', '${userId}', '${fullName}')">Deactivate ${fullName}</p>
        </div>

         <div class="modal-content">
        <p onclick="openModal('reward', '${userId}', '${fullName}')">Reward ${fullName}</p>
        </div>

          <div class="modal-content">
        <p class="" onclick="openModal('approve', '{{ $usr->id }}', '{{ $usr->fullName }}')">Approve {{ $usr->fullName }}</p>
                <p onclick="openModal('reject', '{{ $usr->id }}', '{{ $usr->fullName }}')">Reject  {{ $usr->fullName }}</p>
                <p onclick="openModal('view-edit', '{{ $usr->id }}', '{{ $usr->fullName }}')">View & Edit</p>
                <p onclick="openModal('flag', '{{ $usr->id }}', '{{ $usr->fullName }}')">flag {{ $usr->fullName }}</p>
        </div>

        <div class="modal-content">
           <p class="" onclick="openModal('approve' )">Enable</p>
                    <p onclick="openModal('delete')">Disable </p>
                    <p onclick="openModal('assign-role')">Set Priority level</p>
                    <p onclick="openModal('activate-admin')">Delete </p>
        </div>

    `;
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
            confirmButton.onclick = () => performAction('approve-admin', userId);
            break;
        case 'reset-password':
            modalTitle.textContent = 'Reset Password';
            modalMessage.textContent = `Are you sure you want to make ${userName} an admin?`;
            confirmButton.onclick = () => performAction('reset-password', userId);
            break;
        default:
            modalTitle.textContent = 'Action';
            modalMessage.textContent = `Performing ${action} for ${userName}`;
            confirmButton.onclick = () => performAction(action, userId);
    }

    modal.style.display = 'flex';
}



function performAction(action, userId, role = null) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const data = {
        action,
        role, // Only needed for assign-role
    };

    const url = `/admin/${action}/${userId}`; // Include userId in the URL

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            closeModal();
            location.reload(); // Reload to reflect changes
        })
        .catch(error => console.error('Error:', error));
}
function closeModals() {
    const modal = document.getElementById('dynamicModal');
    modal.style.display = 'none';
}

function showTable(category) {
    // Hide all tables
    document.querySelectorAll('.table-content').forEach(table => {
        table.style.display = 'none';
    });

    // Remove "selected" class from all list items
    document.querySelectorAll('#user-categories li').forEach(li => {
        li.classList.remove('selected');
    });

    // Display the selected table and add "selected" class to the clicked li
    document.querySelector(`.table-content[data-category="${category}"]`).style.display = 'block';
    document.querySelector(`#user-categories li[data-category="${category}"]`).classList.add('selected');
}

// Initialize by showing the first table (e.g., General Users)
showTable('general');

// Get all the list items and table content divs
const listItems = document.querySelectorAll('#user-categories li');
const tableContents = document.querySelectorAll('.table-content');

// Add click event to each list item
listItems.forEach(item => {
    item.addEventListener('click', () => {
        // Get the category from the clicked list item
        const category = item.getAttribute('data-category');

        // Show the relevant table and hide others
        tableContents.forEach(tableContent => {
            if (tableContent.getAttribute('data-category') === category) {
                tableContent.style.display = 'block';
            } else {
                tableContent.style.display = 'none';
            }
        });
    });
});

document.querySelectorAll('select').forEach(select => {
    select.addEventListener('change', () => {
        document.getElementById('filter-form').submit();
    });
});

document.querySelector('.btn.permission-button').addEventListener('click', function() {
    var fullname = document.querySelector('input[placeholder="fullname"]').value;
    var userType = document.querySelector('select').value;
    var email = document.querySelector('input[placeholder="email"]').value;

    // Send AJAX request
    fetch('/invite-admin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            fullname: fullname,
            user_type: userType,
            email: email
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Admin invited successfully!');
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
});

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


