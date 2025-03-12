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
            <div class="section-role-header">
                <h3>Roles $ Permissions</h3>
                <!-- Button to Open Invite Admin Modal -->
                <div><button class="permission-button" id="openInviteModalButton">Invite Admin</button></div>
            </div>

            <div class="dashboard-role-card">
                <div><a href="{{url("permission")}}" class="href_black">
                    <p>Admin</p>
                    <span>151 permissions</span>
                    </a>
                    <i class="iconsax" icon-name="chevron-right" style="font-size: 20px;"></i>
                </div>
                <div><a href="" class="href_black">
                    <p>Moderator</p>
                    <span>15 permissions</span>
                    </a>
                    <i class="iconsax" icon-name="chevron-right" style="font-size: 20px;"></i>
                </div>
                <div><a href="" class="href_black">
                    <p>Transcriber</p>
                    <span>15 permissions</span>
                    </a>
                    <i class="iconsax" icon-name="chevron-right" style="font-size: 20px;"></i>
                </div>
                <div><a href="" class="href_black">
                    <p>Viewers</p>
                    <span>15 permissions</span>
                    </a>
                    <i class="iconsax" icon-name="chevron-right" style="font-size: 20px;"></i>
                </div>
            </div>
        </section>
        <br>
        <div>
            <h3>Admins</h3>

        </div>

        <div class="table-contents" data-category="transcribers" >
            <table class="user-mgt-table">
                <thead>
                <tr>
                    <td colspan="4" >
                        <div class="table-header">
                            <div class="table-header-right">
                                <input type="search" placeholder="search">
{{--                                <i class="iconsax" icon-name="search-normal-2"></i>--}}

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
                    <th>Name</th>
                    <th>Role</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user )
                    <tr>

                        <td>{{ $user->fullName }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td style="text-align: center">{{ $user->status ?? 'Unknown' }}</td>
                        <td onclick="ActionModal(event)"
                            class="action-buttons"
                            data-user-id="{{ $user->id }}"
                            data-full-name="{{ $user->fullName }}"
                            data-page="roles"> <!-- Add this -->
                            <i class="iconsax" icon-name="menu-meatballs"></i>
                        </td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">
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
{{--                        {{ $users->appends(request()->query())->links() }}--}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>


        <section>
            <!-- invite admin Modal -->
            <div class="login-modal" id="inviteAdminModal" >
                <div class="login-modal-content">
                    <span class="close-modal" id="closeInviteModal">&times;</span>
                    <h3>Invite Admin</h3>
                    <input type="text" id="fullname" placeholder="fullname"><br>
                    <select id="userType">
                        <option value="">Select user type</option>
                        <option value="admin">Admin</option>
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
                <div class="modal-content">

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

        </section>
    </div>

</div>
</body>
<script src="js/adminscripts.js"></script>


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
                        alert('Admin invited successfully!');

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

</html>
