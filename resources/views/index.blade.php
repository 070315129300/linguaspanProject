<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
{{--        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">--}}
{{--        <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--        <link rel="stylesheet" href="https://fonts.googlepis.com/css2?family=Permanent+M--}}
{{--        arker&family=Poppins:wght@300;400;600;700;800;900display=swap">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">--}}

</head>
<body>
<section class="backgroundcolor">
<header>
   <h3> <a href="/" class="logo"><span>L</span>inguaSpan</a></h3>
    <ul class="navlist">
        <li><a href="">CONTRIBUTE<i class="fa fa-caret-down"></i></a>
            <ul class="dropdown">
                <li class="navlist-voice-collection">Voice Collection</li>
                <li><a href="{{url('contribute')}}"><img src="img/microphone.png" alt=""></i> Speak</a> <hr></li>
                <li><a href="{{url('listen')}}"><img src="img/sound4.png" alt=""> Listen</a> </li>
                <li class="navlist-sentence-collection">Sentence Collection</li>
                <li><a href="{{url('write')}}"><img src="img/message-edit.png" alt=""> Write</a><hr></li>
                <li><a href="{{url('review')}}"><img src="img/firstline.png" alt=""> Review</a></li>
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
                <a href="" style="color: white">
                    <img src="img/ai-robot1.png" alt=""> IP <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown">
                    <li><a href="{{url('stats')}}"><img src="img/dashboard.png" alt="" > Dashboard</a><hr></li>
                    <li><a href="{{url('profiles')}}"><img src="img/profile-add.png" alt=""> Profile</a></li>
                    <!-- Logout option with form for security -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">
                                <img src="img/logout.png" alt=""> Logout
                            </button>
                        </form>
                    </li>
                    <li style="font-size: 12px;font-weight: bold"><img src="img/profile-add.png" alt=""> {{ Auth::user()->name }}</li>
                </ul>
            </li>

    @else
        <!-- If not logged in, show dropdown with Sign In option -->
            <li id="ip-profile">
                <a href="" style="color: white">
                    <img src="img/ai-robot1.png" alt=""> IP <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown">
                    <li><a href="{{url('stats')}}"><img src="img/dashboard.png" alt=""> Dashboard</a><hr></li>
                    <li><a href="{{url('profiles')}}"><img src="img/profile-add.png" alt=""> Profile</a></li>
                    <li><a href="{{ route('login') }}"><img src="img/logout.png" alt=""> Sign In</a></li>
                </ul>
            </li>
        @endauth
        <li id="navlist-en"><a href="">EN</a></li>
    </ul>
    <div  id="menu-icon" class="menu-icon"><i class="fas fa-bars"></i></div>
    <div class="dropdownsidebar ">
        <li id="ip-profile">
            <a href="" style="color: white">
                <img src="img/ai-robot1.png" alt=""> IP
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
        <li id="navlist-en"><a href="">EN</a></li>

    </div>
</header>

       {{-- <section class="section1">
           <h1> We help <span>teach machines</span> how<br>You <img src="img/image1.png" alt=""> people speak</h1>
           <br>

           <img src="img/Subtract.png" alt=""  id="section1subtractimg">
           <div>
               <a href="" class="" style="margin-top: -600px;margin-left:180px;"> <img src="img/component2.png" alt="" width="70px">
                   <p> "Write"
                       <br> Select write to start <br> contributing to our <br> open data collection
                   </p>
               </a>
               <a href="" style="margin-top: -750px; margin-left:70px;"><img src="img/component4.png" alt="" width="70px">
                   <p> "Speak" <br> Select speak to start<br> contributing to our<br> open data collection
                   </p>
               </a>
               <a href="" style="margin-top: -750px; margin-right:70px;"><img src="img/component3.png" alt="" width="70px">
                   <p> "Listen" <br> Select listen to start<br> contributing to our <br>open data collection
                   </p>
               </a>
               <a href="" style="margin-top: -600px;margin-right:180px;"><img src="img/component1.png" alt="" width="70px">
                   <p> "Review" <br> Select review to start<br> contributing to our<br> open data collection
                   </p>
               </a>
           </div>

           <div class="section1img">
               <img src="img/image2.png" alt=""  id="section1subtractimg1">
           </div>
       </section> --}}

       <section class="sectionA">
         <div class="section-title"> We help teach <span class="title-family"> machines</span> how</div>
         <div class="section-image">You <img src="img/image1.png" class="africa" alt=""> people speak</div>
           <br>

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
                        <div class="tab-body">
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
                   <p>The Voice is an Initiative to help <br>teach machines how real people <br> speak. <br></p>

                   <div class="section3img">
                       <div class="componentimg">
                           <a href="{{url('contribute')}}">
                               <img src="img/component1.png" alt="Component 1">
                           </a> <br>
                           <a href="{{url('listen')}}">
                               <img src="img/component3.png" alt="Component 1">
                           </a> <br>
                           <a href="{{url('write')}}">
                               <img src="img/component2.png" alt="Component 1">
                           </a> <br>
                           <a href="{{url('review')}}">
                               <img src="img/component.png" alt="Component 1">
                           </a><br>
                       </div>
                       <div class="section3backgroundimg">
                           <img src="img/ai-robot.png" alt="">
                       </div>
                   </div>
               </div>
                <div class="section3div2">
                    <p>
                        Voice is natural, voice is human. That's why <br>
                        we're excited about creating usable voice <br> technology for our machines. But to create voice <br>
                        systems, developers need an extremely large <br> amount of voice data.
                        <br> <br>
                    </p>
                    <p>
                        Most of the data used by large companies isn't <br> available to the majority of people. We think
                        <br> that stifles innovation. So we've launched <br> Common <span>Learn More</span>
                    </p>
                </div>
            </div>
        </section>

        <section class="section4">
            <div class="section4content">
                <div class="section4content1" >
                   <div class="section4div">
                       <p> Voices Online Now <br> 20</p>
                       <select name="" id="">
                           <option value="">All languages</option>
                       </select>
                   </div>
                    <div class="chart-container">
                        <canvas id="barChart" width="370" height="200"></canvas>
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
                        <canvas id="lineGraph" width="370" height="200"></canvas>
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
                            <img src="img/component4.png" alt="" height="150px" width="150px">
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
    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['17:00', '18:00', '19:00', '20:00', '21:00', '22:00','23:00','00:00', '01:00','02:00','03:00'],
            datasets: [{
                label: 'Sales',
                data: [0, 20, 40, 60],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Line Graph
    const lineCtx = document.getElementById('lineGraph').getContext('2d');
    const lineGraph = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['1yr', '9mo', '6mo', '3mo', 'today'],
            datasets: [{
                label: 'Revenue',
                data: [15, 25, 20, 35, 45, 60],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

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
</script>
</body>
</html>
