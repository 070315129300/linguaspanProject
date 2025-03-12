@include('navbar')

<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable "><a href="{{url('contribute')}}" ><i class="iconsax" icon-name="mic-1" style="font-size: 15px"></i> Speak</a></td>
            <td class="hoverable active"><a href="{{url('listen')}}"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> Listen</a></td>
            <td class="hoverable"><a href="{{url('write')}}"><i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i>  Write</a> </td>
            <td class="hoverable "><a href="{{url('review')}}"><i class="iconsax" icon-name="first-character" style="font-size: 15px"></i>  Review</a> </td>
        </tr>
    </table>
    <div>
        <select id="languageSelect">
            <option value="">Select Language</option>
            <option value="English">English</option>
            <option value="Swahili">Swahili</option>
            <option value="Yoruba">Yoruba</option>
            <option value="French">French</option>
            <option value="Igbo">Igbo</option>
            <option value="Hausa">Hausa</option>
        </select>
    </div>
</section>

<section class="listen write-section-content" id="listen-section">
        <div class="speak-content">
            <div class="speak-content-word">
                <p class="speak-content-words-p">Press <i class="iconsax" icon-name="sound" style="font-size: 15px"></i> to listen & choose Yes/No to confirm if sentence was well read</p>
                <p class="speak-content-word-p">The man went home <br>yesterday</p>
            </div>
            <div class="speak-content-number">
                <p class="speak-content-number-listen"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> <span class="active"> 1</span></p>
                <div class="number-list">
                    <span>2</span>
                    <span>3</span>
                    <span>4</span>
                    <span>5</span>
                </div>
            </div>
        </div>
        <div  class="speak-content-mic1">

            <p class="speak-content-mic2"><i class="iconsax" icon-name="tick-circle" style="font-size: 15px;color: green"></i> Yes </p>
            <button id="listenButton" style="border: none; background: none">
                <img src="img/component5.png" alt="" width="100px important!" height= "100px important! ">
            </button>
            <p class="speak-content-mic2"><i class="iconsax" icon-name="x-circle" style="font-size: 15px;color: red"></i> No </p>
        </div>


        <div>
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
        </div>
</section>



@include('footer')
<script>

    document.addEventListener("DOMContentLoaded", function () {
        let currentIndex = 0;
        const totalSentences = 5;
        let responses = {};
        let audioFiles = @json($fileList);
        let currentBatch = audioFiles.slice(0, totalSentences);
        let batchStartIndex = 0;

        const listenButton = document.getElementById("listenButton");
        const listenImage = listenButton.querySelector("img");
        const yesButton = document.querySelector(".speak-content-mic2 i[icon-name='tick-circle']").closest("p");
        const noButton = document.querySelector(".speak-content-mic2 i[icon-name='x-circle']").closest("p");
        const numberList = document.querySelector(".number-list").querySelectorAll("span");
        const activeNumberContainer = document.querySelector(".speak-content-number-listen");
        const activeNumber = activeNumberContainer.querySelector("span");

        listenButton.addEventListener("click", function () {
            if (currentIndex < totalSentences) {
                playAudio(currentIndex);
            }
        });

        function playAudio(index) {
            listenImage.src = "img/component4.png";
            let audio = new Audio(currentBatch[index].url);
            audio.play();

            let waveContainer = document.createElement("div");
            waveContainer.id = "waveContainer";
            waveContainer.innerHTML = '<img src="img/audio_wave.png" style="width: 100px;">';
            listenButton.parentNode.insertBefore(waveContainer, listenButton.nextSibling);

            audio.onended = function () {
                waveContainer.remove();
                listenImage.src = "img/component5.png";
            };
        }

        yesButton.addEventListener("click", function () {
            if (currentIndex < totalSentences) {
                saveResponse(currentIndex, "yes");
                updateUI();
            }
        });

        noButton.addEventListener("click", function () {
            if (currentIndex < totalSentences) {
                saveResponse(currentIndex, "no");
                updateUI();
            }
        });

        function saveResponse(index, response) {
            let iconHTML = `<i class='iconsax' icon-name='${response === "yes" ? "tick-circle" : "x-circle"}'
            style='font-size: 15px; color: ${response === "yes" ? "green" : "red"}'></i>`;

            responses[currentBatch[index].name] = response;

            if (index === 0) {
                // First response goes in the <p> tag
                activeNumber.innerHTML = iconHTML;
            } else {
                // Subsequent responses go inside the respective <span>
                numberList[index - 1].innerHTML = iconHTML;
            }
        }

        function updateUI() {
            currentIndex++;

            if (currentIndex < totalSentences) {
                // Move the next number to the active <p> tag
                activeNumber.innerHTML = numberList[currentIndex - 1].innerHTML;
                numberList[currentIndex - 1].style.display = "none";
            } else {
                sendResponsesToBackend();
            }
        }

        function sendResponsesToBackend() {
            fetch("/save-responses", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ responses })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Responses saved successfully:", data);
                    loadNextBatch();
                })
                .catch(error => console.error("Error saving responses:", error));
        }

        function loadNextBatch() {
            batchStartIndex += totalSentences;
            currentBatch = audioFiles.slice(batchStartIndex, batchStartIndex + totalSentences);
            currentIndex = 0;
            responses = {};

            // Reset number list UI
            numberList.forEach((span, index) => {
                span.innerHTML = index + 2;
                span.style.display = "inline-block"; // Show again
            });

            activeNumber.innerHTML = "1"; // Reset active number
            activeNumber.style.display = "inline-block"; // Make sure it's visible

            if (currentBatch.length === 0) {
                console.log("No more audio files to process.");
            }
        }
    });

    {{--document.addEventListener("DOMContentLoaded", function () {--}}
    {{--    let currentIndex = 0;--}}
    {{--    const totalSentences = 5;--}}
    {{--    let responses = {};--}}
    {{--    let audioFiles = @json($fileList);--}}
    {{--    let currentBatch = audioFiles.slice(0, totalSentences); // Get the first 5--}}
    {{--    let batchStartIndex = 0;--}}

    {{--    const listenButton = document.getElementById("listenButton");--}}
    {{--    const listenImage = listenButton.querySelector("img");--}}
    {{--    const yesButton = document.querySelector(".speak-content-mic2 i[icon-name='tick-circle']").closest("p");--}}
    {{--    const noButton = document.querySelector(".speak-content-mic2 i[icon-name='x-circle']").closest("p");--}}
    {{--    const numberList = document.querySelector(".speak-content-number-listen span");--}}
    {{--    let speakContent = document.querySelector(".speak-content");--}}

    {{--    listenButton.addEventListener("click", function () {--}}
    {{--        if (currentIndex < totalSentences) {--}}
    {{--            playAudio(currentIndex);--}}
    {{--        }--}}
    {{--    });--}}

    {{--    function playAudio(index) {--}}
    {{--        listenImage.src = "img/component4.png";--}}
    {{--        let audio = new Audio(currentBatch[index].url);--}}
    {{--        audio.play();--}}

    {{--        let waveContainer = document.createElement("div");--}}
    {{--        waveContainer.id = "waveContainer";--}}
    {{--        waveContainer.innerHTML = '<img src="img/audio_wave.png" style="width: 100px;">';--}}
    {{--        speakContent.parentNode.insertBefore(waveContainer, speakContent.nextSibling);--}}

    {{--        audio.onended = function () {--}}
    {{--            waveContainer.remove();--}}
    {{--            listenImage.src = "img/component5.png";--}}
    {{--        };--}}
    {{--    }--}}

    {{--    yesButton.addEventListener("click", function () {--}}
    {{--        if (currentIndex < totalSentences) {--}}
    {{--            saveResponse(currentIndex, "yes");--}}
    {{--            updateUI();--}}
    {{--        }--}}
    {{--    });--}}

    {{--    noButton.addEventListener("click", function () {--}}
    {{--        if (currentIndex < totalSentences) {--}}
    {{--            saveResponse(currentIndex, "no");--}}
    {{--            updateUI();--}}
    {{--        }--}}
    {{--    });--}}

    {{--    function saveResponse(index, response) {--}}
    {{--        responses[currentBatch[index].name] = response;--}}
    {{--        numberList.innerHTML += `<i class='iconsax' icon-name='${response === "yes" ? "tick-circle" : "x-circle"}' style='font-size: 15px; color: ${response === "yes" ? "green" : "red"}'></i>`;--}}
    {{--    }--}}

    {{--    function updateUI() {--}}
    {{--        currentIndex++;--}}
    {{--        if (currentIndex >= totalSentences) {--}}
    {{--            sendResponsesToBackend();--}}
    {{--        }--}}
    {{--    }--}}

    {{--    function sendResponsesToBackend() {--}}
    {{--        fetch("/save-responses", {--}}
    {{--            method: "POST",--}}
    {{--            headers: { "Content-Type": "application/json" },--}}
    {{--            body: JSON.stringify({ responses })--}}
    {{--        })--}}
    {{--            .then(response => response.json())--}}
    {{--            .then(data => {--}}
    {{--                console.log("Responses saved successfully:", data);--}}
    {{--                loadNextBatch();--}}
    {{--            })--}}
    {{--            .catch(error => console.error("Error saving responses:", error));--}}
    {{--    }--}}

    {{--    function loadNextBatch() {--}}
    {{--        batchStartIndex += totalSentences;--}}
    {{--        currentBatch = audioFiles.slice(batchStartIndex, batchStartIndex + totalSentences);--}}
    {{--        currentIndex = 0;--}}
    {{--        responses = {};--}}
    {{--        numberList.innerHTML = ""; // Reset UI indicators--}}

    {{--        if (currentBatch.length === 0) {--}}
    {{--            console.log("No more audio files to process.");--}}
    {{--        }--}}
    {{--    }--}}
    {{--});--}}

</script>

