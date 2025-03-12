<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_styles.css">
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
                        <h3>User Management</h3>
{{--                        <ul id="user-categories" style="display: flex">--}}
{{--                            <li data-category="general" onclick="showTable('general')">General Users</li>--}}
{{--                            <li data-category="transcribers" onclick="showTable('transcribers')">Transcribers</li>--}}
{{--                            <li data-category="translators" onclick="showTable('translators')">Translators</li>--}}
{{--                        </ul>--}}
                    </div>
{{--                    <div><button class="permission-button" onclick="openModals('loginModal')">Add user</button></div>--}}
                    <div><button class="permission-button" id="openInviteModalButton">Add user</button></div>

                </div>
        </section>
        <div id="tables-container">
            <!-- General Users Table -->
            <div class="table-content" data-category="general">
                <table class="user-mgt-table">

                    <thead>
                    <tr>
                        <td colspan="6">
                            <div class="">
                                <div class="table-header-right">
                                    <form method="GET" action="{{ route('admin.usermanagement') }}" id="filter-form" >
                                    <div class="table-header">
                                        <div>
                                            <input type="search" name="search" placeholder="Search" value="{{ request('search') }}" oninput="document.getElementById('filter-form').submit()">

                                        </div>
                                        <div class="section4div2">
                                            <span>Filter by</span>
                                            <select name="role" onchange="document.getElementById('filter-form').submit()">
                                                <option value="">Role</option>
                                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="viewer" {{ request('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
                                                <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                                <option value="transcriber" {{ request('role') == 'transcriber' ? 'selected' : '' }}>Transcriber</option>
                                            </select>
                                            <select name="status" onchange="document.getElementById('filter-form').submit()">
                                                <option value="">Status</option>
                                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            </select>
                                            <select name="language" onchange="document.getElementById('filter-form').submit()">
                                                <option value="">Language</option>
                                                <option value="english" {{ request('language') == 'english' ? 'selected' : '' }}>English</option>
                                                <option value="yoruba" {{ request('language') == 'yoruba' ? 'selected' : '' }}>Yoruba</option>
                                                <option value="hausa" {{ request('language') == 'hausa' ? 'selected' : '' }}>Hausa</option>
                                                <option value="igbo" {{ request('language') == 'igbo' ? 'selected' : '' }}>Igbo</option>
                                            </select>
                                            <button onclick="exportTableToCSV()">
                                                <i class="iconsax" icon-name="document-download"></i> Download CSV
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>User Name</th>
                        <th>Preferred Language</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="text-align: center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
{{--                            <td>{{ $loop->iteration }}</td>--}}
                            <td>{{ $user->fullName }}</td>
                            <td>{{ $user->favorite_language }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->status ?? 'Unknown' }}</td>
                            <td onclick="ActionModal(event)"
                                class="action-buttons"
                                data-user-id="{{ $user->id }}"
                                data-full-name="{{ $user->fullName }}"
                                data-page="users"> <!-- Add this -->
                                <i class="iconsax" icon-name="menu-meatballs"></i>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="pagination-container">
                                <!-- Left side: Showing the current page and total -->
                                <div class="pagination-info">
                                    {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }}
                                </div>

                                <!-- Middle: Page numbers -->
                                <div class="pagination-links">
                                    {{ $users->appends(request()->query())->links() }}
                                </div>

                                <!-- Right side: Previous & Next buttons -->
                                <div class="pagination-nav">
                                    @if ($users->onFirstPage())
                                        <span class="disabled"><i class="iconsax" icon-name="arrow-left" style="font-size: 15px;"></i> Previous</span>
                                    @else
                                        <a href="{{ $users->previousPageUrl() }}" class="pagination-btn"><i class="iconsax" icon-name="arrow-left" style="font-size: 15px;"></i> Previous</a>
                                    @endif

                                    @if ($users->hasMorePages())
                                        <a href="{{ $users->nextPageUrl() }}" class="pagination-btn">Next <i class="iconsax" icon-name="arrow-right" style="font-size: 15px;"></i></a>
                                    @else
                                        <span class="disabled">Next</span>
                                    @endif
                                </div>
                            </div>

                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        <!-- Modals -->
        <section>

            <div class="login-modal" id="inviteAdminModal" >
                <div class="login-modal-content">
                    <span class="close-modal" id="closeInviteModal">&times;</span>
                    <h3>Invite User</h3>
                    <input type="text" id="fullname" placeholder="fullname"><br>
                    <select id="userType">
                        <option value="">Select user type</option>
                        <option value="">User</option>
                        <option value="">Moderator</option>
                        <option value="">Transcriber</option>
                    </select>
                    <input type="text" id="email" placeholder="email"><br>
                    <button class="btn permission-button" id="inviteButton">Invite</button>
                </div>
            </div>

            <!-- Success Modal (Shown After Successful Invite) -->
            <div class="login-modal" id="sentModal" style="display: none;">
                <div class="login-modal-content">
                    <span class="close-modal" id="sentCloseModal">&times;</span>
                    <h3>Invitation sent</h3>
                    <p>An invite has been <br>sent to your mail</p>
                    <p><i class="fa fa-message"></i></p>
                    <button class="btn">Check Mail</button>
                </div>
            </div>
            <!-- Action Modal -->

            <div class="modal" id="actionModal">
                <div class="modal-content"></div> <!-- This will be populated dynamically -->
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
            var fullname = document.getElementById("fullname").value;
            var userType = document.getElementById("userType").value;
            var email = document.getElementById("email").value;

            fetch('/inviteadmin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                },
                body: JSON.stringify({
                    fullname: fullname,
                    user_type: userType,
                    email: email
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Server Response:", data);
                    if (data.success) {
                        alert('User invited successfully!');

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




