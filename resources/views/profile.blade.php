@include('navbar')
<section class="section-download-header">
    <table>
        <tr>
            <td class="hoverable active"><a href="{{url('profiles')}}"><i class="iconsax" icon-name="user-1" style="font-size: 15px"></i> Profile</a></td>
            <td class="hoverable "><a href="{{url('change_info')}}"><i class="iconsax" icon-name="nut" style="font-size: 15px"></i> Settings</a></td>
            <td class="hoverable"><a href="{{url('download')}}"><i class="iconsax" icon-name="document-download" style="font-size: 15px"></i> Download my data</a> </td>
        </tr>
    </table>
</section>
<section class="section1-profile">
    <div class="section1-profile-main">
          <h1>Profile</h1>
            <p>
                By providing some information about yourself, the audio data you submit to Common Voice will be more useful to Speech Recognition engines that use this data to improve their accuracy.
                Anonymize user data like age, gender, and accent helps improve the audio data used to train the accuracy of speech recognition engines. Your username and email will never be associated with your submitted data, and you can choose whether to make your username public or anonymous.
            </p>
    </div>

        <div  class="section1-profile-img">
            <img src="img/frame.png" alt="">
        </div>

</section>
<section class="section2-profile-content">
    <div class="section2-profile-content-img">
        <img src="img/frame1.png" alt="">
    </div>
    <div class="section2-profile-content-form">
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="full_name">Full Name</label><br>
            <input type="text" name="fullName" id="full_name" value="{{ $user->fullName }}"><br>

            <label for="username">User Name</label><br>
            <input type="text" name="username" id="username" value="{{ $user->username ?? '' }}"><br>

            <label for="age">Age</label><br>
            <select name="age" id="age">
                <option value="19-29" {{ $user->age === '19-29' ? 'selected' : '' }}>19-29 years</option>
                <option value="30-39" {{ $user->age === '30-39' ? 'selected' : '' }}>30-39 years</option>
                <!-- Add other age ranges as needed -->
            </select><br>

            <label for="sex">Sex</label><br>
            <select name="sex" id="sex">
                <option value="male" {{ $user->sex === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $user->sex === 'female' ? 'selected' : '' }}>Female</option>
            </select><br>

            <label for="nationality">Nationality</label><br>
            <select name="nationality" id="nationality">
                <option value="Nigeria" {{ $user->nationality === 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                <!-- Add other nationalities as needed -->
            </select><br>

            <label for="profession">Profession</label><br>
            <input type="text" name="profession" id="profession" value="{{ $user->profession ?? '' }}"><br>

            <label for="ethnicity">Ethnicity</label><br>
            <select name="ethnicity" id="ethnicity">
                <option value="Yoruba" {{ $user->ethnicity === 'Yoruba' ? 'selected' : '' }}>Yoruba</option>
                <option value="Igbo" {{ $user->ethnicity === 'Igbo' ? 'selected' : '' }}>Igbo</option>
                <option value="Hausa" {{ $user->ethnicity === 'Hausa' ? 'selected' : '' }}>Hausa</option>
                <!-- Add other ethnicities as needed -->
            </select><br><br>

            <button type="submit">Send</button><br>
        </form>
    </div>
</section>

@include('footer')
