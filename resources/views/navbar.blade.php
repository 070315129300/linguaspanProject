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
<section class='fullbackground'>
    <header>
        <h3> <a href="/" class="logo"><span>L</span>inguaSpan</a></h3>
        <ul class="navlist">
            <li><a href="">Contribute <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown">
                    <li class="navlist-voice-collection">Voice Collection</li>
                    <li><a href="{{url('contribute')}}"><img src="img/microphone.png" alt=""></i> Speak</a> <hr></li>
                    <li><a href="{{url('listen')}}"><img src="img/sound4.png" alt=""> Listen</a> </li>
                    <li class="navlist-sentence-collection">Sentence Collection</li>
                    <li><a href="{{url('write')}}"><img src="img/message-edit.png" alt=""> Write</a><hr></li>
                    <li><a href="{{url('review')}}"><img src="img/firstline.png" alt=""> Review</a></li>
                </ul></li>
            <li><a href="{{url('language')}}">Languages</a></li>
            <li><a href="{{url('about')}}">About</a></li>
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
