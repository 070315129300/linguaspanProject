@include('navbar')

<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable "><a href="{{url('contribute')}}" ><img src="img/microphone.png" alt="" width="15px" height="15px"> Speak</a></td>
            <td class="hoverable "><a href="{{url('listen')}}"><img src="img/sound4.png" alt="" width="15px" height="15px"> Listen</a></td>
            <td class="hoverable active"><a href="{{url('write')}}"><img src="img/message-edit.png" alt="" width="15px" height="15px">  Write</a> </td>
            <td class="hoverable "><a href="{{url('review')}}"><img src="img/firstline.png" alt="" width="15px" height="15px">  Review</a> </td>
        </tr>
    </table>
</section>
<section class="write-height write-section-content" id="write-section" >

    <div class="write-content-P">
        <p class="write-content-P-content">Single sentence</p>
        <p>Bulk sentence Submission</p>
    </div>
    <div class="write-content-P2">
        <p>Add <img src="img/message-edit.png" alt=""> a public domain sentence</p>
        <p><i>Sentence contributed here will be added to a publicly available cc- 0 licensed dataset</i></p>
    </div>
</section>
<br>
<section class="write-section-content">
    <div class="write-content-main">
        <div class="section2-profile-content-form">
            <form action="">
                <label for="">Sentence</label> <br>
                <input type="text"> <br>
                <label for="">Sentence domain</label><br>
                <select name="" id="">
                    <option value="">Agriculture And Food</option>
                    <option value="">Transport</option>
                    <option value="">Finances</option>
                    <option value="">General</option>
                </select> <br>
                <label for=""> Citation</label><br>
                <input type="text"><br>

                <p style="display: flex; justify-content: space-between">
                    <span class="section5-about-content-span">single sentence Submission</span>
                    <i class="fas fa-plus" id="toggleIcon" onclick="toggleText()"></i>
                </p>
                <span id="languageInfo" style="display: none; font-weight: bold; width: 80%">
                    Cite with a URL or the full name of the work.
                    <span>If it's your own words, just say "Self Citation". We need
                        to know where you found this content sp that we can check it is in
                        the public  domain and no copyright restrictions apply. For more
                        information about citiation see our Guidelines page.
                    </span>
                </span><br>

            </form>
        </div>
        <div class="review-content-content">
            <p>What sentence can i add? </p>
            <ul>
                <li>fewer than 15 words per sentence</li>
                <li>Use correct grammar</li>
                <li>Use correct spelling and punctuation</li>
                <li>No numbers and special characters</li>
                <li>No foreign letters</li>
                <li>Include appropriate citation</li>
                <li>Ideally natural and conversational (it <br>
                    should be easy to read the sentence)</li>
                <li>Please use appropriate tone marks and diacritics</li>
            </ul>
        </div>
    </div>

    <div class="write-content-side-checkbox">
        <p><input type="checkbox">i can confirm that the sentence is a public domain and <br> i have permission to upload it </p>
    </div>
    <br><br>
    <div class="speak-content-ul">
        <div>
            <p><img src="img/message-question.png" alt=""> Guidelines</p>
            <p><img src="img/flag.png" alt="">Contact us</p>
        </div>
        <div>
            <p>Submit</p>
        </div>
    </div>
</section>



@include('footer')
<script>
    function toggleText() {
        const info = document.getElementById("languageInfo");
        const icon = document.getElementById("toggleIcon");

        // Toggle the display of the span
        if (info.style.display === "none") {
            info.style.display = "block";
            icon.classList.remove("fa-plus");
            icon.classList.add("fa-minus");
        } else {
            info.style.display = "none";
            icon.classList.remove("fa-minus");
            icon.classList.add("fa-plus");
        }
    }
</script>
