<!DOCTYPE html>
<html lang="en">
<base href="/">
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
    <div class="sidebar">
        <p><span>L</span>inguaSpan</p>
{{--        <i class="iconsax" icon-name="nut"></i>--}}
        <ul>
            <li ><a href="{{url('admindashboard')}}" id="active" ><i class="iconsax" icon-name="home-1"></i> Dashboard</a></li>
            <li><a href="{{url('role')}}"><i class="iconsax" icon-name="document-text-2"></i> Roles $ Permissions</a></li>
            <li><a href="{{('usermanagement')}}"><i class="iconsax" icon-name="user-2"></i> User Mgt</a></li>
            <li><a href="{{url('transcriptionmanagement')}}"><i class="iconsax" icon-name="clipboard-tick"></i>Transcription Mgt</a></li>
            <li><a href="{{url('languagemanagement')}}"><i class="iconsax" icon-name="receipt"></i> Language Mgt</a></li>
            <li><a href="{{'rewardmanagement'}}"><i class="iconsax" icon-name="award-3"></i> Reward Mgt</a></li>
            <li><a href="{{'settingsmanagement'}}"><i class="iconsax" icon-name="setting-1"></i> Settings Mgt</a></li>
            <li><a href="{{'logout'}}"><i class="iconsax" icon-name="logout-2"></i> Logout</a></li>

        </ul>
    </div>
    <div class="content">
        <section class="navbar">
            <div>
                <ul class="dashboard-navbar">
                    <li> <img src="adminimg/img.jpg" alt="" width="20px" height="20px" style="border-radius: 50%;   box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
"></li>
                    <li><div style="position: relative; display: inline-block;">
                            <i class="iconsax" icon-name="bell-1" style="font-size: 20px; color: #333;"></i>
                            <span style="position: absolute; top: -8px; right: -8px; background-color: red; color: white; font-size: 12px; padding: 2px 6px; border-radius: 50%;">3</span>
                        </div></li>
                    <li> <i class="iconsax" icon-name="nut" style="font-size: 20px; color: #333;"></i>

                    </li>
                </ul>
            </div>

        </section>
        <h3>Dashboard</h3>
        <section>
            <div class="dashboard-card">
                <div><a href="{{url("permission")}}"  class="href_black">
                        <span>Total user</span>
                        <p>15</p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Total Language</span>
                        <p>15</p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Language Transcribed</span>
                        <p>15 </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Pending review</span>
                        <p>15 </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Total Transcription</span>
                        <p>15 </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Total Recording</span>
                        <p>15 </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Total Submission</span>
                        <p>15 </p>
                    </a>
                </div>
            </div>
        </section>

        <section class="section4">
            <div class="section4content">
                <div class="section4content1" >
                    <div class="section4div">
                        <p> Voices Online Now <br> 20</p>
                        <select name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="barChart" width="370" height="200"></canvas>
                    </div>

                </div>
                <div class="section4content1">
                    <div class="section4div">
{{--                        <div  class="section4div2">--}}
                            <div  class="">
                            <p>   Contributions/Language</p>
                            <p>   * Transcription  * Recordings</p>
                        </div>
                        <select name="" id="indexselect">
                            <option value="" >Filter</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="lineGraph" width="370" height="200"></canvas>
                    </div>
                </div>
            </div>

        </section>

        <section class="section4">
            <div class="section4content">
                <div class="section4content1" >
                    <div class="section4div">
                        <div>
                            <p>Approval/Rejection/Quality ratings</p>
                            <p>Approved 45% Rejection 45%</p>
                        </div>
                        <select name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="barChart" width="370" height="200"></canvas>
                    </div>

                </div>
                <div class="section4content1">
                    <div class="section4div">
                        <div  class="section4div2">
                            <p>User activity metric</p>
                        </div>
                        <select name="" id="indexselect">
                            <option value="" >Filter</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="lineGraph" width="370" height="200"></canvas>
                    </div>
                </div>
            </div>

        </section>

        <div id="tables-container">
            <!-- General Users Table -->
            <div class="table-content" data-category="general">
                <table class="user-mgt-table">

                    <thead>
                    <tr>
                        <td colspan="4" >
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
                        <th>Language</th>
                        <th>No. of Transmission</th>
                        <th>Hours Transcribed </th>
                        <th>Users</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>02/12/2024</td>
                        <td>Admin</td>
                        <td>Active</td>
                    </tr>
{{--                    @forelse ($users as $user)--}}
{{--                        <tr>--}}
{{--                            <td>{{ ucfirst($user->language) }}</td>--}}
{{--                            <td>{{$user->nationality}}</td>--}}
{{--                            <td>{{ $user->hours }}</td>--}}
{{--                            <td>{{ ($user->user) }}</td>--}}
{{--                            --}}{{--                            <td>--}}
{{--                            --}}{{--                                <a href="{{ route('user.edit', $user->id) }}">Edit</a> |--}}
{{--                            --}}{{--                                <form action="{{ route('user.delete', $user->id) }}" method="POST" style="display:inline;">--}}
{{--                            --}}{{--                                    @csrf--}}
{{--                            --}}{{--                                    @method('DELETE')--}}
{{--                            --}}{{--                                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>--}}
{{--                            --}}{{--                                </form>--}}
{{--                            --}}{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @empty--}}
{{--                        <tr>--}}
{{--                            <td colspan="7">No results found</td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4">
{{--                            {{ $users->appends(request()->query())->links() }}--}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- Transcribers Table -->
        </div>

    </div>


</div>
</body>
</html>

