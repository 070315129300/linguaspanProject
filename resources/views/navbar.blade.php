<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lingua Span</title>
    <link rel="stylesheet" href="css/styles.css">
    {{--        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">--}}
    {{--        <link rel="preconnect" href="https://fonts.googleapis.com">--}}
    {{--        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
    {{--        <link rel="stylesheet" href="https://fonts.googlepis.com/css2?family=Permanent+M--}}
    {{--        arker&family=Poppins:wght@300;400;600;700;800;900display=swap">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="https://iconsax.gitlab.io/i/icons.css" rel="stylesheet">


</head>
<body>
<section class='fullbackground'>
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
                            <img src="img/ai-robot1.png" alt="">
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
                            <img src="img/ai-robot1.png" alt="">
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
