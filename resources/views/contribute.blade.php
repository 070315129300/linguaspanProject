@include('navbar')

<section class="sectionnavbar">

    <table>
        <tr>
            <td class="hoverable active"><a href="{{url('contribute')}}" ><i class="iconsax" icon-name="mic-1" style="font-size: 15px"></i> Speak</a></td>
            <td class="hoverable "><a href="{{url('listen')}}"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> Listen</a></td>
            <td class="hoverable"><a href="{{url('write')}}"><i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i>  Write</a> </td>
            <td class="hoverable "><a href="{{url('review')}}"><i class="iconsax" icon-name="first-character" style="font-size: 15px"></i>  Review</a> </td>
        </tr>
    </table>
    <div>
            <select name="language" id="language">
                <option value="">Language</option>
                <option value="english">English</option>
                <option value="swahili">Swahili</option>
                <option value="yoruba">Yoruba</option>
                <option value="french">French</option>
                <option value="igbo">Igbo</option>
                <option value="hausa">Hausa</option>
            </select>
    </div>
</section>
<section class="speak write-section-content" id="speak-section">
    <div class="speak-content">
        <div class="speak-content-word">
            <p class="speak-content-words-p">Press <i class="fas fa-microphone"></i> then read the sentence aloud</p>
            <p class="speak-content-word-p" id="sentence-text">Loading...</p>
        </div>
        <div class="speak-content-number">
            <p>Start Recording <span class="active" id="record-count">1</span></p>
            <div class="number-list" id="number-list">
                <span>2</span>
                <span>3</span>
                <span>4</span>
                <span>5</span>
            </div>
        </div>
    </div>

    <div class="speak-content-mic">
        <img src="img/component4.png" alt="" id="record-btn">
    </div>

    <div class="speak-content-ul">

        <div class="section-speak-guidelines">
            <p><i class="iconsax" icon-name="question-message" style="font-size: 15px;"></i> Guidelines</p>
            <p><i class="iconsax" icon-name="flag-1" style="font-size: 15px;"></i> Report</p>
            <p><i class="iconsax" icon-name="keyboard-2" style="font-size: 15px;"></i> Shortcut</p>
        </div>
        <div class="section-speak-skip">
            <p><i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> Skip</p>

            <p>Submit</p>
        </div>
    </div>
</section>

@include('footer')


<script>
    // Fetch sentences from PHP and convert to JavaScript array
    let sentences = @json($sentences);
    let index = 0;
    let recordCount = 1;

    // Set first sentence on load
    document.getElementById('sentence-text').innerText = sentences[index] || "No sentences available";

    document.getElementById('record-btn').addEventListener('click', function () {
        startRecording();
    });

    function startRecording() {
        console.log("Recording started...");

        // Simulate recording process
        setTimeout(() => {
            console.log("Recording saved for: " + sentences[index]);

            // Update recording count
            document.getElementById('record-count').innerText = recordCount;

            // Move to next sentence
            index++;
            recordCount++;

            if (index < sentences.length) {
                document.getElementById('sentence-text').innerText = sentences[index];
            } else {
                document.getElementById('sentence-text').innerText = "No more sentences!";
            }

        }, 3000); // Simulate a 3-second recording
    }
</script>

