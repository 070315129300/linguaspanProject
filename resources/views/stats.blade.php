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
           <p><span style="color: blue">6</span>/ 45 Clips you've Recorded</p><br>
           <img src="img/component4.png" alt=""><br>
           <p>62,000/ 1200 <span>Today's Common Voice progress on clips recorded</span></p>
       </div>
        <div class="section-stats-main">
            <p><span  style="color: red">6</span>/ 45 Clips you've Validated</p><br>
            <img src="img/component3.png" alt=""><br>
            <p>62,000/ 1200 <span>Today's Common Voice progress on clips recorded</span></p>

        </div>
    </div>
    <div class="section-stats-head">
       <div class="section-stats-main">
           <div class="section-stats-head ">
               <p>Contribution activity <br> <span style="color: red">you</span> <span>Everyone</span></p>
               <select>
                   <option value="">All Language</option>
               </select>
           </div>
           <div class="chart-container">
               <canvas id="barChart" width="370" height="200"></canvas>
           </div>
       </div>
        <div class="section-stats-main">
            <div class="section-stats-head">
                <p>Top Contributors <span style="color: red"> <br>Recorded clips</span> <span>Validated clips</span></p>
                <select name="" id="">
                    <option value="">All Language</option>
                </select>
            </div>
            <p class="section-stat-lineheight">01 <span>1</span> George Musa </p>
            <hr>
            <p class="section-stat-lineheight">02 <span>2</span> George Musa </p>
            <hr>
            <p class="section-stat-lineheight">03 <span>2</span> George Musa </p>
            <hr>
            <p class="section-stat-lineheight">04 <span>4</span> George Musa </p>
            <hr>
            <p class="section-stat-lineheight">05 <span>5</span> George Musa </p>
            <hr>

        </div>
    </div>

</section>

@include('footer')
