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
        <select name="language" id="selectlanguage">
            <option value="english">Language</option>
            <option value="english">English</option>
            <option value="swahili">Swahili</option>
            <option value="yoruba">Yoruba</option>
            <option value="french">French</option>
            <option value="igbo">Igbo</option>
            <option value="hausa">Hausa</option>
        </select>
    </div>
</section>

<section class="listen write-section-content" id="listen-section">
        <div class="speak-content">
            <div class="speak-content-word">
                <p class="speak-content-words-p">Press <i class="iconsax" icon-name="sound" style="font-size: 15px"></i> to listen & choose Yes/No to confirm if sentence was well read</p>
                <p id="sentence-text" class="speak-content-word-p">Loading ...</p>

            </div>
            <div class="speak-content-number">
                <p class="speak-content-number-listen"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> <span class="active"> 1</span></p>
                <p class="speak-content-number-listen"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> <span class="active"> 2</span></p>
                <p class="speak-content-number-listen"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> <span class="active"> 3</span></p>
                <p class="speak-content-number-listen"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> <span class="active"> 4</span></p>
                <p class="speak-content-number-listen"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> <span class="active"> 5</span></p>

            </div>
        </div>
{{--        <div  class="speak-content-mic1">--}}

{{--            <p class="speak-content-mic2" id="yesButton"><i class="iconsax" icon-name="tick-circle" style="font-size: 15px;color: green"></i> Yes </p>--}}

{{--            <button id="listenButton" style="border: none; background: none">--}}
{{--                <img src="img/component5.png" alt="Play Audio" width="100px" height="100px">--}}
{{--            </button>--}}
{{--            <p class="speak-content-mic2" id="noButton"><i class="iconsax" icon-name="x-circle" style="font-size: 15px;color: red"></i> No </p>--}}
{{--        </div>--}}

    <div class="speak-content-mic1">
        <p class="speak-content-mic2" id="yesButton"><i class="iconsax" icon-name="tick-circle" style="font-size: 15px;color: green"></i> Yes </p>

        <button id="listenButton" style="border: none; background: none">
            <img src="img/component5.png" alt="Play Audio" width="100px" height="100px">
        </button>

        <p class="speak-content-mic2" id="noButton"><i class="iconsax" icon-name="x-circle" style="font-size: 15px;color: red"></i> No </p>
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

        let currentReviewId = null;
      //  let currentAudioUrl = null;
        // let mediaRecorder;
        // let audioChunks = [];
        // let isRecording = false;
        // let recordCounter = 0;
        // let recordedAudios = {};
        // let responses = {}; // Stores Yes/No responses for each recording

        // Image paths
        // const micImg = "img/Component4.png";
        // const mic2Img = "img/Component 4.png";
        // const waveImg = "img/audio_wave.png";

        // const recordBtn = document.getElementById("record-btn");
        // const waveIndicator = document.createElement("img");
        // waveIndicator.src = waveImg;
        // waveIndicator.style.display = "none";
        // waveIndicator.style.marginLeft = "10px";
        // waveIndicator.style.width = "150px";
        // waveIndicator.style.height = "80px";
        // recordBtn.parentElement.appendChild(waveIndicator);

        let currentAudio = null; // To track the current audio instance
        // Global variables
        // Fetch sentence & audio
        function loadNextSentence() {
            const selectedLanguage = document.getElementById('selectlanguage').value.toLowerCase();

            console.log("Fetching next sentence for language:", selectedLanguage); // Debugging

            fetch(`/getnextlisten?language=${selectedLanguage}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Response:", data); // Debugging

                    if (data.message === 'Not available') {
                        console.log("No sentence available:", data.message);
                        document.getElementById('sentence-text').innerText = 'Not available';
                    } else if (data.message === 'Success' && data.sentence) {

                    document.getElementById('sentence-text').innerText = data.sentence.sentence;
                    // currentAudioUrl = sentenceData.audio_url;
                    } else {
                        document.getElementById('sentence-text').innerText = 'Error fetching sentence';

                    }
                })
                .catch(error => {
                    console.error('Error fetching sentence:', error);
                    document.getElementById('sentence-text').innerText = 'Error loading content';
                   // currentAudioUrl = null;
                });
        }

        document.getElementById('selectlanguage').addEventListener('change', loadNextSentence);

      //  document.addEventListener('DOMContentLoaded', function() {
            // Set up event listeners
            // document.getElementById('languageSelect').addEventListener('change', loadNextSentence);
           // document.getElementById('listenButton').addEventListener('click', playCurrentAudio);

            // Load initial content
        //     loadNextSentence();
        // });

        // // Play audio with error handling
        // function playCurrentAudio() {
        //     if (!currentAudioUrl) {
        //         alert("No audio available. Please select a language or try again.");
        //         return;
        //     }
        //
        //     // Clean up previous audio if exists
        //     if (currentAudio) {
        //         currentAudio.pause();
        //         currentAudio = null;
        //     }
        //
        //     // Create and play new audio instance
        //     currentAudio = new Audio(currentAudioUrl);
        //     currentAudio.play()
        //         .then(() => console.log("Audio playback started"))
        //         .catch(error => {
        //             console.error("Audio playback failed:", error);
        //             alert("Couldn't play audio. Please check your connection.");
        //
        //             if (error.name === 'NotAllowedError') {
        //                 alert("Please allow microphone access in your browser settings");
        //             }
        //         });
        // }

        // Initialize page


        // Play audio with error handling
        // function playCurrentAudio() {
        //     if (!currentAudioUrl) {
        //         alert("No audio available. Please select a language or try again.");
        //         return;
        //     }
        //
        //     // Clean up previous audio if exists
        //     if (currentAudio) {
        //         currentAudio.pause();
        //         currentAudio = null;
        //     }
        //
        //     // Create and play new audio instance
        //     currentAudio = new Audio(currentAudioUrl);
        //     currentAudio.play()
        //         .then(() => console.log("Audio playback started"))
        //         .catch(error => {
        //             console.error("Audio playback failed:", error);
        //             alert("Couldn't play audio. Please check your connection.");
        //
        //             // Handle specific error cases
        //             if (error.name === 'NotAllowedError') {
        //                 alert("Please allow microphone access in your browser settings");
        //             }
        //         });
        // }

        // Initialize page
        // document.addEventListener('DOMContentLoaded', function() {
        //     // Set up event listeners
        //     document.getElementById('languageSelect').addEventListener('change', loadNextSentence);
        //     document.getElementById('listenButton').addEventListener('click', playCurrentAudio);
        //
        //     // Load initial content
        //     loadNextSentence();
        // });
        // Fetch sentence & audio
    //     function loadNextSentence() {
    //     const selectedLanguage = document.getElementById('selectlanguage').value;
    //
    //     fetch(`/getnextlisten?language=${selectedLanguage}`)
    //     .then(response => response.json())
    //     .then(data => {
    //     if (data.message === 'Not available') {
    //     document.getElementById('sentence-text').innerText = 'Not available';
    //     currentAudioUrl = null;
    // } else {
    //     document.getElementById('sentence-text').innerText = data.sentence.sentence;
    //     currentReviewId = data.sentence.id;
    //     currentAudioUrl = data.fileUrl;
    // }
    // })
    //     .catch(error => console.error('Error:', error));
    // }
    //
    //     // Play original sentence audio
    //     document.getElementById('listenButton').addEventListener('click', function () {
    //     if (currentAudioUrl) {
    //     let audio = new Audio(currentAudioUrl);
    //     audio.play();
    // } else {
    //     alert("No audio available.");
    // }
    // });

        // Start recording
    //     function startRecording() {
    //     navigator.mediaDevices.getUserMedia({ audio: true })
    //         .then(stream => {
    //             mediaRecorder = new MediaRecorder(stream);
    //             audioChunks = [];
    //
    //             mediaRecorder.ondataavailable = event => {
    //                 audioChunks.push(event.data);
    //             };
    //
    //             mediaRecorder.start();
    //             isRecording = true;
    //             recordBtn.src = mic2Img;
    //             waveIndicator.style.display = "inline";
    //
    //             console.log("Recording started...");
    //         })
    //         .catch(error => {
    //             console.error("Error accessing microphone:", error);
    //         });
    // }

        // Stop recording and save audio
        function stopRecording() {
        if (mediaRecorder && isRecording) {
        mediaRecorder.onstop = () => {
        const audioBlob = new Blob(audioChunks, { type: "audio/wav" });
        const audioURL = URL.createObjectURL(audioBlob);

        recordedAudios[recordCounter] = audioURL;
        updateRecordingDisplay(recordCounter);
        recordCounter++; // Move to next recording slot
    };

        mediaRecorder.stop();
        isRecording = false;
        recordBtn.src = micImg;
        waveIndicator.style.display = "none";
    }
    }

    //     // Update UI with recorded audio
    //     function updateRecordingDisplay(index) {
    //     const recordingContainer = document.querySelector(".speak-content-number");
    //
    //     const newRecording = document.createElement("p");
    //     newRecording.classList.add("speak-content-number-listen");
    //     newRecording.innerHTML = `<i class="iconsax" icon-name="sound" style="font-size: 15px"></i>
    //                               <span class="active">${index + 1}</span>`;
    //     newRecording.addEventListener("click", () => playRecording(index));
    //
    //     recordingContainer.appendChild(newRecording);
    // }
    //
    //     // Play recorded audio
    //     function playRecording(index) {
    //     if (recordedAudios[index]) {
    //     const audio = new Audio(recordedAudios[index]);
    //     audio.play();
    // } else {
    //     console.log("No recording available.");
    // }
    // }

        // Save Yes/No response and attach icon
    //     function saveResponse(response) {
    //     responses[recordCounter - 1] = response;
    //
    //     let iconHTML = `<i class='iconsax' icon-name='${response === "yes" ? "tick-circle" : "x-circle"}'
    //                     style='font-size: 15px; color: ${response === "yes" ? "green" : "red"}'></i>`;
    //
    //     const responseContainer = document.querySelector(".speak-content-mic2:last-of-type");
    //     responseContainer.innerHTML = `${iconHTML} ${response === "yes" ? "Yes" : "No"}`;
    // }

        // // Attach event listeners
        // document.getElementById('yesButton').addEventListener('click', () => saveResponse("yes"));
        // document.getElementById('noButton').addEventListener('click', () => saveResponse("no"));
        // document.getElementById('selectlanguage').addEventListener('change', loadNextSentence);
        //
        // let recordedFiles = [];
        // let sentencesArray = [];
        // let fileNamesArray = [];
        // let fileUrlsArray = [];
        // let playbackOrder = []; // Stores the order in which audio files are played
        // let responsesArray = []; // Stores user responses (Yes/No) for each recording

        // Function to play recording and track order
        // function playRecording(index) {
        //     if (recordedAudios[index]) {
        //         const audio = new Audio(recordedAudios[index]);
        //         audio.play();
        //
        //         // Track playback order only if it's not already recorded
        //         if (!playbackOrder.includes(index)) {
        //             playbackOrder.push(index);
        //         }
        //
        //         console.log("Playback order:", playbackOrder);
        //     } else {
        //         console.log("No recording available to play.");
        //     }
        // }

        // Function to delete recording
        // function deleteRecording(index) {
        //     if (recordedAudios[index]) {
        //         delete recordedAudios[index];
        //         console.log(`Recording ${index + 1} deleted.`);
        //
        //         // Remove from playback order if it was recorded
        //         playbackOrder = playbackOrder.filter(i => i !== index);
        //         responsesArray[index] = null; // Remove the associated response
        //
        //         recordingElements[index].innerHTML = `
        //     <button class="re-record-btn" style="cursor: pointer;">Re-Record</button>
        //     <span class="active">${index + 1}</span>
        // `;

        //         // Attach event listener to re-record button
        //         const reRecordBtn = recordingElements[index].querySelector(".re-record-btn");
        //         reRecordBtn.addEventListener("click", () => {
        //             startRecording(index);
        //         });
        //     }
        // }
        //
        // // Function to save user response (Yes/No)
        // function saveResponse(index, response) {
        //     let iconHTML = `<i class='iconsax' icon-name='${response === "yes" ? "tick-circle" : "x-circle"}'
        // style='font-size: 15px; color: ${response === "yes" ? "green" : "red"}'></i> ${response === "yes" ? "Yes" : "No"}`;
        //
        //     // Store the response
        //     responsesArray[index] = response;
        //
        //     // Update the UI with the response
        //     document.querySelector(`.speak-content-number p:nth-child(${index + 1})`).innerHTML = iconHTML;
        // }
        //
        // // Event listeners for Yes/No buttons
        // document.querySelectorAll('.speak-content-mic2').forEach((element, index) => {
        //     element.addEventListener("click", function () {
        //         let response = element.textContent.trim().toLowerCase();
        //         saveResponse(index, response);
        //     });
        // });

        // Function to submit recordings
        {{--function submitRecordings() {--}}
        {{--    console.log('Submit clicked');--}}
        {{--    if (!currentReviewId) {--}}
        {{--        alert("No sentence available to submit.");--}}
        {{--        return;--}}
        {{--    }--}}

        {{--    const selectedLanguage = document.getElementById('selectlanguage').value;--}}
        {{--    let formData = new FormData();--}}
        {{--    formData.append("sentence_id", currentReviewId);--}}
        {{--    formData.append('language', selectedLanguage);--}}

        {{--    // Append recordings, sentences, file names, file URLs, responses, and playback order--}}
        {{--    recordedFiles.forEach((file, index) => {--}}
        {{--        formData.append(`recordings[${index}]`, file);--}}
        {{--        formData.append(`sentences[${index}]`, sentencesArray[index] || '');--}}
        {{--        formData.append(`file_names[${index}]`, fileNamesArray[index] || '');--}}
        {{--        formData.append(`file_urls[${index}]`, fileUrlsArray[index] || '');--}}
        {{--        formData.append(`responses[${index}]`, responsesArray[index] || ''); // Save Yes/No response--}}
        {{--    });--}}

        {{--    // Append playback order--}}
        {{--    formData.append("playback_order", JSON.stringify(playbackOrder));--}}

        {{--    // Debugging--}}
        {{--    formData.forEach((value, key) => {--}}
        {{--        console.log(key, value);--}}
        {{--    });--}}

        {{--    fetch('/save-listening', {--}}
        {{--        method: 'POST',--}}
        {{--        body: formData,--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
        {{--        }--}}
        {{--    })--}}
        {{--        .then(response => response.json())--}}
        {{--        .then(data => {--}}
        {{--            console.log('Response from server:', data.message);--}}
        {{--            location.reload();--}}
        {{--        })--}}
        {{--        .catch(error => console.error('Error saving recordings:', error));--}}
        {{--}--}}

        {{--// Attach submit function--}}
        {{--document.getElementById('submitBtn').addEventListener('click', submitRecordings);--}}
</script>



