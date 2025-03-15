<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lingua Span</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">
</head>
<body>
<section class="backgroundcolor" style=" background-image: url('{{ asset("img/webHero.png") }}');">
<header>
   <h3> <a href="/" class="logo"><span>L</span>inguaSpan</a></h3>
    <ul class="navlist">
        <li><a href="">CONTRIBUTE <i class="iconsax" icon-name="chevron-down" style="font-size: 20px"></i></a>
            <ul class="dropdown">
                <li><p class="navlist-voice-collection">Voice Collection</p></li>
                <li ><a href="{{url('contribute')}}"><i class="iconsax" icon-name="mic-1" style="font-size: 15px"></i> Speak</a></li> <hr>
                <li><a href="{{url('listen')}}"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i>Listen </a> </li>
                <li ><p class="navlist-sentence-collection">Sentence Collection</p></li>
                <li><a href="{{url('write')}}"><i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i> Write</a></li><hr>
                <li><a href="{{url('review')}}"><i class="iconsax" icon-name="first-character" style="font-size: 15px"></i> Review</a></li>
            </ul></li>
        <li><a href="{{url('language')}}">LANGUAGES</a></li>
        <li><a href="{{url('about')}}">ABOUT</a></li>
    </ul>
{{--    <ul class="navprofile">--}}
{{--        <li{{Auth: username}}</li>--}}
{{--        <li id="ip-profile" ><a href="" style="color: white"><img src="img/ai-robot1.png" alt=""> IP <i class="fa fa-caret-down"></i></a>--}}
{{--            <ul class="dropdown" >--}}
{{--                <li ><a href=""><img src="img/dashboard.png" alt=""> Dashboard</a>--}}
{{--                    <hr></li>--}}
{{--                <li><a href=""><img src="img/profile-add.png" alt=""> Profile</a></li>--}}
{{--                <li><a href="{{ route('login') }}"><img src="img/logout.png" alt=""> sign in</a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}
{{--        <li id="navlist-en"><a href="">EN</a></li>--}}
{{--    </ul>--}


    {{--    <div class="bx bx-menu" id="menu-icon"></div>--}}
    <ul class="navprofile">
    @auth
        <!-- Display user's name when authenticated -->

            <li id="ip-profile">
                <div>
                    <a href="" style="color: white">

                        <p> IP </p>
                        <p><i class="iconsax" icon-name="chevron-down" style="font-size: 20px;"></i></p>
                    </a>
                </div>
                <ul class="dropdown">
                    <li ><a href="{{url('stats')}}" style="padding-left: 10px"><i class="iconsax" icon-name="keyboard-2" style="font-size: 20px;"></i> Dashboard</a><hr></li>
                    <li><a href="{{url('profiles')}}"><i class="iconsax" icon-name="user-1" style="font-size: 20px;"></i>Profile</a></li>
                    <!-- Logout option with form for security -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;padding-left: 10px">
                                <i class="iconsax" icon-name="logout-2" style="font-size: 20px;"></i> Logout
                            </button>
                        </form>
                    </li>
                    <li style="font-size: 12px;font-weight: bold; padding-left: 10px"><i class="iconsax" icon-name="user-1-tick" style="font-size: 20px;"></i> {{ Auth::user()->fullName }}</li>
                </ul>
            </li>

    @else
        <!-- If not logged in, show dropdown with Sign In option -->
            <li id="ip-profile">
                <div>
                <a href="" style="color: white">

                    <p> IP </p>
                   <p><i class="iconsax" icon-name="chevron-down" style="font-size: 20px;"></i></p>
                </a>
                </div>
                <ul class="dropdown">
                    <li ><a href="{{url('stats')}}" style="padding-left: 10px"><i class="iconsax" icon-name="keyboard-2" style="font-size: 20px;"></i> Dashboard</a><hr></li>
                    <li><a href="{{url('profiles')}}"><i class="iconsax" icon-name="user-1" style="font-size: 20px;"></i>Profile</a></li>
                    <li><a href="{{ route('login') }}"><i class="iconsax" icon-name="logout-2" style="font-size: 20px;"></i> Sign In</a></li>
                </ul>
            </li>
        @endauth
        <li><p style="margin-top: 50%" ><i class="iconsax" icon-name="bell-1"  style="font-size: 20px;color: #AFAFB0;"></i></p></li>
        <li id="navlist-en"><a href="">EN</a></li>

{{--    pause here--}}
    </ul>
    <div  id="menu-icon" class="menu-icon"><i class="fas fa-bars"></i></div>
    <div class="dropdownsidebar ">
        <li id="ip-profile">
            <a href="" style="color: white">
                <img src="img/ai-robot1.png" alt="">
            </a>
        </li>
{{--        <li><a href="">Contribute</a></li>--}}

                <li class="">Voice Collection</li>
                <li><a href="{{url('contribute')}}"><img src="img/microphone.png" alt="" width="15px" height="15px"></i> Speak</a></li>
                <li><a href="{{url('listen')}}"><img src="img/sound4.png" alt="" width="15px" height="15px"> Listen</a> </li>
                <li class="">Sentence Collection</li>
                <li><a href="{{url('write')}}"><img src="img/message-edit.png" alt="" width="15px" height="15px"> Write</a></li>
                <li><a href="{{url('review')}}"><img src="img/firstline.png" alt="" width="15px" height="15px"> Review</a></li>


        <li><a href="{{url('language')}}">Languages</a></li>
        <li><a href="{{url('about')}}">About</a></li>
    @auth
        <!-- Display user's name when authenticated -->

                    <li><a href="{{url('stats')}}"><img src="img/dashboard.png" alt="" width="15px" height="15px"> Dashboard</a></li>
                    <li><a href="{{url('profiles')}}"><img src="img/profile-add.png" alt="" width="15px" height="15px"> Profile</a></li>
                    <!-- Logout option with form for security -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST" >
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">
                                <img src="img/logout.png" alt="" width="15px" height="15px"> Logout
                            </button>
                        </form>
                    </li>
                    <li style="font-size: 12px;font-weight: bold"><img src="img/profile-add.png" alt="" width="15px" height="15px"> {{ Auth::user()->name }}</li>
    @else
        <!-- If not logged in, show dropdown with Sign In option -->
                    <li><a href="{{url('login')}}"><img src="img/dashboard.png" alt="" width="15px" height="15px"> Dashboard</a></li>
                    <li><a href="{{url('login')}}"><img src="img/profile-add.png" alt="" width="15px" height="15px"> Profile</a></li>
                    <li><a href="{{ route('login') }}"><img src="img/logout.png" alt="" width="15px" height="15px"> Sign In</a></li>
        @endauth
        <li id="navlist-en"><a href=""><img src="img/frameEN" alt=""></a></li>

    </div>
</header>


    <br>
       <section class="sectionA">
         <div class="section-title"> We help teach <span class="title-family"> machines</span> how</div>
         <div class="section-image">African <img src="img/image1.png" class="africa" alt=""> people speak</div>
           <br><br><br>

           <div class="banner-items">
              <div class="inner-section">
                <img src="img/rounded-img.png" alt=""  class="line-img">
              </div>
              <div class="edit-tab">
                <div class="icon-tab">
                   <div class="icon-card">
                     <img src="img/edit.png" alt="">
                   </div>
                   <div class="icon-tab tab-toggle">
                     <div class="card-line"></div>
                    <div class="tab-content">
                        <h1>Write</h1>
                        <div class="tab-body">up
                            Select write to start contribution to our Open collection data
                        </div>
                    </div>
                   </div>
                </div>
              </div>
              <div class="edit-tabB">
                <div class="icon-tab">
                   <div class="icon-card">
                     <img src="img/microphone2.png" alt="">
                   </div>
                   <div class="icon-tab tab-toggle">
                     <div class="card-lineB"></div>
                    <div class="tab-contentB">
                        <h1>Write</h1>
                        <div class="tab-body">
                            Select write to start contribution to our Open collection data
                        </div>
                    </div>
                   </div>
                </div>
              </div>
              <div class="edit-tabC">
                <div class="icon-tab">
                   <div class="icon-card">
                     <img src="img/soundA.png" alt="">
                   </div>
                   <div class="icon-tab tab-toggle">
                     <div class="card-lineC"></div>
                    <div class="tab-contentC">
                        <h1>Write</h1>
                        <div class="tab-body">
                            Select write to start contribution to our Open collection data
                        </div>
                    </div>
                   </div>
                </div>
              </div>
              <div class="edit-tabD">
                <div class="icon-tab">
                   <div class="icon-card">
                     <img src="img/firstlineA.png" alt="">
                   </div>
                   <div class="icon-tab tab-toggle">
                     <div class="card-lineD"></div>
                    <div class="tab-contentD">
                        <h1>Write</h1>
                        <div class="tab-body">
                            Select write to start contribution to our Open collection data
                        </div>
                    </div>
                   </div>
                </div>
              </div>
           </div>

       </section>
</section>
        <section class="section2">
            <div class="section2img">
                <img  src="img/image.png" alt="">
                <img  src="img/image4.png" alt="">
                <p>Start speaking, listening, writing and reviewing numerous languages <br><br><span><a href="{{url('contribute')}}">join us</a></span></p>
                <img  src="img/image3.png" alt="">
                <img  src="img/image5.png" alt="">
            </div>
            <div class="section2words">
               <div class="section2imgword">
                   <img height="50px" width="50" src="img/sound.png" alt="">
                   <p>over 1 Million<br> Voices</p>
               </div>


                <div class="section2p">
                    <table>
                        <tr>
                            <td class="hoverable"><i class="fa-solid fa-microphone"></i><a href="{{url('contribute')}}"> speak</a></td>
                            <td class="hoverable"><i class="fa-solid fa-ear-listen"></i><a href="{{url('listen')}}"> listen</a></td>
                            <td class="hoverable"><i class="fa-regular fa-pen-to-square"></i><a href="{{url('write')}}"> write</a></td>
                            <td class="hoverable"><i class="fa-solid fa-book"></i><a href="{{url('review')}}"> review</a></td>
                        </tr>
                    </table>
                </div>

                <div class="section2imgword">
                    <img height="50px" width="50" src="img/sound1.png" alt="">
                    <p>over 1 Million<br>  Sentences</p>
                </div>
            </div>
        </section>

        <section class="section3">
            <div>
                <img height="30px" src="img/sound2.png" alt=""><br>
            </div>
            <div class="section3Content">
               <div class=" section3div">
                   <p>The Voice is an Initiative to help teach machines how real people speak. <br></p>

                   <div class="section3img">
{{--                       <div class="componentimg">--}}
{{--                           <br>--}}
{{--                           <a href="{{url('contribute')}}">--}}
{{--                               <img src="img/component1.png" alt="Component 1">--}}
{{--                           </a> <br>--}}
{{--                           <a href="{{url('listen')}}">--}}
{{--                               <img src="img/component3.png" alt="Component 1">--}}
{{--                           </a> <br>--}}
{{--                           <a href="{{url('write')}}">--}}
{{--                               <img src="img/component2.png" alt="Component 1">--}}
{{--                           </a> <br>--}}
{{--                           <a href="{{url('review')}}">--}}
{{--                               <img src="img/component.png" alt="Component 1">--}}
{{--                           </a><br>--}}
{{--                       </div>--}}
{{--                       <div class="section3backgroundimg">--}}
{{--                           <img src="img/ai-robot.png" alt="">--}}
{{--                       </div>--}}
                       <img src="img/Caleb.jpg" alt="" height="400px" width="400px">
                   </div>
               </div>
                <div class="section3div2">
                    <p>
                        Voice is natural, voice is human. That's why
                        we're excited about creating usable voice  technology for our machines. But to create voice
                        systems, developers need an extremely large  amount of voice data.
                        <br> <br>
                    </p>
                    <p>
                        Most of the data used by large companies isn't available to the majority of people. We think
                        that stifles innovation. So we've launched Common <span>Learn More</span>
                    </p>
                </div>
            </div>
        </section>

        <section class="section4">
            <div class="section4content">
                <div class="section4content1">
                    <div class="section4div">
                        <p>Voices Online Now <br> <span id="onlineCount">20</span></p>
                        <select id="languageSelect">
                            <option value="">All languages</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language }}">{{ ucfirst($language) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- HOURLY BAR CHART (For Today) -->
                    <div class="chart-container">
                        <canvas id="hourlyChart"></canvas>
                    </div>
                </div>
                <div class="section4content1">
                    <div class="section4div">
                       <div  class="section4div2">
                           <p>   Hours <br>Recorded <br> * 32 K</p>
                           <div class="border-vertical-lines"></div>
                           <p>   Hours <br>Validated <br> * 22 K</p>
                       </div>
                        <select name="" id="indexselect">
                            <option value="" >All languages</option>
                        </select>
                    </div>
                    <div class="chart-container">

                        <canvas id="transcriptionChart"></canvas>
                    </div>
                </div>
            </div>

        </section>

        <section class="section5">
            <div class="section5main">
                <div class="section5mainimg">
                    <img src="img/ai-brain.png" alt="" height="300px" width="400px">
                </div>
                <div class="section5content">
                    <div>
                        <p> Want to <br> donate <br> your <br> voice ?</p>
                    </div>
                    <div>
                        <a href="{{url('contribute')}}">

                            <img src="img/Component4.png" alt="" height="120px" width="150px">

                        </a>
                    </div>
                </div>
            </div>
            <div><img src="img/group.png" alt="" width="100%" height="100px"></div>
        </section>
    </main>
@include("footer")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="script.js"></script>
<script>
    // Bar Chart start her
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("hourlyChart").getContext("2d");

        // Get data directly from Laravel (No API call)
        const intervals = @json($intervals);
        const dailyTotalHoursData = @json($dailyTotalHoursData);

        // Ensure that even if no data exists, we show the X and Y axes
        const defaultData = dailyTotalHoursData.length ? dailyTotalHoursData : new Array(intervals.length).fill(0);

        // Render Chart
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: intervals,
                datasets: [{
                    label: "Hours Transcribed (Today)",
                    data: defaultData,
                    backgroundColor: "rgba(255, 99, 132, 0.6)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 5,
                        ticks: {
                            font: { size: 9 } // ✅ Set font size to 8px
                        }
                    },
                    x: {
                        grid: { display: true },
                        ticks: {
                            font: { size: 9 }
                        }
                    }
                }
            }
        });

        // Language filter (refresh page with selected language)
        document.getElementById("languageSelect").addEventListener("change", function () {
            window.location.href = "?stats=" + this.value;
        });
    });


    // bar chart end here
    // line graph start here
    document.addEventListener("DOMContentLoaded", function () {
        const months = @json($months);
        const totalHours = @json($totalHoursData);
        const approvedHours = @json($approvedHoursData);

        const ctx = document.getElementById('transcriptionChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Total Hours',
                        data: totalHours,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 0, 255, 0.1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Approved Hours',
                        data: approvedHours,
                        borderColor: 'red',
                        backgroundColor: 'rgba(255, 0, 0, 0.1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 9 } // ✅ Reduce Y-axis font size to 6px
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 9 } // ✅ Reduce X-axis font size to 6px
                        }
                    }
                }
            }
        });
    });

    // line graph end her

</script>
<script>
    const toggleBtn = document.querySelector('menu-icon')
    const toggleBtnIcon = document.querySelector('menu-icon i')
    const dropDownMenu = document.querySelector('dropdownsidebar')

    toggleBtn.onclick = function () {
        dropDownMenu.classList.toggle('open')
        const isOpen = dropDownMenu.classList.contains('open')

        toggleBtnIcon.classList = isOpen
        ? 'fas fa-bars'
            : 'fas fa-xmark'
    }

    document.addEventListener("DOMContentLoaded", function () {
        let contributeMenu = document.querySelector(".navlist li"); // The "CONTRIBUTE" li
        let dropdown = contributeMenu.querySelector(".dropdown"); // The dropdown inside

        let hideTimeout; // Timeout variable to delay hiding

        // Function to show the dropdown
        function showDropdown() {
            clearTimeout(hideTimeout); // Clear any hide delay
            contributeMenu.classList.add("show");
        }

        // Function to hide the dropdown with delay
        function hideDropdown() {
            hideTimeout = setTimeout(() => {
                contributeMenu.classList.remove("show");
            }, 30000); // Delay of 300ms
        }

        // Show dropdown on hover
        contributeMenu.addEventListener("mouseenter", showDropdown);
        dropdown.addEventListener("mouseenter", showDropdown);

        // Hide dropdown when mouse leaves (with delay)
        contributeMenu.addEventListener("mouseleave", hideDropdown);
        dropdown.addEventListener("mouseleave", hideDropdown);

        // Toggle dropdown on click
        contributeMenu.addEventListener("click", function (event) {
            event.stopPropagation();
            showDropdown();
        });

        // Hide when clicking outside
        document.addEventListener("click", function (event) {
            if (!contributeMenu.contains(event.target)) {
                contributeMenu.classList.remove("show");
            }
        });
    });

</script>
</body>
</html>
