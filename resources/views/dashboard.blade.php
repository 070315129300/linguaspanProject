<!DOCTYPE html>
<html lang="en">
<base href="/">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
<div class="dashboard">
    <div class="sidebar">
        <h3>LinguaSpan</h3>
        <ul>
            <li><a href="{{url('admindashboard')}}"><img src="adminimg/home.png" alt="" > Dashboard</a></li>
            <li><a href="{{url('role')}}"><img src="adminimg/document.png" alt=""> Roles $ Permissions</a></li>
            <li><a href="{{('usermanagement')}}"><img src="adminimg/user.png" alt=""> User Mgt</a></li>
            <li><a href="{{url('transcriptionmanagement')}}"><img src="adminimg/clipboard.png" alt=""> Transcription Mgt</a></li>
            <li><a href="{{url('languagemanagement')}}"><img src="adminimg/receipt.png" alt=""> Language Mgt</a></li>
            <li><a href="#"><img src="adminimg/setting.png" alt=""> Settings Mgt</a></li>
            <li><a href="{{route('logout')}}"><img src="adminimg/logout.png" alt=""> Logout</a></li>

        </ul>
    </div>
    <div class="content">
        <section class="navbar">
            <div>
                <ul class="dashboard-navbar">
                    <li> <img src="adminimg/img.jpg" alt="" width="20px" height="20px" style="border-radius: 50%;   box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
"></li>
                    <li><div style="position: relative; display: inline-block;">
                            <i class="fas fa-bell" style="font-size: 20px; color: #333;"></i>
                            <span style="position: absolute; top: -8px; right: -8px; background-color: red; color: white; font-size: 12px; padding: 2px 6px; border-radius: 50%;">3</span>
                        </div></li>
                    <li><i class="fas fa-cog" style="font-size: 20px; color: #333;"></i>
                    </li>
                </ul>
            </div>

        </section>
        <h1>Welcome to the Admin Dashboard</h1>
        <p>This is where your content will be displayed.</p>
    </div>

</div>
</body>
</html>

