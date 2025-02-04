@include('navbar')

<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable "><a href="{{url('contribute')}}" ><img src="img/microphone.png" alt="" width="15px" height="15px"> Speak</a></td>
            <td class="hoverable "><a href="{{url('listen')}}"><img src="img/sound4.png" alt="" width="15px" height="15px"> Listen</a></td>
            <td class="hoverable"><a href="{{url('write')}}"><img src="img/message-edit.png" alt="" width="15px" height="15px">  Write</a> </td>
            <td class="hoverable active"><a href="{{url('review')}}"><img src="img/firstline.png" alt="" width="15px" height="15px">  Review</a> </td>
        </tr>
    </table>
</section>
<br>
<section class="review write-section-content" id="review-section">

    <div class="review-content">
        <div class="review-content-word">
            <p class="speak-content-words-p">Press <img src="img/sound4.png" width="10px" alt=""> to listen & choose Yes/No to confirm if sentence was well read</p>
            <br>
            <p class="speak-content-word-p">The man went home <br>
                yesterday</p>
            <br>
            <div  class="review-content-mic1">
                <p class="speak-content-mic2"><img src="img/tickcircle.png" alt=""> Yes </p>
                <p class="speak-content-mic2"><img src="img/forward.png" alt=""> No Skip </p>
                <p class="speak-content-mic2"><img src="img/closecircle.png" alt="">No </p>
            </div>
        </div>
        <div class="review-content-content">
            <p>Does the sentence meet the guidelines? </p>
            <ul style="list-style-type: circle !important;">
                <li>fewer than 15 words per sentence</li>
                <li>Use correct grammar</li>
                <li>Use correct spelling and punctuation</li>
                <li>No numbers and special characters</li>
                <li>No foreign letters</li>
                <li>Include appropriate citation</li>
                <li>Ideally natural and conversational (it <br>
                    should be easy to read the sentence</li>
            </ul>
        </div>
    </div>

    <div class="speak-content-ul">
        <div>
            <p><img src="img/message-question.png" alt=""> Guidelines</p>
            <p><img src="img/flag.png" alt="">Report</p>
            <p><img src="img/keyboard-open.png" alt="">Shortcut</p>
        </div>
        <div></div>
    </div>
</section>

@include('footer')

