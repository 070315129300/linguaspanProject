@include('navbar')
<section class="stat-section">
    <div class="section-stats-head1">
        <h2>Stats</h2>
        <select>
            <option value="">All Language</option>
        </select>
    </div>
    <div class="section-stats-head">
       <div class="section-stats-main">
           <p style="float:left !important"><span style="color: blue;">{{$totalUserTranscriptions}}</span>/ 45 Clips you've Recorded</p><br>
           <img src="img/Component4.png" alt=""><br>
           <p>{{$totalTranscriptions}}/ 1200 <span> Today's Common Voice progress on clips recorded</span></p>
       </div>
        <div class="section-stats-main">
            <p style="float:left !important"><span  style="color: red">{{$totalUserApprovedTranscriptions}}</span>/ 45 Clips you've Validated</p><br>
            <img src="img/Component3.png" alt=""><br>
            <p>{{$totalApprovedTranscriptions}}/ 1200 <span> Today's Common Voice progress on clips recorded</span></p>

        </div>
    </div>
    <div class="section-stats-head">
       <div class="section-stats-main-div">
           <div class="section-stats-head1">
               <p>Contribution activity <br> <span style="color: red">You</span> <span>Everyone</span></p>
               <select id="languageSelect">
                   <option value="" {{ request('language') == '' ? 'selected' : '' }}>All languages</option>
                   @foreach ($languages as $language)
                       <option value="{{ $language }}" {{ request('language', '') == $language ? 'selected' : '' }}>
                           {{ ucfirst($language) }}
                       </option>
                   @endforeach
               </select>
           </div>
           <div class="chart-container" style="width: 100%; height: 400px;">
               <canvas id="hourlyChart"></canvas>
           </div>
       </div>

        <div class="section-stats-main-div">
            <div class="section-stats-head1">
                <p>Top Contributors <span class="recorded"> <br>Recorded clips</span> <span>Validated clips</span></p>
                <select name="" id="">
                    <option value="">All Languages</option>
                </select>
            </div>

            @foreach ($topContributors as $index => $contributor)
                <div class="contributor">
                    <span class="dot"></span>
                    <p>{{ sprintf('%02d', $index + 1) }} {{ $contributor->fullName }}</p>
                    <span class="count">{{ number_format($contributor->total_hours, 0, '.', ',') }}H</span>
                </div>
                @if (!$loop->last)  {{-- Add <hr> if it's not the last contributor --}}
                <hr>
                @endif
            @endforeach
        </div>
    </div>

</section>

@include('footer')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

        document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("hourlyChart").getContext("2d");

        // Get data from Laravel
        const intervals = @json($intervals);
        let dailyTotalHoursData = @json($dailyTotalHoursData);

        // Ensure the dataset is not empty (fill with 0s if necessary)
        if (dailyTotalHoursData.every(value => value === 0)) {
        dailyTotalHoursData = new Array(intervals.length).fill(0);
    }

        // Create Chart
        let chart = new Chart(ctx, {
        type: "bar",
        data: {
        labels: intervals,
        datasets: [{
        label: "Transcriptions (Today)",
        data: dailyTotalHoursData,
        backgroundColor: "rgba(54, 162, 235, 0.6)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 1
    }]
    },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
        y: {
        beginAtZero: true,
        suggestedMax: 5, // Ensures Y-axis has some range
        ticks: {
        stepSize: 1, // Ensures integer values
        font: { size: 9 }
    },
        grid: { display: true } // Ensures Y-axis is always visible
    },
        x: {
        grid: { display: true }, // Ensures X-axis gridlines are always visible
        ticks: {
        font: { size: 9 }
    }
    }
    }
    }
    });

        // Handle Language Selection
        document.getElementById('languageSelect').addEventListener('change', function () {
        const selectedLanguage = this.value;
        window.location.href = `{{ url('stats') }}?language=${selectedLanguage}`;
    });
    });
</script>



