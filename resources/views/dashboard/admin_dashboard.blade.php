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
                <div>
                    <a href="" class="href_black">
                        <span>Total Users</span>
                        <p>{{ $userCount }}</p> <!-- Dynamically display user count -->
                    </a>
                </div>

                <div><a href="" class="href_black">
                        <span>Total Language</span>
                        <p>{{$totalLanguage}}</p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Language Transcribed</span>
                        <p>{{$uniqueTranscribedLanguages}} </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Pending review</span>
                        <p>{{$pendingReviews}} </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Total Transcription</span>
                        <p>{{$totalTranscriptions}} </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Total Recording</span>
                        <p>{{$totalSpeak}} </p>
                    </a>
                </div>
                <div><a href="" class="href_black">
                        <span>Total Submission</span>
                        <p>{{$totalTranscriptions}}  </p>
                    </a>
                </div>
            </div>
        </section>

        <section class="section4">
            <div class="section4content">
                <div class="section4content1" >
                    <div class="section4div">
                        <p>User activity metric</p>
                        <select name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="transcriptionChart"></canvas>
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
                        <canvas id="contributionChart" width="370" height="200"></canvas>
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
                            <p>Approved {{$approvedPercentage}}% <span style="color: red">Rejection </span> {{$rejectedPercentage}}%</p>
                        </div>
                        <select name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="chart-container">
{{--                        <canvas id="transcriptionChartpie"></canvas>--}}
                        <canvas id="qualityChart" width="370" height="200"></canvas>

                    </div>



                </div>
                <div class="section4content1">
                    <div class="section4div">
                        <div  class="section4div2">

                            <p>Reviewer Activity</p>
                        </div>
                        <select name="" id="indexselect">
                            <option value="" >Filter</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="reviewerChart"></canvas>
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
                                            <button onclick="exportTableToCSV()">
                                                <i class="iconsax" icon-name="document-download"></i> Download CSV
                                            </button>

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

                    @forelse ($transcribedLanguages as $transcribedLanguage)
                        <tr>
                            <td>{{ $transcribedLanguage['language'] }}</td>
                            <td>{{ $transcribedLanguage['user_count'] }}</td>
                            <td>{{ $transcribedLanguage['total_hours'] }}</td>
                            <td>{{ $transcribedLanguage['total_transcriptions'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No results found</td>
                        </tr>
                    @endforelse

                    </tbody>
{{--                    <tfoot>--}}
{{--                    <tr>--}}
{{--                        <td colspan="4">--}}
{{--                            {{ $languages->appends(request()->query())->links() }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    </tfoot>--}}
                </table>
            </div>
            <!-- Transcribers Table -->
        </div>

    </div>


</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let ctx = document.getElementById('transcriptionChart').getContext('2d');
        let transcriptionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months->pluck('label')), // ["Jan", "Feb", "Mar", ...]
                datasets: [{
                    label: 'Monthly Transcriptions',
                    data: @json($months->pluck('total')), // [10, 50, 20, 80, ...]
                    borderColor: 'red',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3, // Smooth curve
                    pointRadius: 5,
                    pointBackgroundColor: 'blue',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });
    });


    // pie chart

        var ctx = document.getElementById('qualityChart').getContext('2d');
        var qualityChart = new Chart(ctx, {
        type: 'pie',
        data: {
        labels: ['Bad', 'Fair', 'Good', 'Excellent'],
        datasets: [{
        data: [{{ $badPercentage }}, {{ $fairPercentage }}, {{ $goodPercentage }}, {{ $excellentPercentage }}],
        backgroundColor: ['#FF5733', '#FFC300', '#36A2EB', '#4CAF50']
    }]
    }
    });

    var ctx = document.getElementById('reviewerChart').getContext('2d');
    var reviewerChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Rejected', 'Pending'],
            datasets: [{
                data: [{{ $approvedPercentage }}, {{ $rejectedPercentage }}, {{ $pendingPercentage }}],
                backgroundColor: ['#4CAF50', '#FF5733', '#36A2EB'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left'
                }
            }
        }
    });

    {{--const ctx = document.getElementById("contributionChart").getContext("2d");--}}

    {{--const languageData = {!! json_encode($languageApprovalData) !!}; // Pass data from PHP--}}

    {{--const labels = languageData.map(item => item.language);--}}
    {{--const approvedData = languageData.map(item => item.approved_percentage);--}}
    {{--const pendingRejectedData = languageData.map(item => item.pending_rejected_percentage);--}}

    {{--const chartData = {--}}
    {{--    labels: labels,--}}
    {{--    datasets: [--}}
    {{--        {--}}
    {{--            label: "Approved (%)",--}}
    {{--            backgroundColor: "rgba(54, 162, 235, 0.6)", // Blue--}}
    {{--            borderColor: "rgba(54, 162, 235, 1)",--}}
    {{--            borderWidth: 1,--}}
    {{--            data: approvedData--}}
    {{--        },--}}
    {{--        {--}}
    {{--            label: "Pending/Rejected (%)",--}}
    {{--            backgroundColor: "rgba(255, 99, 132, 0.6)", // Red--}}
    {{--            borderColor: "rgba(255, 99, 132, 1)",--}}
    {{--            borderWidth: 1,--}}
    {{--            data: pendingRejectedData--}}
    {{--        }--}}
    {{--    ]--}}
    {{--};--}}

    {{--const contributionChart = new Chart(ctx, {--}}
    {{--    type: "bar",--}}
    {{--    data: chartData,--}}
    {{--    options: {--}}
    {{--        responsive: true,--}}
    {{--        maintainAspectRatio: false,--}}
    {{--        scales: {--}}
    {{--            y: {--}}
    {{--                beginAtZero: true,--}}
    {{--                max: 100,--}}
    {{--                title: {--}}
    {{--                    display: true,--}}
    {{--                    text: "Percentage (%)"--}}
    {{--                }--}}
    {{--            },--}}
    {{--            x: {--}}
    {{--                title: {--}}
    {{--                    display: true,--}}
    {{--                    text: "Languages"--}}
    {{--                }--}}
    {{--            }--}}
    {{--        }--}}
    {{--    }--}}
    {{--});--}}

</script>

</html>

