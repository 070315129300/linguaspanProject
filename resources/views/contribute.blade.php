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
<section class="speak write-section-content" id="speak-section">
    <div class="speak-content">
        <div class="speak-content-word">
            <p class="speak-content-words-p">Press <i class="fas fa-microphone"></i> then read the sentence aloud</p>
            <p class="speak-content-word-p" id="sentence-text">Loading...</p>
        </div>
        <div class="speak-content-number">
            <p>Start Recording  <span class="active" id="record-count">1</span></p>
            <p>Start Recording <span class="active" id="record-count">2</span></p>
            <p>Start Recording <span class="active" id="record-count">3</span></p>
            <p>Start Recording <span class="active" id="record-count">4</span></p>
            <p>Start Recording <span class="active" id="record-count">5</span></p>
        </div>
    </div>



    <div class="speak-content-mic">
        <img src="img/Component4.png" alt="Microphone" id="record-btn" style="cursor: pointer;">
    </div>



    <div class="speak-content-ul">

        <div class="section-speak-guidelines">
            <p><i class="iconsax" icon-name="question-message" style="font-size: 15px;"></i> Guidelines</p>
            <p><i class="iconsax" icon-name="flag-1" style="font-size: 15px;"></i> Report</p>
            <p><i class="iconsax" icon-name="keyboard-2" style="font-size: 15px;"></i> Shortcut</p>
        </div>
        <div class="section-speak-skip">
            <p><i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> Skip</p>
            <p id="submitBtn" style="cursor: pointer;">Submit</p>
        </div>
    </div>
</section>

@include('footer')


<script>

    let currentReviewId = null;
    let currentReviewfilename = null;


    function loadNextSentence() {
        const selectedLanguage = document.getElementById('selectlanguage').value;

        fetch(`/getnextcontribute?language=${selectedLanguage}`)
            .then(response => response.json())
            .then(data => {
                console.log("Response:", data); // Debugging line

                if (data.message === 'Not available') {
                    document.getElementById('sentence-text').innerText = 'Not available';
                } else if (data.message === 'Success' && data.sentence) {
                    document.getElementById('sentence-text').innerText = data.sentence.sentence;
                    //currentReviewId = data.sentence.id;
                    currentReviewfilename = data.sentence.file_name;
                } else {
                    document.getElementById('sentence-text').innerText = 'Error fetching sentence';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Reload sentences when language changes
    document.getElementById('selectlanguage').addEventListener('change', loadNextSentence);



    // Fetch sentences from PHP and convert to JavaScript array
    let sentence = @json($sentence ?? []);

    let index = 0;
    let recordCount = 1;

    console.log(sentence);

    document.getElementById('sentence-text').innerText = sentence ? sentence.sentence : "No sentences available";

    // record start here
    let mediaRecorder;
    let audioChunks = [];
    let isRecording = false;
    let recordCounter = 0; // Tracks the current recording index
    let recordedAudios = {}; // Stores recorded audio per index
    let reRecordIndex = null; // Stores the index of the re-recorded audio

    // Image paths
    const micImg = "img/Component4.png";
    const mic2Img = "img/Component 4.png";
    const waveImg = "img/audio_wave.png";

    const recordBtn = document.getElementById("record-btn");
    const waveIndicator = document.createElement("img");
    waveIndicator.src = waveImg;
    waveIndicator.style.display = "none";
    waveIndicator.style.marginLeft = "10px";
    waveIndicator.style.width = "150px";
    waveIndicator.style.height = "80px";
    recordBtn.parentElement.appendChild(waveIndicator);

    const recordingElements = document.querySelectorAll(".speak-content-number p");

    function startRecording(index = null) {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };

                mediaRecorder.start();
                isRecording = true;
                recordBtn.src = mic2Img;
                waveIndicator.style.display = "inline";

                reRecordIndex = index !== null ? index : recordCounter;

                console.log("Recording started...");
            })
            .catch(error => {
                console.error("Error accessing microphone:", error);
            });
    }


    function stopRecording() {
        if (!mediaRecorder || !isRecording) {
            console.error("No recording in progress.");
            return;
        }
        mediaRecorder.onstop = () => {
            const audioBlob = new Blob(audioChunks, { type: "audio/wav" });
            const audioURL = URL.createObjectURL(audioBlob);
            console.log("Audio recorded successfully:", audioURL);
            recordedAudios[reRecordIndex] = audioBlob;
            recordedFiles[reRecordIndex] = audioBlob; // Add this line
            fileUrlsArray[reRecordIndex] = audioURL;
            sentencesArray[reRecordIndex] = document.getElementById('sentence-text').innerText;
            fileNamesArray[reRecordIndex] = currentReviewfilename;
            updateRecordingDisplay(reRecordIndex);
            if (reRecordIndex === recordCounter) {
                recordCounter++;
            }
            loadNextSentence(); // Automatically load the next sentence
        };
        mediaRecorder.stop();
        isRecording = false;
        recordBtn.src = micImg;
        waveIndicator.style.display = "none";
    }

    function updateRecordingDisplay(index) {
        const recordingElement = recordingElements[index];

        recordingElement.innerHTML = `
        <i class="iconsax play-btn" icon-name="play-circle" style="font-size: 15px; cursor: pointer;"></i>
        <i class="iconsax repeat-btn" icon-name="repeat" style="font-size: 15px; cursor: pointer;"></i>
        <span class="active">${index + 1}</span>
    `;

        setTimeout(() => { // Ensure the buttons are added before attaching event listeners
            const playBtn = recordingElement.querySelector(".play-btn");
            const repeatBtn = recordingElement.querySelector(".repeat-btn");

            playBtn.addEventListener("click", () => playRecording(index));
            repeatBtn.addEventListener("click", () => deleteRecording(index));
        }, 100);
    }
    function playRecording(index) {
        if (fileUrlsArray[index]) {
            console.log("Playing audio from:", fileUrlsArray[index]);
            const audio = new Audio(fileUrlsArray[index]);
            audio.play().catch(error => console.error("Audio playback error:", error));
        } else {
            console.log(`No recording available to play at index ${index}`);
        }
    }
    function deleteRecording(index) {
        if (recordedAudios[index]) {
            delete recordedAudios[index];  // Remove recorded audio
            delete fileUrlsArray[index];   // Remove audio URL
            delete recordedFiles[index];   // Remove recorded file

            console.log(`Recording ${index + 1} deleted.`);

            // Show the "Re-Record" button in place of the deleted recording
            recordingElements[index].innerHTML = `
            <button class="re-record-btn" style="cursor: pointer;">Re-Record</button>
            <span class="active">${index + 1}</span>
        `;

            // Attach event listener to the re-record button
            const reRecordBtn = recordingElements[index].querySelector(".re-record-btn");
            reRecordBtn.addEventListener("click", () => startRecording(index));
        }
    }

    // Event listener for the record button
    recordBtn.addEventListener("click", () => {
        if (isRecording) {
            stopRecording();
        } else {
            startRecording();
        }
    });


    let recordedFiles = {};
    let sentencesArray = {};
    let fileNamesArray = {};
    let fileUrlsArray = {};


    function submitRecordings() {
        const selectedLanguage = document.getElementById('selectlanguage').value;
        const recordedFilesArray = Object.values(recordedFiles);

        if (recordedFilesArray.length === 0) {
            console.error("No recorded files available!");
            return;
        }

        let formData = new FormData();
        formData.append("file_name", currentReviewfilename);
        formData.append('language', selectedLanguage);

        Object.keys(recordedFiles).forEach(index => {
            formData.append(`recordings[]`, recordedFiles[index]);
            formData.append(`sentences[]`, sentencesArray[index] || '');
            formData.append(`file_names[]`, fileNamesArray[index] || '');
            if (fileUrlsArray[index]) {
                formData.append(`file_urls[]`, fileUrlsArray[index]);
            }
        });

        console.log("FormData before sending:");
        for (let pair of formData.entries()) {
            console.log(pair[0], pair[1]);
        }

        fetch('/save-recordings', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log("Server Response:", data);
                // Show success message (optional)
                alert('Recordings saved successfully!');
                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1000); // 1 second delay
            })
            .catch(error => {
                console.error("Error submitting:", error);
                alert('Error saving recordings: ' + error.message);
            });
    }


    // Attach the function to the submit button (only once)
    document.getElementById('submitBtn').addEventListener('click', submitRecordings);



</script>



