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
                        <h3>User Management</h3>
                        <ul id="user-categories" style="display: flex">
                            <li data-category="general" onclick="showTable('general')">General Users</li>
{{--                            <li data-category="transcribers" onclick="showTable('transcribers')">Transcribers</li>--}}
{{--                            <li data-category="translators" onclick="showTable('translators')">Translators</li>--}}
                        </ul>
                    </div>
                    <div><button class="permission-button" onclick="openModals('loginModal')">Add user</button></div>

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
                                            <button type="submit"><i class="iconsax" icon-name="document-download"></i> download</button>
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
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
{{--                            <td>{{ $loop->iteration }}</td>--}}
                            <td>{{ $user->fullName }}</td>
                            <td>{{ $user->language }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->status ?? 'Unknown' }}</td>
                            <td onclick="ActionModal(event)"
                                class="action-buttons"
                                data-user-id="{{ $user->id }}"
                                data-full-name="{{ $user->fullName }}">
                                <i class="iconsax" icon-name="menu-meatballs"></i>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            {{ $users->appends(request()->query())->links() }}

                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        <!-- Modals -->
        <section>
            <!-- Login Modal -->
            <div class="login-modal" id="loginModal">
                <div class="login-modal-content">
                    <span class="close-modal" id="closeModal">&times;</span>
                    <h3>Add user</h3>
                    <input type="text" placeholder="fullname"><br>
                    <select name="" id="">
                        <option value="">Select user type</option>
                        <option value="">Admin</option>
                        <option value="">User</option>
                        <option value="">Moderator</option>
                        <option value="">Transcriber</option>
                    </select>
                    <input type="text" placeholder="email"><br>
                    <button class="btn permission-button" onclick="openModals('sentModal')"> Invite </button>
                </div>
            </div>

            <!-- Action Modal -->
            <div class="modal" id="actionModal">
                <div class="modal-content">
                    <!-- Buttons to open modals -->
                    <p class="" onclick="openModal('approve', '{{ $user->id }}', '{{ $user->fullName }}')">Suspend {{ $user->fullName }}</p>
                    <p onclick="openModal('delete', '{{ $user->id }}', '{{ $user->fullName }}')">View More  {{ $user->fullName }}</p>
                    <p onclick="openModal('assign-role', '{{ $user->id }}', '{{ $user->fullName }}')">Assign Role</p>
                    <p onclick="openModal('activate-admin', '{{ $user->id }}', '{{ $user->fullName }}')">Deactivate {{ $user->fullName }}</p>
                    <p onclick="openModal('activate-admin', '{{ $user->id }}', '{{ $user->fullName }}')">Reset Password {{ $user->fullName }}</p>

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
            <div class="login-modal" id="sentModal">
                <div class="login-modal-content">
                    <span class="close-modal" id="sentcloseModal">&times;</span>
                    <h3>Invitation sent</h3>
                    <p>An invite has been <br>sent to your mail</p>
                    <p><i class="fa fa-message"></i></p>
                    <button class="btn"> Check Mail</button>
                </div>
            </div>

        </section>

{{--stop here--}}
    </div>

</div>
</body>
<script>
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

</script>
<script>
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
</script>

<script>
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', () => {
            document.getElementById('filter-form').submit();
        });
    });
</script>
<script src="js/adminscripts.js"></script>

</html>




