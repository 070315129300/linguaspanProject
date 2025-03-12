@include("navbar")

<section class="section-download-header">
    <table>
        <tr>
            <td class="hoverable"><a href="{{url('profiles')}}"><i class="iconsax" icon-name="user-1" style="font-size: 15px"></i> Profile</a></td>
            <td class="hoverable active"><a href="{{url('change_info')}}"><i class="iconsax" icon-name="nut" style="font-size: 15px"></i> Settings</a></td>
            <td class="hoverable"><a href="{{url('download')}}"><i class="iconsax" icon-name="document-download" style="font-size: 15px"></i> Download my data</a> </td>
        </tr>
    </table>
</section>
<section class="section1info">
    <h1>Change information</h1>
    <p>To change or edit your email, email us at <span style="color: red">thevoice@gmail.com</span> </p>
    <br>
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
            <button type="submit">send an email</button>
        </form>


    </div>
    <br><br>
    <hr>
    <p class="section-delete-profile"><i class="iconsax" icon-name="trash" style="font-size: 15px"></i>
        <a href="{{url('delete_profile')}}">Delete Profile</a></p>
</section>

@include("footer")
