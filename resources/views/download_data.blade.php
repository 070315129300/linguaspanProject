@include("navbar")

<section class="section-download-header">
    <table>
        <tr>
            <td class="hoverable "><a href="{{url('profiles')}}"><i class="iconsax" icon-name="user-1" style="font-size: 15px"></i> Profile</a></td>
            <td class="hoverable "><a href="{{url('change_info')}}"><i class="iconsax" icon-name="nut" style="font-size: 15px"></i> Settings</a></td>
            <td class="hoverable active"><a href="{{url('download')}}"><i class="iconsax" icon-name="document-download" style="font-size: 15px"></i> Download my data</a> </td>
        </tr>
    </table>
</section>

<section class="section-download-head">
    <h2>Download Data</h2>
    <br>
    <div class="section-download-main">
        <div class="section-download-content">
            <img src="img/profile-add.png" alt="" height="60px"> <br>
            <h4>Profile</h4>
            <p>include email, username & <br>
            demographic info, available right
            away. A few bytes it is.</p>
            <button class="section-download-profile">Download Profile</button>
        </div>
        <div class="section-download-content downshift">
            <img src="img/sound2.png" alt="" height="60px"> <br>
            <h4>Recordings</h4>
            <p>includes mp3s and related <br>
                sentences, may take some time
            prepare</p>
            <button class="section-download-profile">Request Recordings</button>
        </div>
    </div>
</section>

@include('footer')
