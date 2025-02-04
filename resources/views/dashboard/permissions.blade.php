<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">

</head>
<body>
<div class="dashboard">
    @include("dashboard/sidebar")
    <div class="content">
        @include("dashboard/adminNavbar")

        <section>
            <div class="dashboard-permission-head">
                <div>
                    <p>< back</p>
                    <h3>Admin</h3>
                    <p class="dashboard-permission-content">An admin has the following permissions listed below</p>
                </div>
                <div><button class="permission-button" onclick="openModal('addPermissionModal')">Add Permission</button></div>
            </div>

            <h4>Permissions (8)</h4>
            <p class="dashboard-permission-content">1. Lorem ipsum dolor sit amet
                <span><i class="fas fa-pen" onclick="openModal('editPermissionModal')" style="font-size: 12px; color: #007bff; cursor:pointer;"></i></span>
                <span><i class="fas fa-trash" onclick="openModal('deletePermissionModal')" style="font-size: 12px; color: #dc3545; cursor:pointer;"></i></span>
            </p>
            <!-- Repeat similar blocks for other permissions -->
        </section>

        <!-- Modals -->
        <div class="modal" id="addPermissionModal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('addPermissionModal')">&times;i</span>
                <h3>Add Permission</h3>
                <input type="text" placeholder="Permission Name"> <br>
                <button class="btn">Add</button>
            </div>
        </div>

        <div class="modal" id="editPermissionModal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('editPermissionModal')">&times;</span>
                <h3>Edit Permission</h3>
                <input type="text" placeholder="New Permission Name">
                <button class="btn">Save Changes</button>
            </div>
        </div>

    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Close modal when clicking outside content
    window.onclick = function(event) {
        document.querySelectorAll('.modal').forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }
</script>
</body>
</html>
