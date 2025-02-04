@include("navbar")

@include('minnavbar')
<section class="section1info">
    <h1>Change information</h1>
    <p>To change or edit your email, email us at <span style="color: red">thevoice@gmail.com</span> </p>
    <div class="section2-profile-content-form">
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
            <form action="{{ route('changeinfo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <label for="">User name</label> <br>
            <input type="text" name="username" value="{{ $user->username ?? '' }}"> <br>
            <label for="">Email</label> <br>
            <input type="text" name="email" value="{{ $user->email ?? '' }}"> <br>
            <label for="">Enter Alternative Email</label><br>
            <input type="text" name="a_email" value="{{ $user->email ?? '' }}"><br><br>
            <button type="submit">send</button>
        </form>
    </div>
    <br><br><br>
    <hr>
    <p class="section-delete-profile"><i class="far fa-trash-alt"></i>
        <a href="{{url('delete_profile')}}">Delete Profile</a></p>
</section>
