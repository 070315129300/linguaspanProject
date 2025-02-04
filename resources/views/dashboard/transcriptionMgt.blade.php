<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_styles.css">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">--}}
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
                    <h3>Transcription Management</h3>
                </div>
{{--                <div><button class="permission-button" onclick="openModal('addPermissionModal')">set Quality Threshold</button></div>--}}
            </div>
        </section>
        <div id="tables-container">
            <!-- General Users Table -->
            <div class="table-content" data-category="general">
                <table class="user-mgt-table">

                    <thead>
                    <tr>
                        <td colspan="9" >
                            <div class="">
                                <form method="GET" action="{{ route('admin.transcriptionmanagement') }}">
                                    <div class="table-header">
                                        <div class="table-header-right">
                                            <!-- Search Box -->
                                            <input type="search" name="search" placeholder="Search" value="{{ request('search') }}">
                                        </div>
                                        <div class="table-header-right section4div22">
{{--                                            <button style="color:red">Bulk Action</button>--}}
                                            <select name="" id="">
                                                <option value="">Bulk Action</option>
                                            </select>
                                            <!-- Filters -->
                                            <span>Filter by</span>

                                            <!-- Role Filter -->
                                            <select name="Quality Rating">
                                                <option value="">Role</option>
                                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                                            </select>

                                            <!-- Status Filter -->
                                            <select name="Date range">
                                                <option value="">Status</option>
                                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>

                                            <!-- Language Filter -->
                                            <select name="language">
                                                <option value="">Language</option>
                                                <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                                                <option value="Yoruba" {{ request('language') == 'Yoruba' ? 'selected' : '' }}>Yoruba</option>
                                                <option value="Hausa" {{ request('language') == 'Hausa' ? 'selected' : '' }}>Hausa</option>
                                                <option value="Igbo" {{ request('language') == 'Igbo' ? 'selected' : '' }}>Igbo</option>
                                            </select>

                                            <!-- Submit Button -->
                                            <button type="submit"><i class="iconsax" icon-name="document-download"></i> download</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Transcription Id</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Language</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Hours</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>John Doe</td>
                        <td>02/12/2024</td>
                        <td>Admin</td>
                        <td>Active</td>
                        <td>Edit | Delete</td>
                    </tr>
                    @forelse ($users as $user)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->date }}</td>
                            <td>{{ ucfirst($user->type) }}</td>
                            <td>{{ ucfirst($user->language) }}</td>
                            <td>{{ $user->userId }}</td>
                            <td>{{ ($user->rating) }}</td>
                            <td>{{ ($user->hours) }}</td>
                            <td onclick="ActionModal(event)" class="action-buttons"> ***</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No results found</td>
                        </tr>
                    @endforelse

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="9">
                            {{ $users->appends(request()->query())->links() }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- Transcribers Table -->
        </div>

        <!-- Action Modal -->
        <div class="modal" id="actionModal">
            <div class="modal-content">
                <!-- Buttons to open modals -->
                <p class="" onclick="openModal('approve', '{{ $user->id }}', '{{ $user->fullName }}')">Approve {{ $user->fullName }}</p>
                <p onclick="openModal('delete', '{{ $user->id }}', '{{ $user->fullName }}')">Reject  {{ $user->fullName }}</p>
                <p onclick="openModal('assign-role', '{{ $user->id }}', '{{ $user->fullName }}')">View & Edit</p>
                <p onclick="openModal('activate-admin', '{{ $user->id }}', '{{ $user->fullName }}')">flag {{ $user->fullName }}</p>

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

    </div>

</div>
</body>
<script src="js/adminscripts.js"></script>

</html>





