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

<section class="section1delete_profile">
    <h2 class="section1delete_profile-head">Would you like to request your voice recordings be deleted too, or do you prefer
        to keep them in the The Voice dota collection?*</h2>
    <p class="section1delete_profile-content">If you still want to keep your voice recordings with us then your anonymous voice recordings will remain in the the Voice data collection.
        Once you delete your profile you will no longer be able to submit a request to remove your recordings from the data collection,
        but if you want to remove all your recordings. We will review your request to remove your voice recordings from the dataset.
        If your request is approved, we will contact those who have downloaded the dataset and request they remove your voice recordings as
        well.</p>
    <form action="{{ route('profile.delete') }}" method="POST" enctype="multipart/form-data"><br>
        <input type="checkbox"><span> * I want to keep my recordings with TheVoice</span>
        <br><br>
        <button type="submit">Delete Profile</button>
    </form>

</section>

@include('footer')
