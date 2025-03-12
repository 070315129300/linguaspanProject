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
                    <h3>Reward Management</h3>
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
                        <td colspan="7" >
                            <div class="">
                                <form method="GET" action="{{ route('admin.transcriptionmanagement') }}">
                                    <div class="table-header">
                                        <div class="table-header-right">
                                            <!-- Search Box -->
                                            <input type="search" name="search" placeholder="Search" value="{{ request('search') }}">
                                        </div>
                                        <div class="table-header-right">
                                            <!-- Submit Button -->
                                            <button type="submit"><i class="iconsax" icon-name="document-download"></i> download</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>FullName</th>
                        <th>Profession</th>
                        <th>Nationality</th>
                        <th>Hours Transcribed</th>
                        <th>Reward points</th>
                        <th style="text-align: center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>02/12/2024</td>
                        <td>Active</td>
                        <td>Edit | Delete</td>
                        <td>Active</td>
                        <td onclick="ActionModal(event)"
                            class="action-buttons"
                            {{--                            data-user-id="{{ $user->id }}"--}}
                            {{--                            data-full-name="{{ $user->fullName }}"--}}
                        >
                            <i class="iconsax" icon-name="menu-meatballs"></i>
                        </td>
                    </tr>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->fullName }}</td>
                            <td>{{ $user->profession }}</td>
                            <td>{{$user->nationality}}</td>
                            <td>{{ $user->hours }}</td>
                            <td>{{ ($user->rewardPoint) }}</td>
                            <td onclick="ActionModal(event)"
                                class="action-buttons"
                                data-user-id="{{ $user->id }}"
                                data-full-name="{{ $user->fullName }}"
                                data-page="reward"> <!-- Add this -->
                                <i class="iconsax" icon-name="menu-meatballs"></i>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No results found</td>
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




        <!-- Modals -->
        <div class="modal" id="actionModal">
            <div class="modal-content">
                <p onclick="openModals('loginModal')">Send Reward</p>
            </div>
        </div>

        <div class="login-modal" id="loginModal">
            <div class="login-modal-content">
                <span class="close-modal" id="closeModal">&times;</span>
                <h3>Reward Sent</h3>
                <p>reward will be sent to users email</p>
                <img src="img/img.jpg" alt="" width="100px"><br>
                <button class="btn permission-button" > Invite </button>
            </div>
        </div>

        {{--stop here--}}
    </div>

</div>
</body>
<script src="js/adminscripts.js"></script>

</html>





