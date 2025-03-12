<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_styles.css">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">--}}
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div class="dashboard">
    @include("dashboard/sidebar")

    <div class="content">

        @include("dashboard/adminNavbar")

        <section>
            <div class="dashboard-permission-head">
                <div>
                    <h3>Language Management</h3>

                </div>
                <div><button class="permission-button" id="openInviteModalButton">Add Language</button></div>

            </div>
        </section>
        <div id="tables-container">
            <!-- General Users Table -->
            <div class="table-content" data-category="general">
                <table class="user-mgt-table">

                    <thead>
                    <tr>
                        <td colspan="5" >
                            <div class="table-header">
                                <div class="table-header-right">
                                    <input type="search" placeholder="search">
                                </div>
                                <div class="table-header-right">
                                    <button onclick="exportTableToCSV()">
                                        <i class="iconsax" icon-name="document-download"></i> Download CSV
                                    </button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Language</th>
                        <th>No. of. submissions</th>
                        <th>Language Status</th>
                        <th style="text-align: center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($languages as $language)
                    <tr>
                        <td>{{$language->language}}</td>
                        <td>{{$language->total}}</td>
                        <td>Active</td>
{{--                        <td onclick="ActionModal(event)" class="action-buttons"> ***</td>--}}
                        <td onclick="ActionModal(event)"
                            class="action-buttons"
{{--                            data-user-id="{{ $user->id }}"--}}
{{--                            data-full-name="{{ $user->fullName }}"--}}
                            data-page="language"> <!-- Add this -->
                            <i class="iconsax" icon-name="menu-meatballs"></i>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <section>
            <!-- Add language Modal -->
            <div class="login-modal" id="inviteAdminModal" >
                <div class="login-modal-content">
                    <span class="close-modal" id="closeInviteModal">&times;</span>
                    <h3>Invite Admin</h3>
                    <input type="text" id="language" placeholder="enter language name"><br>

                    <button class="btn permission-button" id="inviteButton">Invite</button>
                </div>
            </div>

            <!-- Success Modal (Shown After Successful Invite) -->
            <div class="login-modal" id="sentModal" style="display: none;">
                <div class="login-modal-content">
                    <span class="close-modal" id="sentCloseModal">&times;</span>
                    <h3>Language</h3>
                    <p>language created successfully</p>
                </div>
            </div>


            <!-- Action Modal -->
            <div class="modal" id="actionModal">
                <div class="modal-content">
                    <!-- Buttons to open modals -->
                </div>
            </div>

            <!-- Reusable Modal -->
            <div class="login-modal" id="dynamicModal">
                <div class="login-modal-content">
                    <span class="close-modal" onclick="closeModals()">&times;</span>
                    <h3 id="modalTitle"></h3>
                    <p id="modalMessage"></p>
                    <button class="btn" id="confirmButton">Yes</button>
                </div>
            </div>
            <!-- invite admin -->


        </section>

        {{--stop here--}}
    </div>

</div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Open invite modal
        document.getElementById("openInviteModalButton").addEventListener("click", function () {
            document.getElementById("inviteAdminModal").style.display = "flex"; // Change to flex
        });

        // Close invite modal
        document.getElementById("closeInviteModal").addEventListener("click", function () {
            document.getElementById("inviteAdminModal").style.display = "none";
        });

        // Close success modal
        document.getElementById("sentCloseModal").addEventListener("click", function () {
            document.getElementById("sentModal").style.display = "none";
        });

        // Handle Invite API Call
        document.getElementById("inviteButton").addEventListener("click", function () {
            var language = document.getElementById("language").value;


            fetch('/createlanguage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                },
                body: JSON.stringify({
                    language: language,

                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Server Response:", data);
                    if (data.success) {
                        alert('Language created successfully!');

                        // Hide invite modal and show success modal
                        document.getElementById("inviteAdminModal").style.display = "none";
                        document.getElementById("sentModal").style.display = "flex";
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>

<script src="js/adminscripts.js"></script>

</html>




