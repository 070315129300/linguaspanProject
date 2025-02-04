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
                    <h3>Language Management</h3>
                    <ul id="user-categories" style="display: flex">
                        <li data-category="general" onclick="showTable('general')">Transcription Languages</li>
                        <li data-category="transcribers" onclick="showTable('transcribers')">Transcribers Languages</li>
                    </ul>
                </div>
                <div><button class="permission-button" onclick="openModals('loginModal')">invite user</button></div>

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
                                    <button type="submit"><i class="iconsax" icon-name="document-download"></i> download</button>

                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Language</th>
                        <th>No. of. submissions</th>
                        <th>Priority Level</th>
                        <th>Language Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>john.doe@example.com</td>

                        <td>Active</td>
{{--                        <td onclick="ActionModal(event)" class="action-buttons"> ***</td>--}}
                        <td onclick="ActionModal(event)"
                            class="action-buttons"
{{--                            data-user-id="{{ $user->id }}"--}}
{{--                            data-full-name="{{ $user->fullName }}"--}}
                        >
                            <i class="iconsax" icon-name="menu-meatballs"></i>
                        </td>
                    </tr>


                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <button class="btn">next</button>

                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Transcribers Table -->
            <div class="table-content" data-category="transcribers" style="display: none;">
                <table class="user-mgt-table">
                    <thead>
                    <tr>
                        <td colspan="5" >
                            <div class="table-header">
                                <div class="table-header-right">
                                    <input type="search" placeholder="search">
                                </div>
                                <div class="table-header-right">
                                    <button type="submit"><i class="iconsax" icon-name="document-download"></i> download</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Translstion:From</th>
                        <th>To</th>
                        <th>Translation Rate</th>
                        <th>Translation Rate</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>John cayleb</td>
                        <td>john.doe@example.com</td>
                        <td>User</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>jane.smith@example.com</td>
                        <td>User</td>

                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            <button class="btn">next</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>




        <section>
            <!-- Login Modal -->
            <div class="login-modal" id="loginModal">
                <div class="login-modal-content">
                    <span class="close-modal" id="closeModal">&times;</span>
                    <h3>Invite Admin</h3>
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
                    <p class="" onclick="openModal('approve' )">Enable</p>
                    <p onclick="openModal('delete')">Disable </p>
                    <p onclick="openModal('assign-role')">Set Priority level</p>
                    <p onclick="openModal('activate-admin')">Delete </p>

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

<script src="js/adminscripts.js"></script>

</html>




