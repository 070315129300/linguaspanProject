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
                    <h3>Notification Management</h3>
                </div>
                {{--                <div><button class="permission-button" onclick="openModal('addPermissionModal')">set Quality Threshold</button></div>--}}
            </div>
        </section>
        <secton class='style' style="background: white">
            <div style="background: white">
                <br>
            <div class="settingsdiv">
                <p>
                    Send Filter By
                </p>

                <select name="" id="">
                    <option value="">occupation</option>
                </select>

                <select name="" id="">
                    <option value="">language</option>
                </select>
            </div>
            <hr>
            <div class="settingsdiv1">
                <p>Transcriber can now earn get reward by point as they transcribe on the platform</p>
                <span>02 jan 2025, 04:23am</span>
            </div>
            <div>
                <textarea rows="4" cols="50" placeholder="Enter your message"></textarea><br>
                <button class="permission-button">Send Message</button>
            </div>
            </div>
        </secton>

    </div>

</div>
</body>

</html>





